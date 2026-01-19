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
        <!-- Product Main Section -->
        <div class="product-main">
            <div class="row g-4">
                <!-- Product Gallery -->
                <div class="col-lg-7">
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
                                </div>
                                
                                <!-- Zoom Button -->
                                <button class="image-zoom-btn" data-bs-toggle="modal" data-bs-target="#imageZoomModal">
                                    <i class="fas fa-expand"></i>
                                </button>
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
                    </div>
                </div>

                <!-- Product Info -->
                <div class="col-lg-5">
                    <div class="product-info-card">
                        <!-- Category & Rating -->
                        <div class="product-meta">
                            <div class="category-tag">
                                <i class="fas fa-tag me-1"></i>
                                {{ $product->category->name ?? 'Uncategorized' }}
                            </div>
                            <div class="rating-display">
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
                                </div>
                                <span class="rating-count">({{ $product->total_reviews }} reviews)</span>
                            </div>
                        </div>

                        <!-- Product Title -->
                        <h1 class="product-title">{{ $product->name }}</h1>

                        <!-- Short Description -->
                        <p class="product-excerpt">{{ $product->short_description }}</p>

                        <!-- Pricing -->
                        <div class="pricing-section">
                            <div class="price-display">
                                <span class="current-price">${{ number_format($product->best_price, 2) }}</span>
                                @if($product->compare_at_price)
                                <span class="original-price">${{ number_format($product->compare_at_price, 2) }}</span>
                                @endif
                            </div>
                            @if($product->compare_at_price)
                            <div class="savings-info">
                                <i class="fas fa-percentage text-danger me-1"></i>
                                Save {{ $product->discount_percentage }}%
                            </div>
                            @endif
                        </div>

                        <!-- Stock Status -->
                        <div class="stock-status">
                            <div class="status-indicator available"></div>
                            <span>In Stock</span>
                            <span class="stock-count">• {{ rand(50, 200) }} units available</span>
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
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="action-buttons">
                            <button class="btn btn-primary btn-lg add-to-cart-btn" 
                                    data-id="{{ $product->id }}"
                                    data-name="{{ $product->name }}">
                                <i class="fas fa-shopping-cart me-2"></i>
                                Add to Cart
                            </button>
                            
                            <button class="btn btn-outline btn-lg buy-now-btn" 
                                    data-id="{{ $product->id }}">
                                <i class="fas fa-bolt me-2"></i>
                                Buy Now
                            </button>
                        </div>

                        <!-- Quick Actions -->
                        <div class="quick-actions">
                            <button class="action-link wishlist-toggle" data-id="{{ $product->id }}">
                                <i class="far fa-heart me-1"></i>
                                <span>Add to Wishlist</span>
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
                                <span>Secure Payment</span>
                            </div>
                            <div class="trust-item">
                                <i class="fas fa-truck"></i>
                                <span>Free Shipping</span>
                            </div>
                            <div class="trust-item">
                                <i class="fas fa-undo"></i>
                                <span>Easy Returns</span>
                            </div>
                        </div>
                    </div>
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
                    </a>
                    <a href="#shipping" class="nav-link">
                        <i class="fas fa-truck me-2"></i>
                        Shipping
                    </a>
                </div>
            </nav>

            <div class="details-content">
                <!-- Description Section -->
                <section id="description" class="content-section active">
                    <div class="description-content">
                        {!! $product->full_description !!}
                    </div>
                    
                    <div class="features-grid">
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-leaf"></i>
                            </div>
                            <div class="feature-text">
                                <h5>100% Natural</h5>
                                <p>No preservatives or artificial additives</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-seedling"></i>
                            </div>
                            <div class="feature-text">
                                <h5>Premium Quality</h5>
                                <p>Carefully selected and handpicked</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-heart"></i>
                            </div>
                            <div class="feature-text">
                                <h5>Health Benefits</h5>
                                <p>Rich in essential nutrients</p>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-certificate"></i>
                            </div>
                            <div class="feature-text">
                                <h5>Certified Organic</h5>
                                <p>100% certified organic produce</p>
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
                                <dd>500g</dd>
                                
                                <dt>Dimensions</dt>
                                <dd>20 × 15 × 5 cm</dd>
                                
                                <dt>Shelf Life</dt>
                                <dd>12 Months</dd>
                                
                                <dt>Storage</dt>
                                <dd>Cool & Dry Place</dd>
                            </dl>
                        </div>
                        
                        <div class="specs-column">
                            <h5>Nutritional Information</h5>
                            <dl class="specs-list">
                                <dt>Calories</dt>
                                <dd>600 kcal/100g</dd>
                                
                                <dt>Protein</dt>
                                <dd>20g/100g</dd>
                                
                                <dt>Fat</dt>
                                <dd>45g/100g</dd>
                                
                                <dt>Fiber</dt>
                                <dd>15g/100g</dd>
                                
                                <dt>Sugar</dt>
                                <dd>5g/100g</dd>
                            </dl>
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
                                </div>
                            @endfor
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
                        <h5>Write a Review</h5>
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
                            
                            <button type="submit" class="btn btn-primary">
                                Submit Review
                            </button>
                        </form>
                    </div>
                    @else
                    <div class="review-login-prompt">
                        <p>
                            Please <a href="{{ route('login') }}" class="text-primary">login</a> 
                            to write a review.
                        </p>
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
                                <ul class="info-list">
                                    <li>Free shipping on orders over $50</li>
                                    <li>Standard delivery: 3-5 business days</li>
                                    <li>Express delivery available</li>
                                    <li>International shipping</li>
                                    <li>Real-time tracking</li>
                                </ul>
                            </div>
                        </div>
                        
                        <div class="info-card">
                            <div class="info-icon">
                                <i class="fas fa-undo"></i>
                            </div>
                            <div class="info-content">
                                <h5>Return Policy</h5>
                                <ul class="info-list">
                                    <li>30-day return policy</li>
                                    <li>Money-back guarantee</li>
                                    <li>Easy returns process</li>
                                    <li>Free returns on defective items</li>
                                    <li>Quick refund processing</li>
                                </ul>
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
                <h3>Customers also bought</h3>
                <a href="{{ route('shop.index') }}" class="view-all">View All</a>
            </div>
            
            <div class="related-products-grid">
                @foreach($relatedProducts as $related)
                <div class="related-product-card">
                    <a href="{{ route('shop.show', $related->slug) }}" class="product-image">
                        <img src="{{ $related->primaryImage->media_url ?? 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80' }}"
                             alt="{{ $related->name }}">
                    </a>
                    <div class="product-info">
                        <a href="{{ route('shop.show', $related->slug) }}" class="product-name">
                            {{ Str::limit($related->name, 40) }}
                        </a>
                        <div class="product-price">
                            ${{ number_format($related->best_price, 2) }}
                        </div>
                        <button class="btn btn-sm btn-outline add-to-cart-quick" 
                                data-id="{{ $related->id }}">
                            <i class="fas fa-cart-plus"></i> Add
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
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
@endsection

@push('styles')
<style>
    /* Product Hero */
    .product-hero {
        background: var(--surface-color);
        padding: 1.5rem 0;
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
    
    /* Product Main Section */
    .product-detail {
        padding: 2rem 0;
    }
    
    .product-gallery-wrapper {
        position: sticky;
        top: 100px;
    }
    
    .main-image-area {
        margin-bottom: 1rem;
    }
    
    .main-image-container {
        position: relative;
        background: white;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid var(--border-color);
    }
    
    .main-product-image {
        width: 100%;
        height: auto;
        display: block;
        object-fit: contain;
    }
    
    .image-badges {
        position: absolute;
        top: 1rem;
        left: 1rem;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .badge {
        padding: 0.375rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
    }
    
    .badge-new {
        background: var(--gradient-gold);
        color: var(--text-primary);
    }
    
    .badge-sale {
        background: var(--danger-color);
        color: white;
    }
    
    .image-zoom-btn {
        position: absolute;
        bottom: 1rem;
        right: 1rem;
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.9);
        border: none;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-primary);
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .image-zoom-btn:hover {
        background: var(--primary-color);
        color: white;
        transform: scale(1.1);
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
        flex: 0 0 80px;
        height: 80px;
        border: 2px solid var(--border-color);
        border-radius: 8px;
        overflow: hidden;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .thumbnail-item:hover,
    .thumbnail-item.active {
        border-color: var(--primary-color);
    }
    
    .thumbnail-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    /* Product Info Card */
    .product-info-card {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 2px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid var(--border-color);
    }
    
    .product-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }
    
    .category-tag {
        background: var(--surface-color);
        padding: 0.375rem 0.75rem;
        border-radius: 20px;
        font-size: 0.875rem;
        color: var(--text-secondary);
        display: inline-flex;
        align-items: center;
    }
    
    .rating-display {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .rating-display .stars {
        display: flex;
        gap: 2px;
    }
    
    .rating-display .stars i {
        color: var(--accent-color);
        font-size: 0.875rem;
    }
    
    .rating-count {
        font-size: 0.875rem;
        color: var(--text-muted);
    }
    
    .product-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 1rem;
        line-height: 1.3;
    }
    
    .product-excerpt {
        color: var(--text-secondary);
        line-height: 1.6;
        margin-bottom: 1.5rem;
    }
    
    /* Pricing Section */
    .pricing-section {
        margin-bottom: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid var(--border-color);
    }
    
    .price-display {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 0.5rem;
    }
    
    .current-price {
        font-size: 2rem;
        font-weight: 700;
        color: var(--primary-color);
    }
    
    .original-price {
        font-size: 1.25rem;
        color: var(--text-muted);
        text-decoration: line-through;
    }
    
    .savings-info {
        display: inline-flex;
        align-items: center;
        background: rgba(231, 76, 60, 0.1);
        color: var(--danger-color);
        padding: 0.375rem 0.75rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
    }
    
    /* Stock Status */
    .stock-status {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
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
    }
    
    .stock-count {
        color: var(--text-muted);
    }
    
    /* Quantity Section */
    .quantity-section {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .quantity-label {
        font-weight: 500;
        color: var(--text-primary);
        min-width: 80px;
    }
    
    .quantity-controls {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .quantity-btn {
        width: 36px;
        height: 36px;
        border: 1px solid var(--border-color);
        background: white;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .quantity-btn:hover {
        border-color: var(--primary-color);
        background: var(--surface-color);
    }
    
    .quantity-input {
        width: 60px;
        height: 36px;
        border: 1px solid var(--border-color);
        border-radius: 6px;
        text-align: center;
        font-weight: 500;
        font-size: 1rem;
    }
    
    .quantity-input:focus {
        outline: none;
        border-color: var(--primary-color);
    }
    
    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .action-buttons .btn {
        flex: 1;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
    }
    
    .btn-primary {
        background: var(--primary-color);
        border: none;
    }
    
    .btn-primary:hover {
        background: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(17, 80, 40, 0.2);
    }
    
    .btn-outline {
        background: transparent;
        border: 2px solid var(--primary-color);
        color: var(--primary-color);
    }
    
    .btn-outline:hover {
        background: var(--primary-color);
        color: white;
        transform: translateY(-2px);
    }
    
    /* Quick Actions */
    .quick-actions {
        display: flex;
        justify-content: center;
        gap: 2rem;
        margin-bottom: 1.5rem;
        padding: 1rem 0;
        border-top: 1px solid var(--border-color);
        border-bottom: 1px solid var(--border-color);
    }
    
    .action-link {
        background: none;
        border: none;
        color: var(--text-secondary);
        cursor: pointer;
        display: flex;
        align-items: center;
        font-size: 0.875rem;
        transition: color 0.2s;
    }
    
    .action-link:hover {
        color: var(--primary-color);
    }
    
    /* Trust Section */
    .trust-section {
        display: flex;
        justify-content: space-around;
        padding-top: 1rem;
    }
    
    .trust-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        color: var(--text-muted);
        font-size: 0.75rem;
    }
    
    .trust-item i {
        font-size: 1.25rem;
        color: var(--primary-color);
    }
    
    /* Product Details Tabs */
    .product-details-tabs {
        margin-top: 3rem;
    }
    
    .details-nav {
        border-bottom: 1px solid var(--border-color);
        margin-bottom: 2rem;
    }
    
    .nav-links {
        display: flex;
        gap: 2rem;
        overflow-x: auto;
    }
    
    .nav-link {
        padding: 1rem 0;
        color: var(--text-secondary);
        text-decoration: none;
        font-weight: 500;
        border-bottom: 2px solid transparent;
        white-space: nowrap;
        transition: all 0.2s;
    }
    
    .nav-link:hover,
    .nav-link.active {
        color: var(--primary-color);
        border-bottom-color: var(--primary-color);
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
    
    /* Description Section */
    .description-content {
        color: var(--text-secondary);
        line-height: 1.8;
        margin-bottom: 2rem;
    }
    
    .description-content h1,
    .description-content h2,
    .description-content h3 {
        color: var(--text-primary);
        margin-top: 1.5rem;
        margin-bottom: 1rem;
    }
    
    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-top: 2rem;
    }
    
    .feature-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.5rem;
        background: var(--surface-color);
        border-radius: 8px;
        border: 1px solid var(--border-color);
    }
    
    .feature-icon {
        width: 48px;
        height: 48px;
        background: var(--gradient-gold);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.25rem;
    }
    
    .feature-text h5 {
        margin: 0 0 0.25rem 0;
        color: var(--text-primary);
    }
    
    .feature-text p {
        margin: 0;
        color: var(--text-secondary);
        font-size: 0.875rem;
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
    }
    
    .specs-list {
        display: grid;
        gap: 0.75rem;
    }
    
    .specs-list dt {
        font-weight: 500;
        color: var(--text-secondary);
    }
    
    .specs-list dd {
        color: var(--text-primary);
        margin-left: 1rem;
    }
    
    /* Reviews Section */
    .reviews-summary {
        display: flex;
        align-items: center;
        gap: 3rem;
        margin-bottom: 2rem;
        padding: 2rem;
        background: var(--surface-color);
        border-radius: 12px;
        border: 1px solid var(--border-color);
    }
    
    .overall-rating {
        text-align: center;
        min-width: 120px;
    }
    
    .rating-number {
        font-size: 3rem;
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
    }
    
    .rating-distribution {
        flex: 1;
    }
    
    .distribution-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 0.5rem;
    }
    
    .star-label {
        min-width: 60px;
        color: var(--text-secondary);
        font-size: 0.875rem;
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
        font-size: 0.875rem;
    }
    
    /* Review Cards */
    .reviews-list {
        display: grid;
        gap: 1.5rem;
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
        align-items: start;
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
    }
    
    .reviewer-name {
        margin: 0 0 0.25rem 0;
        color: var(--text-primary);
    }
    
    .review-date {
        color: var(--text-muted);
        font-size: 0.875rem;
    }
    
    .review-rating {
        display: flex;
        gap: 2px;
    }
    
    .review-title {
        margin: 0 0 0.5rem 0;
        color: var(--text-primary);
    }
    
    .review-content {
        color: var(--text-secondary);
        line-height: 1.6;
        margin-bottom: 1rem;
    }
    
    .review-highlights {
        display: grid;
        gap: 0.5rem;
    }
    
    .highlight {
        display: flex;
        align-items: center;
        padding: 0.5rem;
        background: var(--surface-color);
        border-radius: 6px;
        font-size: 0.875rem;
    }
    
    /* Add Review Form */
    .add-review-form {
        margin-top: 2rem;
        padding: 2rem;
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
    
    /* Shipping Info */
    .shipping-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
    }
    
    .info-card {
        padding: 2rem;
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
    
    .info-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .info-list li {
        padding: 0.5rem 0;
        color: var(--text-secondary);
        position: relative;
        padding-left: 1.5rem;
    }
    
    .info-list li:before {
        content: "✓";
        position: absolute;
        left: 0;
        color: var(--success-color);
        font-weight: bold;
    }
    
    /* Related Products */
    .related-products-section {
        margin-top: 3rem;
        padding-top: 3rem;
        border-top: 1px solid var(--border-color);
    }
    
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }
    
    .section-header h3 {
        margin: 0;
        color: var(--text-primary);
    }
    
    .view-all {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 500;
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
        border-radius: 8px;
        overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    
    .related-product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    .related-product-card .product-image {
        display: block;
        height: 150px;
        overflow: hidden;
    }
    
    .related-product-card .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
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
        margin-bottom: 0.5rem;
        transition: color 0.2s;
    }
    
    .related-product-card .product-name:hover {
        color: var(--primary-color);
    }
    
    .related-product-card .product-price {
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 0.5rem;
    }
    
    /* Responsive Design */
    @media (max-width: 992px) {
        .product-gallery-wrapper {
            position: static;
        }
        
        .reviews-summary {
            flex-direction: column;
            text-align: center;
            gap: 1.5rem;
        }
        
        .action-buttons {
            flex-direction: column;
        }
    }
    
    @media (max-width: 768px) {
        .product-title {
            font-size: 1.5rem;
        }
        
        .current-price {
            font-size: 1.75rem;
        }
        
        .features-grid {
            grid-template-columns: 1fr;
        }
        
        .specs-grid {
            grid-template-columns: 1fr;
        }
        
        .shipping-info-grid {
            grid-template-columns: 1fr;
        }
        
        .nav-links {
            gap: 1rem;
        }
        
        .trust-section {
            flex-direction: column;
            gap: 1rem;
        }
        
        .quick-actions {
            flex-direction: column;
            gap: 1rem;
        }
    }
    
    @media (max-width: 576px) {
        .product-info-card {
            padding: 1.5rem;
        }
        
        .price-display {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }
        
        .quantity-section {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Image Gallery
        const mainImage = document.getElementById('mainProductImage');
        const thumbnails = document.querySelectorAll('.thumbnail-item');
        
        thumbnails.forEach(thumbnail => {
            thumbnail.addEventListener('click', function() {
                const imageUrl = this.dataset.image;
                if (imageUrl) {
                    mainImage.src = imageUrl;
                    
                    // Update active state
                    thumbnails.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                }
            });
        });
        
        // Quantity Controls
        const quantityInput = document.getElementById('quantity');
        const decreaseBtn = document.getElementById('decreaseQty');
        const increaseBtn = document.getElementById('increaseQty');
        
        decreaseBtn.addEventListener('click', () => {
            let value = parseInt(quantityInput.value);
            if (value > 1) {
                quantityInput.value = value - 1;
            }
        });
        
        increaseBtn.addEventListener('click', () => {
            let value = parseInt(quantityInput.value);
            if (value < 99) {
                quantityInput.value = value + 1;
            }
        });
        
        // Tab Navigation
        const navLinks = document.querySelectorAll('.nav-link');
        const contentSections = document.querySelectorAll('.content-section');
        
        navLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Get target section
                const targetId = this.getAttribute('href').substring(1);
                const targetSection = document.getElementById(targetId);
                
                if (targetSection) {
                    // Update active states
                    navLinks.forEach(l => l.classList.remove('active'));
                    this.classList.add('active');
                    
                    contentSections.forEach(section => {
                        section.classList.remove('active');
                    });
                    targetSection.classList.add('active');
                    
                    // Smooth scroll to section
                    targetSection.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
        
        // Star Rating for Review Form
        const ratingStars = document.querySelectorAll('.rating-star');
        const userRatingInput = document.getElementById('userRating');
        
        ratingStars.forEach(star => {
            star.addEventListener('click', function() {
                const rating = this.dataset.rating;
                userRatingInput.value = rating;
                
                // Update star display
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
            
            // Hover effect
            star.addEventListener('mouseover', function() {
                const rating = this.dataset.rating;
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
        
        // Add to Cart
        const addToCartBtn = document.querySelector('.add-to-cart-btn');
        const buyNowBtn = document.querySelector('.buy-now-btn');
        
        async function addToCart(productId, quantity, redirect = false) {
            try {
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
                    
                    if (redirect) {
                        window.location.href = '{{ route("checkout") }}';
                    } else {
                        showSuccess('Product added to cart!');
                    }
                } else {
                    showError(data.message || 'Failed to add to cart');
                }
            } catch (error) {
                console.error('Error:', error);
                showError('Network error. Please try again.');
            }
        }
        
        if (addToCartBtn) {
            addToCartBtn.addEventListener('click', function() {
                const productId = this.dataset.id;
                const quantity = parseInt(quantityInput.value);
                
                // Show loading state
                const originalText = this.innerHTML;
                this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Adding...';
                this.disabled = true;
                
                setTimeout(() => {
                    addToCart(productId, quantity);
                    this.innerHTML = originalText;
                    this.disabled = false;
                }, 500);
            });
        }
        
        if (buyNowBtn) {
            buyNowBtn.addEventListener('click', function() {
                const productId = this.dataset.id;
                const quantity = parseInt(quantityInput.value);
                
                // Show loading state
                const originalText = this.innerHTML;
                this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> Processing...';
                this.disabled = true;
                
                setTimeout(() => {
                    addToCart(productId, quantity, true);
                    this.innerHTML = originalText;
                    this.disabled = false;
                }, 500);
            });
        }
        
        // Quick Add to Cart for related products
        document.querySelectorAll('.add-to-cart-quick').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.dataset.id;
                
                // Show loading state
                const originalText = this.innerHTML;
                this.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
                this.disabled = true;
                
                setTimeout(() => {
                    addToCart(productId, 1);
                    
                    // Show success state
                    this.innerHTML = '<i class="fas fa-check"></i> Added';
                    this.classList.remove('btn-outline');
                    this.classList.add('btn-success');
                    
                    setTimeout(() => {
                        this.innerHTML = originalText;
                        this.classList.remove('btn-success');
                        this.classList.add('btn-outline');
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
                            showSuccess('Added to wishlist!');
                        } else {
                            icon.className = 'far fa-heart me-1';
                            showInfo('Removed from wishlist');
                        }
                    }
                } catch (error) {
                    console.error('Error:', error);
                    showError('Failed to update wishlist');
                }
            });
        }
        
        // Share Product
        const shareBtn = document.querySelector('.share-product');
        if (shareBtn && navigator.share) {
            shareBtn.addEventListener('click', async () => {
                try {
                    await navigator.share({
                        title: document.title,
                        text: 'Check out this product!',
                        url: window.location.href
                    });
                } catch (error) {
                    console.log('Error sharing:', error);
                }
            });
        }
        
        // Image Zoom Modal
        const zoomModal = document.getElementById('imageZoomModal');
        const zoomedImage = document.getElementById('zoomedImage');
        
        if (zoomModal) {
            zoomModal.addEventListener('show.bs.modal', function () {
                zoomedImage.src = mainImage.src;
            });
        }
        
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
    });
</script>
@endpush