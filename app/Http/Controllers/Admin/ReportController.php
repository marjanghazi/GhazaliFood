<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;

class ReportController extends Controller
{
    public function index()
    {
        // Monthly sales data for chart
        $monthlySales = $this->getMonthlySales();
        $topProducts = Product::with(['category'])
            ->withCount(['orderItems'])
            ->orderBy('order_items_count', 'desc')
            ->limit(5)
            ->get();

        $recentOrders = Order::with(['user'])
            ->latest()
            ->limit(10)
            ->get();

        return view('admin.reports.index', compact('monthlySales', 'topProducts', 'recentOrders'));
    }

    public function sales(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->subMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));

        $orders = Order::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->with(['user'])
            ->get();

        $totalSales = $orders->sum('total_amount');
        $totalOrders = $orders->count();
        $averageOrder = $totalOrders > 0 ? $totalSales / $totalOrders : 0;
        $uniqueCustomers = $orders->unique('customer_email')->count();

        // Daily sales breakdown
        $dailySales = $orders->groupBy(function ($order) {
            return $order->created_at->format('Y-m-d');
        })->map(function ($dayOrders, $date) {
            return [
                'date' => Carbon::parse($date)->format('M d'),
                'sales' => $dayOrders->sum('total_amount'),
                'orders' => $dayOrders->count()
            ];
        })->values();

        return view('admin.reports.sales', compact(
            'orders',
            'totalSales',
            'totalOrders',
            'averageOrder',
            'dailySales',
            'startDate',
            'endDate',
            'uniqueCustomers'
        ));
    }
    public function products(Request $request)
    {
        $products = Product::with(['category'])
            ->withCount(['orderItems'])
            ->withSum('orderItems', 'quantity')
            ->orderBy('order_items_count', 'desc')
            ->paginate(20);

        $totalRevenue = Product::with(['orderItems'])->get()->sum(function ($product) {
            return $product->orderItems->sum(function ($item) {
                return $item->price * $item->quantity;
            });
        });

        return view('admin.reports.products', compact('products', 'totalRevenue'));
    }

    public function customers(Request $request)
    {
        $customers = User::where('role_id', 4)
            ->withCount(['orders'])
            ->withSum('orders', 'total_amount')
            ->orderBy('orders_sum_total_amount', 'desc')
            ->paginate(20);

        $totalCustomers = User::where('role_id', 4)->count();
        $activeCustomers = User::where('role_id', 4)->where('status', 'active')->count();
        $newCustomers = User::where('role_id', 4)
            ->where('created_at', '>=', Carbon::now()->subMonth())
            ->count();

        return view('admin.reports.customers', compact(
            'customers',
            'totalCustomers',
            'activeCustomers',
            'newCustomers'
        ));
    }

    public function coupons(Request $request)
    {
        $coupons = Coupon::with(['creator'])
            ->orderBy('used_count', 'desc')
            ->paginate(20);

        $totalCoupons = Coupon::count();
        $activeCoupons = Coupon::where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('expiry_date', '>=', now())
            ->count();

        return view('admin.reports.coupons', compact('coupons', 'totalCoupons', 'activeCoupons'));
    }

    private function getMonthlySales()
    {
        $sales = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthSales = Order::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('total_amount');

            $sales[] = [
                'month' => $date->format('M'),
                'sales' => $monthSales ?: 0
            ];
        }

        return $sales;
    }

    public function exportSales(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->subMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));

        $orders = Order::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->with(['items'])
            ->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="sales-report-' . date('Y-m-d') . '.csv"',
        ];

        $callback = function () use ($orders) {
            $file = fopen('php://output', 'w');
            // Add UTF-8 BOM for Excel compatibility
            fwrite($file, "\xEF\xBB\xBF");

            fputcsv($file, ['Order #', 'Date', 'Customer', 'Items', 'Subtotal', 'Tax', 'Shipping', 'Discount', 'Total', 'Status']);

            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->order_number,
                    $order->created_at->format('Y-m-d'),
                    $order->customer_name,
                    $order->items->sum('quantity'),
                    '$' . number_format($order->subtotal, 2),
                    '$' . number_format($order->tax_amount, 2),
                    '$' . number_format($order->shipping_cost, 2),
                    '$' . number_format($order->discount_amount, 2),
                    '$' . number_format($order->total_amount, 2),
                    ucfirst($order->order_status)
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}
