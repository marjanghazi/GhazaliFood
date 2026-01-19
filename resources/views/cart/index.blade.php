@extends('layouts.app')

@section('title', 'Shopping Cart - Premium Dry Fruits Store | Ghazali Food')

@section('hero')
<section class="cart-hero">
    <div class="container">
        <div class="hero-inner">
            <nav class="breadcrumb-nav">
                <a href="{{ url('/') }}" class="breadcrumb-link">Home</a>
                <span class="breadcrumb-separator">/</span>
                <a href="{{ route('shop.index') }}" class="breadcrumb-link">Shop</a>
                <span class="breadcrumb-separator">/</span>
                <span class="breadcrumb-current">Shopping Cart</span>
            </nav>
            <h1 class="page-title">Shopping Cart</h1>
        </div>
    </div>
</section>
@endsection

@section('content')
<div class="container">
    <!-- Success & Error Messages -->
    @if(session('success'))
    <div class="alert-message success fade-in">
        <div class="alert-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="alert-content">
            <h6>Success!</h6>
            <p>{{ session('success') }}</p>
        </div>
        <button class="alert-close" onclick="this.parentElement.remove()">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert-message error fade-in">
        <div class="alert-icon">
            <i class="fas fa-exclamation-circle"></i>
        </div>
        <div class="alert-content">
            <h6>Error!</h6>
            <p>{{ session('error') }}</p>
        </div>
        <button class="alert-close" onclick="this.parentElement.remove()">
            <i class="fas fa-times"></i>
        </button>
    </div>
    @endif

    @if(count($products) > 0)
    <div class="cart-layout">
        <!-- Cart Items Section -->
        <div class="cart-main">
            <!-- Cart Header -->
            <div class="cart-header">
                <h2 class="cart-title">
                    <i class="fas fa-shopping-basket me-2"></i>
                    Your Cart Items
                </h2>
                <span class="cart-count">{{ count($products) }} item{{ count($products) > 1 ? 's' : '' }}</span>
            </div>

            <!-- Cart Items List -->
            <div class="cart-items">
                @foreach($products as $item)
                <div class="cart-item" data-id="{{ $item['product']->id }}">
                    <!-- Product Image -->
                    <div class="cart-item-image">
                        <a href="{{ route('shop.show', $item['product']->slug) }}">
                            <img src="{{ $item['product']->primaryImage->media_url ?? 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80' }}" 
                                 alt="{{ $item['product']->name }}">
                        </a>
                        @if($item['product']->is_new_arrival)
                        <span class="image-badge badge-new">
                            <i class="fas fa-star"></i> New
                        </span>
                        @endif
                    </div>

                    <!-- Product Info -->
                    <div class="cart-item-info">
                        <div class="product-header">
                            <h3 class="product-name">
                                <a href="{{ route('shop.show', $item['product']->slug) }}">
                                    {{ $item['product']->name }}
                                </a>
                            </h3>
                            <span class="product-category">
                                {{ $item['product']->category->name ?? 'Uncategorized' }}
                            </span>
                        </div>

                        <div class="product-details">
                            <div class="product-price">
                                <span class="current-price">${{ number_format($item['product']->best_price, 2) }}</span>
                                @if($item['product']->compare_at_price)
                                <span class="original-price">${{ number_format($item['product']->compare_at_price, 2) }}</span>
                                @endif
                            </div>

                            @if($item['product']->compare_at_price)
                            <div class="savings-badge">
                                <i class="fas fa-percentage"></i>
                                Save {{ $item['product']->discount_percentage }}%
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Quantity Controls -->
                    <div class="cart-item-controls">
                        <div class="quantity-section">
                            <label>Quantity:</label>
                            <div class="quantity-controls">
                                <button class="quantity-btn minus" data-id="{{ $item['product']->id }}">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number" 
                                       class="quantity-input" 
                                       value="{{ $item['quantity'] }}" 
                                       min="1" 
                                       max="99"
                                       data-id="{{ $item['product']->id }}">
                                <button class="quantity-btn plus" data-id="{{ $item['product']->id }}">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Subtotal & Actions -->
                    <div class="cart-item-subtotal">
                        <div class="subtotal-info">
                            <span class="subtotal-label">Subtotal:</span>
                            <span class="subtotal-amount">${{ number_format($item['subtotal'], 2) }}</span>
                        </div>
                        <div class="item-actions">
                            <button class="action-btn remove-item" 
                                    data-id="{{ $item['product']->id }}"
                                    title="Remove item">
                                <i class="fas fa-trash"></i>
                            </button>
                            <button class="action-btn wishlist-btn" 
                                    data-id="{{ $item['product']->id }}"
                                    title="Move to wishlist">
                                <i class="far fa-heart"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Cart Actions -->
            <div class="cart-actions">
                <a href="{{ route('shop.index') }}" class="btn btn-outline">
                    <i class="fas fa-arrow-left me-2"></i> Continue Shopping
                </a>
                <div class="cart-buttons">
                    <button class="btn btn-danger" id="clearCartBtn">
                        <i class="fas fa-trash me-2"></i> Clear Cart
                    </button>
                    <a href="{{ route('shop.index', ['featured' => true]) }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i> Add More Items
                    </a>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="order-summary">
            <!-- Summary Card -->
            <div class="summary-card">
                <div class="summary-header">
                    <h3>
                        <i class="fas fa-receipt me-2"></i> Order Summary
                    </h3>
                </div>

                <div class="summary-body">
                    <!-- Order Items -->
                    <div class="order-items">
                        <h4>Order Details</h4>
                        <div class="items-list">
                            @foreach($products as $item)
                            <div class="summary-item">
                                <div class="item-info">
                                    <span class="item-name">{{ $item['product']->name }}</span>
                                    <span class="item-quantity">×{{ $item['quantity'] }}</span>
                                </div>
                                <span class="item-total">${{ number_format($item['subtotal'], 2) }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Price Breakdown -->
                    <div class="price-breakdown">
                        <div class="breakdown-row">
                            <span>Subtotal</span>
                            <span class="amount">${{ number_format($cartTotal, 2) }}</span>
                        </div>

                        <div class="breakdown-row">
                            <span>Shipping</span>
                            <span class="amount">
                                @if($cartTotal >= 50)
                                <span class="free-shipping">Free</span>
                                @else
                                $5.00
                                @endif
                            </span>
                        </div>

                        <div class="breakdown-row">
                            <span>Tax (10%)</span>
                            <span class="amount">${{ number_format($cartTotal * 0.1, 2) }}</span>
                        </div>

                        @if($cartTotal >= 50)
                        <div class="breakdown-row discount">
                            <span>
                                <i class="fas fa-gift me-1"></i> Shipping Discount
                            </span>
                            <span class="amount">-$5.00</span>
                        </div>
                        @endif

                        <div class="breakdown-divider"></div>

                        <div class="breakdown-total">
                            <span>Total Amount</span>
                            <span class="total-amount">
                                ${{ number_format($cartTotal + ($cartTotal * 0.1) + ($cartTotal >= 50 ? 0 : 5), 2) }}
                            </span>
                        </div>
                    </div>

                    <!-- Checkout Button -->
                    <div class="checkout-section">
                        <a href="{{ route('checkout') }}" class="btn btn-primary checkout-btn">
                            <i class="fas fa-lock me-2"></i> Proceed to Checkout
                        </a>

                        <!-- Secure Payment -->
                        <div class="secure-payment">
                            <p class="secure-label">
                                <i class="fas fa-shield-alt me-1"></i> Secure Payment
                            </p>
                            <div class="payment-icons">
                                <i class="fab fa-cc-visa"></i>
                                <i class="fab fa-cc-mastercard"></i>
                                <i class="fab fa-cc-amex"></i>
                                <i class="fab fa-cc-paypal"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Coupon Card -->
            <div class="coupon-card">
                <div class="coupon-header">
                    <h4>
                        <i class="fas fa-tag me-2"></i> Apply Coupon
                    </h4>
                </div>
                <div class="coupon-body">
                    <div class="coupon-form">
                        <input type="text" 
                               class="form-control" 
                               placeholder="Enter coupon code"
                               aria-label="Coupon code">
                        <button class="btn btn-primary">Apply</button>
                    </div>
                    <p class="coupon-tips">
                        Available coupons: <span>SAVE10</span>, <span>WELCOME15</span>
                    </p>
                </div>
            </div>

            <!-- Shipping Info Card -->
            <div class="shipping-card">
                <div class="shipping-header">
                    <h4>
                        <i class="fas fa-shipping-fast me-2"></i> Shipping Information
                    </h4>
                </div>
                <div class="shipping-body">
                    <ul class="shipping-features">
                        <li>
                            <i class="fas fa-check-circle"></i>
                            Free shipping on orders over $50
                        </li>
                        <li>
                            <i class="fas fa-check-circle"></i>
                            Same-day shipping before 2 PM
                        </li>
                        <li>
                            <i class="fas fa-check-circle"></i>
                            30-day return policy
                        </li>
                        <li>
                            <i class="fas fa-check-circle"></i>
                            Secure packaging guaranteed
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @else
    <!-- Empty Cart -->
    <div class="empty-cart">
        <div class="empty-cart-icon">
            <i class="fas fa-shopping-basket"></i>
        </div>
        <h2>Your cart is empty</h2>
        <p class="empty-message">
            Looks like you haven't added any premium items to your cart yet.
        </p>
        
        <div class="empty-actions">
            <a href="{{ route('shop.index') }}" class="btn btn-primary">
                <i class="fas fa-store me-2"></i> Start Shopping
            </a>
            <a href="{{ route('shop.index', ['featured' => true]) }}" class="btn btn-outline">
                <i class="fas fa-star me-2"></i> View Featured
            </a>
        </div>

        <!-- Popular Categories -->
        <div class="popular-categories">
            <h4>Popular Categories</h4>
            <div class="category-buttons">
                <a href="{{ route('shop.index', ['category' => 'almonds']) }}" class="category-btn">
                    Almonds
                </a>
                <a href="{{ route('shop.index', ['category' => 'cashews']) }}" class="category-btn">
                    Cashews
                </a>
                <a href="{{ route('shop.index', ['category' => 'dates']) }}" class="category-btn">
                    Dates
                </a>
                <a href="{{ route('shop.index', ['category' => 'raisins']) }}" class="category-btn">
                    Raisins
                </a>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Newsletter Section -->
<section class="newsletter-section">
    <div class="container">
        <div class="newsletter-content">
            <div class="newsletter-text">
                <h2>Don't Miss Out!</h2>
                <p>Subscribe for exclusive deals and new product alerts.</p>
            </div>
            <form class="newsletter-form">
                <div class="input-group">
                    <input type="email" 
                           class="form-control" 
                           placeholder="Your email address" 
                           required>
                    <button type="submit" class="btn btn-light">
                        <i class="fas fa-paper-plane me-2"></i> Subscribe
                    </button>
                </div>
                <p class="form-note">We respect your privacy. Unsubscribe at any time.</p>
            </form>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    /* Cart Hero */
    .cart-hero {
        background: var(--surface-color);
        padding: 2rem 0;
        border-bottom: 1px solid var(--border-color);
    }
    
    .cart-hero .hero-inner {
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .page-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-top: 1rem;
    }
    
    /* Alert Messages */
    .alert-message {
        display: flex;
        align-items: center;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 2rem;
        animation: slideDown 0.3s ease;
        border-left: 4px solid;
    }
    
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .alert-message.success {
        background: rgba(46, 204, 113, 0.1);
        border-left-color: var(--success-color);
    }
    
    .alert-message.error {
        background: rgba(231, 76, 60, 0.1);
        border-left-color: var(--danger-color);
    }
    
    .alert-icon {
        font-size: 1.5rem;
        margin-right: 1rem;
    }
    
    .alert-message.success .alert-icon {
        color: var(--success-color);
    }
    
    .alert-message.error .alert-icon {
        color: var(--danger-color);
    }
    
    .alert-content h6 {
        margin: 0 0 0.25rem 0;
        font-weight: 600;
    }
    
    .alert-content p {
        margin: 0;
        color: var(--text-secondary);
    }
    
    .alert-close {
        background: none;
        border: none;
        color: var(--text-muted);
        cursor: pointer;
        margin-left: auto;
        padding: 0.5rem;
    }
    
    .alert-close:hover {
        color: var(--text-primary);
    }
    
    /* Cart Layout */
    .cart-layout {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2rem;
        margin: 2rem 0;
    }
    
    @media (max-width: 992px) {
        .cart-layout {
            grid-template-columns: 1fr;
        }
    }
    
    /* Cart Header */
    .cart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--border-color);
    }
    
    .cart-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--text-primary);
        display: flex;
        align-items: center;
    }
    
    .cart-count {
        background: var(--primary-color);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.875rem;
    }
    
    /* Cart Items */
    .cart-items {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }
    
    .cart-item {
        display: grid;
        grid-template-columns: 100px 1fr auto auto;
        gap: 1.5rem;
        padding: 1.5rem;
        background: white;
        border-radius: 12px;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
        align-items: center;
    }
    
    .cart-item:hover {
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        transform: translateY(-2px);
    }
    
    @media (max-width: 768px) {
        .cart-item {
            grid-template-columns: 1fr;
            text-align: center;
        }
    }
    
    /* Cart Item Image */
    .cart-item-image {
        position: relative;
        overflow: hidden;
        border-radius: 8px;
    }
    
    .cart-item-image img {
        width: 100%;
        height: 100px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    
    .cart-item:hover .cart-item-image img {
        transform: scale(1.05);
    }
    
    .image-badge {
        position: absolute;
        top: 8px;
        left: 8px;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 4px;
    }
    
    .badge-new {
        background: var(--gradient-gold);
        color: var(--text-primary);
    }
    
    /* Cart Item Info */
    .cart-item-info {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }
    
    .product-header {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }
    
    .product-name {
        margin: 0;
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--text-primary);
    }
    
    .product-name a {
        color: inherit;
        text-decoration: none;
        transition: color 0.2s;
    }
    
    .product-name a:hover {
        color: var(--primary-color);
    }
    
    .product-category {
        font-size: 0.875rem;
        color: var(--text-muted);
    }
    
    .product-details {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
    }
    
    .product-price {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .current-price {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--primary-color);
    }
    
    .original-price {
        font-size: 1rem;
        color: var(--text-muted);
        text-decoration: line-through;
    }
    
    .savings-badge {
        background: rgba(231, 76, 60, 0.1);
        color: var(--danger-color);
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.875rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    
    /* Quantity Controls */
    .cart-item-controls {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        min-width: 120px;
    }
    
    .quantity-section label {
        display: block;
        font-size: 0.875rem;
        color: var(--text-secondary);
        margin-bottom: 0.5rem;
    }
    
    .quantity-controls {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .quantity-btn {
        width: 32px;
        height: 32px;
        border: 1px solid var(--border-color);
        background: white;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
        color: var(--text-primary);
    }
    
    .quantity-btn:hover {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }
    
    .quantity-input {
        width: 50px;
        height: 32px;
        text-align: center;
        border: 1px solid var(--border-color);
        border-radius: 6px;
        font-weight: 600;
        color: var(--text-primary);
    }
    
    .quantity-input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(17, 80, 40, 0.1);
    }
    
    /* Subtotal & Actions */
    .cart-item-subtotal {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        min-width: 140px;
        text-align: right;
    }
    
    .subtotal-info {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }
    
    .subtotal-label {
        font-size: 0.875rem;
        color: var(--text-secondary);
    }
    
    .subtotal-amount {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--primary-color);
    }
    
    .item-actions {
        display: flex;
        gap: 0.5rem;
        justify-content: flex-end;
    }
    
    .action-btn {
        width: 32px;
        height: 32px;
        border: 1px solid var(--border-color);
        background: white;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
        color: var(--text-secondary);
    }
    
    .action-btn:hover {
        background: var(--surface-color);
        color: var(--text-primary);
    }
    
    .remove-item:hover {
        background: rgba(231, 76, 60, 0.1);
        color: var(--danger-color);
        border-color: rgba(231, 76, 60, 0.2);
    }
    
    .wishlist-btn:hover {
        background: rgba(249, 24, 128, 0.1);
        color: #f91880;
        border-color: rgba(249, 24, 128, 0.2);
    }
    
    /* Cart Actions */
    .cart-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 2px solid var(--border-color);
    }
    
    .cart-buttons {
        display: flex;
        gap: 1rem;
    }
    
    @media (max-width: 576px) {
        .cart-actions {
            flex-direction: column;
            gap: 1rem;
        }
        
        .cart-buttons {
            width: 100%;
        }
        
        .cart-buttons .btn {
            flex: 1;
        }
    }
    
    /* Order Summary */
    .order-summary {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }
    
    /* Summary Card */
    .summary-card {
        background: white;
        border-radius: 12px;
        border: 1px solid var(--border-color);
        overflow: hidden;
    }
    
    .summary-header {
        padding: 1.5rem;
        background: var(--surface-color);
        border-bottom: 1px solid var(--border-color);
    }
    
    .summary-header h3 {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-primary);
        display: flex;
        align-items: center;
    }
    
    .summary-body {
        padding: 1.5rem;
    }
    
    /* Order Items */
    .order-items h4 {
        margin: 0 0 1rem 0;
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-primary);
    }
    
    .items-list {
        max-height: 200px;
        overflow-y: auto;
        padding-right: 0.5rem;
        margin-bottom: 1.5rem;
    }
    
    .items-list::-webkit-scrollbar {
        width: 6px;
    }
    
    .items-list::-webkit-scrollbar-track {
        background: var(--border-color);
        border-radius: 10px;
    }
    
    .items-list::-webkit-scrollbar-thumb {
        background: var(--primary-color);
        border-radius: 10px;
    }
    
    .summary-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem;
        margin-bottom: 0.5rem;
        background: var(--surface-color);
        border-radius: 8px;
    }
    
    .item-info {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }
    
    .item-name {
        font-size: 0.875rem;
        color: var(--text-primary);
        font-weight: 500;
    }
    
    .item-quantity {
        font-size: 0.75rem;
        color: var(--text-muted);
    }
    
    .item-total {
        font-weight: 600;
        color: var(--text-primary);
    }
    
    /* Price Breakdown */
    .price-breakdown {
        margin: 1.5rem 0;
    }
    
    .breakdown-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px dashed var(--border-color);
    }
    
    .breakdown-row:last-child {
        border-bottom: none;
    }
    
    .breakdown-row span:first-child {
        color: var(--text-secondary);
    }
    
    .breakdown-row .amount {
        font-weight: 500;
        color: var(--text-primary);
    }
    
    .free-shipping {
        color: var(--success-color);
        font-weight: 600;
    }
    
    .breakdown-row.discount {
        background: rgba(46, 204, 113, 0.1);
        padding: 0.75rem;
        border-radius: 8px;
        margin: 0.75rem 0;
    }
    
    .breakdown-row.discount span:first-child {
        color: var(--success-color);
        font-weight: 600;
    }
    
    .breakdown-row.discount .amount {
        color: var(--success-color);
        font-weight: 600;
    }
    
    .breakdown-divider {
        height: 2px;
        background: var(--border-color);
        margin: 1rem 0;
    }
    
    .breakdown-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 0;
    }
    
    .breakdown-total span:first-child {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--text-primary);
    }
    
    .total-amount {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary-color);
    }
    
    /* Checkout Section */
    .checkout-section {
        margin-top: 2rem;
    }
    
    .checkout-btn {
        width: 100%;
        padding: 1rem;
        font-size: 1.125rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }
    
    .secure-payment {
        text-align: center;
        padding: 1rem;
        border-top: 1px solid var(--border-color);
    }
    
    .secure-label {
        margin: 0 0 0.75rem 0;
        color: var(--text-secondary);
        font-size: 0.875rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
    }
    
    .payment-icons {
        display: flex;
        justify-content: center;
        gap: 1rem;
        font-size: 1.5rem;
        color: var(--text-muted);
    }
    
    /* Coupon Card */
    .coupon-card,
    .shipping-card {
        background: white;
        border-radius: 12px;
        border: 1px solid var(--border-color);
        overflow: hidden;
    }
    
    .coupon-header,
    .shipping-header {
        padding: 1rem 1.5rem;
        background: var(--surface-color);
        border-bottom: 1px solid var(--border-color);
    }
    
    .coupon-header h4,
    .shipping-header h4 {
        margin: 0;
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--text-primary);
        display: flex;
        align-items: center;
    }
    
    .coupon-body,
    .shipping-body {
        padding: 1.5rem;
    }
    
    .coupon-form {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }
    
    .coupon-form .form-control {
        flex: 1;
    }
    
    .coupon-tips {
        margin: 0;
        font-size: 0.875rem;
        color: var(--text-secondary);
    }
    
    .coupon-tips span {
        color: var(--primary-color);
        font-weight: 500;
        margin: 0 2px;
    }
    
    /* Shipping Features */
    .shipping-features {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .shipping-features li {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 0;
        color: var(--text-secondary);
    }
    
    .shipping-features li:not(:last-child) {
        border-bottom: 1px dashed var(--border-color);
    }
    
    .shipping-features li i {
        color: var(--success-color);
        font-size: 1rem;
    }
    
    /* Empty Cart */
    .empty-cart {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 12px;
        border: 1px solid var(--border-color);
        margin: 2rem 0;
    }
    
    .empty-cart-icon {
        font-size: 4rem;
        color: var(--text-muted);
        margin-bottom: 1.5rem;
        opacity: 0.5;
    }
    
    .empty-cart h2 {
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 1rem;
    }
    
    .empty-message {
        font-size: 1.125rem;
        color: var(--text-secondary);
        max-width: 500px;
        margin: 0 auto 2rem;
        line-height: 1.6;
    }
    
    .empty-actions {
        display: flex;
        gap: 1rem;
        justify-content: center;
        margin-bottom: 3rem;
    }
    
    @media (max-width: 576px) {
        .empty-actions {
            flex-direction: column;
        }
    }
    
    /* Popular Categories */
    .popular-categories {
        max-width: 600px;
        margin: 0 auto;
    }
    
    .popular-categories h4 {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 1.5rem;
    }
    
    .category-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        justify-content: center;
    }
    
    .category-btn {
        padding: 0.75rem 1.5rem;
        background: var(--surface-color);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        color: var(--text-primary);
        text-decoration: none;
        font-weight: 500;
        transition: all 0.2s;
    }
    
    .category-btn:hover {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
        transform: translateY(-2px);
    }
    
    /* Newsletter Section */
    .newsletter-section {
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-color) 100%);
        padding: 3rem 0;
        margin-top: 3rem;
    }
    
    .newsletter-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        max-width: 1200px;
        margin: 0 auto;
    }
    
    .newsletter-text h2 {
        color: white;
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .newsletter-text p {
        color: rgba(255, 255, 255, 0.9);
        margin: 0;
    }
    
    .newsletter-form {
        min-width: 400px;
    }
    
    .newsletter-form .input-group {
        margin-bottom: 0.5rem;
    }
    
    .form-note {
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.875rem;
        margin: 0;
    }
    
    @media (max-width: 768px) {
        .newsletter-content {
            flex-direction: column;
            text-align: center;
            gap: 2rem;
        }
        
        .newsletter-form {
            min-width: 100%;
        }
    }
    
    /* Fade Out Animation */
    .fading-out {
        opacity: 0;
        transform: translateX(-20px);
        transition: opacity 0.3s ease, transform 0.3s ease;
    }
    
    /* Button Styles */
    .btn {
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        border-radius: 8px;
        transition: all 0.2s;
        border: 2px solid transparent;
    }
    
    .btn-primary {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }
    
    .btn-primary:hover {
        background: var(--primary-dark);
        border-color: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(17, 80, 40, 0.2);
    }
    
    .btn-outline {
        background: transparent;
        border-color: var(--primary-color);
        color: var(--primary-color);
    }
    
    .btn-outline:hover {
        background: var(--primary-color);
        color: white;
        transform: translateY(-2px);
    }
    
    .btn-danger {
        background: var(--danger-color);
        color: white;
        border-color: var(--danger-color);
    }
    
    .btn-danger:hover {
        background: #c0392b;
        border-color: #c0392b;
        transform: translateY(-2px);
    }
    
    .btn-light {
        background: white;
        color: var(--primary-color);
        border-color: white;
    }
    
    .btn-light:hover {
        background: #f8f9fa;
        border-color: #f8f9fa;
        color: var(--primary-color);
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Update cart item quantity
    document.querySelectorAll('.quantity-btn').forEach(button => {
        button.addEventListener('click', async function() {
            const productId = this.dataset.id;
            const input = document.querySelector(`.quantity-input[data-id="${productId}"]`);
            let quantity = parseInt(input.value);
            
            if (this.classList.contains('minus')) {
                if (quantity > 1) {
                    quantity--;
                }
            } else if (this.classList.contains('plus')) {
                if (quantity < 99) {
                    quantity++;
                }
            }
            
            input.value = quantity;
            await updateCartItem(productId, quantity);
        });
    });
    
    // Handle quantity input change
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', async function() {
            const productId = this.dataset.id;
            let quantity = parseInt(this.value);
            
            if (quantity < 1) quantity = 1;
            if (quantity > 99) quantity = 99;
            
            this.value = quantity;
            await updateCartItem(productId, quantity);
        });
    });
    
    // Remove item from cart
    document.querySelectorAll('.remove-item').forEach(button => {
        button.addEventListener('click', async function() {
            const productId = this.dataset.id;
            await showConfirmDialog(
                'Remove Item',
                'Are you sure you want to remove this item from your cart?',
                async () => {
                    await removeCartItem(productId);
                }
            );
        });
    });
    
    // Move to wishlist
    document.querySelectorAll('.wishlist-btn').forEach(button => {
        button.addEventListener('click', async function() {
            const productId = this.dataset.id;
            await addToWishlist(productId);
        });
    });
    
    // Clear entire cart
    document.getElementById('clearCartBtn')?.addEventListener('click', function() {
        showConfirmDialog(
            'Clear Cart',
            'Are you sure you want to clear your entire cart?',
            async () => {
                await clearCart();
            }
        );
    });
    
    // Apply coupon
    document.querySelector('.coupon-form button')?.addEventListener('click', async function() {
        const couponInput = this.previousElementSibling;
        const couponCode = couponInput.value.trim();
        
        if (!couponCode) {
            showToast('Please enter a coupon code', 'error');
            return;
        }
        
        // Simulate coupon validation
        const validCoupons = ['SAVE10', 'WELCOME15'];
        if (validCoupons.includes(couponCode.toUpperCase())) {
            showToast('Coupon applied successfully!', 'success');
            couponInput.value = '';
        } else {
            showToast('Invalid coupon code', 'error');
        }
    });
    
    // Newsletter subscription
    document.querySelector('.newsletter-form button[type="submit"]')?.addEventListener('click', function(e) {
        e.preventDefault();
        const emailInput = this.closest('.input-group').querySelector('input[type="email"]');
        const email = emailInput.value.trim();
        
        if (!email || !isValidEmail(email)) {
            showToast('Please enter a valid email address', 'error');
            return;
        }
        
        // Simulate subscription
        emailInput.value = '';
        showToast('Thank you for subscribing!', 'success');
    });
    
    // Cart functions
    async function updateCartItem(productId, quantity) {
        try {
            const response = await fetch(`/cart/update/${productId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ quantity })
            });
            
            const data = await response.json();
            
            if (data.success) {
                // Update cart count in header
                updateCartCount(data.cart_count);
                
                // Reload page to update totals
                location.reload();
            } else {
                showToast(data.message || 'Error updating cart', 'error');
            }
        } catch (error) {
            console.error('Error updating cart:', error);
            showToast('Network error. Please try again.', 'error');
        }
    }
    
    async function removeCartItem(productId) {
        try {
            const response = await fetch(`/cart/remove/${productId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
            
            const data = await response.json();
            
            if (data.success) {
                // Update cart count
                updateCartCount(data.cart_count);
                
                // Remove item from DOM with animation
                const item = document.querySelector(`.cart-item[data-id="${productId}"]`);
                if (item) {
                    item.classList.add('fading-out');
                    setTimeout(() => {
                        item.remove();
                        
                        // If cart is empty, reload page
                        if (data.cart_count === 0) {
                            location.reload();
                        }
                    }, 300);
                }
                
                showToast('Item removed from cart', 'success');
            } else {
                showToast(data.message || 'Error removing item', 'error');
            }
        } catch (error) {
            console.error('Error removing item:', error);
            showToast('Network error. Please try again.', 'error');
        }
    }
    
    async function clearCart() {
        try {
            const response = await fetch('/cart/clear', {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
            
            const data = await response.json();
            
            if (data.success) {
                updateCartCount(0);
                showToast('Cart cleared successfully', 'success');
                setTimeout(() => location.reload(), 1000);
            } else {
                showToast(data.message || 'Error clearing cart', 'error');
            }
        } catch (error) {
            console.error('Error clearing cart:', error);
            showToast('Network error. Please try again.', 'error');
        }
    }
    
    async function addToWishlist(productId) {
        try {
            const response = await fetch('/wishlist/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ product_id: productId })
            });
            
            const data = await response.json();
            
            if (data.success) {
                showToast('Added to wishlist!', 'success');
            } else {
                showToast(data.message || 'Error adding to wishlist', 'error');
            }
        } catch (error) {
            console.error('Error adding to wishlist:', error);
            showToast('Network error. Please try again.', 'error');
        }
    }
    
    // Utility functions
    function updateCartCount(count) {
        const cartBadges = document.querySelectorAll('.cart-badge');
        cartBadges.forEach(badge => {
            badge.textContent = count;
            badge.style.display = count > 0 ? 'flex' : 'none';
        });
        
        // Update cart header count
        const cartCountElement = document.querySelector('.cart-count');
        if (cartCountElement) {
            cartCountElement.textContent = count + ' item' + (count !== 1 ? 's' : '');
        }
    }
    
    function showConfirmDialog(title, message, onConfirm) {
        // Create modal
        const modalHTML = `
            <div class="confirm-modal" id="confirmModal">
                <div class="modal-backdrop"></div>
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>${title}</h5>
                        <button class="modal-close">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>${message}</p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-outline cancel-btn">Cancel</button>
                        <button class="btn btn-danger confirm-btn">Confirm</button>
                    </div>
                </div>
            </div>
        `;
        
        // Add modal to body
        document.body.insertAdjacentHTML('beforeend', modalHTML);
        const modal = document.getElementById('confirmModal');
        
        // Show modal
        modal.style.display = 'block';
        setTimeout(() => modal.classList.add('show'), 10);
        
        // Handle events
        modal.querySelector('.modal-close').addEventListener('click', closeModal);
        modal.querySelector('.cancel-btn').addEventListener('click', closeModal);
        modal.querySelector('.confirm-btn').addEventListener('click', function() {
            closeModal();
            onConfirm();
        });
        
        function closeModal() {
            modal.classList.remove('show');
            setTimeout(() => {
                modal.remove();
            }, 300);
        }
    }
    
    function showToast(message, type = 'success') {
        // Create toast
        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.innerHTML = `
            <div class="toast-content">
                <i class="fas ${getToastIcon(type)}"></i>
                <span>${message}</span>
            </div>
            <button class="toast-close">&times;</button>
        `;
        
        // Add toast to container
        const container = document.getElementById('toastContainer') || createToastContainer();
        container.appendChild(toast);
        
        // Show toast
        setTimeout(() => toast.classList.add('show'), 10);
        
        // Auto remove
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
        
        // Close button
        toast.querySelector('.toast-close').addEventListener('click', function() {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 300);
        });
    }
    
    function createToastContainer() {
        const container = document.createElement('div');
        container.id = 'toastContainer';
        container.className = 'toast-container';
        document.body.appendChild(container);
        return container;
    }
    
    function getToastIcon(type) {
        const icons = {
            success: 'fa-check-circle',
            error: 'fa-exclamation-circle',
            warning: 'fa-exclamation-triangle',
            info: 'fa-info-circle'
        };
        return icons[type] || icons.info;
    }
    
    function isValidEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }
});
</script>
@endpush