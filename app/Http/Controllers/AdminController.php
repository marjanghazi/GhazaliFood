<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Blog;
use App\Models\User;
use App\Models\Feedback;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\Banner;
use App\Models\Announcement;
use App\Models\Review;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Stats
        $stats = [
            'total_products' => Product::count(),
            'total_categories' => Category::count(),
            'total_blogs' => Blog::count(),
            'total_users' => User::count(),
            'total_customers' => User::where('role_id', 4)->count(),
            'active_customers' => User::where('role_id', 4)->where('status', 'active')->count(),
            'new_customers_this_month' => User::where('role_id', 4)
                ->whereMonth('created_at', Carbon::now()->month)
                ->count(),
            'pending_reviews' => Review::where('status', 'pending')->count(),
            'active_coupons' => Coupon::where('is_active', true)
                ->where('start_date', '<=', now())
                ->where('expiry_date', '>=', now())
                ->count(),
            'active_banners' => Banner::where('status', 'active')
                ->where('start_date', '<=', now())
                ->where('end_date', '>=', now())
                ->count(),
            'low_stock_products' => 0, // You'll need to implement this
        ];

        // Recent Products
        $recentProducts = Product::with(['category', 'primaryImage'])
            ->latest()
            ->limit(5)
            ->get();

        // Recent Feedback
        $recentFeedback = Feedback::latest()
            ->limit(5)
            ->get();

        // Recent Orders (for demo - you'll need to create Order model)
        $recentOrders = collect([
            (object) [
                'id' => 1001,
                'customer_name' => 'John Doe',
                'total_amount' => 125.50,
                'status' => 'Processing',
                'status_color' => 'warning',
                'created_at' => now()->subDays(1)
            ],
            (object) [
                'id' => 1002,
                'customer_name' => 'Jane Smith',
                'total_amount' => 89.99,
                'status' => 'Completed',
                'status_color' => 'success',
                'created_at' => now()->subDays(2)
            ],
            // Add more demo orders
        ]);

        return view('admin.dashboard', compact('stats', 'recentProducts', 'recentFeedback', 'recentOrders'));
    }
}