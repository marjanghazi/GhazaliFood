@extends('layouts.app')

@section('title', 'Shopping Cart - Ghazali Food')

@section('hero')
<section class="hero-section" style="background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?ixlib=rb-4.0.3') center/cover no-repeat;">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="animate__animated animate__fadeInUp">Shopping Cart</h1>
                <nav aria-label="breadcrumb" class="d-flex justify-content-center">
                    <ol class="breadcrumb bg-transparent p-0 animate__animated animate__fadeInUp animate__delay-1s">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Cart</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
@endsection

@section('content')
<div class="container py-5">
    @if(count($cartItems) > 0)
    <div class="row">
        <!-- Cart Items -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cartItems as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $item['image'] ?? 'https://via.placeholder.com/80x80?text=Product' }}" 
                                                 class="rounded me-3" width="80" height="80" alt="{{ $item['name'] }}">
                                            <div>
                                                <h6 class="mb-1">{{ $item['name'] }}</h6>
                                                <a href="{{ route('shop.show', $item['slug']) }}" class="text-success small">View Product</a>
                                            </div>
                                        </div>
                                    </td>
                                    <td>${{ number_format($item['price'], 2) }}</td>
                                    <td>
                                        <div class="input-group" style="width: 120px;">
                                            <button class="btn btn-outline-secondary btn-sm decrement-qty" 
                                                    data-id="{{ $item['id'] }}" type="button">-</button>
                                            <input type="number" class="form-control form-control-sm text-center" 
                                                   value="{{ $item['quantity'] }}" min="1" max="99" 
                                                   id="qty-{{ $item['id'] }}">
                                            <button class="btn btn-outline-secondary btn-sm increment-qty" 
                                                    data-id="{{ $item['id'] }}" type="button">+</button>
                                        </div>
                                    </td>
                                    <td>${{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                                    <td>
                                        <button class="btn btn-outline-danger btn-sm remove-from-cart" 
                                                data-id="{{ $item['id'] }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <a href="{{ route('shop.index') }}" class="btn btn-outline-success">
                            <i class="fas fa-arrow-left me-2"></i> Continue Shopping
                        </a>
                        <button class="btn btn-danger" id="clear-cart">
                            <i class="fas fa-trash me-2"></i> Clear Cart
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Order Summary -->
        <div class="col-lg-4 mt-4 mt-lg-0">
            <div class="card shadow-sm border-0 sticky-top" style="top: 20px;">
                <div class="card-body p-4">
                    <h5 class="card-title fw-bold mb-4">Order Summary</h5>
                    
                    <div class="d-flex justify-content-between mb-3">
                        <span>Subtotal</span>
                        <span>${{ number_format($cartTotal, 2) }}</span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-3">
                        <span>Shipping</span>
                        <span class="text-success">Free</span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-3">
                        <span>Tax</span>
                        <span>${{ number_format($cartTotal * 0.08, 2) }}</span>
                    </div>
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between mb-4">
                        <h6 class="fw-bold">Total</h6>
                        <h6 class="fw-bold">${{ number_format($cartTotal + ($cartTotal * 0.08), 2) }}</h6>
                    </div>
                    
                    <div class="mb-3">
                        <label for="coupon" class="form-label">Coupon Code</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="coupon" placeholder="Enter code">
                            <button class="btn btn-success" type="button">Apply</button>
                        </div>
                    </div>
                    
                    <a href="{{ route('checkout') }}" class="btn btn-success btn-lg w-100">
                        Proceed to Checkout <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                    
                    <div class="text-center mt-3">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/a/a4/Mastercard_2019_logo.svg" 
                             class="me-2" height="30" alt="Mastercard">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg" 
                             class="me-2" height="30" alt="Visa">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" 
                             height="30" alt="PayPal">
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="text-center py-5">
        <div class="empty-cart-icon mb-4">
            <i class="fas fa-shopping-cart fa-4x text-muted"></i>
        </div>
        <h4>Your cart is empty</h4>
        <p class="text-muted mb-4">Looks like you haven't added any products to your cart yet.</p>
        <a href="{{ route('shop.index') }}" class="btn btn-success btn-lg">
            <i class="fas fa-store me-2"></i> Start Shopping
        </a>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Update quantity
        $('.increment-qty').click(function() {
            const productId = $(this).data('id');
            const input = $('#qty-' + productId);
            let currentVal = parseInt(input.val());
            if (currentVal < 99) {
                input.val(currentVal + 1);
                updateCartQuantity(productId, currentVal + 1);
            }
        });
        
        $('.decrement-qty').click(function() {
            const productId = $(this).data('id');
            const input = $('#qty-' + productId);
            let currentVal = parseInt(input.val());
            if (currentVal > 1) {
                input.val(currentVal - 1);
                updateCartQuantity(productId, currentVal - 1);
            }
        });
        
        // Remove item from cart
        $('.remove-from-cart').click(function() {
            const productId = $(this).data('id');
            
            if (confirm('Are you sure you want to remove this item from cart?')) {
                $.ajax({
                    url: '/cart/remove/' + productId,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        location.reload();
                    }
                });
            }
        });
        
        // Clear cart
        $('#clear-cart').click(function() {
            if (confirm('Are you sure you want to clear your cart?')) {
                $.ajax({
                    url: '/cart/clear',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        location.reload();
                    }
                });
            }
        });
        
        // Manual quantity input change
        $('input[type="number"]').change(function() {
            const productId = $(this).attr('id').replace('qty-', '');
            const quantity = $(this).val();
            updateCartQuantity(productId, quantity);
        });
        
        function updateCartQuantity(productId, quantity) {
            $.ajax({
                url: '/cart/update/' + productId,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    quantity: quantity
                },
                success: function(response) {
                    // Update cart count in navbar
                    $.get('/cart/count', function(data) {
                        $('.cart-count').text(data.count);
                    });
                    
                    // Reload page to update totals
                    setTimeout(function() {
                        location.reload();
                    }, 500);
                }
            });
        }
    });
</script>
@endpush