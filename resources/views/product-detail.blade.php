@extends('layouts.app')

@section('title', $product->name . ' - Ghazali Food')

@section('hero')
<section class="hero-section" style="background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?ixlib=rb-4.0.3') center/cover no-repeat;">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="animate__animated animate__fadeInUp">Product Details</h1>
                <nav aria-label="breadcrumb" class="d-flex justify-content-center">
                    <ol class="breadcrumb bg-transparent p-0 animate__animated animate__fadeInUp animate__delay-1s">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('shop.index') }}">Shop</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
@endsection

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Product Images -->
        <div class="col-lg-6 mb-4">
            <div class="product-images">
                <!-- Main Image -->
                <div class="main-image mb-3">
                    <img src="{{ $product->media->first()->media_url ?? 'https://via.placeholder.com/600x600?text=Product' }}" 
                         class="img-fluid rounded-3" id="main-product-image" 
                         alt="{{ $product->name }}">
                </div>
                
                <!-- Thumbnails -->
                @if($product->media->count() > 1)
                <div class="thumbnail-images">
                    <div class="row g-2">
                        @foreach($product->media as $media)
                        <div class="col-3">
                            <img src="{{ $media->media_url }}" 
                                 class="img-fluid rounded thumbnail" 
                                 alt="{{ $product->name }}"
                                 onclick="changeMainImage(this)">
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Product Info -->
        <div class="col-lg-6 mb-4">
            <div class="product-info">
                <h1 class="product-title fw-bold mb-3">{{ $product->name }}</h1>
                
                <!-- Rating -->
                <div class="product-rating mb-3">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= floor($product->average_rating))
                            <i class="fas fa-star text-warning"></i>
                        @elseif($i - 0.5 <= $product->average_rating)
                            <i class="fas fa-star-half-alt text-warning"></i>
                        @else
                            <i class="far fa-star text-warning"></i>
                        @endif
                    @endfor
                    <span class="ms-2">({{ $product->total_reviews }} reviews)</span>
                </div>
                
                <!-- Price -->
                <div class="product-price mb-4">
                    <h2 class="text-success fw-bold">${{ number_format($product->best_price, 2) }}</h2>
                    @if($product->compare_at_price)
                        <del class="text-muted fs-5">${{ number_format($product->compare_at_price, 2) }}</del>
                        <span class="badge bg-danger ms-2">Save {{ $product->discount_percentage }}%</span>
                    @endif
                </div>
                
                <!-- Short Description -->
                <div class="product-short-desc mb-4">
                    <p>{{ $product->short_description }}</p>
                </div>
                
                <!-- Product Meta -->
                <div class="product-meta mb-4">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-2"><strong>Category:</strong> {{ $product->category->name }}</p>
                            <p class="mb-2"><strong>SKU:</strong> {{ $product->id }}</p>
                            <p class="mb-0"><strong>Availability:</strong> 
                                <span class="text-success">In Stock</span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2"><strong>Brand:</strong> Ghazali Food</p>
                            <p class="mb-2"><strong>Weight:</strong> 500g</p>
                        </div>
                    </div>
                </div>
                
                <!-- Quantity and Actions -->
                <div class="product-actions">
                    <form id="add-to-cart-form">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        
                        <div class="row align-items-center mb-4">
                            <div class="col-auto">
                                <label class="form-label">Quantity:</label>
                            </div>
                            <div class="col-auto">
                                <div class="input-group" style="width: 120px;">
                                    <button class="btn btn-outline-secondary" type="button" id="decrement-qty">-</button>
                                    <input type="number" class="form-control text-center" 
                                           name="quantity" id="quantity" value="1" min="1" max="99">
                                    <button class="btn btn-outline-secondary" type="button" id="increment-qty">+</button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <button type="button" class="btn btn-success btn-lg w-100 add-to-cart-btn" 
                                        data-id="{{ $product->id }}" data-name="{{ $product->name }}">
                                    <i class="fas fa-cart-plus me-2"></i> Add to Cart
                                </button>
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-outline-danger btn-lg w-100 add-to-wishlist-btn"
                                        data-id="{{ $product->id }}">
                                    <i class="fas fa-heart me-2"></i> Add to Wishlist
                                </button>
                            </div>
                        </div>
                        
                        <div class="row g-2">
                            <div class="col-md-6">
                                <a href="https://wa.me/?text=I'm interested in {{ $product->name }} from Ghazali Food. Product URL: {{ url()->current() }}" 
                                   target="_blank" class="btn btn-outline-success w-100">
                                    <i class="fab fa-whatsapp me-2"></i> WhatsApp
                                </a>
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-outline-primary w-100" id="buy-now">
                                    <i class="fas fa-bolt me-2"></i> Buy Now
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Product Tabs -->
    <div class="row mt-5">
        <div class="col-12">
            <ul class="nav nav-tabs" id="productTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="description-tab" data-bs-toggle="tab" 
                            data-bs-target="#description" type="button" role="tab">
                        Description
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" 
                            data-bs-target="#reviews" type="button" role="tab">
                        Reviews ({{ $product->reviews->count() }})
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="shipping-tab" data-bs-toggle="tab" 
                            data-bs-target="#shipping" type="button" role="tab">
                        Shipping & Returns
                    </button>
                </li>
            </ul>
            
            <div class="tab-content p-4 border border-top-0 rounded-bottom" id="productTabsContent">
                <!-- Description Tab -->
                <div class="tab-pane fade show active" id="description" role="tabpanel">
                    {!! $product->full_description !!}
                </div>
                
                <!-- Reviews Tab -->
                <div class="tab-pane fade" id="reviews" role="tabpanel">
                    @if($product->reviews->count() > 0)
                        @foreach($product->reviews as $review)
                        <div class="review-item mb-4 pb-4 border-bottom">
                            <div class="d-flex justify-content-between mb-2">
                                <div>
                                    <h6 class="fw-bold mb-1">{{ $review->user->name }}</h6>
                                    <div class="rating">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star{{ $i > $review->rating ? '-o' : '' }} text-warning"></i>
                                        @endfor
                                    </div>
                                </div>
                                <small class="text-muted">{{ $review->created_at->format('M d, Y') }}</small>
                            </div>
                            @if($review->title)
                                <h6 class="fw-bold">{{ $review->title }}</h6>
                            @endif
                            <p class="mb-2">{{ $review->comment }}</p>
                            @if($review->pros)
                                <p class="mb-1"><strong>Pros:</strong> {{ $review->pros }}</p>
                            @endif
                            @if($review->cons)
                                <p class="mb-0"><strong>Cons:</strong> {{ $review->cons }}</p>
                            @endif
                        </div>
                        @endforeach
                    @else
                        <p class="text-muted">No reviews yet. Be the first to review this product!</p>
                    @endif
                    
                    <!-- Add Review Form -->
                    @auth
                    <div class="mt-4">
                        <h5 class="fw-bold mb-3">Add Your Review</h5>
                        <form>
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Rating</label>
                                <div class="rating-input">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="far fa-star fa-2x text-warning" 
                                           data-rating="{{ $i }}"
                                           onmouseover="hoverStar(this)" 
                                           onmouseout="resetStars()" 
                                           onclick="setRating({{ $i }})"></i>
                                    @endfor
                                    <input type="hidden" name="rating" id="rating-value" value="0">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="review-title" class="form-label">Title</label>
                                <input type="text" class="form-control" id="review-title">
                            </div>
                            <div class="mb-3">
                                <label for="review-comment" class="form-label">Comment</label>
                                <textarea class="form-control" id="review-comment" rows="4"></textarea>
                            </div>
                            <button type="button" class="btn btn-success">Submit Review</button>
                        </form>
                    </div>
                    @else
                        <p>Please <a href="{{ route('login') }}">login</a> to add a review.</p>
                    @endauth
                </div>
                
                <!-- Shipping Tab -->
                <div class="tab-pane fade" id="shipping" role="tabpanel">
                    <h5 class="fw-bold mb-3">Shipping Information</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Free shipping on orders over $50</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Standard delivery: 3-5 business days</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Express delivery available</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Track your order online</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i> International shipping available</li>
                    </ul>
                    
                    <h5 class="fw-bold mt-4 mb-3">Return Policy</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i> 30-day return policy</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Money-back guarantee</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i> No questions asked returns</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Free return shipping on defective items</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="fw-bold mb-4">Related Products</h3>
            <div class="row g-4">
                @foreach($relatedProducts as $related)
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="product-card">
                        <div class="product-img">
                            <img src="{{ $related->primaryImage->media_url ?? 'https://via.placeholder.com/300x300?text=Product' }}" 
                                 alt="{{ $related->name }}">
                        </div>
                        <div class="product-info">
                            <h6 class="product-title">
                                <a href="{{ route('shop.show', $related->slug) }}" class="text-decoration-none text-dark">
                                    {{ Str::limit($related->name, 40) }}
                                </a>
                            </h6>
                            
                            <div class="product-price d-flex align-items-center">
                                ${{ number_format($related->best_price, 2) }}
                            </div>
                            
                            <div class="product-actions mt-3">
                                <button class="btn btn-success btn-sm add-to-cart" 
                                        data-id="{{ $related->id }}"
                                        data-name="{{ $related->name }}">
                                    <i class="fas fa-cart-plus me-1"></i> Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    function changeMainImage(element) {
        document.getElementById('main-product-image').src = element.src;
    }
    
    // Quantity controls
    document.getElementById('increment-qty').addEventListener('click', function() {
        const quantityInput = document.getElementById('quantity');
        let currentVal = parseInt(quantityInput.value);
        if (currentVal < 99) {
            quantityInput.value = currentVal + 1;
        }
    });
    
    document.getElementById('decrement-qty').addEventListener('click', function() {
        const quantityInput = document.getElementById('quantity');
        let currentVal = parseInt(quantityInput.value);
        if (currentVal > 1) {
            quantityInput.value = currentVal - 1;
        }
    });
    
    // Add to cart from product detail
    $('.add-to-cart-btn').click(function() {
        const productId = $(this).data('id');
        const productName = $(this).data('name');
        const quantity = $('#quantity').val();
        
        $.ajax({
            url: '{{ route("cart.add") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                product_id: productId,
                quantity: quantity
            },
            success: function(response) {
                $('.cart-count').text(response.cart_count);
                showToast('Success', productName + ' added to cart!', 'success');
            },
            error: function(xhr) {
                showToast('Error', 'Failed to add item to cart', 'error');
            }
        });
    });
    
    // Add to wishlist from product detail
    $('.add-to-wishlist-btn').click(function() {
        const productId = $(this).data('id');
        
        $.ajax({
            url: '{{ route("wishlist.add") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                product_id: productId
            },
            success: function(response) {
                showToast('Success', 'Added to wishlist!', 'success');
            },
            error: function(xhr) {
                showToast('Error', 'Failed to add to wishlist', 'error');
            }
        });
    });
    
    // Buy now button
    $('#buy-now').click(function() {
        const productId = $('input[name="product_id"]').val();
        const quantity = $('#quantity').val();
        
        $.ajax({
            url: '{{ route("cart.add") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                product_id: productId,
                quantity: quantity
            },
            success: function(response) {
                window.location.href = '{{ route("checkout") }}';
            }
        });
    });
    
    // Star rating for reviews
    let currentRating = 0;
    let stars = [];
    
    function initializeStars() {
        stars = document.querySelectorAll('.rating-input .fa-star');
    }
    
    function hoverStar(element) {
        const rating = parseInt(element.getAttribute('data-rating'));
        highlightStars(rating);
    }
    
    function resetStars() {
        highlightStars(currentRating);
    }
    
    function setRating(rating) {
        currentRating = rating;
        document.getElementById('rating-value').value = rating;
        highlightStars(rating);
    }
    
    function highlightStars(rating) {
        stars.forEach(star => {
            const starRating = parseInt(star.getAttribute('data-rating'));
            if (starRating <= rating) {
                star.classList.remove('far');
                star.classList.add('fas');
            } else {
                star.classList.remove('fas');
                star.classList.add('far');
            }
        });
    }
    
    // Initialize stars when document is ready
    $(document).ready(function() {
        initializeStars();
    });
</script>
@endpush