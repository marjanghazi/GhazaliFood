@extends('layouts.admin')

@section('title', 'Customer Details')
@section('page_title', 'Customer Details')
@section('breadcrumb', 'Customers')

@section('page_actions')
    <div class="btn-group">
        <a href="{{ route('admin.customers.edit', $customer) }}" class="btn btn-outline-info">
            <i class="fas fa-edit me-2"></i> Edit Customer
        </a>
    </div>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-4">
        <!-- Customer Profile -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Customer Profile</h6>
            </div>
            <div class="card-body text-center">
                <div class="avatar mb-3">
                    <div class="bg-primary rounded-circle text-white d-flex align-items-center justify-content-center mx-auto" 
                         style="width: 80px; height: 80px; font-size: 32px;">
                        {{ strtoupper(substr($customer->name, 0, 1)) }}
                    </div>
                </div>
                <h4>{{ $customer->name }}</h4>
                <p class="text-muted">{{ $customer->email }}</p>
                
                <div class="row text-center mt-4">
                    <div class="col-6">
                        <h5>{{ $customer->orders_count ?? 0 }}</h5>
                        <small class="text-muted">Total Orders</small>
                    </div>
                    <div class="col-6">
                        <h5>
                            @php
                                $totalSpent = $customer->orders->sum('total_amount');
                            @endphp
                            ${{ number_format($totalSpent, 2) }}
                        </h5>
                        <small class="text-muted">Total Spent</small>
                    </div>
                </div>
                
                <hr>
                
                <div class="text-start">
                    <div class="mb-3">
                        <strong>Customer ID:</strong>
                        <div class="text-muted">{{ $customer->id }}</div>
                    </div>
                    <div class="mb-3">
                        <strong>Phone:</strong>
                        <div class="text-muted">{{ $customer->phone ?? 'N/A' }}</div>
                    </div>
                    <div class="mb-3">
                        <strong>Status:</strong>
                        <div>
                            <span class="badge bg-{{ $customer->status === 'active' ? 'success' : 'secondary' }}">
                                {{ ucfirst($customer->status) }}
                            </span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <strong>Joined Date:</strong>
                        <div class="text-muted">{{ $customer->created_at->format('F d, Y') }}</div>
                    </div>
                    <div class="mb-3">
                        <strong>Last Login:</strong>
                        <div class="text-muted">
                            {{ $customer->last_login_at ? $customer->last_login_at->format('M d, Y h:i A') : 'Never' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Contact Information -->
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Contact Information</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Email:</strong>
                    <div class="text-muted">{{ $customer->email }}</div>
                </div>
                <div class="mb-3">
                    <strong>Phone:</strong>
                    <div class="text-muted">{{ $customer->phone ?? 'N/A' }}</div>
                </div>
                <div class="mb-0">
                    <strong>Account Status:</strong>
                    <div>
                        <form action="{{ route('admin.customers.toggle-status', $customer) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-{{ $customer->status === 'active' ? 'success' : 'secondary' }}">
                                {{ ucfirst($customer->status) }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-8">
        <!-- Recent Orders -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Recent Orders</h6>
                <span class="badge bg-primary">{{ $customer->orders->count() }} Orders</span>
            </div>
            <div class="card-body">
                @if($customer->orders->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Date</th>
                                <th>Items</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customer->orders as $order)
                            <tr>
                                <td>#{{ $order->order_number }}</td>
                                <td>{{ $order->created_at->format('M d, Y') }}</td>
                                <td>{{ $order->items->sum('quantity') }}</td>
                                <td>${{ number_format($order->total_amount, 2) }}</td>
                                <td>
                                    <span class="badge bg-{{ $order->status_color }}">
                                        {{ ucfirst($order->order_status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order) }}" 
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-4">
                    <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                    <h5>No Orders Yet</h5>
                    <p class="text-muted">This customer hasn't placed any orders yet.</p>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Order Statistics -->
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Orders</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $customer->orders_count ?? 0 }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-shopping-cart fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Total Spent</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    ${{ number_format($customer->orders->sum('total_amount'), 2) }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Avg. Order Value</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    @php
                                        $avg = $customer->orders_count > 0 
                                            ? $customer->orders->sum('total_amount') / $customer->orders_count 
                                            : 0;
                                    @endphp
                                    ${{ number_format($avg, 2) }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-chart-line fa-2x text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Customer Notes -->
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Customer Notes</h6>
            </div>
            <div class="card-body">
                <form>
                    @csrf
                    <div class="mb-3">
                        <textarea class="form-control" rows="3" placeholder="Add notes about this customer..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Notes</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection