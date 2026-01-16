@extends('layouts.admin')

@section('title', 'Sales Report')
@section('page_title', 'Reports')
@section('breadcrumb', 'Sales Report')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Sales Report</h5>
                <div class="card-tools">
                    <form action="{{ route('admin.reports.sales') }}" method="GET" class="row g-3">
                        <div class="col-auto">
                            <input type="date" class="form-control" name="start_date" 
                                   value="{{ $startDate }}" required>
                        </div>
                        <div class="col-auto">
                            <input type="date" class="form-control" name="end_date" 
                                   value="{{ $endDate }}" required>
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('admin.reports.export-sales', ['start_date' => $startDate, 'end_date' => $endDate]) }}" 
                               class="btn btn-success">
                                <i class="fas fa-download me-2"></i> Export
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <!-- Summary Cards -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <h6 class="card-title">Total Sales</h6>
                                <h3 class="card-text">${{ number_format($totalSales, 2) }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <h6 class="card-title">Total Orders</h6>
                                <h3 class="card-text">{{ $totalOrders }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <h6 class="card-title">Avg. Order Value</h6>
                                <h3 class="card-text">${{ number_format($averageOrder, 2) }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-warning text-white">
                            <div class="card-body">
                                <h6 class="card-title">Unique Customers</h6>
                                <h3 class="card-text">{{ $uniqueCustomers }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Daily Sales Chart -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="mb-0">Daily Sales Breakdown</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="dailySalesChart" height="100"></canvas>
                    </div>
                </div>

                <!-- Orders Table -->
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Order Details</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Order #</th>
                                        <th>Date</th>
                                        <th>Customer</th>
                                        <th>Items</th>
                                        <th>Subtotal</th>
                                        <th>Tax</th>
                                        <th>Shipping</th>
                                        <th>Discount</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                    <tr>
                                        <td>{{ $order->order_number }}</td>
                                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                                        <td>{{ $order->customer_name }}</td>
                                        <td>{{ $order->items->sum('quantity') }}</td>
                                        <td>${{ number_format($order->subtotal, 2) }}</td>
                                        <td>${{ number_format($order->tax_amount, 2) }}</td>
                                        <td>${{ number_format($order->shipping_cost, 2) }}</td>
                                        <td>${{ number_format($order->discount_amount, 2) }}</td>
                                        <td>${{ number_format($order->total_amount, 2) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $order->order_status == 'delivered' ? 'success' : 'warning' }}">
                                                {{ ucfirst($order->order_status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="table-dark">
                                        <td colspan="4"><strong>Totals</strong></td>
                                        <td><strong>${{ number_format($orders->sum('subtotal'), 2) }}</strong></td>
                                        <td><strong>${{ number_format($orders->sum('tax_amount'), 2) }}</strong></td>
                                        <td><strong>${{ number_format($orders->sum('shipping_cost'), 2) }}</strong></td>
                                        <td><strong>${{ number_format($orders->sum('discount_amount'), 2) }}</strong></td>
                                        <td><strong>${{ number_format($orders->sum('total_amount'), 2) }}</strong></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Daily Sales Chart
    const dailyData = @json($dailySales->values());
    const dailyLabels = @json($dailySales->pluck('date'));
    const dailySalesAmounts = @json($dailySales->pluck('sales'));
    const dailyOrdersCount = @json($dailySales->pluck('orders'));

    const ctx = document.getElementById('dailySalesChart').getContext('2d');
    const dailySalesChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: dailyLabels,
            datasets: [{
                label: 'Sales ($)',
                data: dailySalesAmounts,
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                yAxisID: 'y'
            }, {
                label: 'Orders',
                data: dailyOrdersCount,
                backgroundColor: 'rgba(255, 99, 132, 0.7)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1,
                yAxisID: 'y1',
                type: 'line'
            }]
        },
        options: {
            responsive: true,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    }
                },
                y: {
                    type: 'linear',
                    display: true,
                    position: 'left',
                    ticks: {
                        callback: function(value) {
                            return '$' + value;
                        }
                    }
                },
                y1: {
                    type: 'linear',
                    display: true,
                    position: 'right',
                    grid: {
                        drawOnChartArea: false,
                    },
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });
</script>
@endpush