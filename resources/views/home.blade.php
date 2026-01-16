@extends('layouts.app')

@section('title', 'Ghazali Food - Premium Quality Food Products')

@section('hero')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="animate__animated animate__fadeInUp">Fresh & Healthy Food Delivered to Your Doorstep</h1>
                <p class="lead animate__animated animate__fadeInUp animate__delay-1s">
                    Discover our premium collection of organic and locally sourced food products. 
                    Quality guaranteed, delivered fresh.
                </p>
                <div class="animate__animated animate__fadeInUp animate__delay-2s">
                    <a href="{{ route('shop.index') }}" class="btn btn-success btn-lg me-3">
                        Shop Now <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                    <a href="{{ route('about') }}" class="btn btn-outline-light btn-lg">
                        Learn More
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                <!-- Hero image or slider can be added here -->
            </div>
        </div>
    </div>
</section>
@endsection

@section('content')
<!-- Features Section -->
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-3 col-sm-6">
                <div class="text-center p-4 border rounded-3 h-100">
                    <div class="feature-icon mb-3">
                        <i class="fas fa-shipping-fast fa-3x text-success"></i>
                    </div>
                    <h5 class="fw-bold">Free Shipping</h5>
                    <p class="text-muted mb-0">On orders over $50</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="text-center p-4 border rounded-3 h-100">
                    <div class="feature-icon mb-3">
                        <i class="fas fa-undo fa-3x text-success"></i>
                    </div>
                    <h5 class="fw-bold">Easy Returns</h5>
                    <p class="text-muted mb-0">30-day return policy</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="text-center p-4 border rounded-3 h-100">
                    <div class="feature-icon mb-3">
                        <i class="fas fa-shield-alt fa-3x text-success"></i>
                    </div>
                    <h5 class="fw-bold">Secure Payment</h5>
                    <p class="text-muted mb-0">100% secure transactions</p>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="text-center p-4 border rounded-3 h-100">
                    <div class="feature-icon mb-3">
                        <i class="fas fa-headset fa-3x text-success"></i>
                    </div>
                    <h5 class="fw-bold">24/7 Support</h5>
                    <p class="text-muted mb-0">Dedicated customer service</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Categories -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="text-center fw-bold mb-3">Shop By Categories</h2>
                <p class="text-center text-muted mb-0">Browse our wide range of food categories</p>
            </div>
        </div>
        <div class="row g-4">
            @foreach($categories as $category)
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="category-card">
                    <div class="category-img">
                        <img src="{{ $category->category_image ? asset('storage/' . $category->category_image) : 'https://via.placeholder.com/300x200?text=' . $category->name }}" 
                             alt="{{ $category->name }}">
                    </div>
                    <div class="category-info text-center">
                        <h5 class="fw-bold">{{ $category->name }}</h5>
                        <p class="text-muted mb-2">{{ $category->activeProducts->count() }} products</p>
                        <a href="{{ route('shop.index', ['category' => $category->slug]) }}" 
                           class="btn btn-outline-success btn-sm">
                            Shop Now
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="py-5">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="fw-bold mb-3">Featured Products</h2>
                <p class="text-muted">Handpicked selection of our best products</p>
            </div>
        </div>
        <div class="row g-4">
            @foreach($featuredProducts as $product)
            <div class="col-xl-3 col-lg-4 col-md-6">
                <div class="product-card">
                    <div class="product-img">
                        <img src="{{ $product->primaryImage->media_url ?? 'https://via.placeholder.com/300x300?text=Product' }}" 
                             alt="{{ $product->name }}">
                        @if($product->is_new_arrival)
                            <span class="product-badge badge-new">New</span>
                        @endif
                        @if($product->compare_at_price && $product->compare_at_price > $product->best_price)
                            <span class="product-badge badge-sale">Sale</span>
                        @endif
                    </div>
                    <div class="product-info">
                        <div class="product-category text-muted small mb-2">
                            {{ $product->category->name }}
                        </div>
                        <h5 class="product-title">
                            <a href="{{ route('shop.show', $product->slug) }}" class="text-decoration-none text-dark">
                                {{ Str::limit($product->name, 40) }}
                            </a>
                        </h5>
                        
                        <div class="product-rating">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= floor($product->average_rating))
                                    <i class="fas fa-star text-warning"></i>
                                @elseif($i - 0.5 <= $product->average_rating)
                                    <i class="fas fa-star-half-alt text-warning"></i>
                                @else
                                    <i class="far fa-star text-warning"></i>
                                @endif
                            @endfor
                            <span class="reviews">({{ $product->total_reviews }})</span>
                        </div>
                        
                        <div class="product-price d-flex align-items-center">
                            ${{ number_format($product->best_price, 2) }}
                            @if($product->compare_at_price)
                                <span class="old-price ms-2">${{ number_format($product->compare_at_price, 2) }}</span>
                                <span class="discount ms-2">-{{ $product->discount_percentage }}%</span>
                            @endif
                        </div>
                        
                        <div class="product-actions mt-3">
                            <button class="btn btn-success add-to-cart" 
                                    data-id="{{ $product->id }}"
                                    data-name="{{ $product->name }}">
                                <i class="fas fa-cart-plus me-1"></i> Add to Cart
                            </button>
                            <button class="btn btn-outline-danger add-to-wishlist"
                                    data-id="{{ $product->id }}">
                                <i class="fas fa-heart"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('shop.index') }}" class="btn btn-outline-success">
                View All Products <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

<!-- Banner Section -->
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="banner-card position-relative overflow-hidden rounded-3">
                    <img src="https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?ixlib=rb-4.0.3" 
                         class="img-fluid rounded-3" alt="Special Offer">
                    <div class="banner-content position-absolute top-0 start-0 p-5 text-white">
                        <h3 class="fw-bold">Summer Sale</h3>
                        <p class="mb-3">Up to 50% off on selected items</p>
                        <a href="{{ route('shop.index') }}" class="btn btn-light">
                            Shop Now
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="banner-card position-relative overflow-hidden rounded-3">
                    <img src="https://images.unsplash.com/photo-1565958011703-44f9829ba187?ixlib=rb-4.0.3" 
                         class="img-fluid rounded-3" alt="New Arrivals">
                    <div class="banner-content position-absolute top-0 start-0 p-5 text-white">
                        <h3 class="fw-bold">New Arrivals</h3>
                        <p class="mb-3">Fresh products added weekly</p>
                        <a href="{{ route('shop.index', ['new_arrival' => true]) }}" class="btn btn-light">
                            Explore
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="text-center fw-bold mb-3">What Our Customers Say</h2>
                <p class="text-center text-muted mb-0">Trusted by thousands of happy customers</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="testimonial-card p-4 bg-white rounded-3 shadow-sm h-100">
                    <div class="rating mb-3">
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                    </div>
                    <p class="mb-4">"The quality of products from Ghazali Food is exceptional. Fresh delivery every time!"</p>
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <img src="https://i.pravatar.cc/50?img=1" class="rounded-circle" alt="Customer">
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">Sarah Johnson</h6>
                            <small class="text-muted">Regular Customer</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testimonial-card p-4 bg-white rounded-3 shadow-sm h-100">
                    <div class="rating mb-3">
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star-half-alt text-warning"></i>
                    </div>
                    <p class="mb-4">"Great variety and excellent customer service. My go-to for quality food products."</p>
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <img src="https://i.pravatar.cc/50?img=2" class="rounded-circle" alt="Customer">
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">Michael Chen</h6>
                            <small class="text-muted">Food Blogger</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testimonial-card p-4 bg-white rounded-3 shadow-sm h-100">
                    <div class="rating mb-3">
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                        <i class="fas fa-star text-warning"></i>
                    </div>
                    <p class="mb-4">"Fast delivery and fresh products every time. Highly recommend Ghazali Food!"</p>
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <img src="https://i.pravatar.cc/50?img=3" class="rounded-circle" alt="Customer">
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">Emma Davis</h6>
                            <small class="text-muted">Restaurant Owner</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection