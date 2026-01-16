@extends('layouts.admin')

@section('title', 'Customers Report')
@section('page_title', 'Reports')
@section('breadcrumb', 'Customers Report')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Customers Analytics Report</h5>
                <div class="card-tools">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search customers..." id="customerSearch">
                        <button class="btn btn-outline-secondary" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <!-- Summary Cards -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <h6 class="card-title">Total Customers</h6>
                                <h3 class="card-text">{{ $totalCustomers }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <h6 class="card-title">Active Customers</h6>
                                <h3 class="card-text">{{ $activeCustomers }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <h6 class="card-title">New This Month</h6>
                                <h3 class="card-text">{{ $newCustomers }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-warning text-white">
                            <div class="card-body">
                                <h6 class="card-title">Avg. Order Value</h6>
                                <h3 class="card-text">
                                    @php
                                        $totalOrders = $customers->sum('orders_count');
                                        $totalSpent = $customers->sum('orders_sum_total_amount');
                                        $avgValue = $totalOrders > 0 ? $totalSpent / $totalOrders : 0;
                                    @endphp
                                    ${{ number_format($avgValue, 2) }}
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Customers Table -->
                <div class="table-responsive">
                    <table class="table table-hover" id="customersTable">
                        <thead>
                            <tr>
                                <th>Customer</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Orders</th>
                                <th>Total Spent</th>
                                <th>Avg. Order</th>
                                <th>Joined</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customers as $customer)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            @if($customer->avatar_url)
                                                <img src="{{ asset('storage/' . $customer->avatar_url) }}" 
                                                     class="rounded-circle" width="40" height="40" alt="{{ $customer->name }}">
                                            @else
                                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" 
                                                     style="width: 40px; height: 40px;">
                                                    <i class="fas fa-user text-muted"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <strong>{{ $customer->name }}</strong>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $customer->email }}</td>
                                <td>{{ $customer->phone ?? 'N/A' }}</td>
                                <td>{{ $customer->orders_count ?? 0 }}</td>
                                <td>${{ number_format($customer->orders_sum_total_amount ?? 0, 2) }}</td>
                                <td>
                                    @php
                                        $avgOrder = $customer->orders_count > 0 ? 
                                                   ($customer->orders_sum_total_amount ?? 0) / $customer->orders_count : 0;
                                    @endphp
                                    ${{ number_format($avgOrder, 2) }}
                                </td>
                                <td>{{ $customer->created_at->format('M d, Y') }}</td>
                                <td>
                                    <span class="badge bg-{{ $customer->status == 'active' ? 'success' : ($customer->status == 'inactive' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($customer->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.customers.show', $customer) }}" 
                                           class="btn btn-sm btn-outline-primary" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.customers.edit', $customer) }}" 
                                           class="btn btn-sm btn-outline-info" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($customers->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $customers->links() }}
                    </div>
                @endif

                <!-- Customer Stats -->
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Top Customers by Spending</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Customer</th>
                                                <th>Total Spent</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($customers->take(5) as $topCustomer)
                                            <tr>
                                                <td>{{ $topCustomer->name }}</td>
                                                <td>${{ number_format($topCustomer->orders_sum_total_amount ?? 0, 2) }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Customer Distribution</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="customerChart" height="150"></canvas>
                            </div>
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
    // Search functionality
    document.getElementById('customerSearch').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('#customersTable tbody tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });

    // Customer Distribution Chart
    const ctx = document.getElementById('customerChart').getContext('2d');
    const customerChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Active', 'Inactive', 'Suspended'],
            datasets: [{
                data: [{{ $activeCustomers }}, {{ $totalCustomers - $activeCustomers }}, 0], // Assuming suspended count is 0
                backgroundColor: [
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(255, 205, 86, 0.8)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
@endpush