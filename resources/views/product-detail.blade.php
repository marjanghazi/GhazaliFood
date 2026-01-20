@extends('layouts.app')

@section('title', $product->name . ' - Ghazali Food')

@section('hero')
<section class="product-hero">
    <div class="container">
        <div class="hero-inner">
            <nav class="breadcrumb-nav">
                <a href="{{ url('/') }}" class="breadcrumb-link">Home</a>
                <span class="breadcrumb-separator">/</span>
                <a href="{{ route('shop.index') }}" class="breadcrumb-link">Shop</a>
                <span class="breadcrumb-separator">/</span>
                <span class="breadcrumb-current">{{ Str::limit($product->name, 30) }}</span>
            </nav>
        </div>
    </div>
</section>
@endsection

@section('content')
<div class="container">
    <div class="product-detail">
        <!-- Social Proof Header -->
        <div class="social-proof-header">
            <div class="proof-item">
                <i class="fas fa-users"></i>
                <span class="proof-text"><strong id="current-viewers">124</strong> people viewing this</span>
            </div>
            <div class="proof-item">
                <i class="fas fa-shopping-cart"></i>
                <span class="proof-text"><strong id="recent-purchases">87</strong> purchased today</span>
            </div>
            <div class="proof-item">
                <i class="fas fa-fire"></i>
                <span class="proof-text">Trending <span id="trending-rank">#3</span> in {{ $product->category->name ?? 'Dry Fruits' }}</span>
            </div>
        </div>

        <!-- Product Main Section - REVERSED LAYOUT -->
        <div class="product-main">
            <div class="row g-4">
                <!-- Product Gallery - NOW ON LEFT -->
                <div class="col-lg-6">
                    <div class="product-gallery-wrapper">
                        <!-- Main Image -->
                        <div class="main-image-area">
                            <div class="main-image-container">
                                <img src="{{ $product->media->first()->media_url ?? 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80' }}" 
                                     class="main-product-image" 
                                     id="mainProductImage"
                                     alt="{{ $product->name }}">
                                
                                <!-- Image Badges -->
                                <div class="image-badges">
                                    @if($product->is_new_arrival)
                                    <span class="badge badge-new">
                                        <i class="fas fa-star me-1"></i>New
                                    </span>
                                    @endif
                                    
                                    @if($product->compare_at_price && $product->compare_at_price > $product->best_price)
                                    <span class="badge badge-sale">
                                        -{{ $product->discount_percentage }}%
                                    </span>
                                    @endif

                                    @if($product->is_featured)
                                    <span class="badge badge-featured">
                                        <i class="fas fa-crown me-1"></i>Featured
                                    </span>
                                    @endif
                                </div>
                                
                                <!-- Live Viewers Indicator -->
                                <div class="live-viewers-indicator">
                                    <i class="fas fa-eye"></i>
                                    <span class="viewers-count" id="product-viewers">12</span> viewing now
                                </div>
                                
                                <!-- Recent Purchase Pulse -->
                                <div class="recent-purchase-pulse" id="recent-purchase-pulse">
                                    <i class="fas fa-bolt"></i>
                                    Just purchased
                                </div>
                            </div>
                        </div>

                        <!-- Thumbnails -->
                        @if($product->media->count() > 1)
                        <div class="thumbnail-area">
                            <div class="thumbnail-scroll">
                                @foreach($product->media as $index => $media)
                                <div class="thumbnail-item {{ $index === 0 ? 'active' : '' }}" 
                                     data-image="{{ $media->media_url }}">
                                    <img src="{{ $media->media_url }}" 
                                         alt="{{ $product->name }} - {{ $index + 1 }}">
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Image Stats -->
                        <div class="image-stats">
                            <div class="stat-item">
                                <i class="fas fa-expand"></i>
                                <span>Hover to zoom</span>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-images"></i>
                                <span>{{ $product->media->count() }} images</span>
                            </div>
                            <div class="stat-item">
                                <i class="fas fa-video"></i>
                                <span>360° view available</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Info - NOW ON RIGHT -->
                <div class="col-lg-6">
                    <div class="product-info-card">
                        <!-- Product Stats -->
                        <div class="product-stats-header">
                            <div class="stat-badge">
                                <i class="fas fa-star"></i>
                                <span>{{ number_format($product->average_rating, 1) }} ({{ $product->total_reviews }})</span>
                            </div>
                            <div class="stat-badge">
                                <i class="fas fa-shopping-cart"></i>
                                <span id="total-purchases">{{ rand(500, 2000) }}+ sold</span>
                            </div>
                            <div class="stat-badge">
                                <i class="fas fa-heart"></i>
                                <span id="wishlist-count">{{ rand(50, 300) }} saved</span>
                            </div>
                        </div>

                        <!-- Category & Brand -->
                        <div class="product-meta">
                            <div class="category-tag">
                                <i class="fas fa-tag me-1"></i>
                                {{ $product->category->name ?? 'Uncategorized' }}
                            </div>
                            <div class="brand-tag">
                                <i class="fas fa-crown me-1"></i>
                                Ghazali Premium
                            </div>
                        </div>

                        <!-- Product Title -->
                        <h1 class="product-title">{{ $product->name }}</h1>

                        <!-- Short Description -->
                        <p class="product-excerpt">{{ $product->short_description }}</p>

                        <!-- Rating & Verified Badge -->
                        <div class="rating-verified">
                            <div class="stars">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($product->average_rating))
                                        <i class="fas fa-star"></i>
                                    @elseif($i - 0.5 <= $product->average_rating)
                                        <i class="fas fa-star-half-alt"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                                <span class="rating-count">({{ $product->total_reviews }} reviews)</span>
                            </div>
                            <div class="verified-badge">
                                <i class="fas fa-check-circle"></i>
                                <span>Verified Purchase</span>
                            </div>
                        </div>

                        <!-- Pricing -->
                        <div class="pricing-section">
                            <div class="price-display">
                                <span class="current-price">${{ number_format($product->best_price, 2) }}</span>
                                @if($product->compare_at_price)
                                <span class="original-price">${{ number_format($product->compare_at_price, 2) }}</span>
                                <span class="savings-badge">Save ${{ number_format($product->compare_at_price - $product->best_price, 2) }}</span>
                                @endif
                            </div>
                            @if($product->compare_at_price)
                            <div class="savings-info">
                                <i class="fas fa-percentage text-danger me-1"></i>
                                Save {{ $product->discount_percentage }}%
                                <span class="discount-time">• Limited time offer</span>
                            </div>
                            @endif
                        </div>

                        <!-- Stock & Delivery -->
                        <div class="stock-delivery-info">
                            <div class="stock-status">
                                <div class="status-indicator available"></div>
                                <span>In Stock</span>
                                <span class="stock-count">• {{ rand(50, 200) }} units available</span>
                            </div>
                            <div class="delivery-estimate">
                                <i class="fas fa-shipping-fast"></i>
                                <span>Free delivery by <strong>tomorrow</strong></span>
                            </div>
                        </div>

                        <!-- Flash Sale Countdown - UPDATED WITH WEBSITE THEME -->
                        <div class="flash-sale-countdown">
                            <div class="countdown-header">
                                <i class="fas fa-bolt"></i>
                                <span>Flash Sale Ending In:</span>
                            </div>
                            <div class="countdown-timer" id="countdown-timer">
                                <div class="time-unit">
                                    <span class="time-value" id="hours">00</span>
                                    <span class="time-label">Hours</span>
                                </div>
                                <div class="time-unit">
                                    <span class="time-value" id="minutes">30</span>
                                    <span class="time-label">Minutes</span>
                                </div>
                                <div class="time-unit">
                                    <span class="time-value" id="seconds">00</span>
                                    <span class="time-label">Seconds</span>
                                </div>
                            </div>
                            <div class="sale-progress">
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: {{ rand(60, 90) }}%"></div>
                                </div>
                                <div class="progress-text">{{ rand(60, 90) }}% claimed</div>
                            </div>
                        </div>

                        <!-- Quantity Selector -->
                        <div class="quantity-section">
                            <label class="quantity-label">Quantity:</label>
                            <div class="quantity-controls">
                                <button class="quantity-btn minus" id="decreaseQty">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number" 
                                       class="quantity-input" 
                                       id="quantity" 
                                       value="1" 
                                       min="1" 
                                       max="99">
                                <button class="quantity-btn plus" id="increaseQty">
                                    <i class="fas fa-plus"></i>
                                </button>
                                <div class="quantity-actions">
                                    <button class="btn-quick-add" data-qty="3">+3</button>
                                    <button class="btn-quick-add" data-qty="5">+5</button>
                                </div>
                            </div>
                            <div class="bulk-discount">
                                <i class="fas fa-percentage"></i>
                                <span>Buy 3+, save 5% • Buy 5+, save 10%</span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="action-buttons">
                            <button class="btn btn-primary btn-lg add-to-cart-btn" 
                                    data-id="{{ $product->id }}"
                                    data-name="{{ $product->name }}">
                                <i class="fas fa-shopping-cart me-2"></i>
                                Add to Cart
                                <span class="btn-badge">+{{ rand(50, 200) }} today</span>
                            </button>
                            
                            <button class="btn btn-warning btn-lg buy-now-btn" 
                                    data-id="{{ $product->id }}">
                                <i class="fas fa-bolt me-2"></i>
                                Buy Now
                            </button>
                        </div>

                        <!-- Recent Purchases Notification -->
                        <div class="recent-purchases-notification">
                            <div class="notification-header">
                                <i class="fas fa-history"></i>
                                <span>Recent Purchases</span>
                            </div>
                            <div class="purchase-list" id="purchase-list">
                                <!-- Will be populated by JS -->
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="quick-actions">
                            <button class="action-link wishlist-toggle" data-id="{{ $product->id }}">
                                <i class="far fa-heart me-1"></i>
                                <span>Add to Wishlist</span>
                                <span class="action-count" id="wishlist-action-count">{{ rand(50, 300) }}</span>
                            </button>
                            <button class="action-link compare-toggle">
                                <i class="fas fa-balance-scale me-1"></i>
                                <span>Compare</span>
                            </button>
                            <button class="action-link share-product">
                                <i class="fas fa-share-alt me-1"></i>
                                <span>Share</span>
                            </button>
                        </div>

                        <!-- Trust Badges -->
                        <div class="trust-section">
                            <div class="trust-item">
                                <i class="fas fa-shield-alt"></i>
                                <span>100% Secure</span>
                            </div>
                            <div class="trust-item">
                                <i class="fas fa-truck"></i>
                                <span>Free Shipping</span>
                            </div>
                            <div class="trust-item">
                                <i class="fas fa-undo"></i>
                                <span>30-Day Returns</span>
                            </div>
                            <div class="trust-item">
                                <i class="fas fa-award"></i>
                                <span>Quality Guarantee</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Stats Bar -->
        <div class="product-stats-bar">
            <div class="stat-item">
                <div class="stat-icon">
                    <i class="fas fa-shipping-fast"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ rand(1, 3) }}-{{ rand(4, 7) }} days</div>
                    <div class="stat-label">Delivery</div>
                </div>
            </div>
            <div class="stat-item">
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">98%</div>
                    <div class="stat-label">Positive Reviews</div>
                </div>
            </div>
            <div class="stat-item">
                <div class="stat-icon">
                    <i class="fas fa-repeat"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ rand(1, 5) }}%</div>
                    <div class="stat-label">Return Rate</div>
                </div>
            </div>
            <div class="stat-item">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value" id="monthly-buyers">{{ rand(1000, 5000) }}+</div>
                    <div class="stat-label">Monthly Buyers</div>
                </div>
            </div>
        </div>

        <!-- Product Details Tabs -->
        <div class="product-details-tabs">
            <nav class="details-nav">
                <div class="nav-links">
                    <a href="#description" class="nav-link active">
                        <i class="fas fa-file-alt me-2"></i>
                        Description
                    </a>
                    <a href="#specifications" class="nav-link">
                        <i class="fas fa-list me-2"></i>
                        Specifications
                    </a>
                    <a href="#reviews" class="nav-link">
                        <i class="fas fa-star me-2"></i>
                        Reviews ({{ $product->reviews->count() }})
                        <span class="nav-badge">4.8</span>
                    </a>
                    <a href="#shipping" class="nav-link">
                        <i class="fas fa-truck me-2"></i>
                        Shipping & Returns
                    </a>
                    <a href="#faq" class="nav-link">
                        <i class="fas fa-question-circle me-2"></i>
                        FAQ
                    </a>
                </div>
            </nav>

            <div class="details-content">
                <!-- Description Section -->
                <section id="description" class="content-section active">
                    <div class="description-content">
                        {!! $product->full_description !!}
                    </div>
                    
                    <!-- Product Highlights -->
                    <div class="product-highlights">
                        <h5>Why Customers Love This Product</h5>
                        <div class="highlights-grid">
                            <div class="highlight-item">
                                <div class="highlight-icon">
                                    <i class="fas fa-leaf"></i>
                                </div>
                                <div class="highlight-text">
                                    <h6>100% Natural & Organic</h6>
                                    <p>No preservatives, additives, or artificial flavors</p>
                                </div>
                                <div class="highlight-stats">
                                    <span class="stat-value">98%</span>
                                    <span class="stat-label">Satisfaction</span>
                                </div>
                            </div>
                            <div class="highlight-item">
                                <div class="highlight-icon">
                                    <i class="fas fa-award"></i>
                                </div>
                                <div class="highlight-text">
                                    <h6>Premium Quality</h6>
                                    <p>Handpicked and carefully selected for maximum freshness</p>
                                </div>
                                <div class="highlight-stats">
                                    <span class="stat-value">#1</span>
                                    <span class="stat-label">Best Seller</span>
                                </div>
                            </div>
                            <div class="highlight-item">
                                <div class="highlight-icon">
                                    <i class="fas fa-heart"></i>
                                </div>
                                <div class="highlight-text">
                                    <h6>Health Benefits</h6>
                                    <p>Rich in antioxidants, vitamins, and essential nutrients</p>
                                </div>
                                <div class="highlight-stats">
                                    <span class="stat-value">5★</span>
                                    <span class="stat-label">Rating</span>
                                </div>
                            </div>
                            <div class="highlight-item">
                                <div class="highlight-icon">
                                    <i class="fas fa-recycle"></i>
                                </div>
                                <div class="highlight-text">
                                    <h6>Eco-Friendly Packaging</h6>
                                    <p>Sustainable materials, fully recyclable</p>
                                </div>
                                <div class="highlight-stats">
                                    <span class="stat-value">100%</span>
                                    <span class="stat-label">Sustainable</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Usage Tips -->
                    <div class="usage-tips">
                        <h5>How to Enjoy</h5>
                        <div class="tips-grid">
                            <div class="tip-item">
                                <div class="tip-number">1</div>
                                <div class="tip-content">
                                    <h6>As a Healthy Snack</h6>
                                    <p>Enjoy directly from the pack as a nutritious snack</p>
                                </div>
                            </div>
                            <div class="tip-item">
                                <div class="tip-number">2</div>
                                <div class="tip-content">
                                    <h6>In Breakfast</h6>
                                    <p>Add to cereals, oatmeal, or yogurt for extra nutrition</p>
                                </div>
                            </div>
                            <div class="tip-item">
                                <div class="tip-number">3</div>
                                <div class="tip-content">
                                    <h6>In Baking</h6>
                                    <p>Perfect for cookies, cakes, and bread recipes</p>
                                </div>
                            </div>
                            <div class="tip-item">
                                <div class="tip-number">4</div>
                                <div class="tip-content">
                                    <h6>As a Gift</h6>
                                    <p>Premium packaging makes it perfect for gifting</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Specifications Section -->
                <section id="specifications" class="content-section">
                    <div class="specs-grid">
                        <div class="specs-column">
                            <h5>Product Details</h5>
                            <dl class="specs-list">
                                <dt>SKU</dt>
                                <dd>{{ $product->sku ?? 'GF-' . str_pad($product->id, 6, '0', STR_PAD_LEFT) }}</dd>
                                
                                <dt>Weight</dt>
                                <dd>500g / 1.1 lbs</dd>
                                
                                <dt>Dimensions</dt>
                                <dd>20 × 15 × 5 cm (7.9 × 5.9 × 2 in)</dd>
                                
                                <dt>Shelf Life</dt>
                                <dd>12 Months from production date</dd>
                                
                                <dt>Storage</dt>
                                <dd>Cool, dry place away from direct sunlight</dd>
                                
                                <dt>Packaging</dt>
                                <dd>Resealable bag, recyclable materials</dd>
                                
                                <dt>Country of Origin</dt>
                                <dd>USA</dd>
                            </dl>
                        </div>
                        
                        <div class="specs-column">
                            <h5>Nutritional Information (per 100g)</h5>
                            <dl class="specs-list">
                                <dt>Energy</dt>
                                <dd>600 kcal</dd>
                                
                                <dt>Protein</dt>
                                <dd>20g</dd>
                                
                                <dt>Fat</dt>
                                <dd>45g (Saturated: 5g)</dd>
                                
                                <dt>Carbohydrates</dt>
                                <dd>25g</dd>
                                
                                <dt>Fiber</dt>
                                <dd>15g</dd>
                                
                                <dt>Sugar</dt>
                                <dd>5g (Natural)</dd>
                                
                                <dt>Sodium</dt>
                                <dd>2mg</dd>
                                
                                <dt>Cholesterol</dt>
                                <dd>0mg</dd>
                            </dl>
                        </div>
                    </div>

                    <!-- Certifications -->
                    <div class="certifications">
                        <h5>Certifications & Quality Standards</h5>
                        <div class="cert-grid">
                            <div class="cert-item">
                                <i class="fas fa-certificate"></i>
                                <span>USDA Organic</span>
                            </div>
                            <div class="cert-item">
                                <i class="fas fa-certificate"></i>
                                <span>Non-GMO Project Verified</span>
                            </div>
                            <div class="cert-item">
                                <i class="fas fa-certificate"></i>
                                <span>Gluten-Free Certified</span>
                            </div>
                            <div class="cert-item">
                                <i class="fas fa-certificate"></i>
                                <span>Kosher Certified</span>
                            </div>
                            <div class="cert-item">
                                <i class="fas fa-certificate"></i>
                                <span>FDA Approved</span>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Reviews Section -->
                <section id="reviews" class="content-section">
                    <!-- Reviews Summary -->
                    <div class="reviews-summary">
                        <div class="overall-rating">
                            <div class="rating-number">{{ number_format($product->average_rating, 1) }}</div>
                            <div class="rating-stars">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= floor($product->average_rating) ? 'text-warning' : '' }}"></i>
                                @endfor
                            </div>
                            <div class="rating-count">{{ $product->total_reviews }} reviews</div>
                            <div class="recommendation">
                                <i class="fas fa-thumbs-up"></i>
                                <span>98% recommend this product</span>
                            </div>
                        </div>
                        
                        <div class="rating-distribution">
                            @for($i = 5; $i >= 1; $i--)
                                @php
                                    $count = $product->reviews->where('rating', $i)->count();
                                    $percentage = $product->total_reviews > 0 ? ($count / $product->total_reviews) * 100 : 0;
                                @endphp
                                <div class="distribution-item">
                                    <span class="star-label">{{ $i }} star{{ $i > 1 ? 's' : '' }}</span>
                                    <div class="progress-bar">
                                        <div class="progress-fill" style="width: {{ $percentage }}%"></div>
                                    </div>
                                    <span class="percentage">{{ round($percentage) }}%</span>
                                    <span class="count">({{ $count }})</span>
                                </div>
                            @endfor
                        </div>

                        <!-- Review Highlights -->
                        <div class="review-highlights">
                            <h6>What customers say:</h6>
                            <div class="highlight-tags">
                                <span class="highlight-tag">Premium Quality</span>
                                <span class="highlight-tag">Fresh Taste</span>
                                <span class="highlight-tag">Great Value</span>
                                <span class="highlight-tag">Fast Delivery</span>
                                <span class="highlight-tag">Healthy Snack</span>
                            </div>
                        </div>
                    </div>

                    <!-- Reviews List -->
                    @if($product->reviews->count() > 0)
                    <div class="reviews-list">
                        @foreach($product->reviews as $review)
                        <div class="review-card">
                            <div class="review-header">
                                <div class="reviewer-info">
                                    <div class="reviewer-avatar">
                                        {{ substr($review->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h6 class="reviewer-name">{{ $review->user->name }}</h6>
                                        <div class="reviewer-verified">
                                            <i class="fas fa-check-circle"></i>
                                            <span>Verified Purchase</span>
                                        </div>
                                        <div class="review-date">
                                            {{ $review->created_at->format('F d, Y') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="review-rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                                    @endfor
                                </div>
                            </div>
                            
                            @if($review->title)
                            <h6 class="review-title">{{ $review->title }}</h6>
                            @endif
                            
                            <p class="review-content">{{ $review->comment }}</p>
                            
                            @if($review->pros || $review->cons)
                            <div class="review-highlights">
                                @if($review->pros)
                                <div class="highlight positive">
                                    <i class="fas fa-plus-circle text-success me-2"></i>
                                    {{ $review->pros }}
                                </div>
                                @endif
                                @if($review->cons)
                                <div class="highlight negative">
                                    <i class="fas fa-minus-circle text-danger me-2"></i>
                                    {{ $review->cons }}
                                </div>
                                @endif
                            </div>
                            @endif

                            <!-- Review Helpful -->
                            <div class="review-helpful">
                                <span class="helpful-text">Was this review helpful?</span>
                                <button class="btn-helpful">
                                    <i class="fas fa-thumbs-up"></i> Yes
                                    <span class="count">{{ rand(5, 50) }}</span>
                                </button>
                                <button class="btn-helpful">
                                    <i class="fas fa-thumbs-down"></i> No
                                    <span class="count">{{ rand(1, 10) }}</span>
                                </button>
                                <button class="btn-report">
                                    <i class="fas fa-flag"></i> Report
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="no-reviews">
                        <i class="fas fa-star fa-3x text-muted"></i>
                        <h5>No reviews yet</h5>
                        <p>Be the first to share your experience!</p>
                    </div>
                    @endif

                    <!-- Add Review Form -->
                    @auth
                    <div class="add-review-form">
                        <h5>Share Your Experience</h5>
                        <form id="reviewForm">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            
                            <div class="rating-input mb-4">
                                <label>Your Rating</label>
                                <div class="star-rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="far fa-star rating-star" 
                                           data-rating="{{ $i }}"></i>
                                    @endfor
                                    <input type="hidden" name="rating" id="userRating" value="0">
                                </div>
                            </div>
                            
                            <div class="form-group mb-4">
                                <label for="reviewTitle">Review Title</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="reviewTitle" 
                                       name="title"
                                       placeholder="Summarize your experience">
                            </div>
                            
                            <div class="form-group mb-4">
                                <label for="reviewText">Your Review</label>
                                <textarea class="form-control" 
                                          id="reviewText" 
                                          name="comment" 
                                          rows="4"
                                          placeholder="Share your thoughts about this product..."></textarea>
                            </div>

                            <div class="form-group mb-4">
                                <label>What did you like?</label>
                                <input type="text" 
                                       class="form-control" 
                                       name="pros"
                                       placeholder="What you loved about this product">
                            </div>

                            <div class="form-group mb-4">
                                <label>What could be improved?</label>
                                <input type="text" 
                                       class="form-control" 
                                       name="cons"
                                       placeholder="Any suggestions for improvement">
                            </div>
                            
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-2"></i>Submit Review
                            </button>
                        </form>
                    </div>
                    @else
                    <div class="review-login-prompt">
                        <div class="prompt-content">
                            <i class="fas fa-user-circle fa-2x"></i>
                            <div>
                                <h6>Share your thoughts</h6>
                                <p>
                                    Please <a href="{{ route('login') }}" class="text-primary">login</a> 
                                    to write a review and help other customers.
                                </p>
                            </div>
                        </div>
                    </div>
                    @endauth
                </section>

                <!-- Shipping Section -->
                <section id="shipping" class="content-section">
                    <div class="shipping-info-grid">
                        <div class="info-card">
                            <div class="info-icon">
                                <i class="fas fa-shipping-fast"></i>
                            </div>
                            <div class="info-content">
                                <h5>Shipping Information</h5>
                                <div class="shipping-options">
                                    <div class="option-item">
                                        <div class="option-header">
                                            <i class="fas fa-truck"></i>
                                            <span>Standard Shipping</span>
                                        </div>
                                        <div class="option-details">
                                            <span class="price">Free on orders over $50</span>
                                            <span class="time">3-5 business days</span>
                                        </div>
                                    </div>
                                    <div class="option-item">
                                        <div class="option-header">
                                            <i class="fas fa-rocket"></i>
                                            <span>Express Shipping</span>
                                        </div>
                                        <div class="option-details">
                                            <span class="price">$9.99</span>
                                            <span class="time">1-2 business days</span>
                                        </div>
                                    </div>
                                    <div class="option-item">
                                        <div class="option-header">
                                            <i class="fas fa-globe"></i>
                                            <span>International Shipping</span>
                                        </div>
                                        <div class="option-details">
                                            <span class="price">$19.99</span>
                                            <span class="time">7-14 business days</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="info-card">
                            <div class="info-icon">
                                <i class="fas fa-undo"></i>
                            </div>
                            <div class="info-content">
                                <h5>Return Policy</h5>
                                <div class="policy-details">
                                    <div class="policy-item">
                                        <i class="fas fa-check-circle text-success"></i>
                                        <div>
                                            <h6>30-Day Return Policy</h6>
                                            <p>Full refund within 30 days of delivery</p>
                                        </div>
                                    </div>
                                    <div class="policy-item">
                                        <i class="fas fa-sync-alt text-primary"></i>
                                        <div>
                                            <h6>Easy Returns</h6>
                                            <p>Free returns for defective items</p>
                                        </div>
                                    </div>
                                    <div class="policy-item">
                                        <i class="fas fa-shield-alt text-warning"></i>
                                        <div>
                                            <h6>Money-Back Guarantee</h6>
                                            <p>100% satisfaction guarantee</p>
                                        </div>
                                    </div>
                                    <div class="policy-item">
                                        <i class="fas fa-clock text-info"></i>
                                        <div>
                                            <h6>Quick Refunds</h6>
                                            <p>Refunds processed within 5 business days</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Delivery Map -->
                    <div class="delivery-map">
                        <h5>Delivery Coverage</h5>
                        <div class="map-placeholder">
                            <i class="fas fa-map-marked-alt fa-3x"></i>
                            <p>We deliver to all 50 US states</p>
                            <div class="coverage-stats">
                                <div class="stat">
                                    <span class="value">50</span>
                                    <span class="label">States</span>
                                </div>
                                <div class="stat">
                                    <span class="value">98%</span>
                                    <span class="label">Coverage</span>
                                </div>
                                <div class="stat">
                                    <span class="value">24/7</span>
                                    <span class="label">Tracking</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- FAQ Section -->
                <section id="faq" class="content-section">
                    <div class="faq-grid">
                        <div class="faq-column">
                            <h5>Product Questions</h5>
                            <div class="faq-item">
                                <div class="faq-question">
                                    <span>Is this product organic?</span>
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                                <div class="faq-answer">
                                    <p>Yes, all our products are 100% certified organic and grown without pesticides or synthetic fertilizers.</p>
                                </div>
                            </div>
                            <div class="faq-item">
                                <div class="faq-question">
                                    <span>How should I store this product?</span>
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                                <div class="faq-answer">
                                    <p>Store in a cool, dry place away from direct sunlight. Once opened, keep in an airtight container to maintain freshness.</p>
                                </div>
                            </div>
                            <div class="faq-item">
                                <div class="faq-question">
                                    <span>What is the shelf life?</span>
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                                <div class="faq-answer">
                                    <p>The product has a shelf life of 12 months from the production date. The expiry date is clearly marked on the packaging.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="faq-column">
                            <h5>Order & Delivery</h5>
                            <div class="faq-item">
                                <div class="faq-question">
                                    <span>How long does shipping take?</span>
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                                <div class="faq-answer">
                                    <p>Standard shipping takes 3-5 business days. Express shipping (1-2 days) is available at checkout.</p>
                                </div>
                            </div>
                            <div class="faq-item">
                                <div class="faq-question">
                                    <span>Do you ship internationally?</span>
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                                <div class="faq-answer">
                                    <p>Yes, we ship worldwide. International shipping typically takes 7-14 business days.</p>
                                </div>
                            </div>
                            <div class="faq-item">
                                <div class="faq-question">
                                    <span>Can I track my order?</span>
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                                <div class="faq-answer">
                                    <p>Yes, you'll receive a tracking number via email once your order is shipped.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
        <div class="related-products-section">
            <div class="section-header">
                <h3>Frequently bought together</h3>
                <p class="section-subtitle">Customers who bought this also purchased</p>
            </div>
            
            <div class="related-products-grid">
                @foreach($relatedProducts as $related)
                <div class="related-product-card">
                    <div class="product-badge">
                        <span class="badge-best">Best Seller</span>
                        @if($related->compare_at_price)
                        <span class="badge-sale">-{{ $related->discount_percentage }}%</span>
                        @endif
                    </div>
                    <a href="{{ route('shop.show', $related->slug) }}" class="product-image">
                        <img src="{{ $related->primaryImage->media_url ?? 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80' }}"
                             alt="{{ $related->name }}">
                    </a>
                    <div class="product-info">
                        <a href="{{ route('shop.show', $related->slug) }}" class="product-name">
                            {{ Str::limit($related->name, 40) }}
                        </a>
                        <div class="product-rating">
                            <div class="stars">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($related->average_rating))
                                        <i class="fas fa-star"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="rating-count">({{ $related->total_reviews }})</span>
                        </div>
                        <div class="product-price">
                            ${{ number_format($related->best_price, 2) }}
                            @if($related->compare_at_price)
                            <span class="original-price">${{ number_format($related->compare_at_price, 2) }}</span>
                            @endif
                        </div>
                        <div class="product-stats">
                            <span class="stat"><i class="fas fa-shopping-cart"></i> {{ rand(100, 1000) }}+ sold</span>
                        </div>
                        <button class="btn btn-sm btn-primary add-to-cart-quick" 
                                data-id="{{ $related->id }}">
                            <i class="fas fa-cart-plus me-1"></i> Add to Cart
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Recently Viewed -->
        <div class="recently-viewed-section">
            <div class="section-header">
                <h3>Recently Viewed</h3>
                <a href="{{ route('shop.index') }}" class="view-all">View All Products</a>
            </div>
            <div class="recently-viewed-grid">
                <!-- Will be populated by JavaScript based on browsing history -->
            </div>
        </div>
    </div>
</div>

<!-- Image Zoom Modal -->
<div class="modal fade" id="imageZoomModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-body">
                <img src="" class="img-fluid" id="zoomedImage" alt="">
            </div>
        </div>
    </div>
</div>

<!-- Share Modal -->
<div class="modal fade" id="shareModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Share this product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="share-options">
                    <button class="share-option">
                        <i class="fab fa-facebook-f"></i>
                        <span>Facebook</span>
                    </button>
                    <button class="share-option">
                        <i class="fab fa-twitter"></i>
                        <span>Twitter</span>
                    </button>
                    <button class="share-option">
                        <i class="fab fa-pinterest-p"></i>
                        <span>Pinterest</span>
                    </button>
                    <button class="share-option">
                        <i class="fab fa-whatsapp"></i>
                        <span>WhatsApp</span>
                    </button>
                    <button class="share-option" onclick="navigator.clipboard.writeText(window.location.href)">
                        <i class="fas fa-link"></i>
                        <span>Copy Link</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Product Hero */
    .product-hero {
        background: var(--surface-color);
        padding: 1rem 0;
        border-bottom: 1px solid var(--border-color);
    }
    
    .breadcrumb-nav {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
    }
    
    .breadcrumb-link {
        color: var(--text-secondary);
        text-decoration: none;
        transition: color 0.2s;
    }
    
    .breadcrumb-link:hover {
        color: var(--primary-color);
    }
    
    .breadcrumb-current {
        color: var(--text-primary);
        font-weight: 500;
    }
    
    .breadcrumb-separator {
        color: var(--text-muted);
    }

    /* Social Proof Header */
    .social-proof-header {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        color: white;
        padding: 0.75rem 1rem;
        border-radius: 8px;
        margin: 1.5rem 0;
        display: flex;
        justify-content: space-around;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
        box-shadow: 0 2px 10px rgba(17, 80, 40, 0.2);
    }
    
    .proof-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
    }
    
    .proof-item i {
        font-size: 1rem;
        opacity: 0.9;
    }
    
    .proof-text strong {
        font-weight: 700;
        margin-right: 0.25rem;
    }
    
    /* Product Main Section */
    .product-detail {
        padding: 1.5rem 0;
    }
    
    /* Gallery on left side */
    .product-gallery-wrapper {
        position: sticky;
        top: 100px;
        background: white;
        border-radius: 12px;
        padding: 1rem;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
        border: 1px solid var(--border-color);
    }
    
    .main-image-area {
        margin-bottom: 1rem;
        position: relative;
    }
    
    .main-image-container {
        position: relative;
        background: #f8f9fa;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid var(--border-color);
        min-height: 300px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .main-product-image {
        max-width: 100%;
        max-height: 400px;
        width: auto;
        height: auto;
        object-fit: contain;
        padding: 1rem;
        transition: transform 0.3s ease;
        cursor: zoom-in;
    }
    
    .main-product-image:hover {
        transform: scale(1.02);
    }
    
    .image-badges {
        position: absolute;
        top: 1rem;
        left: 1rem;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        z-index: 10;
    }
    
    .badge {
        padding: 0.375rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }
    
    .badge-new {
        background: var(--gradient-gold);
        color: var(--text-primary);
    }
    
    .badge-sale {
        background: var(--danger-color);
        color: white;
    }
    
    .badge-featured {
        background: var(--primary-color);
        color: white;
    }
    
    /* Live Viewers Indicator */
    .live-viewers-indicator {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: rgba(0, 0, 0, 0.75);
        color: white;
        padding: 0.5rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        backdrop-filter: blur(4px);
        z-index: 10;
    }
    
    .live-viewers-indicator i {
        font-size: 0.875rem;
    }
    
    .viewers-count {
        font-weight: 700;
        color: var(--accent-color);
    }
    
    /* Recent Purchase Pulse */
    .recent-purchase-pulse {
        position: absolute;
        bottom: 1rem;
        left: 50%;
        transform: translateX(-50%);
        background: rgba(39, 174, 96, 0.9);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        animation: pulse 2s infinite;
        z-index: 10;
        backdrop-filter: blur(4px);
    }
    
    @keyframes pulse {
        0%, 100% {
            opacity: 0.9;
            transform: translateX(-50%) scale(1);
        }
        50% {
            opacity: 1;
            transform: translateX(-50%) scale(1.05);
        }
    }
    
    .thumbnail-area {
        margin-top: 1rem;
    }
    
    .thumbnail-scroll {
        display: flex;
        gap: 0.5rem;
        overflow-x: auto;
        padding: 0.25rem;
    }
    
    .thumbnail-item {
        flex: 0 0 60px;
        height: 60px;
        border: 2px solid var(--border-color);
        border-radius: 6px;
        overflow: hidden;
        cursor: pointer;
        transition: all 0.2s;
        background: #f8f9fa;
    }
    
    .thumbnail-item:hover,
    .thumbnail-item.active {
        border-color: var(--primary-color);
        transform: scale(1.05);
    }
    
    .thumbnail-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        padding: 0.25rem;
    }
    
    /* Image Stats */
    .image-stats {
        display: flex;
        justify-content: space-around;
        padding: 0.75rem;
        background: var(--surface-color);
        border-radius: 6px;
        margin-top: 1rem;
        border: 1px solid var(--border-color);
    }
    
    .image-stats .stat-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.75rem;
        color: var(--text-muted);
    }
    
    .image-stats .stat-item i {
        color: var(--primary-color);
        font-size: 0.875rem;
    }
    
    /* Product Info Card - Now on right */
    .product-info-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 2px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid var(--border-color);
        position: sticky;
        top: 100px;
        margin-left: 0;
        margin-right: 0;
    }
    
    .product-stats-header {
        display: flex;
        gap: 0.75rem;
        margin-bottom: 1rem;
        flex-wrap: wrap;
    }
    
    .stat-badge {
        display: flex;
        align-items: center;
        gap: 0.375rem;
        background: var(--surface-color);
        padding: 0.375rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        color: var(--text-secondary);
        border: 1px solid var(--border-color);
    }
    
    .stat-badge i {
        color: var(--accent-color);
        font-size: 0.875rem;
    }
    
    .product-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    
    .category-tag {
        background: var(--primary-light);
        color: white;
        padding: 0.375rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
    }
    
    .brand-tag {
        background: var(--surface-color);
        color: var(--text-secondary);
        padding: 0.375rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        border: 1px solid var(--border-color);
    }
    
    .product-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.75rem;
        line-height: 1.3;
    }
    
    .product-excerpt {
        color: var(--text-secondary);
        line-height: 1.6;
        margin-bottom: 1rem;
        font-size: 0.9375rem;
    }
    
    /* Rating & Verified */
    .rating-verified {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
        flex-wrap: wrap;
    }
    
    .rating-verified .stars {
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    .rating-verified .stars i {
        color: var(--accent-color);
        font-size: 0.875rem;
    }
    
    .rating-count {
        font-size: 0.875rem;
        color: var(--text-muted);
        margin-left: 0.5rem;
    }
    
    .verified-badge {
        display: flex;
        align-items: center;
        gap: 0.375rem;
        background: rgba(39, 174, 96, 0.1);
        color: var(--success-color);
        padding: 0.375rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    /* Pricing Section */
    .pricing-section {
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--border-color);
    }
    
    .price-display {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 0.5rem;
        flex-wrap: wrap;
    }
    
    .current-price {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--primary-color);
    }
    
    .original-price {
        font-size: 1.125rem;
        color: var(--text-muted);
        text-decoration: line-through;
    }
    
    .savings-badge {
        background: rgba(231, 76, 60, 0.1);
        color: var(--danger-color);
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .savings-info {
        display: flex;
        align-items: center;
        gap: 0.375rem;
        color: var(--danger-color);
        font-size: 0.875rem;
        font-weight: 500;
    }
    
    .discount-time {
        color: var(--text-muted);
        font-size: 0.75rem;
    }
    
    /* Stock & Delivery */
    .stock-delivery-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        padding: 0.75rem;
        background: var(--surface-color);
        border-radius: 8px;
        border: 1px solid var(--border-color);
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    
    .stock-status {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--text-secondary);
        font-size: 0.875rem;
    }
    
    .status-indicator {
        width: 8px;
        height: 8px;
        border-radius: 50%;
    }
    
    .status-indicator.available {
        background: var(--success-color);
        animation: blink 2s infinite;
    }
    
    @keyframes blink {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
    
    .stock-count {
        color: var(--text-muted);
        font-size: 0.75rem;
    }
    
    .delivery-estimate {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--text-secondary);
        font-size: 0.875rem;
    }
    
    .delivery-estimate i {
        color: var(--primary-color);
    }
    
    /* Flash Sale Countdown - UPDATED THEME */
    .flash-sale-countdown {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        color: white;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 1rem;
        box-shadow: 0 4px 15px rgba(17, 80, 40, 0.3);
        position: relative;
        overflow: hidden;
    }
    
    .flash-sale-countdown::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--accent-color), #ff9500, var(--accent-color));
        animation: shimmer 2s infinite linear;
    }
    
    @keyframes shimmer {
        0% { background-position: -200px 0; }
        100% { background-position: 200px 0; }
    }
    
    .countdown-header {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.75rem;
        font-size: 0.875rem;
        font-weight: 600;
        color: white;
    }
    
    .countdown-header i {
        color: var(--accent-color);
    }
    
    .countdown-timer {
        display: flex;
        justify-content: space-around;
        margin-bottom: 0.75rem;
    }
    
    .time-unit {
        display: flex;
        flex-direction: column;
        align-items: center;
        background: rgba(255, 255, 255, 0.15);
        padding: 0.75rem 0.5rem;
        border-radius: 8px;
        min-width: 70px;
        backdrop-filter: blur(4px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .time-value {
        font-size: 1.5rem;
        font-weight: 800;
        line-height: 1;
        color: white;
        font-family: 'Courier New', monospace;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }
    
    .time-label {
        font-size: 0.75rem;
        opacity: 0.9;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-top: 0.25rem;
    }
    
    .sale-progress {
        margin-top: 0.75rem;
    }
    
    .progress-bar {
        height: 8px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 4px;
        overflow: hidden;
        margin-bottom: 0.375rem;
    }
    
    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--accent-color), #ff9500);
        border-radius: 4px;
        transition: width 1s ease;
        position: relative;
    }
    
    .progress-fill::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        animation: progressShimmer 1.5s infinite;
    }
    
    @keyframes progressShimmer {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }
    
    .progress-text {
        font-size: 0.75rem;
        text-align: center;
        opacity: 0.9;
        font-weight: 600;
    }
    
    /* Quantity Section */
    .quantity-section {
        margin-bottom: 1rem;
    }
    
    .quantity-label {
        display: block;
        font-weight: 500;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
    }
    
    .quantity-controls {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.5rem;
    }
    
    .quantity-btn {
        width: 40px;
        height: 40px;
        border: 1px solid var(--border-color);
        background: white;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 1rem;
        color: var(--text-primary);
    }
    
    .quantity-btn:hover {
        border-color: var(--primary-color);
        background: var(--surface-color);
        color: var(--primary-color);
    }
    
    .quantity-input {
        width: 60px;
        height: 40px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        text-align: center;
        font-weight: 500;
        font-size: 1rem;
        background: white;
    }
    
    .quantity-input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 2px rgba(17, 80, 40, 0.1);
    }
    
    .quantity-actions {
        display: flex;
        gap: 0.5rem;
        margin-left: 0.5rem;
    }
    
    .btn-quick-add {
        padding: 0.375rem 0.75rem;
        border: 1px solid var(--border-color);
        background: white;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 500;
        color: var(--text-primary);
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .btn-quick-add:hover {
        border-color: var(--primary-color);
        background: var(--primary-color);
        color: white;
    }
    
    .bulk-discount {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(212, 175, 55, 0.1);
        padding: 0.5rem;
        border-radius: 6px;
        font-size: 0.75rem;
        color: var(--accent-color);
        font-weight: 500;
    }
    
    .bulk-discount i {
        font-size: 0.875rem;
    }
    
    /* Action Buttons */
    .action-buttons {
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 0.75rem;
        margin-bottom: 1rem;
    }
    
    .action-buttons .btn {
        padding: 0.875rem 1.5rem;
        font-weight: 600;
        border-radius: 8px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        border: none;
        color: white;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(17, 80, 40, 0.3);
    }
    
    .btn-primary .btn-badge {
        position: absolute;
        top: -8px;
        right: -8px;
        background: var(--danger-color);
        color: white;
        font-size: 0.625rem;
        padding: 0.125rem 0.375rem;
        border-radius: 10px;
        font-weight: 700;
    }
    
    .btn-warning {
        background: linear-gradient(135deg, var(--accent-color), #ff9500);
        border: none;
        color: white;
    }
    
    .btn-warning:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(212, 175, 55, 0.3);
    }
    
    /* Recent Purchases Notification */
    .recent-purchases-notification {
        background: var(--surface-color);
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1rem;
        border: 1px solid var(--border-color);
    }
    
    .notification-header {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.75rem;
        font-size: 0.875rem;
        color: var(--text-primary);
        font-weight: 500;
    }
    
    .notification-header i {
        color: var(--primary-color);
    }
    
    .purchase-list {
        font-size: 0.8125rem;
        color: var(--text-secondary);
        line-height: 1.4;
    }
    
    .purchase-list .purchase-item {
        padding: 0.25rem 0;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .purchase-list .purchase-item:last-child {
        border-bottom: none;
    }
    
    /* Quick Actions */
    .quick-actions {
        display: flex;
        justify-content: space-around;
        margin-bottom: 1rem;
        padding: 0.75rem 0;
        border-top: 1px solid var(--border-color);
        border-bottom: 1px solid var(--border-color);
    }
    
    .action-link {
        background: none;
        border: none;
        color: var(--text-secondary);
        cursor: pointer;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.25rem;
        font-size: 0.75rem;
        transition: color 0.2s;
        position: relative;
        padding: 0.25rem;
    }
    
    .action-link:hover {
        color: var(--primary-color);
    }
    
    .action-link i {
        font-size: 1.125rem;
    }
    
    .action-count {
        position: absolute;
        top: -5px;
        right: -5px;
        background: var(--danger-color);
        color: white;
        font-size: 0.625rem;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    /* Trust Section */
    .trust-section {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 0.5rem;
        padding-top: 1rem;
        border-top: 1px solid var(--border-color);
    }
    
    .trust-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.25rem;
        color: var(--text-muted);
        font-size: 0.625rem;
        text-align: center;
    }
    
    .trust-item i {
        font-size: 1rem;
        color: var(--primary-color);
    }
    
    /* Product Stats Bar */
    .product-stats-bar {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin: 2rem 0;
        padding: 1.5rem;
        background: var(--surface-color);
        border-radius: 12px;
        border: 1px solid var(--border-color);
    }
    
    .product-stats-bar .stat-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .product-stats-bar .stat-icon {
        width: 48px;
        height: 48px;
        background: var(--gradient-gold);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.25rem;
    }
    
    .product-stats-bar .stat-content {
        flex: 1;
    }
    
    .product-stats-bar .stat-value {
        display: block;
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-primary);
        line-height: 1.2;
    }
    
    .product-stats-bar .stat-label {
        display: block;
        font-size: 0.75rem;
        color: var(--text-muted);
    }
    
    /* Product Details Tabs */
    .product-details-tabs {
        margin-top: 2rem;
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
        border: 1px solid var(--border-color);
        overflow: hidden;
    }
    
    .details-nav {
        background: var(--surface-color);
        border-bottom: 1px solid var(--border-color);
        padding: 0 1.5rem;
    }
    
    .nav-links {
        display: flex;
        gap: 2rem;
        overflow-x: auto;
        padding: 1rem 0;
    }
    
    .nav-link {
        padding: 0.5rem 0;
        color: var(--text-secondary);
        text-decoration: none;
        font-weight: 500;
        font-size: 0.875rem;
        border-bottom: 2px solid transparent;
        white-space: nowrap;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .nav-link:hover,
    .nav-link.active {
        color: var(--primary-color);
        border-bottom-color: var(--primary-color);
    }
    
    .nav-badge {
        background: var(--gradient-gold);
        color: var(--text-primary);
        font-size: 0.625rem;
        padding: 0.125rem 0.375rem;
        border-radius: 10px;
        font-weight: 700;
    }
    
    .details-content {
        padding: 2rem;
    }
    
    .content-section {
        display: none;
        animation: fadeIn 0.3s ease;
    }
    
    .content-section.active {
        display: block;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    /* Description Content */
    .description-content {
        color: var(--text-secondary);
        line-height: 1.8;
        margin-bottom: 2rem;
        font-size: 0.9375rem;
    }
    
    .description-content h1,
    .description-content h2,
    .description-content h3 {
        color: var(--text-primary);
        margin-top: 1.5rem;
        margin-bottom: 1rem;
    }
    
    /* Product Highlights */
    .product-highlights {
        margin: 2rem 0;
        padding: 1.5rem;
        background: var(--surface-color);
        border-radius: 12px;
        border: 1px solid var(--border-color);
    }
    
    .product-highlights h5 {
        margin-bottom: 1rem;
        color: var(--text-primary);
    }
    
    .highlights-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
    }
    
    .highlight-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: white;
        border-radius: 8px;
        border: 1px solid var(--border-color);
    }
    
    .highlight-icon {
        width: 48px;
        height: 48px;
        background: var(--gradient-gold);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.25rem;
        flex-shrink: 0;
    }
    
    .highlight-text {
        flex: 1;
    }
    
    .highlight-text h6 {
        margin: 0 0 0.25rem 0;
        color: var(--text-primary);
        font-size: 0.875rem;
    }
    
    .highlight-text p {
        margin: 0;
        color: var(--text-secondary);
        font-size: 0.75rem;
        line-height: 1.4;
    }
    
    .highlight-stats {
        text-align: center;
        min-width: 50px;
    }
    
    .highlight-stats .stat-value {
        display: block;
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--primary-color);
    }
    
    .highlight-stats .stat-label {
        display: block;
        font-size: 0.625rem;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    /* Usage Tips */
    .usage-tips {
        margin: 2rem 0;
        padding: 1.5rem;
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        border-radius: 12px;
    }
    
    .usage-tips h5 {
        margin-bottom: 1rem;
        color: var(--text-primary);
    }
    
    .tips-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }
    
    .tip-item {
        display: flex;
        gap: 1rem;
        align-items: flex-start;
    }
    
    .tip-number {
        width: 32px;
        height: 32px;
        background: var(--primary-color);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.875rem;
        flex-shrink: 0;
    }
    
    .tip-content h6 {
        margin: 0 0 0.25rem 0;
        color: var(--text-primary);
        font-size: 0.875rem;
    }
    
    .tip-content p {
        margin: 0;
        color: var(--text-secondary);
        font-size: 0.75rem;
        line-height: 1.4;
    }
    
    /* Specifications */
    .specs-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
    }
    
    .specs-column h5 {
        margin-bottom: 1rem;
        color: var(--text-primary);
        font-size: 1rem;
    }
    
    .specs-list {
        display: grid;
        gap: 0.75rem;
    }
    
    .specs-list dt {
        font-weight: 500;
        color: var(--text-secondary);
        font-size: 0.875rem;
    }
    
    .specs-list dd {
        color: var(--text-primary);
        margin-left: 1rem;
        font-size: 0.875rem;
    }
    
    /* Certifications */
    .certifications {
        margin-top: 2rem;
        padding: 1.5rem;
        background: var(--surface-color);
        border-radius: 12px;
        border: 1px solid var(--border-color);
    }
    
    .certifications h5 {
        margin-bottom: 1rem;
        color: var(--text-primary);
    }
    
    .cert-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }
    
    .cert-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem;
        background: white;
        border-radius: 8px;
        border: 1px solid var(--border-color);
        font-size: 0.875rem;
        color: var(--text-primary);
    }
    
    .cert-item i {
        color: var(--accent-color);
        font-size: 1rem;
    }
    
    /* Reviews Section */
    .reviews-summary {
        display: grid;
        grid-template-columns: auto 1fr;
        gap: 2rem;
        margin-bottom: 2rem;
        padding: 1.5rem;
        background: var(--surface-color);
        border-radius: 12px;
        border: 1px solid var(--border-color);
    }
    
    .overall-rating {
        text-align: center;
        min-width: 120px;
    }
    
    .rating-number {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--text-primary);
        line-height: 1;
        margin-bottom: 0.5rem;
    }
    
    .rating-stars {
        margin-bottom: 0.5rem;
    }
    
    .rating-count {
        color: var(--text-muted);
        font-size: 0.875rem;
        margin-bottom: 0.5rem;
    }
    
    .recommendation {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--success-color);
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    .rating-distribution {
        flex: 1;
    }
    
    .distribution-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
    }
    
    .star-label {
        min-width: 60px;
        color: var(--text-secondary);
    }
    
    .progress-bar {
        flex: 1;
        height: 8px;
        background: var(--border-color);
        border-radius: 4px;
        overflow: hidden;
    }
    
    .progress-fill {
        height: 100%;
        background: var(--gradient-gold);
        border-radius: 4px;
    }
    
    .percentage {
        min-width: 40px;
        text-align: right;
        color: var(--text-muted);
    }
    
    .count {
        color: var(--text-muted);
        font-size: 0.75rem;
    }
    
    /* Review Highlights */
    .review-highlights {
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid var(--border-color);
    }
    
    .review-highlights h6 {
        margin-bottom: 0.5rem;
        color: var(--text-primary);
        font-size: 0.875rem;
    }
    
    .highlight-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    
    .highlight-tag {
        background: rgba(212, 175, 55, 0.1);
        color: var(--accent-color);
        padding: 0.375rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    /* Review Cards */
    .reviews-list {
        display: grid;
        gap: 1rem;
    }
    
    .review-card {
        padding: 1.5rem;
        background: white;
        border-radius: 8px;
        border: 1px solid var(--border-color);
    }
    
    .review-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
    }
    
    .reviewer-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .reviewer-avatar {
        width: 40px;
        height: 40px;
        background: var(--gradient-gold);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        flex-shrink: 0;
    }
    
    .reviewer-name {
        margin: 0 0 0.25rem 0;
        color: var(--text-primary);
        font-size: 0.875rem;
    }
    
    .reviewer-verified {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        color: var(--success-color);
        font-size: 0.75rem;
    }
    
    .review-date {
        color: var(--text-muted);
        font-size: 0.75rem;
    }
    
    .review-rating {
        display: flex;
        gap: 0.125rem;
    }
    
    .review-title {
        margin: 0 0 0.5rem 0;
        color: var(--text-primary);
        font-size: 0.9375rem;
    }
    
    .review-content {
        color: var(--text-secondary);
        line-height: 1.6;
        margin-bottom: 1rem;
        font-size: 0.875rem;
    }
    
    /* Review Helpful */
    .review-helpful {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding-top: 1rem;
        border-top: 1px solid var(--border-color);
        font-size: 0.75rem;
    }
    
    .helpful-text {
        color: var(--text-muted);
    }
    
    .btn-helpful {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        background: var(--surface-color);
        border: 1px solid var(--border-color);
        padding: 0.25rem 0.75rem;
        border-radius: 4px;
        color: var(--text-secondary);
        cursor: pointer;
        transition: all 0.2s;
        font-size: 0.75rem;
    }
    
    .btn-helpful:hover {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }
    
    .btn-helpful .count {
        margin-left: 0.25rem;
        font-weight: 500;
    }
    
    .btn-report {
        background: none;
        border: none;
        color: var(--text-muted);
        cursor: pointer;
        font-size: 0.75rem;
        margin-left: auto;
    }
    
    .btn-report:hover {
        color: var(--danger-color);
    }
    
    /* Add Review Form */
    .add-review-form {
        margin-top: 2rem;
        padding: 1.5rem;
        background: var(--surface-color);
        border-radius: 12px;
        border: 1px solid var(--border-color);
    }
    
    .add-review-form h5 {
        margin-bottom: 1.5rem;
        color: var(--text-primary);
    }
    
    .star-rating {
        display: flex;
        gap: 0.5rem;
        margin-top: 0.5rem;
    }
    
    .rating-star {
        font-size: 1.5rem;
        color: var(--border-color);
        cursor: pointer;
        transition: color 0.2s;
    }
    
    .rating-star:hover,
    .rating-star.active {
        color: var(--accent-color);
    }
    
    /* No Reviews */
    .no-reviews {
        text-align: center;
        padding: 3rem;
        color: var(--text-muted);
    }
    
    /* Review Login Prompt */
    .review-login-prompt {
        background: var(--surface-color);
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        border: 1px solid var(--border-color);
        margin-top: 2rem;
    }
    
    .prompt-content {
        display: flex;
        align-items: center;
        gap: 1rem;
        justify-content: center;
    }
    
    .prompt-content i {
        color: var(--primary-color);
    }
    
    .prompt-content h6 {
        margin: 0 0 0.25rem 0;
        color: var(--text-primary);
    }
    
    .prompt-content p {
        margin: 0;
        color: var(--text-secondary);
        font-size: 0.875rem;
    }
    
    /* Shipping Info */
    .shipping-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
    }
    
    .info-card {
        padding: 1.5rem;
        background: var(--surface-color);
        border-radius: 12px;
        border: 1px solid var(--border-color);
    }
    
    .info-icon {
        width: 60px;
        height: 60px;
        background: var(--gradient-gold);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .info-content h5 {
        margin-bottom: 1rem;
        color: var(--text-primary);
    }
    
    /* Shipping Options */
    .shipping-options {
        display: grid;
        gap: 1rem;
    }
    
    .option-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        background: white;
        border-radius: 8px;
        border: 1px solid var(--border-color);
    }
    
    .option-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .option-header i {
        color: var(--primary-color);
        font-size: 1.25rem;
    }
    
    .option-header span {
        font-weight: 500;
        color: var(--text-primary);
        font-size: 0.875rem;
    }
    
    .option-details {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 0.25rem;
    }
    
    .option-details .price {
        font-weight: 600;
        color: var(--primary-color);
        font-size: 0.875rem;
    }
    
    .option-details .time {
        color: var(--text-muted);
        font-size: 0.75rem;
    }
    
    /* Policy Details */
    .policy-details {
        display: grid;
        gap: 1rem;
    }
    
    .policy-item {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    
    .policy-item i {
        font-size: 1.25rem;
        flex-shrink: 0;
    }
    
    .policy-item h6 {
        margin: 0 0 0.25rem 0;
        color: var(--text-primary);
        font-size: 0.875rem;
    }
    
    .policy-item p {
        margin: 0;
        color: var(--text-secondary);
        font-size: 0.75rem;
    }
    
    /* Delivery Map */
    .delivery-map {
        margin-top: 2rem;
        padding: 1.5rem;
        background: var(--surface-color);
        border-radius: 12px;
        border: 1px solid var(--border-color);
        text-align: center;
    }
    
    .delivery-map h5 {
        margin-bottom: 1rem;
        color: var(--text-primary);
    }
    
    .map-placeholder {
        padding: 2rem;
        background: white;
        border-radius: 8px;
        border: 1px solid var(--border-color);
    }
    
    .map-placeholder i {
        color: var(--primary-color);
        margin-bottom: 1rem;
    }
    
    .map-placeholder p {
        color: var(--text-secondary);
        font-size: 0.875rem;
        margin-bottom: 1rem;
    }
    
    .coverage-stats {
        display: flex;
        justify-content: center;
        gap: 2rem;
        margin-top: 1.5rem;
    }
    
    .coverage-stats .stat {
        text-align: center;
    }
    
    .coverage-stats .value {
        display: block;
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary-color);
        line-height: 1;
        margin-bottom: 0.25rem;
    }
    
    .coverage-stats .label {
        display: block;
        font-size: 0.75rem;
        color: var(--text-muted);
    }
    
    /* FAQ Section */
    .faq-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
    }
    
    .faq-column h5 {
        margin-bottom: 1rem;
        color: var(--text-primary);
    }
    
    .faq-item {
        margin-bottom: 1rem;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        overflow: hidden;
    }
    
    .faq-question {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        background: var(--surface-color);
        cursor: pointer;
        font-weight: 500;
        color: var(--text-primary);
        font-size: 0.875rem;
    }
    
    .faq-question i {
        transition: transform 0.3s ease;
    }
    
    .faq-question.active i {
        transform: rotate(180deg);
    }
    
    .faq-answer {
        padding: 1rem;
        background: white;
        display: none;
        font-size: 0.875rem;
        color: var(--text-secondary);
        line-height: 1.6;
    }
    
    .faq-item.active .faq-answer {
        display: block;
    }
    
    /* Related Products */
    .related-products-section {
        margin-top: 3rem;
        padding-top: 3rem;
        border-top: 1px solid var(--border-color);
    }
    
    .section-header {
        margin-bottom: 2rem;
    }
    
    .section-header h3 {
        margin: 0 0 0.5rem 0;
        color: var(--text-primary);
    }
    
    .section-subtitle {
        color: var(--text-muted);
        font-size: 0.875rem;
        margin: 0;
    }
    
    .view-all {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 500;
        font-size: 0.875rem;
        transition: color 0.2s;
    }
    
    .view-all:hover {
        color: var(--primary-dark);
    }
    
    .related-products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1.5rem;
    }
    
    .related-product-card {
        border: 1px solid var(--border-color);
        border-radius: 12px;
        overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s;
        position: relative;
    }
    
    .related-product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    .product-badge {
        position: absolute;
        top: 0.5rem;
        left: 0.5rem;
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
        z-index: 10;
    }
    
    .badge-best {
        background: var(--gradient-gold);
        color: var(--text-primary);
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        font-size: 0.625rem;
        font-weight: 600;
    }
    
    .related-product-card .product-image {
        display: block;
        height: 160px;
        overflow: hidden;
        background: #f8f9fa;
    }
    
    .related-product-card .product-image img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        padding: 1rem;
        transition: transform 0.3s;
    }
    
    .related-product-card:hover .product-image img {
        transform: scale(1.05);
    }
    
    .related-product-card .product-info {
        padding: 1rem;
    }
    
    .related-product-card .product-name {
        display: block;
        color: var(--text-primary);
        text-decoration: none;
        font-weight: 500;
        font-size: 0.875rem;
        margin-bottom: 0.5rem;
        transition: color 0.2s;
        line-height: 1.4;
    }
    
    .related-product-card .product-name:hover {
        color: var(--primary-color);
    }
    
    .related-product-card .product-rating {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.5rem;
    }
    
    .related-product-card .product-rating .stars {
        display: flex;
        gap: 0.125rem;
    }
    
    .related-product-card .product-rating .stars i {
        color: var(--accent-color);
        font-size: 0.75rem;
    }
    
    .related-product-card .rating-count {
        color: var(--text-muted);
        font-size: 0.75rem;
    }
    
    .related-product-card .product-price {
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 0.5rem;
        font-size: 0.9375rem;
    }
    
    .related-product-card .original-price {
        font-size: 0.75rem;
        color: var(--text-muted);
        text-decoration: line-through;
        margin-left: 0.5rem;
    }
    
    .related-product-card .product-stats {
        margin-bottom: 0.5rem;
    }
    
    .related-product-card .product-stats .stat {
        color: var(--text-muted);
        font-size: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    .related-product-card .product-stats .stat i {
        font-size: 0.75rem;
    }
    
    .related-product-card .btn {
        width: 100%;
        padding: 0.5rem;
        font-size: 0.75rem;
    }
    
    /* Recently Viewed */
    .recently-viewed-section {
        margin-top: 3rem;
        padding-top: 2rem;
        border-top: 1px solid var(--border-color);
    }
    
    /* Share Modal */
    .share-options {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 1rem;
        padding: 1rem 0;
    }
    
    .share-option {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        padding: 1rem;
        border: 1px solid var(--border-color);
        background: white;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .share-option:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    .share-option i {
        font-size: 1.5rem;
    }
    
    .share-option span {
        font-size: 0.75rem;
        color: var(--text-secondary);
    }
    
    /* Responsive Design */
    @media (max-width: 1200px) {
        .product-gallery-wrapper,
        .product-info-card {
            position: static;
        }
        
        .product-stats-bar {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    
    @media (max-width: 992px) {
        .row {
            flex-direction: column;
        }
        
        .col-lg-6 {
            width: 100%;
        }
        
        .action-buttons {
            grid-template-columns: 1fr;
        }
        
        .trust-section {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .reviews-summary {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }
        
        .overall-rating {
            text-align: left;
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }
    }
    
    @media (max-width: 768px) {
        .social-proof-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }
        
        .proof-item {
            width: 100%;
            justify-content: flex-start;
        }
        
        .product-stats-header {
            justify-content: center;
        }
        
        .product-meta {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .rating-verified {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }
        
        .price-display {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }
        
        .stock-delivery-info {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .countdown-timer {
            justify-content: space-between;
        }
        
        .time-unit {
            min-width: 60px;
        }
        
        .quantity-controls {
            flex-wrap: wrap;
        }
        
        .quantity-actions {
            width: 100%;
            justify-content: center;
        }
        
        .quick-actions {
            flex-wrap: wrap;
        }
        
        .trust-section {
            grid-template-columns: 1fr;
        }
        
        .product-stats-bar {
            grid-template-columns: 1fr;
        }
        
        .nav-links {
            gap: 1rem;
        }
        
        .nav-link {
            font-size: 0.75rem;
        }
        
        .details-content {
            padding: 1rem;
        }
        
        .highlights-grid,
        .tips-grid {
            grid-template-columns: 1fr;
        }
        
        .specs-grid,
        .faq-grid {
            grid-template-columns: 1fr;
        }
        
        .shipping-info-grid {
            grid-template-columns: 1fr;
        }
        
        .share-options {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    
    @media (max-width: 576px) {
        .product-title {
            font-size: 1.25rem;
        }
        
        .current-price {
            font-size: 1.5rem;
        }
        
        .flash-sale-countdown {
            padding: 0.75rem;
        }
        
        .countdown-timer {
            gap: 0.5rem;
        }
        
        .time-unit {
            min-width: 50px;
            padding: 0.5rem;
        }
        
        .time-value {
            font-size: 1.25rem;
        }
        
        .main-image-container {
            min-height: 250px;
        }
        
        .main-product-image {
            max-height: 250px;
        }
        
        .thumbnail-item {
            flex: 0 0 50px;
            height: 50px;
        }
        
        .related-products-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ========== FAKE SOCIAL PROOF DYNAMICS ==========
        
        // Initialize with random numbers
        let currentViewers = Math.floor(Math.random() * 100) + 50;
        let recentPurchases = Math.floor(Math.random() * 50) + 30;
        let productViewers = Math.floor(Math.random() * 30) + 10;
        let totalPurchases = parseInt(document.getElementById('total-purchases')?.textContent) || 1500;
        let wishlistCount = parseInt(document.getElementById('wishlist-count')?.textContent) || 150;
        let monthlyBuyers = Math.floor(Math.random() * 4000) + 1000;
        let trendingRank = Math.floor(Math.random() * 10) + 1;

        // Update stats display
        const updateStats = () => {
            const viewersElement = document.getElementById('current-viewers');
            const purchasesElement = document.getElementById('recent-purchases');
            const productViewersElement = document.getElementById('product-viewers');
            const totalPurchasesElement = document.getElementById('total-purchases');
            const wishlistCountElement = document.getElementById('wishlist-count');
            const monthlyBuyersElement = document.getElementById('monthly-buyers');
            const trendingRankElement = document.getElementById('trending-rank');

            if (viewersElement) viewersElement.textContent = currentViewers;
            if (purchasesElement) purchasesElement.textContent = recentPurchases;
            if (productViewersElement) productViewersElement.textContent = productViewers;
            if (totalPurchasesElement) totalPurchasesElement.textContent = totalPurchases + '+ sold';
            if (wishlistCountElement) wishlistCountElement.textContent = wishlistCount + ' saved';
            if (monthlyBuyersElement) monthlyBuyersElement.textContent = monthlyBuyers + '+';
            if (trendingRankElement) trendingRankElement.textContent = '#' + trendingRank;
        };

        // Simulate recent purchases notification
        const simulateRecentPurchase = () => {
            const purchaseList = document.getElementById('purchase-list');
            if (!purchaseList) return;

            const customers = [
                'Sarah M.', 'John D.', 'Emma W.', 'Michael B.', 'Lisa K.',
                'David R.', 'Sophia L.', 'Robert T.', 'Maria G.', 'James P.'
            ];
            const cities = ['New York', 'Los Angeles', 'Chicago', 'Houston', 'Phoenix',
                          'Philadelphia', 'San Antonio', 'San Diego', 'Dallas', 'San Jose'];
            const times = ['just now', '1 min ago', '2 mins ago', '3 mins ago', '5 mins ago',
                         '10 mins ago', '15 mins ago', '20 mins ago', '25 mins ago', '30 mins ago'];

            if (Math.random() > 0.7) {
                const customer = customers[Math.floor(Math.random() * customers.length)];
                const city = cities[Math.floor(Math.random() * cities.length)];
                const time = times[Math.floor(Math.random() * times.length)];
                
                const purchaseItem = document.createElement('div');
                purchaseItem.className = 'purchase-item';
                purchaseItem.innerHTML = `🏆 <strong>${customer}</strong> from ${city} purchased this ${time}`;
                
                purchaseList.insertBefore(purchaseItem, purchaseList.firstChild);
                
                // Limit to 5 items
                if (purchaseList.children.length > 5) {
                    purchaseList.removeChild(purchaseList.lastChild);
                }

                // Update counters
                recentPurchases++;
                totalPurchases++;
                updateStats();
            }
        };

        // Enhanced Countdown Timer with random start times
        const initializeCountdown = () => {
            const hoursElement = document.getElementById('hours');
            const minutesElement = document.getElementById('minutes');
            const secondsElement = document.getElementById('seconds');

            if (!hoursElement || !minutesElement || !secondsElement) return;

            // Generate random time between 10 minutes and 2 hours
            const randomMinutes = Math.floor(Math.random() * 110) + 10; // 10-120 minutes
            const randomSeconds = Math.floor(Math.random() * 60);
            
            let totalSeconds = (randomMinutes * 60) + randomSeconds;
            
            const updateCountdown = () => {
                totalSeconds--;
                if (totalSeconds < 0) {
                    // Reset to random time when countdown finishes
                    const newMinutes = Math.floor(Math.random() * 110) + 10;
                    const newSeconds = Math.floor(Math.random() * 60);
                    totalSeconds = (newMinutes * 60) + newSeconds;
                    
                    // Update progress bar to show reset
                    const progressBar = document.querySelector('.progress-fill');
                    if (progressBar) {
                        progressBar.style.width = '10%';
                        const progressText = document.querySelector('.progress-text');
                        if (progressText) {
                            progressText.textContent = '10% claimed';
                        }
                    }
                }

                const hours = Math.floor(totalSeconds / 3600);
                const minutes = Math.floor((totalSeconds % 3600) / 60);
                const seconds = totalSeconds % 60;

                hoursElement.textContent = hours.toString().padStart(2, '0');
                minutesElement.textContent = minutes.toString().padStart(2, '0');
                secondsElement.textContent = seconds.toString().padStart(2, '0');

                // Animate time units when they change
                if (seconds === 59) {
                    const timeUnits = document.querySelectorAll('.time-unit');
                    timeUnits.forEach(unit => {
                        unit.style.animation = 'none';
                        setTimeout(() => {
                            unit.style.animation = 'pulse 0.5s ease';
                        }, 10);
                    });
                }

                // Update progress bar gradually
                if (totalSeconds % 10 === 0) {
                    const progressBar = document.querySelector('.progress-fill');
                    if (progressBar) {
                        const currentWidth = parseInt(progressBar.style.width) || 60;
                        const newWidth = Math.min(95, currentWidth + Math.floor(Math.random() * 3));
                        progressBar.style.width = newWidth + '%';
                        const progressText = document.querySelector('.progress-text');
                        if (progressText) {
                            progressText.textContent = newWidth + '% claimed';
                        }
                    }
                }
            };

            // Set initial values
            const initialHours = Math.floor(totalSeconds / 3600);
            const initialMinutes = Math.floor((totalSeconds % 3600) / 60);
            const initialSeconds = totalSeconds % 60;

            hoursElement.textContent = initialHours.toString().padStart(2, '0');
            minutesElement.textContent = initialMinutes.toString().padStart(2, '0');
            secondsElement.textContent = initialSeconds.toString().padStart(2, '0');

            // Update countdown every second
            setInterval(updateCountdown, 1000);
        };

        // Animate recent purchase pulse
        const animatePurchasePulse = () => {
            const pulseElement = document.getElementById('recent-purchase-pulse');
            if (!pulseElement) return;

            // Show pulse randomly
            if (Math.random() > 0.7) {
                pulseElement.style.display = 'flex';
                setTimeout(() => {
                    pulseElement.style.display = 'none';
                }, 3000);
            }
        };

        // Initialize all stats and start updates
        updateStats();
        initializeCountdown();

        // Set up intervals for dynamic updates
        setInterval(() => {
            // Randomly update viewer counts
            if (Math.random() > 0.5) {
                const change = Math.random() > 0.6 ? 1 : (Math.random() > 0.3 ? -1 : 0);
                currentViewers = Math.max(50, currentViewers + change);
                productViewers = Math.max(5, productViewers + (Math.random() > 0.7 ? 1 : -1));
            }

            // Randomly update trending rank
            if (Math.random() > 0.8) {
                trendingRank = Math.max(1, Math.min(10, trendingRank + (Math.random() > 0.5 ? 1 : -1)));
            }

            updateStats();
            simulateRecentPurchase();
            animatePurchasePulse();

            // Occasionally update wishlist count
            if (Math.random() > 0.9) {
                wishlistCount += Math.random() > 0.6 ? 1 : -1;
                wishlistCount = Math.max(50, wishlistCount);
                updateStats();
            }

        }, 3000); // Update every 3 seconds

        // ========== PRODUCT INTERACTIONS ==========

        // Image Gallery
        const mainImage = document.getElementById('mainProductImage');
        const thumbnails = document.querySelectorAll('.thumbnail-item');
        
        thumbnails.forEach(thumbnail => {
            thumbnail.addEventListener('click', function() {
                const imageUrl = this.dataset.image;
                if (imageUrl) {
                    mainImage.src = imageUrl;
                    const zoomedImage = document.getElementById('zoomedImage');
                    if (zoomedImage) zoomedImage.src = imageUrl;
                    
                    // Update active state
                    thumbnails.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                }
            });
        });

        // Image zoom on hover
        mainImage.addEventListener('mousemove', function(e) {
            if (!this.parentElement) return;
            
            const container = this.parentElement;
            const containerRect = container.getBoundingClientRect();
            const imageRect = this.getBoundingClientRect();
            
            const x = ((e.clientX - containerRect.left) / containerRect.width) * 100;
            const y = ((e.clientY - containerRect.top) / containerRect.height) * 100;
            
            this.style.transformOrigin = `${x}% ${y}%`;
        });

        // Quantity Controls
        const quantityInput = document.getElementById('quantity');
        const decreaseBtn = document.getElementById('decreaseQty');
        const increaseBtn = document.getElementById('increaseQty');
        const quickAddButtons = document.querySelectorAll('.btn-quick-add');
        
        if (decreaseBtn) {
            decreaseBtn.addEventListener('click', () => {
                let value = parseInt(quantityInput.value);
                if (value > 1) {
                    quantityInput.value = value - 1;
                }
            });
        }
        
        if (increaseBtn) {
            increaseBtn.addEventListener('click', () => {
                let value = parseInt(quantityInput.value);
                if (value < 99) {
                    quantityInput.value = value + 1;
                }
            });
        }
        
        quickAddButtons.forEach(button => {
            button.addEventListener('click', function() {
                const qty = parseInt(this.dataset.qty);
                let currentValue = parseInt(quantityInput.value);
                quantityInput.value = currentValue + qty;
            });
        });

        // Tab Navigation
        const navLinks = document.querySelectorAll('.nav-link');
        const contentSections = document.querySelectorAll('.content-section');
        
        navLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                const targetId = this.getAttribute('href').substring(1);
                const targetSection = document.getElementById(targetId);
                
                if (targetSection) {
                    navLinks.forEach(l => l.classList.remove('active'));
                    this.classList.add('active');
                    
                    contentSections.forEach(section => {
                        section.classList.remove('active');
                    });
                    targetSection.classList.add('active');
                }
            });
        });

        // FAQ Accordion
        const faqQuestions = document.querySelectorAll('.faq-question');
        faqQuestions.forEach(question => {
            question.addEventListener('click', function() {
                const faqItem = this.parentElement;
                const isActive = faqItem.classList.contains('active');
                
                // Close all FAQ items
                document.querySelectorAll('.faq-item').forEach(item => {
                    item.classList.remove('active');
                });
                
                // Open clicked item if it wasn't active
                if (!isActive) {
                    faqItem.classList.add('active');
                }
            });
        });

        // Star Rating for Review Form
        const ratingStars = document.querySelectorAll('.rating-star');
        const userRatingInput = document.getElementById('userRating');
        
        if (ratingStars.length > 0 && userRatingInput) {
            ratingStars.forEach(star => {
                star.addEventListener('click', function() {
                    const rating = parseInt(this.dataset.rating);
                    userRatingInput.value = rating;
                    
                    ratingStars.forEach((s, index) => {
                        if (index < rating) {
                            s.classList.remove('far');
                            s.classList.add('fas', 'active');
                        } else {
                            s.classList.remove('fas', 'active');
                            s.classList.add('far');
                        }
                    });
                });
                
                star.addEventListener('mouseover', function() {
                    const rating = parseInt(this.dataset.rating);
                    ratingStars.forEach((s, index) => {
                        if (index < rating) {
                            s.classList.add('hover');
                        }
                    });
                });
                
                star.addEventListener('mouseout', function() {
                    ratingStars.forEach(s => s.classList.remove('hover'));
                });
            });
        }

        // Add to Cart Functionality
        const addToCartBtn = document.querySelector('.add-to-cart-btn');
        const buyNowBtn = document.querySelector('.buy-now-btn');
        
        async function addToCart(productId, quantity, redirect = false) {
            try {
                // Show loading state
                if (addToCartBtn) {
                    const originalText = addToCartBtn.innerHTML;
                    addToCartBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Adding...';
                    addToCartBtn.disabled = true;
                }

                const response = await fetch('{{ route("cart.add") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: quantity
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Update cart count in header
                    updateCartCount(data.cart_count);
                    
                    // Update purchase counters
                    recentPurchases++;
                    totalPurchases++;
                    updateStats();
                    
                    if (redirect) {
                        window.location.href = '{{ route("checkout") }}';
                    } else {
                        showSuccess('Product added to cart! 🛒');
                        
                        // Show purchase notification
                        simulateRecentPurchase();
                    }
                } else {
                    showError(data.message || 'Failed to add to cart');
                }
            } catch (error) {
                console.error('Error:', error);
                showError('Network error. Please try again.');
            } finally {
                // Reset button state
                if (addToCartBtn) {
                    setTimeout(() => {
                        addToCartBtn.innerHTML = '<i class="fas fa-shopping-cart me-2"></i>Add to Cart <span class="btn-badge">+' + recentPurchases + ' today</span>';
                        addToCartBtn.disabled = false;
                    }, 500);
                }
            }
        }
        
        if (addToCartBtn) {
            addToCartBtn.addEventListener('click', function() {
                const productId = this.dataset.id;
                const quantity = parseInt(quantityInput.value);
                addToCart(productId, quantity);
            });
        }
        
        if (buyNowBtn) {
            buyNowBtn.addEventListener('click', function() {
                const productId = this.dataset.id;
                const quantity = parseInt(quantityInput.value);
                addToCart(productId, quantity, true);
            });
        }

        // Quick Add to Cart for related products
        document.querySelectorAll('.add-to-cart-quick').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.dataset.id;
                
                // Show loading state
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                this.disabled = true;
                
                setTimeout(() => {
                    addToCart(productId, 1);
                    
                    // Show success state
                    this.innerHTML = '<i class="fas fa-check me-1"></i> Added';
                    this.classList.remove('btn-primary');
                    this.classList.add('btn-success');
                    
                    setTimeout(() => {
                        this.innerHTML = originalText;
                        this.classList.remove('btn-success');
                        this.classList.add('btn-primary');
                        this.disabled = false;
                    }, 2000);
                }, 500);
            });
        });

        // Wishlist Toggle
        const wishlistBtn = document.querySelector('.wishlist-toggle');
        if (wishlistBtn) {
            wishlistBtn.addEventListener('click', async function() {
                const productId = this.dataset.id;
                const icon = this.querySelector('i');
                const countElement = document.getElementById('wishlist-action-count');
                
                try {
                    const response = await fetch('{{ route("wishlist.toggle") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            product_id: productId
                        })
                    });
                    
                    const data = await response.json();
                    
                    if (data.success) {
                        if (data.in_wishlist) {
                            icon.className = 'fas fa-heart me-1 text-danger';
                            wishlistCount++;
                            if (countElement) {
                                countElement.textContent = parseInt(countElement.textContent) + 1;
                            }
                            showSuccess('Added to wishlist! ❤️');
                        } else {
                            icon.className = 'far fa-heart me-1';
                            wishlistCount = Math.max(0, wishlistCount - 1);
                            if (countElement) {
                                countElement.textContent = Math.max(0, parseInt(countElement.textContent) - 1);
                            }
                            showInfo('Removed from wishlist');
                        }
                        updateStats();
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showError('Failed to update wishlist');
                }
            });
        }

        // Share Product
        const shareBtn = document.querySelector('.share-product');
        if (shareBtn) {
            shareBtn.addEventListener('click', function() {
                const shareModal = new bootstrap.Modal(document.getElementById('shareModal'));
                shareModal.show();
            });
        }

        // Share options
        document.querySelectorAll('.share-option').forEach(button => {
            button.addEventListener('click', function() {
                const platform = this.querySelector('span').textContent.toLowerCase();
                const url = encodeURIComponent(window.location.href);
                const title = encodeURIComponent(document.title);
                
                let shareUrl = '';
                switch(platform) {
                    case 'facebook':
                        shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
                        break;
                    case 'twitter':
                        shareUrl = `https://twitter.com/intent/tweet?url=${url}&text=${title}`;
                        break;
                    case 'pinterest':
                        shareUrl = `https://pinterest.com/pin/create/button/?url=${url}&description=${title}`;
                        break;
                    case 'whatsapp':
                        shareUrl = `https://wa.me/?text=${title}%20${url}`;
                        break;
                    case 'copy link':
                        navigator.clipboard.writeText(window.location.href).then(() => {
                            showSuccess('Link copied to clipboard! 📋');
                        });
                        return;
                }
                
                if (shareUrl) {
                    window.open(shareUrl, '_blank', 'width=600,height=400');
                }
            });
        });

        // Image Zoom Modal
        const zoomModal = document.getElementById('imageZoomModal');
        const zoomedImage = document.getElementById('zoomedImage');
        
        if (zoomModal && zoomedImage) {
            zoomModal.addEventListener('show.bs.modal', function() {
                zoomedImage.src = mainImage.src;
            });
        }

        // Review Form Submission
        const reviewForm = document.getElementById('reviewForm');
        if (reviewForm) {
            reviewForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                const rating = userRatingInput.value;
                
                if (rating < 1) {
                    showError('Please select a rating');
                    return;
                }
                
                // Simulate form submission
                showSuccess('Thank you for your review! 🌟');
                this.reset();
                
                // Reset stars
                ratingStars.forEach(star => {
                    star.classList.remove('fas', 'active');
                    star.classList.add('far');
                });
                userRatingInput.value = 0;
            });
        }

        // Review Helpful Buttons
        document.querySelectorAll('.btn-helpful').forEach(button => {
            button.addEventListener('click', function() {
                const countElement = this.querySelector('.count');
                let count = parseInt(countElement.textContent);
                count++;
                countElement.textContent = count;
                
                this.style.backgroundColor = 'var(--primary-color)';
                this.style.color = 'white';
                this.style.borderColor = 'var(--primary-color)';
                
                showSuccess('Thanks for your feedback! 👍');
            });
        });

        // Utility Functions
        function updateCartCount(count) {
            const cartBadges = document.querySelectorAll('.cart-btn .badge');
            cartBadges.forEach(badge => {
                badge.textContent = count;
                badge.style.display = count > 0 ? 'flex' : 'none';
            });
        }
        
        function showSuccess(message) {
            if (typeof showToast === 'function') {
                showToast(message, 'success');
            } else {
                alert(message);
            }
        }
        
        function showError(message) {
            if (typeof showToast === 'function') {
                showToast(message, 'error');
            } else {
                alert(message);
            }
        }
        
        function showInfo(message) {
            if (typeof showToast === 'function') {
                showToast(message, 'info');
            } else {
                alert(message);
            }
        }

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                if (href !== '#') {
                    const targetElement = document.querySelector(href);
                    if (targetElement) {
                        e.preventDefault();
                        targetElement.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                }
            });
        });

        // Initialize with some recent purchases
        for (let i = 0; i < 3; i++) {
            setTimeout(() => simulateRecentPurchase(), i * 1000);
        }

        // Simulate initial purchase pulse
        setTimeout(() => animatePurchasePulse(), 2000);
    });
</script>
@endpush