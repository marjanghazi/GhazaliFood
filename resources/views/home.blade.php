@extends('layouts.app')

@section('title', 'Premium Dry Fruits Store | Nuts & Berries')

@section('hero')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center min-vh-70">
            <div class="col-lg-6">
                <h1 class="hero-title animate-slide-up">Premium Quality Dry Fruits & Nuts</h1>
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
            <div class="col-lg-6">
                <div class="hero-image">
                    <img src="https://images.unsplash.com/photo-1542291025-1ec7e8e7cbc6?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                         alt="Premium Dry Fruits"
                         class="img-fluid rounded-3">
                    <div class="hero-badge animate-bounce">
                        <i class="fas fa-trophy me-2"></i> #1 Rated
                    </div>
                </div>
            </div>
        </div>
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
                            @if($i <= $product->average_rating)
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
                        @if($i <= $testimonial->rating)
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
.hero-section {
    padding-top: 120px;
    padding-bottom: var(--space-2xl);
    background: linear-gradient(135deg, var(--background-color) 0%, #F8F4E9 100%);
    position: relative;
    overflow: hidden;
}

.hero-title {
    font-size: var(--text-5xl);
    margin-bottom: var(--space-lg);
    color: var(--primary-color);
}

.hero-subtitle {
    font-size: var(--text-xl);
    margin-bottom: var(--space-xl);
    max-width: 600px;
    color: var(--text-secondary);
}

.hero-image {
    position: relative;
    animation: float 6s ease-in-out infinite;
}

.hero-image img {
    max-width: 100%;
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-xl);
}

.hero-badge {
    position: absolute;
    top: 20px;
    right: 20px;
    background: var(--gradient-gold);
    color: var(--primary-dark);
    padding: var(--space-sm) var(--space-md);
    border-radius: var(--radius-full);
    font-weight: 600;
    box-shadow: var(--shadow-lg);
    animation: bounce 2s infinite;
}

.hero-buttons {
    display: flex;
    gap: var(--space-md);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .hero-section {
        padding-top: 100px;
        padding-bottom: var(--space-xl);
    }
    
    .hero-title {
        font-size: var(--text-3xl);
    }
    
    .hero-subtitle {
        font-size: var(--text-lg);
    }
    
    .hero-buttons {
        flex-direction: column;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add to cart functionality for home page
    document.querySelectorAll('.add-to-cart-btn').forEach(button => {
        button.addEventListener('click', async function(e) {
            e.preventDefault();
            
            const productId = this.dataset.productId;
            
            // Show loading state
            const originalHtml = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            this.disabled = true;
            
            try {
                const response = await fetch('{{ route("cart.add") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: 1
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Update cart count
                    document.querySelectorAll('.cart-count').forEach(element => {
                        element.textContent = data.cart_count;
                        element.style.display = data.cart_count > 0 ? 'flex' : 'none';
                    });
                    
                    // Show success toast
                    showToast('Product added to cart!', 'success');
                } else {
                    showToast(data.message || 'Failed to add to cart', 'error');
                }
            } catch (error) {
                console.error('Error adding to cart:', error);
                showToast('Network error. Please try again.', 'error');
            } finally {
                // Reset button state
                this.innerHTML = originalHtml;
                this.disabled = false;
            }
        });
    });
    
    // Wishlist toggle for home page
    document.querySelectorAll('.wishlist-toggle-btn').forEach(button => {
        button.addEventListener('click', async function(e) {
            e.preventDefault();
            
            const productId = this.dataset.productId;
            
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
                    // Update wishlist count
                    if (data.wishlist_count !== undefined) {
                        document.querySelectorAll('.badge-count').forEach(element => {
                            element.textContent = data.wishlist_count;
                            element.style.display = data.wishlist_count > 0 ? 'inline' : 'none';
                        });
                    }
                    
                    // Update button icon
                    const icon = this.querySelector('i');
                    if (data.in_wishlist) {
                        icon.classList.remove('far');
                        icon.classList.add('fas', 'text-danger');
                    } else {
                        icon.classList.remove('fas', 'text-danger');
                        icon.classList.add('far');
                    }
                    
                    showToast(data.message, data.in_wishlist ? 'success' : 'info');
                }
            } catch (error) {
                console.error('Error toggling wishlist:', error);
                showToast('Network error. Please try again.', 'error');
            }
        });
    });
});
</script>
@endpush