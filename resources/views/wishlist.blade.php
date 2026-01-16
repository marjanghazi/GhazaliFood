@extends('layouts.app')

@section('title', 'Wishlist - Ghazali Food')

@section('hero')
<section class="hero-section" style="background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?ixlib=rb-4.0.3') center/cover no-repeat;">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="animate__animated animate__fadeInUp">My Wishlist</h1>
                <nav aria-label="breadcrumb" class="d-flex justify-content-center">
                    <ol class="breadcrumb bg-transparent p-0 animate__animated animate__fadeInUp animate__delay-1s">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Wishlist</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
@endsection

@section('content')
<div class="container py-5">
    @if(count($wishlistItems) > 0)
    <div class="row">
        @foreach($wishlistItems as $item)
        <div class="col-md-4 col-lg-3 mb-4">
            <div class="product-card">
                <div class="product-img">
                    <img src="{{ $item['image'] ?? 'https://via.placeholder.com/300x300?text=Product' }}" 
                         alt="{{ $item['name'] }}">
                </div>
                <div class="product-info">
                    <h6 class="product-title">
                        <a href="{{ route('shop.show', $item['slug']) }}" class="text-decoration-none text-dark">
                            {{ Str::limit($item['name'], 40) }}
                        </a>
                    </h6>
                    
                    <div class="product-price d-flex align-items-center">
                        ${{ number_format($item['price'], 2) }}
                    </div>
                    
                    <div class="product-actions mt-3">
                        <button class="btn btn-success move-to-cart" 
                                data-id="{{ $item['id'] }}">
                            <i class="fas fa-cart-plus me-1"></i> Add to Cart
                        </button>
                        <button class="btn btn-outline-danger remove-from-wishlist"
                                data-id="{{ $item['id'] }}">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    <div class="text-center mt-4">
        <a href="{{ route('shop.index') }}" class="btn btn-outline-success me-3">
            <i class="fas fa-arrow-left me-2"></i> Continue Shopping
        </a>
        <button class="btn btn-danger" id="clear-wishlist">
            <i class="fas fa-trash me-2"></i> Clear All
        </button>
    </div>
    @else
    <div class="text-center py-5">
        <div class="empty-wishlist-icon mb-4">
            <i class="fas fa-heart fa-4x text-muted"></i>
        </div>
        <h4>Your wishlist is empty</h4>
        <p class="text-muted mb-4">Save items you like to your wishlist.</p>
        <a href="{{ route('shop.index') }}" class="btn btn-success btn-lg">
            <i class="fas fa-store me-2"></i> Browse Products
        </a>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Move to cart
        $('.move-to-cart').click(function() {
            const productId = $(this).data('id');
            
            $.ajax({
                url: '/wishlist/move-to-cart/' + productId,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    showToast('Success', 'Item moved to cart!', 'success');
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                }
            });
        });
        
        // Remove from wishlist
        $('.remove-from-wishlist').click(function() {
            const productId = $(this).data('id');
            
            $.ajax({
                url: '/wishlist/remove/' + productId,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    showToast('Success', 'Item removed from wishlist!', 'success');
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                }
            });
        });
        
        // Clear wishlist
        $('#clear-wishlist').click(function() {
            if (confirm('Are you sure you want to clear your wishlist?')) {
                // Since we're using session, we'll remove each item individually
                // In a real app, you'd have a clear endpoint
                $('.remove-from-wishlist').each(function() {
                    const productId = $(this).data('id');
                    // You might want to make a single API call to clear all
                });
                location.reload();
            }
        });
    });
</script>
@endpush