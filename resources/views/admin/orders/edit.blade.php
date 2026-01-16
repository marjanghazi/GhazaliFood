@extends('layouts.admin')

@section('title', 'Edit Order')
@section('page_title', 'Edit Order')
@section('breadcrumb', 'Orders')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Edit Order #{{ $order->order_number }}</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="order_status" class="form-label">Order Status *</label>
                            <select class="form-select" id="order_status" name="order_status" required>
                                @foreach($statuses as $status)
                                    <option value="{{ $status }}" {{ $order->order_status == $status ? 'selected' : '' }}>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="payment_status" class="form-label">Payment Status *</label>
                            <select class="form-select" id="payment_status" name="payment_status" required>
                                @foreach($paymentStatuses as $status)
                                    <option value="{{ $status }}" {{ $order->payment_status == $status ? 'selected' : '' }}>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="tracking_number" class="form-label">Tracking Number</label>
                            <input type="text" class="form-control" id="tracking_number" 
                                   name="tracking_number" value="{{ $order->tracking_number }}">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="shipping_method" class="form-label">Shipping Method</label>
                            <input type="text" class="form-control" id="shipping_method" 
                                   name="shipping_method" value="{{ $order->shipping_method }}">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="notes" class="form-label">Order Notes</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3">{{ $order->notes }}</textarea>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-2"></i> Update Order
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Order Summary -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Order Summary</h6>
            </div>
            <div class="card-body">
                <div class="mb-2">
                    <strong>Order Total:</strong>
                    <span class="float-end">${{ number_format($order->total_amount, 2) }}</span>
                </div>
                <div class="mb-2">
                    <strong>Items:</strong>
                    <span class="float-end">{{ $order->items->sum('quantity') }}</span>
                </div>
                <div class="mb-2">
                    <strong>Customer:</strong>
                    <span class="float-end">{{ $order->customer_name }}</span>
                </div>
                <div class="mb-2">
                    <strong>Order Date:</strong>
                    <span class="float-end">{{ $order->created_at->format('M d, Y') }}</span>
                </div>
                <hr>
                <div class="mb-2">
                    <strong>Current Status:</strong>
                    <span class="float-end badge bg-{{ $order->status_color }}">
                        {{ ucfirst($order->order_status) }}
                    </span>
                </div>
                <div class="mb-2">
                    <strong>Payment Status:</strong>
                    <span class="float-end badge bg-{{ $order->payment_status_color }}">
                        {{ ucfirst($order->payment_status) }}
                    </span>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.orders.print', $order) }}" class="btn btn-outline-primary">
                        <i class="fas fa-print me-2"></i> Print Invoice
                    </a>
                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-outline-secondary">
                        <i class="fas fa-eye me-2"></i> View Details
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection