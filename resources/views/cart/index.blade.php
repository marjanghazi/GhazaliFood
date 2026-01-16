@extends('layouts.app')

@section('title', 'Shopping Cart - Nuts & Berries')
@section('description', 'Your shopping cart with premium dry fruits')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h1 class="fw-bold mb-4">Shopping Cart</h1>
            
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            
            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
        </div>
    </div>

    @if(count($products) > 0)
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" class="border-0">Product</th>
                                    <th scope="col" class="border-0 text-center">Price</th>
                                    <th scope="col" class="border-0 text-center">Quantity</th>
                                    <th scope="col" class="border-0 text-center">Subtotal</th>
                                    <th scope="col" class="border-0 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $item)
                                <tr class="cart-item" data-id="{{ $item['product']->id }}">
                                    <td class="border-0">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="{{ $item['product']->primaryImage->media_url ?? '/images/default-product.jpg' }}" 
                                                     alt="{{ $item['product']->name }}"
                                                     class="rounded-3"
                                                     style="width: 80px; height: 80px; object-fit: cover;">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="fw-bold mb-1">
                                                    <a href="{{ route('shop.show', $item['product']->slug) }}" 
                                                       class="text-decoration-none text-dark">
                                                        {{ $item['product']->name }}
                                                    </a>
                                                </h6>
                                                <p class="text-muted mb-0 small">
                                                    {{ $item['product']->category->name ?? 'Uncategorized' }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="border-0 text-center align-middle">
                                        <span class="fw-bold text-primary">${{ number_format($item['product']->best_price, 2) }}</span>
                                    </td>
                                    <td class="border-0 text-center align-middle">
                                        <div class="quantity-selector d-inline-flex align-items-center">
                                            <button class="quantity-btn quantity-minus" 
                                                    type="button"
                                                    data-id="{{ $item['product']->id }}">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <input type="number" 
                                                   class="quantity-input text-center" 
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
                                    </td>
                                    <td class="border-0 text-center align-middle">
                                        <span class="fw-bold">${{ number_format($item['subtotal'], 2) }}</span>
                                    </td>
                                    <td class="border-0 text-center align-middle">
                                        <button class="btn btn-outline-danger btn-sm remove-item" 
                                                type="button"
                                                data-id="{{ $item['product']->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="card-footer bg-transparent border-0 pt-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('shop.index') }}" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left me-2"></i> Continue Shopping
                            </a>
                            <button class="btn btn-danger" id="clearCartBtn">
                                <i class="fas fa-trash me-2"></i> Clear Cart
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 mt-4 mt-lg-0">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-receipt me-2"></i> Order Summary</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Subtotal</span>
                        <span class="fw-bold">${{ number_format($cartTotal, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Shipping</span>
                        <span class="fw-bold">$0.00</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Tax</span>
                        <span class="fw-bold">${{ number_format($cartTotal * 0.1, 2) }}</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="h5 fw-bold">Total</span>
                        <span class="h5 fw-bold text-primary">
                            ${{ number_format($cartTotal + ($cartTotal * 0.1), 2) }}
                        </span>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <a href="{{ route('checkout') }}" class="btn btn-success btn-lg">
                            <i class="fas fa-lock me-2"></i> Proceed to Checkout
                        </a>
                        <a href="{{ route('shop.index', ['featured' => true]) }}" class="btn btn-outline-primary">
                            <i class="fas fa-bolt me-2"></i> Buy Featured Products
                        </a>
                    </div>
                    
                    <div class="mt-4">
                        <h6 class="fw-bold mb-3">We Accept:</h6>
                        <div class="d-flex justify-content-between">
                            <i class="fab fa-cc-visa fa-2x text-muted"></i>
                            <i class="fab fa-cc-mastercard fa-2x text-muted"></i>
                            <i class="fab fa-cc-amex fa-2x text-muted"></i>
                            <i class="fab fa-cc-paypal fa-2x text-muted"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card shadow-sm border-0 mt-4">
                <div class="card-body">
                    <h6 class="fw-bold mb-3"><i class="fas fa-percentage me-2"></i> Apply Coupon</h6>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Enter coupon code">
                        <button class="btn btn-primary" type="button">Apply</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-shopping-cart fa-4x text-muted mb-4"></i>
                        <h3 class="fw-bold mb-3">Your cart is empty</h3>
                        <p class="text-muted mb-4">Looks like you haven't added any products to your cart yet.</p>
                    </div>
                    <a href="{{ route('shop.index') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-store me-2"></i> Start Shopping
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

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
        if (confirm('Are you sure you want to clear your cart?')) {
            clearCart();
        }
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
            }
        } catch (error) {
            console.error('Error updating cart:', error);
            showToast('Error updating cart', 'error');
        }
    }
    
    async function removeCartItem(productId) {
        if (!confirm('Remove this item from cart?')) return;
        
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
                
                // Remove row from table
                const row = document.querySelector(`.cart-item[data-id="${productId}"]`);
                if (row) {
                    row.remove();
                    
                    // If cart is empty, reload page
                    if (data.cart_count === 0) {
                        location.reload();
                    } else {
                        // Update total on page
                        location.reload();
                    }
                }
                
                showToast('Item removed from cart', 'success');
            }
        } catch (error) {
            console.error('Error removing item:', error);
            showToast('Error removing item', 'error');
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
                // Update cart count in header
                document.querySelectorAll('.cart-count').forEach(element => {
                    element.textContent = 0;
                    element.style.display = 'none';
                });
                
                showToast('Cart cleared', 'success');
                setTimeout(() => location.reload(), 1000);
            }
        } catch (error) {
            console.error('Error clearing cart:', error);
            showToast('Error clearing cart', 'error');
        }
    }
    
    function showToast(message, type = 'info') {
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
        
        const container = document.getElementById('toastContainer');
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
});
</script>
@endpush