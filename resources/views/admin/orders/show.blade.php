@extends('layouts.admin')

@section('title', 'Order Details')
@section('page_title', 'Order Details')
@section('breadcrumb', 'Orders')

@section('page_actions')
    <div class="btn-group">
        <a href="{{ route('admin.orders.print', $order) }}" class="btn btn-outline-primary">
            <i class="fas fa-print me-2"></i> Print Invoice
        </a>
        <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-outline-info">
            <i class="fas fa-edit me-2"></i> Edit Order
        </a>
    </div>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <!-- Order Items -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Order Items</h6>
                <span class="badge bg-primary">Total: ${{ number_format($order->total_amount, 2) }}</span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <strong>{{ $item->product_name }}</strong>
                                            @if($item->variant_name)
                                                <div class="text-muted small">Variant: {{ $item->variant_name }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>${{ number_format($item->unit_price, 2) }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td><strong>${{ number_format($item->total_price, 2) }}</strong></td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Subtotal:</strong></td>
                                <td><strong>${{ number_format($order->subtotal, 2) }}</strong></td>
                            </tr>
                            @if($order->discount_amount > 0)
                            <tr>
                                <td colspan="3" class="text-end"><strong>Discount:</strong></td>
                                <td><strong class="text-danger">-${{ number_format($order->discount_amount, 2) }}</strong></td>
                            </tr>
                            @endif
                            <tr>
                                <td colspan="3" class="text-end"><strong>Shipping:</strong></td>
                                <td><strong>${{ number_format($order->shipping_cost, 2) }}</strong></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Tax:</strong></td>
                                <td><strong>${{ number_format($order->tax_amount, 2) }}</strong></td>
                            </tr>
                            <tr class="table-active">
                                <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                <td><strong class="text-success">${{ number_format($order->total_amount, 2) }}</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <!-- Order Notes -->
        @if($order->notes)
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Order Notes</h6>
            </div>
            <div class="card-body">
                <p>{{ $order->notes }}</p>
            </div>
        </div>
        @endif
    </div>

    <div class="col-lg-4">
        <!-- Order Summary -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Order Summary</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Order Number:</strong>
                    <div class="text-muted">#{{ $order->order_number }}</div>
                </div>
                <div class="mb-3">
                    <strong>Order Date:</strong>
                    <div class="text-muted">{{ $order->created_at->format('F d, Y h:i A') }}</div>
                </div>
                <div class="mb-3">
                    <strong>Order Status:</strong>
                    <div>
                        <span class="badge bg-{{ $order->status_color }}">
                            {{ ucfirst($order->order_status) }}
                        </span>
                    </div>
                </div>
                <div class="mb-3">
                    <strong>Payment Status:</strong>
                    <div>
                        <span class="badge bg-{{ $order->payment_status_color }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </div>
                </div>
                <div class="mb-3">
                    <strong>Payment Method:</strong>
                    <div class="text-muted">{{ ucfirst($order->payment_method) }}</div>
                </div>
                <div class="mb-3">
                    <strong>Shipping Method:</strong>
                    <div class="text-muted">{{ $order->shipping_method ?? 'Standard Shipping' }}</div>
                </div>
                @if($order->tracking_number)
                <div class="mb-3">
                    <strong>Tracking Number:</strong>
                    <div class="text-muted">{{ $order->tracking_number }}</div>
                </div>
                @endif
            </div>
        </div>

        <!-- Customer Information -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Customer Information</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Name:</strong>
                    <div class="text-muted">{{ $order->customer_name }}</div>
                </div>
                <div class="mb-3">
                    <strong>Email:</strong>
                    <div class="text-muted">{{ $order->customer_email }}</div>
                </div>
                <div class="mb-3">
                    <strong>Phone:</strong>
                    <div class="text-muted">{{ $order->customer_phone }}</div>
                </div>
                @if($order->user)
                <div class="mb-3">
                    <strong>Account:</strong>
                    <div class="text-muted">
                        <a href="{{ route('admin.customers.show', $order->user) }}">
                            View Customer Profile
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Shipping Address -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Shipping Address</h6>
            </div>
            <div class="card-body">
                @if(is_array($order->shipping_address))
                    @foreach($order->shipping_address as $key => $value)
                        @if($value)
                            <div class="mb-1">
                                <strong>{{ ucfirst(str_replace('_', ' ', $key)) }}:</strong>
                                <div class="text-muted">{{ $value }}</div>
                            </div>
                        @endif
                    @endforeach
                @else
                    <div class="text-muted">{{ $order->shipping_address }}</div>
                @endif
            </div>
        </div>

        <!-- Billing Address -->
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Billing Address</h6>
            </div>
            <div class="card-body">
                @if(is_array($order->billing_address))
                    @foreach($order->billing_address as $key => $value)
                        @if($value)
                            <div class="mb-1">
                                <strong>{{ ucfirst(str_replace('_', ' ', $key)) }}:</strong>
                                <div class="text-muted">{{ $value }}</div>
                            </div>
                        @endif
                    @endforeach
                @else
                    <div class="text-muted">{{ $order->billing_address }}</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection