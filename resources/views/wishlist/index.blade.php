@extends('layouts.app')

@section('title', 'My Wishlist - Nuts & Berries')
@section('description', 'Your wishlist of favorite dry fruits')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h1 class="fw-bold mb-4">My Wishlist</h1>
            
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

    @if($wishlistItems->count() > 0)
    <div class="row">
        @foreach($wishlistItems as $item)
        <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
            <div class="product-card">
                <div class="product-image">
                    <img src="{{ $item->product->primaryImage->media_url ?? '/images/default-product.jpg' }}" 
                         alt="{{ $item->product->name }}">
                    <div class="product-overlay">
                        <div class="product-actions">
                            <button class="btn btn-primary add-to-cart-btn" 
                                    data-product-id="{{ $item->product->id }}">
                                <i class="fas fa-cart-plus"></i> Add to Cart
                            </button>
                            <button class="btn btn-outline-danger wishlist-toggle-btn" 
                                    data-product-id="{{ $item->product->id }}">
                                <i class="fas fa-heart"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="product-content">
                    <div class="product-category">
                        {{ $item->product->category->name ?? 'Uncategorized' }}
                    </div>
                    <h4 class="product-title">
                        <a href="{{ route('shop.show', $item->product->slug) }}">
                            {{ Str::limit($item->product->name, 40) }}
                        </a>
                    </h4>
                    
                    @if($item->product->average_rating > 0)
                    <div class="product-rating">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $item->product->average_rating)
                            <i class="fas fa-star text-warning"></i>
                            @elseif($i - 0.5 <= $item->product->average_rating)
                            <i class="fas fa-star-half-alt text-warning"></i>
                            @else
                            <i class="far fa-star text-warning"></i>
                            @endif
                        @endfor
                        <span class="rating-count">({{ $item->product->total_reviews }})</span>
                    </div>
                    @endif
                    
                    <div class="product-price">
                        <span class="current-price">${{ number_format($item->product->best_price, 2) }}</span>
                        @if($item->product->compare_at_price && $item->product->compare_at_price > $item->product->best_price)
                        <span class="old-price">${{ number_format($item->product->compare_at_price, 2) }}</span>
                        @endif
                    </div>
                    
                    <div class="d-grid gap-2 mt-3">
                        <button class="btn btn-primary add-to-cart-btn" 
                                data-product-id="{{ $item->product->id }}">
                            <i class="fas fa-cart-plus me-2"></i> Add to Cart
                        </button>
                        <button class="btn btn-outline-danger wishlist-toggle-btn" 
                                data-product-id="{{ $item->product->id }}">
                            <i class="fas fa-heart me-2"></i> Remove
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    <div class="row mt-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-muted">
                        Showing {{ $wishlistItems->count() }} item(s)
                    </span>
                </div>
                <div>
                    <a href="{{ route('shop.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-shopping-bag me-2"></i> Continue Shopping
                    </a>
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
                        <i class="fas fa-heart fa-4x text-muted mb-4"></i>
                        <h3 class="fw-bold mb-3">Your wishlist is empty</h3>
                        <p class="text-muted mb-4">Save your favorite products here to purchase later.</p>
                    </div>
                    <a href="{{ route('shop.index') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-store me-2"></i> Browse Products
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@push('styles')
<style>
.product-card {
    position: relative;
    transition: transform 0.3s ease;
}

.product-card:hover {
    transform: translateY(-5px);
}

.product-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.product-card:hover .product-overlay {
    opacity: 1;
}
</style>
@endpush