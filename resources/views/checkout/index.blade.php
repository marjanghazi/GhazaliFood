@extends('layouts.app')

@section('title', 'Checkout - Ghazali Food')

@section('hero')
<section class="checkout-hero">
    <div class="container">
        <div class="hero-content">
            <h1 class="hero-title">Secure Checkout</h1>
            <p class="hero-subtitle">Complete your purchase with confidence</p>
            <div class="security-badges">
                <div class="badge">
                    <i class="fas fa-lock"></i>
                    <span>256-bit SSL Secure</span>
                </div>
                <div class="badge">
                    <i class="fas fa-shield-alt"></i>
                    <span>Safe & Secure Payment</span>
                </div>
                <div class="badge">
                    <i class="fas fa-truck"></i>
                    <span>Fast Delivery</span>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('content')
<div class="container">
    <div class="checkout-wrapper">
        <!-- Progress Steps -->
        <div class="checkout-steps">
            <div class="step active">
                <div class="step-number">1</div>
                <div class="step-content">
                    <div class="step-title">Shipping</div>
                    <div class="step-subtitle">Address & Delivery</div>
                </div>
            </div>
            <div class="step">
                <div class="step-number">2</div>
                <div class="step-content">
                    <div class="step-title">Payment</div>
                    <div class="step-subtitle">Secure Payment</div>
                </div>
            </div>
            <div class="step">
                <div class="step-number">3</div>
                <div class="step-content">
                    <div class="step-title">Confirmation</div>
                    <div class="step-subtitle">Order Review</div>
                </div>
            </div>
        </div>

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            Please fix the following errors:
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="row g-4">
            <!-- Left Column - Forms -->
            <div class="col-lg-8">
                <form id="checkoutForm" method="POST" action="{{ route('checkout.store') }}">
                    @csrf

                    <!-- Shipping Address -->
                    <div class="checkout-card">
                        <div class="card-header">
                            <h3><i class="fas fa-truck me-2"></i> Shipping Address</h3>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Full Name *</label>
                                        <input type="text" class="form-control @error('shipping_name') is-invalid @enderror"
                                            name="shipping_name" value="{{ old('shipping_name', $user->name) }}" required>
                                        @error('shipping_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email *</label>
                                        <input type="email" class="form-control @error('shipping_email') is-invalid @enderror"
                                            name="shipping_email" value="{{ old('shipping_email', $user->email) }}" required>
                                        @error('shipping_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Phone *</label>
                                        <input type="tel" class="form-control @error('shipping_phone') is-invalid @enderror"
                                            name="shipping_phone" value="{{ old('shipping_phone', $user->phone ?? '') }}" required>
                                        @error('shipping_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Country *</label>
                                        <select class="form-control @error('shipping_country') is-invalid @enderror"
                                            name="shipping_country" required>
                                            <option value="">Select Country</option>
                                            <option value="Pakistan" {{ old('shipping_country', 'Pakistan') == 'Pakistan' ? 'selected' : '' }}>Pakistan</option>
                                            <option value="USA" {{ old('shipping_country') == 'USA' ? 'selected' : '' }}>United States</option>
                                            <option value="UK" {{ old('shipping_country') == 'UK' ? 'selected' : '' }}>United Kingdom</option>
                                            <option value="UAE" {{ old('shipping_country') == 'UAE' ? 'selected' : '' }}>United Arab Emirates</option>
                                            <option value="Canada" {{ old('shipping_country') == 'Canada' ? 'selected' : '' }}>Canada</option>
                                        </select>
                                        @error('shipping_country')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Address *</label>
                                        <textarea class="form-control @error('shipping_address') is-invalid @enderror"
                                            name="shipping_address" rows="3" required>{{ old('shipping_address', $user->address ?? '') }}</textarea>
                                        @error('shipping_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>City *</label>
                                        <input type="text" class="form-control @error('shipping_city') is-invalid @enderror"
                                            name="shipping_city" value="{{ old('shipping_city', 'Karachi') }}" required>
                                        @error('shipping_city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>State *</label>
                                        <input type="text" class="form-control @error('shipping_state') is-invalid @enderror"
                                            name="shipping_state" value="{{ old('shipping_state', 'Sindh') }}" required>
                                        @error('shipping_state')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>ZIP Code *</label>
                                        <input type="text" class="form-control @error('shipping_zip') is-invalid @enderror"
                                            name="shipping_zip" value="{{ old('shipping_zip', '75500') }}" required>
                                        @error('shipping_zip')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Billing Address -->
                    <div class="checkout-card">
                        <div class="card-header">
                            <h3><i class="fas fa-credit-card me-2"></i> Billing Address</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="sameAsShipping" name="billing_same_as_shipping" value="1" checked>
                                <label class="form-check-label" for="sameAsShipping">
                                    Same as shipping address
                                </label>
                            </div>

                            <div id="billingAddress" style="display: none;">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Billing Address *</label>
                                            <textarea class="form-control @error('billing_address') is-invalid @enderror"
                                                name="billing_address" rows="3">{{ old('billing_address') }}</textarea>
                                            @error('billing_address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>City *</label>
                                            <input type="text" class="form-control @error('billing_city') is-invalid @enderror"
                                                name="billing_city" value="{{ old('billing_city') }}">
                                            @error('billing_city')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>State *</label>
                                            <input type="text" class="form-control @error('billing_state') is-invalid @enderror"
                                                name="billing_state" value="{{ old('billing_state') }}">
                                            @error('billing_state')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>ZIP Code *</label>
                                            <input type="text" class="form-control @error('billing_zip') is-invalid @enderror"
                                                name="billing_zip" value="{{ old('billing_zip') }}">
                                            @error('billing_zip')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Country *</label>
                                            <select class="form-control @error('billing_country') is-invalid @enderror"
                                                name="billing_country">
                                                <option value="">Select Country</option>
                                                <option value="Pakistan" {{ old('billing_country') == 'Pakistan' ? 'selected' : '' }}>Pakistan</option>
                                                <option value="USA" {{ old('billing_country') == 'USA' ? 'selected' : '' }}>United States</option>
                                                <option value="UK" {{ old('billing_country') == 'UK' ? 'selected' : '' }}>United Kingdom</option>
                                            </select>
                                            @error('billing_country')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="checkout-card">
                        <div class="card-header">
                            <h3><i class="fas fa-credit-card me-2"></i> Payment Method</h3>
                        </div>
                        <div class="card-body">
                            @error('payment_method')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <div class="payment-methods">
                                <div class="payment-option">
                                    <input type="radio" id="cod" name="payment_method" value="cod"
                                        {{ old('payment_method', 'cod') == 'cod' ? 'checked' : '' }} required>
                                    <label for="cod">
                                        <i class="fas fa-money-bill-wave"></i>
                                        <div>
                                            <span class="method-name">Cash on Delivery</span>
                                            <span class="method-desc">Pay when you receive your order</span>
                                        </div>
                                    </label>
                                </div>

                                <div class="payment-option">
                                    <input type="radio" id="credit" name="payment_method" value="credit_card"
                                        {{ old('payment_method') == 'credit_card' ? 'checked' : '' }}>
                                    <label for="credit">
                                        <i class="fas fa-credit-card"></i>
                                        <div>
                                            <span class="method-name">Credit Card</span>
                                            <span class="method-desc">Visa, MasterCard, American Express</span>
                                        </div>
                                    </label>
                                </div>

                                <div class="payment-option">
                                    <input type="radio" id="debit" name="payment_method" value="debit_card"
                                        {{ old('payment_method') == 'debit_card' ? 'checked' : '' }}>
                                    <label for="debit">
                                        <i class="fas fa-credit-card"></i>
                                        <div>
                                            <span class="method-name">Debit Card</span>
                                            <span class="method-desc">All major debit cards</span>
                                        </div>
                                    </label>
                                </div>

                                <div class="payment-option">
                                    <input type="radio" id="bank" name="payment_method" value="bank_transfer"
                                        {{ old('payment_method') == 'bank_transfer' ? 'checked' : '' }}>
                                    <label for="bank">
                                        <i class="fas fa-university"></i>
                                        <div>
                                            <span class="method-name">Bank Transfer</span>
                                            <span class="method-desc">Direct bank transfer</span>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Credit Card Form (hidden by default) -->
                            <div id="cardDetails" class="card-details" style="display: none;">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label>Card Number</label>
                                        <input type="text" class="form-control" placeholder="1234 5678 9012 3456">
                                    </div>
                                    <div class="col-md-6">
                                        <label>Expiry Date</label>
                                        <input type="text" class="form-control" placeholder="MM/YY">
                                    </div>
                                    <div class="col-md-6">
                                        <label>CVV</label>
                                        <input type="text" class="form-control" placeholder="123">
                                    </div>
                                    <div class="col-12">
                                        <label>Cardholder Name</label>
                                        <input type="text" class="form-control" placeholder="John Doe">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Notes -->
                    <div class="checkout-card">
                        <div class="card-header">
                            <h3><i class="fas fa-sticky-note me-2"></i> Order Notes (Optional)</h3>
                        </div>
                        <div class="card-body">
                            <textarea class="form-control" name="notes" rows="3"
                                placeholder="Special instructions for your order...">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                    
                    <!-- Terms Agreement -->
                    <div class="checkout-card">
                        <div class="card-body">
                            <div class="form-check">
                                <input class="form-check-input @error('agree_terms') is-invalid @enderror" 
                                       type="checkbox" id="agreeTerms" name="agree_terms" value="1"
                                       {{ old('agree_terms') ? 'checked' : '' }} required>
                                <label class="form-check-label" for="agreeTerms">
                                    I agree to the <a href="{{ route('policies.terms') }}" target="_blank">Terms of Service</a> and <a href="{{ route('policies.privacy') }}" target="_blank">Privacy Policy</a>
                                </label>
                                @error('agree_terms')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100 checkout-btn">
                        <i class="fas fa-lock me-2"></i>
                        Place Order Securely
                    </button>
                </form>
            </div>

            <!-- Right Column - Order Summary -->
            <div class="col-lg-4">
                <div class="order-summary-card">
                    <h3 class="summary-title">Order Summary</h3>

                    <!-- Order Items -->
                    <div class="order-items">
                        @forelse($items as $item)
                        <div class="order-item">
                            <div class="item-image">
                            </div>
                            <div class="item-details">
                                <h6 class="item-name">{{ $item['product']->name }}</h6>
                                <div class="item-meta">
                                    <span class="item-quantity">Qty: {{ $item['quantity'] }}</span>
                                    <span class="item-price">{{ config('settings.currency_symbol', 'Rs.') }}{{ number_format($item['price'], 2) }}</span>
                                </div>
                            </div>
                            <div class="item-total">
                                {{ config('settings.currency_symbol', 'Rs.') }}{{ number_format($item['total'], 2) }}
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-3">
                            <p class="text-muted">No items in cart</p>
                        </div>
                        @endforelse
                    </div>

                    <!-- Order Totals -->
                    <div class="order-totals">
                        <div class="total-row">
                            <span>Subtotal</span>
                            <span>{{ config('settings.currency_symbol', 'Rs.') }}{{ number_format($subtotal, 2) }}</span>
                        </div>

                        <div class="total-row">
                            <span>Shipping</span>
                            <span>
                                @if($shippingCost > 0)
                                {{ config('settings.currency_symbol', 'Rs.') }}{{ number_format($shippingCost, 2) }}
                                @else
                                FREE
                                @endif
                            </span>
                        </div>

                        <div class="total-row">
                            <span>Tax</span>
                            <span>{{ config('settings.currency_symbol', 'Rs.') }}{{ number_format($taxAmount, 2) }}</span>
                        </div>

                        <div class="total-row grand-total">
                            <span>Total</span>
                            <span>{{ config('settings.currency_symbol', 'Rs.') }}{{ number_format($total, 2) }}</span>
                        </div>
                    </div>

                    <!-- Shipping Info -->
                    @if($subtotal < $freeShippingThreshold)
                    <div class="shipping-info">
                        <i class="fas fa-info-circle"></i>
                        <span>Add <strong>{{ config('settings.currency_symbol', 'Rs.') }}{{ number_format($freeShippingThreshold - $subtotal, 2) }}</strong> more for free shipping!</span>
                    </div>
                    @else
                    <div class="shipping-info success">
                        <i class="fas fa-check-circle"></i>
                        <span>Free shipping applied!</span>
                    </div>
                    @endif

                    <div class="security-assurance">
                        <i class="fas fa-shield-alt"></i>
                        <small>Your payment is secure and encrypted</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Checkout Hero */
    .checkout-hero {
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-color) 100%);
        padding: 2rem 0;
        color: white;
        text-align: center;
    }

    .hero-title {
        font-size: 2.5rem;
        margin-bottom: 0.5rem;
    }

    .hero-subtitle {
        opacity: 0.9;
        margin-bottom: 1.5rem;
    }

    .security-badges {
        display: flex;
        justify-content: center;
        gap: 1.5rem;
        flex-wrap: wrap;
    }

    .security-badges .badge {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(255, 255, 255, 0.1);
        padding: 0.5rem 1rem;
        border-radius: 20px;
        backdrop-filter: blur(10px);
    }

    /* Checkout Steps */
    .checkout-steps {
        display: flex;
        justify-content: space-between;
        margin: 2rem 0;
        position: relative;
    }

    .checkout-steps::before {
        content: '';
        position: absolute;
        top: 25px;
        left: 50px;
        right: 50px;
        height: 2px;
        background: var(--border-color);
        z-index: 1;
    }

    .step {
        display: flex;
        align-items: center;
        gap: 1rem;
        position: relative;
        z-index: 2;
        background: white;
        padding: 0 1rem;
    }

    .step-number {
        width: 50px;
        height: 50px;
        background: var(--surface-color);
        border: 2px solid var(--border-color);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        color: var(--text-muted);
        transition: all 0.3s;
    }

    .step.active .step-number {
        background: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
    }

    .step-content {
        display: flex;
        flex-direction: column;
    }

    .step-title {
        font-weight: 600;
        color: var(--text-primary);
    }

    .step-subtitle {
        font-size: 0.875rem;
        color: var(--text-muted);
    }

    /* Checkout Cards */
    .checkout-card {
        background: white;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        border: 1px solid var(--border-color);
        overflow: hidden;
    }

    .card-header {
        background: var(--surface-color);
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--border-color);
    }

    .card-header h3 {
        margin: 0;
        font-size: 1.25rem;
        color: var(--text-primary);
    }

    .card-body {
        padding: 1.5rem;
    }

    /* Form Styles */
    .form-group {
        margin-bottom: 1rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: var(--text-primary);
    }

    .form-control {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        background: var(--surface-color);
        color: var(--text-primary);
        transition: all 0.3s;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(17, 80, 40, 0.1);
    }

    .form-control.is-invalid {
        border-color: #dc3545;
    }

    .form-control.is-invalid:focus {
        box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.25);
    }

    /* Payment Methods */
    .payment-methods {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .payment-option {
        position: relative;
    }

    .payment-option input[type="radio"] {
        position: absolute;
        opacity: 0;
    }

    .payment-option label {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        border: 2px solid var(--border-color);
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s;
        background: var(--surface-color);
    }

    .payment-option input[type="radio"]:checked+label {
        border-color: var(--primary-color);
        background: rgba(17, 80, 40, 0.05);
    }

    .payment-option label i {
        font-size: 1.5rem;
        color: var(--primary-color);
        width: 24px;
        text-align: center;
    }

    .payment-option .method-name {
        display: block;
        font-weight: 600;
        color: var(--text-primary);
    }

    .payment-option .method-desc {
        display: block;
        font-size: 0.875rem;
        color: var(--text-muted);
    }

    /* Order Summary */
    .order-summary-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        border: 1px solid var(--border-color);
        position: sticky;
        top: 100px;
    }

    .summary-title {
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--border-color);
        color: var(--text-primary);
    }

    .order-items {
        max-height: 300px;
        overflow-y: auto;
        margin-bottom: 1.5rem;
    }

    .order-item {
        display: flex;
        gap: 1rem;
        padding: 1rem 0;
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
        font-size: 0.875rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
        color: var(--text-primary);
    }

    .item-meta {
        display: flex;
        justify-content: space-between;
        font-size: 0.75rem;
        color: var(--text-muted);
    }

    .item-total {
        font-weight: 600;
        color: var(--text-primary);
    }

    /* Order Totals */
    .order-totals {
        margin: 1.5rem 0;
        padding: 1rem 0;
        border-top: 1px solid var(--border-color);
        border-bottom: 1px solid var(--border-color);
    }

    .total-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.75rem;
        color: var(--text-secondary);
    }

    .total-row:last-child {
        margin-bottom: 0;
    }

    .grand-total {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid var(--border-color);
    }

    /* Shipping Info */
    .shipping-info {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem;
        background: rgba(52, 152, 219, 0.1);
        border-radius: 8px;
        color: #3498db;
        font-size: 0.875rem;
        margin-bottom: 1rem;
    }

    .shipping-info.success {
        background: rgba(46, 204, 113, 0.1);
        color: #27ae60;
    }

    .shipping-info i {
        font-size: 1rem;
    }

    /* Checkout Button */
    .checkout-btn {
        padding: 1rem;
        font-size: 1.1rem;
        font-weight: 600;
        transition: all 0.3s;
        width: 100%;
    }

    .checkout-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .checkout-btn:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    .security-assurance {
        text-align: center;
        color: var(--text-muted);
        margin-top: 1rem;
        font-size: 0.875rem;
    }

    .security-assurance i {
        color: var(--success-color);
        margin-right: 0.5rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .checkout-steps {
            flex-direction: column;
            gap: 1rem;
        }

        .checkout-steps::before {
            display: none;
        }

        .step {
            padding: 0;
        }

        .order-summary-card {
            position: static;
            margin-top: 2rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Checkout page loaded');
        
        // Billing address toggle
        const sameAsShipping = document.getElementById('sameAsShipping');
        const billingAddress = document.getElementById('billingAddress');
        
        if (sameAsShipping && billingAddress) {
            sameAsShipping.addEventListener('change', function() {
                const billingFields = document.querySelectorAll('#billingAddress [name^="billing_"]');
                
                if (this.checked) {
                    billingAddress.style.display = 'none';
                    // Remove required attribute when same as shipping
                    billingFields.forEach(field => {
                        field.removeAttribute('required');
                        field.value = '';
                    });
                } else {
                    billingAddress.style.display = 'block';
                    // Add required attribute
                    billingFields.forEach(field => {
                        field.setAttribute('required', 'required');
                    });
                }
            });
            
            // Trigger change event on page load
            sameAsShipping.dispatchEvent(new Event('change'));
        }

        // Payment method toggle
        const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
        const cardDetails = document.getElementById('cardDetails');
        
        if (paymentMethods.length > 0 && cardDetails) {
            paymentMethods.forEach(method => {
                method.addEventListener('change', function() {
                    if (this.value === 'credit_card' || this.value === 'debit_card') {
                        cardDetails.style.display = 'block';
                    } else {
                        cardDetails.style.display = 'none';
                    }
                });
            });

            // Initialize based on selected payment method
            const selectedPaymentMethod = document.querySelector('input[name="payment_method"]:checked');
            if (selectedPaymentMethod && (selectedPaymentMethod.value === 'credit_card' || selectedPaymentMethod.value === 'debit_card')) {
                cardDetails.style.display = 'block';
            }
        }

        // Form submission handler
        const checkoutForm = document.getElementById('checkoutForm');
        const checkoutBtn = document.querySelector('.checkout-btn');
        
        if (checkoutForm && checkoutBtn) {
            checkoutForm.addEventListener('submit', function(e) {
                console.log('Form submission started');
                
                // Check if agree to terms is checked
                const agreeTerms = document.getElementById('agreeTerms');
                if (agreeTerms && !agreeTerms.checked) {
                    e.preventDefault();
                    alert('Please agree to the terms and conditions');
                    agreeTerms.focus();
                    return false;
                }
                
                // Validate required fields
                const requiredFields = this.querySelectorAll('[required]');
                let isValid = true;
                let firstInvalidField = null;
                
                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        isValid = false;
                        if (!firstInvalidField) {
                            firstInvalidField = field;
                        }
                        field.classList.add('is-invalid');
                    } else {
                        field.classList.remove('is-invalid');
                    }
                });
                
                if (!isValid) {
                    e.preventDefault();
                    alert('Please fill in all required fields');
                    if (firstInvalidField) {
                        firstInvalidField.focus();
                    }
                    return false;
                }
                
                // Disable button to prevent double submission
                checkoutBtn.disabled = true;
                checkoutBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Processing Order...';
                
                console.log('Form validation passed, submitting...');
                // Continue with form submission
                return true;
            });
        }

        // Phone number formatting
        const phoneInput = document.querySelector('input[name="shipping_phone"]');
        if (phoneInput) {
            phoneInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 4) {
                    value = value.slice(0, 4) + '-' + value.slice(4, 11);
                }
                e.target.value = value;
            });
        }

        // Show validation errors on page load
        @if($errors->any())
            setTimeout(() => {
                const firstError = document.querySelector('.is-invalid');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    firstError.focus();
                }
            }, 100);
        @endif
    });
</script>
@endpush