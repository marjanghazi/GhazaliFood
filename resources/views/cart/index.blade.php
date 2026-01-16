@extends('layouts.app')

@section('title', 'Shopping Cart - Premium Dry Fruits Store | Nuts & Berries')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h1 class="section-title mb-4">Shopping Cart</h1>
            
            @if(session('success'))
            <div class="alert alert-success animate-slide-up" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle me-3"></i>
                    <div>{{ session('success') }}</div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
            @endif
            
            @if(session('error'))
            <div class="alert alert-danger animate-slide-up" role="alert">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-circle me-3"></i>
                    <div>{{ session('error') }}</div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
            @endif
        </div>
    </div>

    @if(count($products) > 0)
    <div class="row">
        <!-- Cart Items -->
        <div class="col-lg-8">
            <div class="cart-items bg-surface rounded-3 shadow-md p-4">
                <div class="cart-header mb-4">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-shopping-basket me-2"></i>
                        Your Cart Items ({{ count($products) }})
                    </h5>
                </div>
                
                <div class="cart-body">
                    @foreach($products as $item)
                    <div class="cart-item mb-4 pb-4 border-bottom" data-id="{{ $item['product']->id }}">
                        <div class="row align-items-center">
                            <!-- Product Image -->
                            <div class="col-md-2">
                                <div class="cart-item-image">
                                    <img src="{{ $item['product']->primaryImage->media_url ?? 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?ixlib=rb-4.0.3&auto=format&fit=crop&w=300&q=80' }}" 
                                         alt="{{ $item['product']->name }}"
                                         class="img-fluid rounded-3">
                                </div>
                            </div>
                            
                            <!-- Product Info -->
                            <div class="col-md-5">
                                <div class="cart-item-info">
                                    <h6 class="cart-item-title mb-2">
                                        <a href="{{ route('shop.show', $item['product']->slug) }}" 
                                           class="text-decoration-none">
                                            {{ $item['product']->name }}
                                        </a>
                                    </h6>
                                    <p class="cart-item-category text-muted small mb-2">
                                        {{ $item['product']->category->name ?? 'Uncategorized' }}
                                    </p>
                                    @if($item['product']->compare_at_price)
                                    <div class="cart-item-badges">
                                        <span class="badge bg-success">
                                            Save {{ $item['product']->discount_percentage }}%
                                        </span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Price -->
                            <div class="col-md-2">
                                <div class="cart-item-price">
                                    <span class="current-price fw-bold">${{ number_format($item['product']->best_price, 2) }}</span>
                                    @if($item['product']->compare_at_price)
                                    <span class="old-price text-muted small d-block">
                                        <del>${{ number_format($item['product']->compare_at_price, 2) }}</del>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Quantity -->
                            <div class="col-md-2">
                                <div class="cart-item-quantity">
                                    <div class="quantity-selector">
                                        <button class="quantity-btn quantity-minus" 
                                                type="button"
                                                data-id="{{ $item['product']->id }}">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <input type="number" 
                                               class="quantity-input" 
                                               value="{{ $item['quantity'] }}" 
                                               min="1" 
                                               max="99"
                                               data-id="{{ $item['product']->id }}">
                                        <button class="quantity-btn quantity-plus" 
                                                type="button"
                                                data-id="{{ $item['product']->id }}">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Actions & Subtotal -->
                            <div class="col-md-1">
                                <div class="cart-item-actions text-end">
                                    <div class="cart-item-subtotal mb-2">
                                        <span class="fw-bold text-primary">
                                            ${{ number_format($item['subtotal'], 2) }}
                                        </span>
                                    </div>
                                    <button class="btn btn-outline-danger btn-sm remove-item" 
                                            type="button"
                                            data-id="{{ $item['product']->id }}"
                                            title="Remove item">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Cart Actions -->
                <div class="cart-footer mt-4 pt-3 border-top">
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('shop.index') }}" class="btn btn-outline">
                            <i class="fas fa-arrow-left me-2"></i> Continue Shopping
                        </a>
                        <div class="cart-actions">
                            <button class="btn btn-danger me-2" id="clearCartBtn">
                                <i class="fas fa-trash me-2"></i> Clear Cart
                            </button>
                            <a href="{{ route('shop.index', ['featured' => true]) }}" class="btn btn-primary">
                                <i class="fas fa-bolt me-2"></i> Add Featured Items
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Order Summary -->
        <div class="col-lg-4 mt-4 mt-lg-0">
            <!-- Summary Card -->
            <div class="order-summary bg-surface rounded-3 shadow-md p-4 mb-4">
                <div class="summary-header mb-4">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-receipt me-2"></i> Order Summary
                    </h5>
                </div>
                
                <div class="summary-body">
                    <!-- Order Items -->
                    <div class="summary-items mb-3">
                        <h6 class="fw-bold mb-2">Order Details</h6>
                        <div class="summary-item-list">
                            @foreach($products as $item)
                            <div class="summary-item d-flex justify-content-between mb-2">
                                <div>
                                    <span class="text-muted">{{ $item['product']->name }}</span>
                                    <small class="d-block text-muted">x{{ $item['quantity'] }}</small>
                                </div>
                                <span class="fw-bold">${{ number_format($item['subtotal'], 2) }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Price Breakdown -->
                    <div class="price-breakdown">
                        <div class="breakdown-item d-flex justify-content-between mb-2">
                            <span class="text-muted">Subtotal</span>
                            <span class="fw-bold">${{ number_format($cartTotal, 2) }}</span>
                        </div>
                        
                        <div class="breakdown-item d-flex justify-content-between mb-2">
                            <span class="text-muted">Shipping</span>
                            <span class="fw-bold">
                                @if($cartTotal >= 50)
                                <span class="text-success">Free</span>
                                @else
                                $5.00
                                @endif
                            </span>
                        </div>
                        
                        <div class="breakdown-item d-flex justify-content-between mb-2">
                            <span class="text-muted">Tax (10%)</span>
                            <span class="fw-bold">${{ number_format($cartTotal * 0.1, 2) }}</span>
                        </div>
                        
                        @if($cartTotal >= 50)
                        <div class="breakdown-item d-flex justify-content-between mb-2">
                            <span class="text-success">
                                <i class="fas fa-gift me-1"></i> Shipping Discount
                            </span>
                            <span class="text-success fw-bold">-$5.00</span>
                        </div>
                        @endif
                        
                        <hr class="my-3">
                        
                        <div class="breakdown-total d-flex justify-content-between mb-4">
                            <span class="h5 fw-bold">Total</span>
                            <span class="h5 fw-bold text-primary">
                                ${{ number_format($cartTotal + ($cartTotal * 0.1) + ($cartTotal >= 50 ? 0 : 5), 2) }}
                            </span>
                        </div>
                    </div>
                    
                    <!-- Checkout Button -->
                    <div class="checkout-actions">
                        <a href="{{ route('checkout') }}" class="btn btn-primary btn-lg w-100 mb-3">
                            <i class="fas fa-lock me-2"></i> Proceed to Checkout
                        </a>
                        
                        <!-- Payment Methods -->
                        <div class="payment-methods text-center mt-3">
                            <p class="text-muted small mb-2">Secure Payment</p>
                            <div class="d-flex justify-content-center gap-3">
                                <i class="fab fa-cc-visa fa-lg text-muted"></i>
                                <i class="fab fa-cc-mastercard fa-lg text-muted"></i>
                                <i class="fab fa-cc-amex fa-lg text-muted"></i>
                                <i class="fab fa-cc-paypal fa-lg text-muted"></i>
                                <i class="fab fa-cc-apple-pay fa-lg text-muted"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Coupon Card -->
            <div class="coupon-card bg-surface rounded-3 shadow-md p-4">
                <h6 class="fw-bold mb-3">
                    <i class="fas fa-tag me-2"></i> Apply Coupon
                </h6>
                <div class="coupon-form">
                    <div class="input-group">
                        <input type="text" 
                               class="form-control" 
                               placeholder="Enter coupon code"
                               aria-label="Coupon code">
                        <button class="btn btn-primary" type="button">Apply</button>
                    </div>
                    <p class="text-muted small mt-2">
                        Available coupons: <span class="text-primary">SAVE10</span>, <span class="text-primary">WELCOME15</span>
                    </p>
                </div>
            </div>
            
            <!-- Shipping Info -->
            <div class="shipping-info bg-surface rounded-3 shadow-md p-4 mt-4">
                <h6 class="fw-bold mb-3">
                    <i class="fas fa-shipping-fast me-2"></i> Shipping Info
                </h6>
                <ul class="list-unstyled text-muted small">
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        Free shipping on orders over $50
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        Same-day shipping for orders before 2 PM
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        30-day return policy
                    </li>
                    <li>
                        <i class="fas fa-check text-success me-2"></i>
                        Secure packaging
                    </li>
                </ul>
            </div>
        </div>
    </div>
    @else
    <!-- Empty Cart -->
    <div class="row">
        <div class="col-12">
            <div class="empty-cart text-center py-5">
                <div class="empty-cart-icon mb-4">
                    <i class="fas fa-shopping-cart fa-4x text-muted"></i>
                </div>
                <h3 class="fw-bold mb-3">Your cart is empty</h3>
                <p class="text-muted mb-4">Looks like you haven't added any premium dry fruits to your cart yet.</p>
                <div class="empty-cart-actions">
                    <a href="{{ route('shop.index') }}" class="btn btn-primary btn-lg me-3">
                        <i class="fas fa-store me-2"></i> Start Shopping
                    </a>
                    <a href="{{ route('shop.index', ['featured' => true]) }}" class="btn btn-outline btn-lg">
                        <i class="fas fa-star me-2"></i> View Featured
                    </a>
                </div>
                <div class="mt-5">
                    <h5 class="fw-bold mb-3">Popular Categories</h5>
                    <div class="popular-categories">
                        <a href="{{ route('shop.index', ['category' => 'almonds']) }}" class="btn btn-outline-primary me-2 mb-2">
                            Almonds
                        </a>
                        <a href="{{ route('shop.index', ['category' => 'cashews']) }}" class="btn btn-outline-primary me-2 mb-2">
                            Cashews
                        </a>
                        <a href="{{ route('shop.index', ['category' => 'dates']) }}" class="btn btn-outline-primary me-2 mb-2">
                            Dates
                        </a>
                        <a href="{{ route('shop.index', ['category' => 'raisins']) }}" class="btn btn-outline-primary me-2 mb-2">
                            Raisins
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Newsletter Section -->
<section class="newsletter-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h2 class="text-white mb-3">Don't Miss Out!</h2>
                <p class="text-white mb-4">Subscribe for exclusive deals and new product alerts.</p>
            </div>
            <div class="col-lg-6">
                <form class="newsletter-form">
                    <div class="input-group">
                        <input type="email" 
                               class="form-control" 
                               placeholder="Your email address" 
                               required
                               aria-label="Email for newsletter">
                        <button type="submit" class="btn btn-light">
                            Subscribe <i class="fas fa-paper-plane ms-2"></i>
                        </button>
                    </div>
                    <p class="form-text text-white mt-2">We respect your privacy. Unsubscribe at any time.</p>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.cart-items {
    background: var(--surface-color);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-md);
}

.cart-item {
    padding-bottom: var(--space-md);
    border-bottom: 1px solid var(--border-color);
    transition: var(--transition-normal);
}

.cart-item:hover {
    background: rgba(0, 0, 0, 0.02);
}

.cart-item-image {
    overflow: hidden;
    border-radius: var(--radius-md);
}

.cart-item-image img {
    width: 100%;
    height: 100px;
    object-fit: cover;
    transition: var(--transition-normal);
}

.cart-item:hover .cart-item-image img {
    transform: scale(1.05);
}

.cart-item-title {
    font-size: var(--text-base);
    font-weight: 600;
    color: var(--text-primary);
}

.cart-item-title a:hover {
    color: var(--primary-color);
}

.cart-item-category {
    font-size: var(--text-sm);
}

.cart-item-price .current-price {
    font-size: var(--text-lg);
    color: var(--primary-color);
}

.cart-item-price .old-price {
    font-size: var(--text-sm);
}

.cart-item-badges .badge {
    font-size: var(--text-xs);
    padding: 4px 8px;
    border-radius: var(--radius-sm);
}

.quantity-selector {
    display: flex;
    align-items: center;
    gap: var(--space-xs);
}

.quantity-btn {
    width: 32px;
    height: 32px;
    border: 1px solid var(--border-color);
    background: var(--surface-color);
    border-radius: var(--radius-sm);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: var(--transition-fast);
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
    border-radius: var(--radius-sm);
    background: var(--surface-color);
    color: var(--text-primary);
    font-weight: 600;
}

.quantity-input:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(139, 69, 19, 0.1);
}

.cart-item-subtotal {
    font-size: var(--text-lg);
}

.cart-item-actions .btn {
    padding: 6px 12px;
    border-radius: var(--radius-sm);
}

.order-summary,
.coupon-card,
.shipping-info {
    background: var(--surface-color);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-md);
}

.summary-items {
    max-height: 200px;
    overflow-y: auto;
    padding-right: var(--space-xs);
}

.summary-item-list::-webkit-scrollbar {
    width: 6px;
}

.summary-item-list::-webkit-scrollbar-track {
    background: var(--border-color);
    border-radius: var(--radius-full);
}

.summary-item-list::-webkit-scrollbar-thumb {
    background: var(--primary-color);
    border-radius: var(--radius-full);
}

.summary-item {
    font-size: var(--text-sm);
    padding: var(--space-xs);
    border-radius: var(--radius-sm);
    background: var(--background-color);
}

.breakdown-item {
    padding: var(--space-xs) 0;
    border-bottom: 1px dashed var(--border-color);
}

.breakdown-total {
    padding-top: var(--space-sm);
    border-top: 2px solid var(--border-color);
}

.checkout-actions .btn {
    padding: var(--space-md);
    font-size: var(--text-lg);
    font-weight: 600;
    border-radius: var(--radius-md);
}

.payment-methods {
    padding: var(--space-sm);
    border-top: 1px solid var(--border-color);
}

.coupon-form .input-group {
    margin-bottom: var(--space-xs);
}

.coupon-form .btn {
    padding: 10px 20px;
}

.shipping-info ul {
    margin: 0;
}

.shipping-info li {
    padding: var(--space-xs) 0;
}

/* Empty Cart */
.empty-cart {
    background: var(--surface-color);
    border-radius: var(--radius-lg);
    padding: var(--space-2xl);
    box-shadow: var(--shadow-md);
}

.empty-cart-icon {
    margin-bottom: var(--space-xl);
}

.empty-cart h3 {
    font-size: var(--text-3xl);
    margin-bottom: var(--space-md);
}

.empty-cart p {
    font-size: var(--text-lg);
    margin-bottom: var(--space-xl);
    max-width: 500px;
    margin-left: auto;
    margin-right: auto;
}

.empty-cart-actions {
    display: flex;
    gap: var(--space-md);
    justify-content: center;
    margin-bottom: var(--space-xl);
}

.popular-categories {
    display: flex;
    flex-wrap: wrap;
    gap: var(--space-xs);
    justify-content: center;
}

/* Alerts */
.alert {
    border-radius: var(--radius-md);
    border: none;
    box-shadow: var(--shadow-sm);
}

.alert-success {
    background: rgba(39, 174, 96, 0.1);
    color: var(--success-color);
    border-left: 4px solid var(--success-color);
}

.alert-danger {
    background: rgba(231, 76, 60, 0.1);
    color: var(--danger-color);
    border-left: 4px solid var(--danger-color);
}

.alert .btn-close {
    padding: var(--space-sm);
}

/* Responsive Design */
@media (max-width: 992px) {
    .cart-item .row > div {
        margin-bottom: var(--space-md);
    }
    
    .cart-item-image img {
        height: 150px;
    }
    
    .empty-cart-actions {
        flex-direction: column;
        align-items: center;
    }
    
    .empty-cart-actions .btn {
        width: 100%;
        max-width: 300px;
    }
}

@media (max-width: 768px) {
    .cart-item {
        padding: var(--space-md);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        margin-bottom: var(--space-md);
    }
    
    .cart-item:last-child {
        margin-bottom: 0;
    }
    
    .cart-item .row > div {
        margin-bottom: var(--space-sm);
    }
    
    .cart-item-actions {
        text-align: left;
    }
    
    .popular-categories {
        flex-direction: column;
        align-items: center;
    }
    
    .popular-categories .btn {
        width: 100%;
        max-width: 200px;
    }
}

@media (max-width: 576px) {
    .cart-footer {
        flex-direction: column;
        gap: var(--space-md);
    }
    
    .cart-actions {
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: var(--space-sm);
    }
    
    .cart-actions .btn {
        width: 100%;
    }
    
    .empty-cart {
        padding: var(--space-lg);
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Update quantity
    document.querySelectorAll('.quantity-btn').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.id;
            const input = document.querySelector(`.quantity-input[data-id="${productId}"]`);
            let quantity = parseInt(input.value);
            
            if (this.classList.contains('quantity-minus')) {
                if (quantity > 1) {
                    quantity--;
                }
            } else if (this.classList.contains('quantity-plus')) {
                if (quantity < 99) {
                    quantity++;
                }
            }
            
            input.value = quantity;
            updateCartItem(productId, quantity);
        });
    });
    
    // Input change
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', function() {
            const productId = this.dataset.id;
            let quantity = parseInt(this.value);
            
            if (quantity < 1) quantity = 1;
            if (quantity > 99) quantity = 99;
            
            this.value = quantity;
            updateCartItem(productId, quantity);
        });
    });
    
    // Remove item
    document.querySelectorAll('.remove-item').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.id;
            removeCartItem(productId);
        });
    });
    
    // Clear cart
    document.getElementById('clearCartBtn')?.addEventListener('click', function() {
        showConfirmModal('Clear Cart', 'Are you sure you want to clear your entire cart?', function() {
            clearCart();
        });
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
                body: JSON.stringify({ quantity: quantity })
            });
            
            const data = await response.json();
            
            if (data.success) {
                // Update cart count in header
                document.querySelectorAll('.cart-count').forEach(element => {
                    element.textContent = data.cart_count;
                    element.style.display = data.cart_count > 0 ? 'flex' : 'none';
                });
                
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
        showConfirmModal('Remove Item', 'Are you sure you want to remove this item from your cart?', async function() {
            try {
                const response = await fetch(`/cart/remove/${productId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Update cart count in header
                    document.querySelectorAll('.cart-count').forEach(element => {
                        element.textContent = data.cart_count;
                        element.style.display = data.cart_count > 0 ? 'flex' : 'none';
                    });
                    
                    // Remove item from DOM
                    const item = document.querySelector(`.cart-item[data-id="${productId}"]`);
                    if (item) {
                        item.classList.add('fading');
                        setTimeout(() => {
                            item.remove();
                            
                            // If cart is empty, reload page
                            if (data.cart_count === 0) {
                                location.reload();
                            } else {
                                // Update total display
                                updateCartSummary();
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
        });
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
                // Update cart count in header
                document.querySelectorAll('.cart-count').forEach(element => {
                    element.textContent = 0;
                    element.style.display = 'none';
                });
                
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
    
    function showConfirmModal(title, message, onConfirm) {
        // Create modal HTML
        const modalHTML = `
            <div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">${title}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p>${message}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-danger" id="confirmAction">Confirm</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        // Add modal to body
        document.body.insertAdjacentHTML('beforeend', modalHTML);
        
        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('confirmModal'));
        modal.show();
        
        // Handle confirm action
        document.getElementById('confirmAction').addEventListener('click', function() {
            modal.hide();
            onConfirm();
            setTimeout(() => {
                document.getElementById('confirmModal').remove();
            }, 300);
        });
        
        // Remove modal on hide
        document.getElementById('confirmModal').addEventListener('hidden.bs.modal', function() {
            this.remove();
        });
    }
    
    function showToast(message, type = 'info') {
        const container = document.getElementById('toastContainer');
        if (!container) return;
        
        const toast = document.createElement('div');
        toast.className = `toast show align-items-center text-white bg-${type === 'error' ? 'danger' : type} border-0`;
        toast.setAttribute('role', 'alert');
        toast.setAttribute('aria-live', 'assertive');
        toast.setAttribute('aria-atomic', 'true');
        
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas ${getToastIcon(type)} me-2"></i>
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        `;
        
        container.appendChild(toast);
        
        const bsToast = new bootstrap.Toast(toast, { delay: 3000 });
        bsToast.show();
        
        toast.addEventListener('hidden.bs.toast', () => {
            toast.remove();
        });
    }
    
    function getToastIcon(type) {
        switch (type) {
            case 'success': return 'fa-check-circle';
            case 'error': return 'fa-exclamation-circle';
            case 'warning': return 'fa-exclamation-triangle';
            default: return 'fa-info-circle';
        }
    }
    
    function updateCartSummary() {
        // This function would update cart summary without reloading
        // For now, we'll reload the page for simplicity
        location.reload();
    }
    
    // Add fade-out animation class
    const style = document.createElement('style');
    style.textContent = `
        .fading {
            opacity: 0;
            transform: translateX(-20px);
            transition: opacity 0.3s ease, transform 0.3s ease;
        }
    `;
    document.head.appendChild(style);
});
</script>
@endpush