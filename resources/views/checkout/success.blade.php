@extends('layouts.app')

@section('title', 'Order Confirmation - Ghazali Food')

@section('hero')
<section class="success-hero">
    <div class="container">
        <div class="hero-content">
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h1 class="hero-title">Order Confirmed!</h1>
            <p class="hero-subtitle">Thank you for your purchase. Your order has been received.</p>
            <div class="order-number">
                <i class="fas fa-receipt me-2"></i>
                Order #: <strong>{{ $order->order_number }}</strong>
            </div>
        </div>
    </div>
</section>
@endsection

@section('content')
<div class="container">
    <div class="success-wrapper">
        <div class="row g-4">
            <!-- Order Details -->
            <div class="col-lg-8">
                <!-- Order Status Timeline -->
                <div class="order-status-card">
                    <h3 class="card-title">Order Status</h3>
                    <div class="timeline">
                        <div class="timeline-step active">
                            <div class="step-icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <div class="step-content">
                                <div class="step-title">Order Placed</div>
                                <div class="step-date">{{ $order->created_at->format('M d, Y h:i A') }}</div>
                            </div>
                        </div>
                        
                        <div class="timeline-step {{ in_array($order->order_status, ['processing', 'shipped', 'delivered']) ? 'active' : '' }}">
                            <div class="step-icon">
                                <i class="fas fa-cog"></i>
                            </div>
                            <div class="step-content">
                                <div class="step-title">Processing</div>
                                <div class="step-date">
                                    @if(in_array($order->order_status, ['processing', 'shipped', 'delivered']))
                                        {{ $order->updated_at->format('M d, Y') }}
                                    @else
                                        Upcoming
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="timeline-step {{ in_array($order->order_status, ['shipped', 'delivered']) ? 'active' : '' }}">
                            <div class="step-icon">
                                <i class="fas fa-shipping-fast"></i>
                            </div>
                            <div class="step-content">
                                <div class="step-title">Shipped</div>
                                <div class="step-date">
                                    @if(in_array($order->order_status, ['shipped', 'delivered']))
                                        {{ $order->updated_at->format('M d, Y') }}
                                    @else
                                        Upcoming
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="timeline-step {{ $order->order_status === 'delivered' ? 'active' : '' }}">
                            <div class="step-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="step-content">
                                <div class="step-title">Delivered</div>
                                <div class="step-date">
                                    @if($order->order_status === 'delivered')
                                        {{ $order->delivered_at->format('M d, Y') }}
                                    @else
                                        Upcoming
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="order-items-card">
                    <h3 class="card-title">Order Details</h3>
                    <div class="order-items-table">
                        @foreach($order->items as $item)
                        <div class="order-item">
                            <div class="item-image">
                                <img src="{{ $item->product->media->first()->media_url ?? asset('images/placeholder.jpg') }}" 
                                     alt="{{ $item->product_name }}">
                            </div>
                            <div class="item-details">
                                <h5 class="item-name">{{ $item->product_name }}</h5>
                                <div class="item-meta">
                                    <span>Qty: {{ $item->quantity }}</span>
                                    <span>Price: {{ config('settings.currency_symbol', '₹') }}{{ number_format($item->unit_price, 2) }}</span>
                                </div>
                            </div>
                            <div class="item-total">
                                {{ config('settings.currency_symbol', '₹') }}{{ number_format($item->total_price, 2) }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Order Summary & Actions -->
            <div class="col-lg-4">
                <!-- Order Summary -->
                <div class="summary-card">
                    <h3 class="summary-title">Order Summary</h3>
                    
                    <div class="summary-details">
                        <div class="detail-row">
                            <span>Order Number:</span>
                            <strong>{{ $order->order_number }}</strong>
                        </div>
                        <div class="detail-row">
                            <span>Order Date:</span>
                            <span>{{ $order->created_at->format('M d, Y h:i A') }}</span>
                        </div>
                        <div class="detail-row">
                            <span>Payment Method:</span>
                            <span>{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</span>
                        </div>
                        <div class="detail-row">
                            <span>Payment Status:</span>
                            <span class="status-badge {{ $order->payment_status }}">{{ ucfirst($order->payment_status) }}</span>
                        </div>
                        <div class="detail-row">
                            <span>Order Status:</span>
                            <span class="status-badge {{ $order->order_status }}">{{ ucfirst($order->order_status) }}</span>
                        </div>
                        @if($order->tracking_number)
                        <div class="detail-row">
                            <span>Tracking Number:</span>
                            <strong>{{ $order->tracking_number }}</strong>
                        </div>
                        @endif
                    </div>
                    
                    <div class="summary-totals">
                        <div class="total-row">
                            <span>Subtotal:</span>
                            <span>{{ config('settings.currency_symbol', '₹') }}{{ number_format($order->subtotal_amount, 2) }}</span>
                        </div>
                        <div class="total-row">
                            <span>Shipping:</span>
                            <span>{{ config('settings.currency_symbol', '₹') }}{{ number_format($order->shipping_amount, 2) }}</span>
                        </div>
                        <div class="total-row">
                            <span>Tax:</span>
                            <span>{{ config('settings.currency_symbol', '₹') }}{{ number_format($order->tax_amount, 2) }}</span>
                        </div>
                        <div class="total-row grand-total">
                            <span>Total:</span>
                            <span>{{ config('settings.currency_symbol', '₹') }}{{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Shipping Address -->
                <div class="address-card">
                    <h3 class="card-title">Shipping Address</h3>
                    <div class="address-content">
                        <p>{{ $order->shipping_address }}</p>
                        <p>{{ $order->shipping_city }}, {{ $order->shipping_state }}</p>
                        <p>{{ $order->shipping_zip }}, {{ $order->shipping_country }}</p>
                    </div>
                </div>

                <!-- Actions -->
                <div class="actions-card">
                    <h3 class="card-title">Next Steps</h3>
                    <div class="action-buttons">
                        <a href="{{ route('orders.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-history me-2"></i> View All Orders
                        </a>
                        <a href="{{ route('shop.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-shopping-bag me-2"></i> Continue Shopping
                        </a>
                        <button onclick="window.print()" class="btn btn-outline-info">
                            <i class="fas fa-print me-2"></i> Print Invoice
                        </button>
                        @if(in_array($order->order_status, ['pending', 'processing']))
                        <form action="{{ route('checkout.cancel', $order) }}" method="POST" class="mt-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100" 
                                    onclick="return confirm('Are you sure you want to cancel this order?')">
                                <i class="fas fa-times me-2"></i> Cancel Order
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Success Hero */
.success-hero {
    background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-color) 100%);
    padding: 3rem 0;
    color: white;
    text-align: center;
}

.success-icon {
    font-size: 4rem;
    color: #27ae60;
    margin-bottom: 1rem;
}

.hero-title {
    font-size: 2.5rem;
    margin-bottom: 0.5rem;
}

.hero-subtitle {
    opacity: 0.9;
    margin-bottom: 1.5rem;
    font-size: 1.1rem;
}

.order-number {
    display: inline-flex;
    align-items: center;
    background: rgba(255, 255, 255, 0.1);
    padding: 0.75rem 1.5rem;
    border-radius: 50px;
    font-size: 1.1rem;
    backdrop-filter: blur(10px);
}

/* Order Status Timeline */
.order-status-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    border: 1px solid var(--border-color);
}

.card-title {
    margin-bottom: 1.5rem;
    color: var(--text-primary);
    font-size: 1.25rem;
}

.timeline {
    position: relative;
    padding-left: 40px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 20px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: var(--border-color);
}

.timeline-step {
    position: relative;
    margin-bottom: 2rem;
}

.timeline-step:last-child {
    margin-bottom: 0;
}

.step-icon {
    position: absolute;
    left: -40px;
    width: 40px;
    height: 40px;
    background: var(--surface-color);
    border: 2px solid var(--border-color);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-muted);
    z-index: 2;
}

.timeline-step.active .step-icon {
    background: var(--primary-color);
    border-color: var(--primary-color);
    color: white;
}

.step-content {
    padding-left: 1rem;
}

.step-title {
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.25rem;
}

.step-date {
    font-size: 0.875rem;
    color: var(--text-muted);
}

/* Order Items */
.order-items-table {
    max-height: 400px;
    overflow-y: auto;
}

.order-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    border-bottom: 1px solid var(--border-color);
}

.order-item:last-child {
    border-bottom: none;
}

.item-image {
    width: 60px;
    height: 60px;
    flex-shrink: 0;
    border-radius: 8px;
    overflow: hidden;
}

.item-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.item-details {
    flex: 1;
}

.item-name {
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
    color: var(--text-primary);
}

.item-meta {
    display: flex;
    gap: 1rem;
    font-size: 0.875rem;
    color: var(--text-muted);
}

.item-total {
    font-weight: 600;
    color: var(--text-primary);
    min-width: 80px;
    text-align: right;
}

/* Summary Card */
.summary-card, .address-card, .actions-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    border: 1px solid var(--border-color);
}

.summary-details {
    margin-bottom: 1.5rem;
}

.detail-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.75rem;
    padding-bottom: 0.75rem;
    border-bottom: 1px solid var(--border-color);
}

.detail-row:last-child {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}

.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
}

.status-badge.pending { background: #f39c12; color: white; }
.status-badge.processing { background: #3498db; color: white; }
.status-badge.shipped { background: #9b59b6; color: white; }
.status-badge.delivered { background: #27ae60; color: white; }
.status-badge.cancelled { background: #e74c3c; color: white; }
.status-badge.paid { background: #27ae60; color: white; }

.summary-totals {
    padding-top: 1rem;
    border-top: 2px solid var(--border-color);
}

.total-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.75rem;
    color: var(--text-secondary);
}

.grand-total {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--primary-color);
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid var(--border-color);
}

/* Address Card */
.address-content p {
    margin-bottom: 0.5rem;
    color: var(--text-secondary);
}

.address-content p:last-child {
    margin-bottom: 0;
}

/* Action Buttons */
.action-buttons {
    display: grid;
    gap: 0.75rem;
}

.action-buttons .btn {
    padding: 0.75rem;
}

/* Responsive */
@media (max-width: 768px) {
    .success-hero {
        padding: 2rem 0;
    }
    
    .hero-title {
        font-size: 2rem;
    }
    
    .timeline {
        padding-left: 30px;
    }
    
    .step-icon {
        left: -30px;
        width: 30px;
        height: 30px;
        font-size: 0.875rem;
    }
}
</style>
@endpush