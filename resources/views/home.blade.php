@extends('layouts.app')

@section('title', 'Premium Dry Fruits Store | Nuts & Berries')

@section('hero')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center min-vh-70">
            <!-- Left Column - Text Content -->
            <div class="col-lg-6 hero-text-column">
                <!-- Animated Title with Typing Effect -->
                <h1 class="hero-title mb-3 mb-md-4" data-aos="fade-up" data-aos-delay="100">
                    <span class="typed-text" data-typed-items='"Premium Quality Dry Fruits", "100% Natural & Organic Nuts", "Sourced from Finest Orchards", "Healthy Snacking Delivered"'></span>
                </h1>
                <p class="hero-subtitle animate-slide-up delay-1">
                    Discover our exquisite collection of 100% natural, organic dry fruits,
                    nuts, and berries sourced from the finest orchards worldwide.
                </p>
                <div class="hero-buttons animate-slide-up delay-2">
                    <a href="{{ route('shop.index') }}" class="btn btn-primary btn-lg">
                        Shop Now <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                    <a href="#featured" class="btn btn-outline btn-lg">
                        Explore Products
                    </a>
                </div>
            </div>

            <!-- Right Column - Image Content -->
            <div class="col-lg-6 hero-image-column">
                <div class="hero-image-container position-relative">
                    <!-- Main Product Image with Parallax Effect -->
                    <div class="hero-main-image" data-depth="0.2">
                        <img src="https://images.unsplash.com/photo-1542291025-1ec7e8e7cbc6?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                            alt="Premium Dry Fruits"
                            class="img-fluid rounded-3 shadow-lg">
                        <div class="hero-badge animate-bounce">
                            <i class="fas fa-trophy me-2"></i> #1 Rated
                        </div>
                    </div>

                    <!-- Animated Product Collection Images -->
                    <div class="product-floating-image floating-image-1">
                        <img src="https://images.unsplash.com/photo-1607305387299-a3d9611cd469?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80"
                            alt="Almonds" class="img-fluid">
                        <div class="product-label">Almonds</div>
                    </div>

                    <div class="product-floating-image floating-image-2">
                        <img src="https://images.unsplash.com/photo-1574085733277-851d9d856a3a?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80"
                            alt="Walnuts" class="img-fluid">
                        <div class="product-label">Walnuts</div>
                    </div>

                    <div class="product-floating-image floating-image-3">
                        <img src="https://images.unsplash.com/photo-1592921870789-04563d55041c?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80"
                            alt="Dates" class="img-fluid">
                        <div class="product-label">Dates</div>
                    </div>

                    <div class="product-floating-image floating-image-4">
                        <img src="https://images.unsplash.com/photo-1560343090-f0409e92791a?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80"
                            alt="Berries" class="img-fluid">
                        <div class="product-label">Berries</div>
                    </div>

                    <!-- Quality Badges with Animation -->
                    <div class="quality-badge badge-1 pulse-animation">
                        <i class="fas fa-leaf"></i>
                        <span>100% Organic</span>
                    </div>
                    <div class="quality-badge badge-2 bounce-animation">
                        <i class="fas fa-award"></i>
                        <span>Premium Quality</span>
                    </div>
                    <div class="quality-badge badge-3 float-animation">
                        <i class="fas fa-shipping-fast"></i>
                        <span>Free Delivery</span>
                    </div>

                    <!-- Animated Background Elements -->
                    <div class="bg-element element-1"></div>
                    <div class="bg-element element-2"></div>
                    <div class="bg-element element-3"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Floating Particles Background -->
    <div class="hero-particles">
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
        <div class="particle"></div>
    </div>
</section>
@endsection


@section('content')
<!-- Features Section -->
<section class="features-section py-5">
    <div class="container">
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-shipping-fast"></i>
                </div>
                <h5 class="feature-title">Free Shipping</h5>
                <p>On orders over $50</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-undo"></i>
                </div>
                <h5 class="feature-title">Easy Returns</h5>
                <p>30-day return policy</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h5 class="feature-title">Secure Payment</h5>
                <p>100% secure transactions</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-headset"></i>
                </div>
                <h5 class="feature-title">24/7 Support</h5>
                <p>Dedicated customer service</p>
            </div>
        </div>
    </div>
</section>

<!-- Featured Categories -->
<section class="categories-section py-5 bg-light" id="categories">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Shop By Categories</h2>
            <p class="text-muted">Browse our premium collection of dry fruits categories</p>
        </div>

        <div class="categories-grid">
            @forelse($categories as $category)
            <div class="category-card">
                <div class="category-image">
                    <img src="{{ $category->image_url ?? 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80' }}"
                        alt="{{ $category->name }}">
                    <div class="category-overlay">
                        <a href="{{ route('shop.index', ['category' => $category->slug]) }}" class="btn btn-primary">
                            Shop Now
                        </a>
                    </div>
                </div>
                <div class="category-info">
                    <h5 class="category-title">{{ $category->name }}</h5>
                    <p class="category-count">{{ $category->products_count ?? 0 }} products</p>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">No categories available</h4>
            </div>
            @endforelse
        </div>

        @if($categories->count() > 0)
        <div class="text-center mt-5">
            <a href="{{ route('categories.index') }}" class="btn btn-outline-primary btn-lg">
                View All Categories <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
        @endif
    </div>
</section>

<!-- Featured Products -->
<section class="products-section py-5" id="featured">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Featured Products</h2>
            <p class="text-muted">Handpicked selection of our premium products</p>
        </div>

        <div class="products-grid">
            @forelse($featuredProducts as $product)
            <div class="product-card">
                <div class="product-image">
                    <img src="{{ $product->primaryImage->media_url ?? 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80' }}"
                        alt="{{ $product->name }}">

                    @if($product->is_new_arrival)
                    <span class="product-badge badge-new">New</span>
                    @endif

                    @if($product->compare_at_price && $product->compare_at_price > $product->best_price)
                    <span class="product-badge badge-sale">Sale</span>
                    @endif

                    <div class="product-overlay">
                        <div class="product-actions">
                            <button class="btn btn-primary add-to-cart-btn"
                                data-product-id="{{ $product->id }}">
                                <i class="fas fa-cart-plus"></i>
                            </button>

                            @auth
                            <button class="btn btn-outline-danger wishlist-toggle-btn"
                                data-product-id="{{ $product->id }}">
                                <i class="{{ App\Models\Wishlist::isInWishlist($product->id) ? 'fas' : 'far' }} fa-heart"></i>
                            </button>
                            @endauth

                            <a href="{{ route('shop.show', $product->slug) }}"
                                class="btn btn-outline-secondary">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="product-content">
                    <div class="product-category">
                        {{ $product->category->name ?? 'Uncategorized' }}
                    </div>
                    <h4 class="product-title">
                        <a href="{{ route('shop.show', $product->slug) }}">
                            {{ Str::limit($product->name, 40) }}
                        </a>
                    </h4>

                    @if($product->average_rating > 0)
                    <div class="product-rating">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <=$product->average_rating)
                            <i class="fas fa-star text-warning"></i>
                            @elseif($i - 0.5 <= $product->average_rating)
                                <i class="fas fa-star-half-alt text-warning"></i>
                                @else
                                <i class="far fa-star text-warning"></i>
                                @endif
                                @endfor
                                <span class="rating-count">({{ $product->total_reviews }})</span>
                    </div>
                    @endif

                    <div class="product-price">
                        <span class="current-price">${{ number_format($product->best_price, 2) }}</span>
                        @if($product->compare_at_price && $product->compare_at_price > $product->best_price)
                        <span class="old-price">${{ number_format($product->compare_at_price, 2) }}</span>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">No featured products available</h4>
            </div>
            @endforelse
        </div>

        @if($featuredProducts->count() > 0)
        <div class="text-center mt-4">
            <a href="{{ route('shop.index', ['featured' => true]) }}" class="btn btn-outline-primary btn-lg">
                View All Featured Products <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
        @endif
    </div>
</section>

<!-- New Arrivals -->
@if($newArrivals->count() > 0)
<section class="new-arrivals-section py-5 bg-light">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">New Arrivals</h2>
            <p class="text-muted">Fresh products added weekly</p>
        </div>

        <div class="products-grid">
            @foreach($newArrivals as $product)
            <div class="product-card">
                <div class="product-image">
                    <a href="{{ route('shop.show', $product->slug) }}">
                        <img src="{{ $product->primaryImage->media_url ?? 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80' }}"
                            alt="{{ $product->name }}">
                    </a>
                </div>
                <div class="product-content">
                    <h6 class="product-title">
                        <a href="{{ route('shop.show', $product->slug) }}">
                            {{ Str::limit($product->name, 30) }}
                        </a>
                    </h6>
                    <div class="product-price">
                        <span class="current-price">${{ number_format($product->best_price, 2) }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('shop.index', ['new_arrival' => true]) }}" class="btn btn-outline-primary">
                View All New Arrivals <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>
@endif

<!-- Testimonials -->
<section class="testimonials-section py-5">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">What Our Customers Say</h2>
            <p class="text-muted">Trusted by thousands of happy customers</p>
        </div>

        <div class="testimonial-slider">
            @forelse($testimonials as $testimonial)
            <div class="testimonial-card">
                <div class="testimonial-rating">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <=$testimonial->rating)
                        <i class="fas fa-star text-warning"></i>
                        @else
                        <i class="far fa-star text-warning"></i>
                        @endif
                        @endfor
                </div>
                <p class="testimonial-text">"{{ $testimonial->comment }}"</p>
                <div class="testimonial-author">
                    @if($testimonial->avatar_url)
                    <div class="author-avatar">
                        <img src="{{ asset('storage/' . $testimonial->avatar_url) }}"
                            alt="{{ $testimonial->name }}">
                    </div>
                    @endif
                    <div class="author-info">
                        <h6>{{ $testimonial->name }}</h6>
                        <small>{{ $testimonial->designation }}</small>
                    </div>
                </div>
            </div>
            @empty
            <!-- Default testimonials -->
            <div class="testimonial-card">
                <div class="testimonial-rating">
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star text-warning"></i>
                </div>
                <p class="testimonial-text">"The quality of products from Nuts & Berries is exceptional. Fresh delivery every time!"</p>
                <div class="testimonial-author">
                    <div class="author-avatar">
                        <img src="https://i.pravatar.cc/50?img=1" alt="Customer">
                    </div>
                    <div class="author-info">
                        <h6>Sarah Johnson</h6>
                        <small>Regular Customer</small>
                    </div>
                </div>
            </div>

            <div class="testimonial-card">
                <div class="testimonial-rating">
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star-half-alt text-warning"></i>
                </div>
                <p class="testimonial-text">"Great variety and excellent customer service. My go-to for premium dry fruits."</p>
                <div class="testimonial-author">
                    <div class="author-avatar">
                        <img src="https://i.pravatar.cc/50?img=2" alt="Customer">
                    </div>
                    <div class="author-info">
                        <h6>Michael Chen</h6>
                        <small>Food Blogger</small>
                    </div>
                </div>
            </div>

            <div class="testimonial-card">
                <div class="testimonial-rating">
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star text-warning"></i>
                </div>
                <p class="testimonial-text">"Fast delivery and fresh products every time. Highly recommend Nuts & Berries!"</p>
                <div class="testimonial-author">
                    <div class="author-avatar">
                        <img src="https://i.pravatar.cc/50?img=3" alt="Customer">
                    </div>
                    <div class="author-info">
                        <h6>Emma Davis</h6>
                        <small>Restaurant Owner</small>
                    </div>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>

<!-- Newsletter Section -->
<section class="newsletter-section py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h2 class="text-white mb-3">Stay Updated</h2>
                <p class="text-white mb-0">Subscribe to our newsletter for exclusive offers, new arrivals, and health tips!</p>
            </div>
            <div class="col-lg-6">
                <form class="newsletter-form">
                    <div class="form-group">
                        <input type="email"
                            class="form-control"
                            placeholder="Enter your email address"
                            required
                            aria-label="Email for newsletter">
                    </div>
                    <button type="submit" class="btn btn-light btn-lg mt-3">
                        Subscribe <i class="fas fa-paper-plane ms-2"></i>
                    </button>
                    <p class="form-text text-white mt-2">We respect your privacy. Unsubscribe at any time.</p>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    /* Hero Section - Side by Side Layout */
    .hero-section {
        padding: var(--space-2xl) 0;
        background: linear-gradient(135deg, var(--background-color) 0%, #F8F4E9 100%);
        position: relative;
        overflow: hidden;
        min-height: 80vh;
        display: flex;
        align-items: center;
    }

    .hero-section .container {
        position: relative;
        z-index: 2;
    }

    /* Row and Columns Layout */
    .row {
        display: flex;
        flex-wrap: wrap;
        margin: 0 -15px;
        align-items: center;
    }

    .col-lg-6 {
        flex: 0 0 50%;
        max-width: 50%;
        padding: 0 15px;
        position: relative;
        width: 100%;
    }

    .min-vh-70 {
        min-height: 70vh;
    }

    .align-items-center {
        align-items: center !important;
    }

    /* Left Column - Text Content */
    .hero-text-column {
        padding-right: 40px;
    }

    .hero-title {
        font-size: var(--text-5xl);
        margin-bottom: var(--space-lg);
        color: var(--primary-color);
        font-family: 'Playfair Display', serif;
        font-weight: 800;
        line-height: 1.2;
        min-height: 120px;
        display: flex;
        align-items: center;
    }

    .hero-subtitle {
        font-size: var(--text-lg);
        margin-bottom: var(--space-xl);
        color: var(--text-secondary);
        max-width: 500px;
        line-height: 1.6;
    }

    .hero-buttons {
        display: flex;
        gap: var(--space-md);
        margin-top: var(--space-xl);
    }

    /* Right Column - Image Content */
    .hero-image-column {
        position: relative;
        height: 600px;
    }

    .hero-image-container {
        width: 100%;
        height: 100%;
        position: relative;
    }

    /* Main Image with Floating Animation */
    .hero-main-image {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 450px;
        height: 450px;
        z-index: 2;
        animation: mainImageFloat 6s ease-in-out infinite;
    }

    .hero-main-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 20px;
        box-shadow:
            0 20px 40px rgba(0, 0, 0, 0.1),
            0 0 0 1px rgba(255, 255, 255, 0.2),
            inset 0 1px 0 rgba(255, 255, 255, 0.6);
        transition: all 0.3s ease;
    }

    .hero-main-image:hover img {
        transform: perspective(1000px) rotateY(5deg) rotateX(2deg) scale(1.05);
        box-shadow:
            0 30px 60px rgba(0, 0, 0, 0.15),
            0 0 0 1px rgba(255, 255, 255, 0.3),
            inset 0 2px 0 rgba(255, 255, 255, 0.8);
    }

    .hero-badge {
        position: absolute;
        top: 20px;
        right: 20px;
        background: var(--gradient-gold);
        color: var(--text-primary);
        padding: 10px 20px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 14px;
        box-shadow:
            0 8px 20px rgba(255, 165, 0, 0.3),
            0 0 0 2px rgba(255, 255, 255, 0.5);
        display: flex;
        align-items: center;
        z-index: 3;
        animation: badgePulse 2s ease-in-out infinite;
    }

    /* Floating Product Images */
    .product-floating-image {
        position: absolute;
        width: 140px;
        height: 140px;
        border-radius: 18px;
        overflow: hidden;
        box-shadow:
            0 15px 35px rgba(0, 0, 0, 0.1),
            0 5px 15px rgba(0, 0, 0, 0.07);
        z-index: 1;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        border: 3px solid transparent;
    }

    .product-floating-image:hover {
        transform: scale(1.15) rotate(5deg);
        z-index: 10;
        border-color: var(--accent-color);
        box-shadow:
            0 25px 50px rgba(0, 0, 0, 0.15),
            0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .product-floating-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .product-floating-image:hover img {
        transform: scale(1.1);
    }

    .product-floating-image .product-label {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(transparent, rgba(0, 0, 0, 0.8));
        color: white;
        padding: 8px;
        font-size: 12px;
        font-weight: 600;
        text-align: center;
        transform: translateY(100%);
        transition: transform 0.3s ease;
    }

    .product-floating-image:hover .product-label {
        transform: translateY(0);
    }

    /* Floating positions with individual animations */
    .floating-image-1 {
        top: 10%;
        left: 5%;
        animation: floatProduct1 12s ease-in-out infinite;
    }

    .floating-image-2 {
        top: 5%;
        right: 8%;
        animation: floatProduct2 14s ease-in-out infinite 1s;
    }

    .floating-image-3 {
        bottom: 20%;
        left: 8%;
        animation: floatProduct3 16s ease-in-out infinite 2s;
    }

    .floating-image-4 {
        bottom: 15%;
        right: 5%;
        animation: floatProduct4 18s ease-in-out infinite 3s;
    }

    /* Quality Badges */
    .quality-badge {
        position: absolute;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        padding: 10px 16px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 600;
        color: var(--primary-color);
        box-shadow:
            0 10px 25px rgba(0, 0, 0, 0.1),
            0 0 0 1px rgba(255, 255, 255, 0.5);
        display: flex;
        align-items: center;
        gap: 8px;
        z-index: 4;
        white-space: nowrap;
    }

    .quality-badge i {
        color: var(--accent-color);
    }

    .badge-1 {
        top: 20%;
        right: 20%;
        animation: badgeFloat 8s ease-in-out infinite;
    }

    .badge-2 {
        top: 50%;
        left: 10%;
        animation: badgeFloat 9s ease-in-out infinite 0.5s;
    }

    .badge-3 {
        bottom: 25%;
        right: 15%;
        animation: badgeFloat 10s ease-in-out infinite 1s;
    }

    /* Background Elements */
    .bg-element {
        position: absolute;
        border-radius: 50%;
        background: radial-gradient(circle,
                rgba(255, 245, 235, 0.6) 0%,
                rgba(255, 245, 235, 0) 70%);
        z-index: 0;
    }

    .element-1 {
        width: 300px;
        height: 300px;
        top: -100px;
        right: -100px;
        animation: elementPulse 20s ease-in-out infinite;
    }

    .element-2 {
        width: 400px;
        height: 400px;
        bottom: -150px;
        left: -150px;
        animation: elementPulse 25s ease-in-out infinite reverse;
    }

    .element-3 {
        width: 200px;
        height: 200px;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        animation: elementRotate 30s linear infinite;
    }

    /* Floating Particles */
    .hero-particles {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        z-index: 0;
        pointer-events: none;
    }

    .particle {
        position: absolute;
        background: radial-gradient(circle,
                rgba(255, 215, 140, 0.3) 0%,
                rgba(255, 215, 140, 0) 70%);
        border-radius: 50%;
        animation: particleFloat 20s linear infinite;
    }

    /* Particle positions */
    .particle:nth-child(1) {
        width: 8px;
        height: 8px;
        top: 20%;
        left: 10%;
        animation-delay: 0s;
    }

    .particle:nth-child(2) {
        width: 12px;
        height: 12px;
        top: 60%;
        left: 80%;
        animation-delay: 5s;
    }

    .particle:nth-child(3) {
        width: 6px;
        height: 6px;
        top: 80%;
        left: 30%;
        animation-delay: 10s;
    }

    .particle:nth-child(4) {
        width: 10px;
        height: 10px;
        top: 40%;
        left: 90%;
        animation-delay: 15s;
    }

    .particle:nth-child(5) {
        width: 7px;
        height: 7px;
        top: 70%;
        left: 20%;
        animation-delay: 20s;
    }

    .particle:nth-child(6) {
        width: 9px;
        height: 9px;
        top: 30%;
        left: 70%;
        animation-delay: 8s;
    }

    .particle:nth-child(7) {
        width: 5px;
        height: 5px;
        top: 50%;
        left: 40%;
        animation-delay: 12s;
    }

    .particle:nth-child(8) {
        width: 11px;
        height: 11px;
        top: 65%;
        left: 60%;
        animation-delay: 18s;
    }

    /* Keyframe Animations */
    @keyframes mainImageFloat {

        0%,
        100% {
            transform: translate(-50%, -50%) rotate(0deg);
        }

        33% {
            transform: translate(-50%, -52%) rotate(1deg);
        }

        66% {
            transform: translate(-50%, -48%) rotate(-1deg);
        }
    }

    @keyframes floatProduct1 {

        0%,
        100% {
            transform: translate(0, 0) rotate(0deg);
        }

        25% {
            transform: translate(10px, -15px) rotate(2deg);
        }

        50% {
            transform: translate(-5px, 10px) rotate(-1deg);
        }

        75% {
            transform: translate(15px, 5px) rotate(1deg);
        }
    }

    @keyframes floatProduct2 {

        0%,
        100% {
            transform: translate(0, 0) rotate(0deg);
        }

        25% {
            transform: translate(-15px, 10px) rotate(-2deg);
        }

        50% {
            transform: translate(10px, -5px) rotate(1deg);
        }

        75% {
            transform: translate(-5px, -15px) rotate(-1deg);
        }
    }

    @keyframes floatProduct3 {

        0%,
        100% {
            transform: translate(0, 0) rotate(0deg);
        }

        25% {
            transform: translate(15px, -10px) rotate(3deg);
        }

        50% {
            transform: translate(-10px, 15px) rotate(-2deg);
        }

        75% {
            transform: translate(5px, 10px) rotate(1deg);
        }
    }

    @keyframes floatProduct4 {

        0%,
        100% {
            transform: translate(0, 0) rotate(0deg);
        }

        25% {
            transform: translate(-10px, -15px) rotate(-3deg);
        }

        50% {
            transform: translate(15px, 5px) rotate(2deg);
        }

        75% {
            transform: translate(-5px, 15px) rotate(-1deg);
        }
    }

    @keyframes badgeFloat {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-10px);
        }
    }

    @keyframes badgePulse {

        0%,
        100% {
            transform: scale(1);
            box-shadow:
                0 8px 20px rgba(255, 165, 0, 0.3),
                0 0 0 2px rgba(255, 255, 255, 0.5);
        }

        50% {
            transform: scale(1.05);
            box-shadow:
                0 12px 25px rgba(255, 165, 0, 0.4),
                0 0 0 2px rgba(255, 255, 255, 0.6);
        }
    }

    @keyframes elementPulse {

        0%,
        100% {
            transform: scale(1);
            opacity: 0.5;
        }

        50% {
            transform: scale(1.1);
            opacity: 0.7;
        }
    }

    @keyframes elementRotate {
        0% {
            transform: translate(-50%, -50%) rotate(0deg);
        }

        100% {
            transform: translate(-50%, -50%) rotate(360deg);
        }
    }

    @keyframes particleFloat {
        0% {
            transform: translateY(100vh) translateX(0);
            opacity: 0;
        }

        10% {
            opacity: 1;
        }

        90% {
            opacity: 1;
        }

        100% {
            transform: translateY(-100px) translateX(100px);
            opacity: 0;
        }
    }

    /* Responsive Design */
    @media (max-width: 1200px) {
        .hero-main-image {
            width: 400px;
            height: 400px;
        }

        .product-floating-image {
            width: 120px;
            height: 120px;
        }
    }

    @media (max-width: 992px) {
        .hero-section {
            padding: var(--space-xl) 0;
            min-height: auto;
        }

        .col-lg-6 {
            flex: 0 0 100%;
            max-width: 100%;
        }

        .hero-text-column {
            padding-right: 0;
            margin-bottom: var(--space-xl);
            text-align: center;
        }

        .hero-title {
            min-height: auto;
            justify-content: center;
        }

        .hero-subtitle {
            margin: 0 auto var(--space-lg);
        }

        .hero-buttons {
            justify-content: center;
        }

        .hero-image-column {
            height: 500px;
            margin-top: var(--space-lg);
        }

        .hero-main-image {
            width: 350px;
            height: 350px;
        }

        .product-floating-image {
            width: 100px;
            height: 100px;
        }

        .quality-badge {
            font-size: 10px;
            padding: 8px 12px;
        }
    }

    @media (max-width: 768px) {
        .hero-title {
            font-size: var(--text-3xl);
        }

        .hero-subtitle {
            font-size: var(--text-base);
        }

        .hero-image-column {
            height: 400px;
        }

        .hero-main-image {
            width: 300px;
            height: 300px;
        }

        .product-floating-image {
            width: 80px;
            height: 80px;
        }

        .hero-buttons {
            flex-direction: column;
        }

        .hero-buttons .btn {
            width: 100%;
            text-align: center;
        }
    }

    @media (max-width: 576px) {
        .hero-image-column {
            height: 350px;
        }

        .hero-main-image {
            width: 250px;
            height: 250px;
        }

        .product-floating-image {
            width: 70px;
            height: 70px;
        }

        .quality-badge {
            font-size: 9px;
            padding: 6px 10px;
        }

        .floating-image-1 {
            left: 2%;
        }

        .floating-image-2 {
            right: 2%;
        }

        .floating-image-3 {
            left: 2%;
        }

        .floating-image-4 {
            right: 2%;
        }
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/parallax/3.1.0/parallax.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Typed.js
        if (document.querySelector('.typed-text')) {
            new Typed('.typed-text', {
                strings: document.querySelector('.typed-text').dataset.typedItems.split(','),
                typeSpeed: 50,
                backSpeed: 30,
                backDelay: 2000,
                loop: true,
                showCursor: true,
                cursorChar: '|',
                smartBackspace: true
            });
        }

        // Initialize Parallax Effect on mouse move
        const heroSection = document.querySelector('.hero-section');
        const mainImage = document.querySelector('.hero-main-image');

        if (heroSection && mainImage) {
            let mouseX = 0;
            let mouseY = 0;
            let lastX = 0;
            let lastY = 0;

            heroSection.addEventListener('mousemove', (e) => {
                const rect = heroSection.getBoundingClientRect();
                mouseX = (e.clientX - rect.left) / rect.width;
                mouseY = (e.clientY - rect.top) / rect.height;

                // Smooth interpolation
                lastX += (mouseX - 0.5) * 0.1;
                lastY += (mouseY - 0.5) * 0.1;

                const rotateX = lastY * 10;
                const rotateY = -lastX * 10;

                // Apply parallax to main image
                mainImage.style.transform =
                    `translate(-50%, -50%) 
                     rotateY(${rotateY}deg) 
                     rotateX(${rotateX}deg) 
                     scale(1.02)`;

                // Apply subtle movement to floating images
                document.querySelectorAll('.product-floating-image').forEach((img, index) => {
                    const speed = (index + 1) * 0.3;
                    const x = lastX * 15 * speed;
                    const y = lastY * 15 * speed;
                    img.style.transform = `translate(${x}px, ${y}px)`;
                });

                // Move quality badges slightly
                document.querySelectorAll('.quality-badge').forEach((badge, index) => {
                    const speed = (index + 1) * 0.2;
                    const x = lastX * 10 * speed;
                    const y = lastY * 10 * speed;
                    badge.style.transform = `translate(${x}px, ${y}px)`;
                });
            });

            // Reset on mouse leave
            heroSection.addEventListener('mouseleave', () => {
                mainImage.style.transform = 'translate(-50%, -50%)';
                document.querySelectorAll('.product-floating-image').forEach(img => {
                    // Keep the floating animation but reset parallax
                    img.style.transform = '';
                });
                document.querySelectorAll('.quality-badge').forEach(badge => {
                    badge.style.transform = '';
                });
            });
        }

        // Interactive product image hover effects
        document.querySelectorAll('.product-floating-image').forEach(img => {
            img.addEventListener('mouseenter', function() {
                this.style.zIndex = '10';
                this.style.filter = 'brightness(1.1)';
                // Add glow effect
                this.style.boxShadow =
                    '0 25px 50px rgba(0, 0, 0, 0.2), 0 15px 25px rgba(0, 0, 0, 0.15)';
            });

            img.addEventListener('mouseleave', function() {
                this.style.zIndex = '1';
                this.style.filter = 'brightness(1)';
                this.style.boxShadow =
                    '0 15px 35px rgba(0, 0, 0, 0.1), 0 5px 15px rgba(0, 0, 0, 0.07)';
            });

            // Click to show product info toast
            img.addEventListener('click', function() {
                const label = this.querySelector('.product-label').textContent;
                showToast(`Exploring ${label} collection...`, 'info');

                // Add a click animation
                this.classList.add('clicked');
                setTimeout(() => {
                    this.classList.remove('clicked');
                }, 300);
            });
        });

        // Initialize Intersection Observer for scroll animations
        const observerOptions = {
            root: null,
            rootMargin: '0px',
            threshold: 0.1
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Add animation classes when elements come into view
                    entry.target.classList.add('animated');

                    // For product images, add a staggered animation
                    if (entry.target.classList.contains('product-floating-image')) {
                        setTimeout(() => {
                            entry.target.style.opacity = '1';
                            entry.target.style.transform = 'translateY(0)';
                        }, entry.target.dataset.delay || 0);
                    }
                }
            });
        }, observerOptions);

        // Observe all animated elements
        document.querySelectorAll('.product-floating-image, .quality-badge, .hero-main-image').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'opacity 0.8s cubic-bezier(0.4, 0, 0.2, 1), transform 0.8s cubic-bezier(0.4, 0, 0.2, 1), filter 0.3s ease';
            observer.observe(el);
        });

        // Add click animation to hero badge
        const heroBadge = document.querySelector('.hero-badge');
        if (heroBadge) {
            heroBadge.addEventListener('click', function() {
                this.classList.add('pulse-click');
                setTimeout(() => {
                    this.classList.remove('pulse-click');
                }, 600);
                showToast('We\'re rated #1 by our customers!', 'success');
            });
        }

        // Add subtle breathing animation to hero badge
        if (heroBadge) {
            setInterval(() => {
                const scale = 1 + Math.sin(Date.now() / 1000) * 0.05;
                heroBadge.style.transform = `scale(${scale})`;
            }, 50);
        }

        // Initialize particle animation
        const particles = document.querySelectorAll('.particle');
        particles.forEach((particle, index) => {
            // Set random initial position
            particle.style.left = `${Math.random() * 100}%`;
            particle.style.top = `${Math.random() * 100}%`;

            // Set random animation duration
            const duration = 15 + Math.random() * 20;
            particle.style.animationDuration = `${duration}s`;

            // Set random delay
            const delay = Math.random() * 5;
            particle.style.animationDelay = `${delay}s`;
        });
    });

    // Toast notification function
    function showToast(message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = `toast-notification toast-${type}`;
        toast.textContent = message;
        toast.style.cssText = `
            position: fixed;
            top: 100px;
            right: 20px;
            background: ${type === 'info' ? '#3498db' : type === 'success' ? '#2ecc71' : type === 'warning' ? '#f39c12' : '#e74c3c'};
            color: white;
            padding: 16px 24px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            z-index: 10000;
            font-weight: 500;
            max-width: 300px;
            animation: slideInRight 0.3s ease, fadeOut 0.3s ease 2.7s forwards;
            border-left: 4px solid ${type === 'info' ? '#2980b9' : type === 'success' ? '#229954' : type === 'warning' ? '#d68910' : '#cb4335'};
        `;

        document.body.appendChild(toast);

        // Remove after 3 seconds
        setTimeout(() => {
            toast.remove();
        }, 3000);

        // Add CSS for animations if not already present
        if (!document.getElementById('toast-animations')) {
            const style = document.createElement('style');
            style.id = 'toast-animations';
            style.textContent = `
                @keyframes slideInRight {
                    from {
                        transform: translateX(100%);
                        opacity: 0;
                    }
                    to {
                        transform: translateX(0);
                        opacity: 1;
                    }
                }
                @keyframes fadeOut {
                    from {
                        opacity: 1;
                    }
                    to {
                        opacity: 0;
                    }
                }
            `;
            document.head.appendChild(style);
        }
    }

    // Function to handle scroll animations
    function handleScrollAnimations() {
        const elements = document.querySelectorAll('.animate-on-scroll');
        elements.forEach(element => {
            const elementTop = element.getBoundingClientRect().top;
            const elementVisible = 150;

            if (elementTop < window.innerHeight - elementVisible) {
                element.classList.add('active');
            }
        });
    }

    // Add scroll event listener for animations
    window.addEventListener('scroll', handleScrollAnimations);
    // Initial check
    handleScrollAnimations();
</script>
@endpush