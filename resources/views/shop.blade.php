@extends('layouts.app')

@section('title', 'Shop - Ghazali Food')

@section('hero')
<!-- Shop Hero -->
<section class="hero-section" style="background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?ixlib=rb-4.0.3') center/cover no-repeat;">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="animate__animated animate__fadeInUp">Our Premium Products</h1>
                <p class="lead animate__animated animate__fadeInUp animate__delay-1s">
                    Discover our collection of fresh and healthy food products
                </p>
                <nav aria-label="breadcrumb" class="d-flex justify-content-center">
                    <ol class="breadcrumb bg-transparent p-0 animate__animated animate__fadeInUp animate__delay-2s">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Shop</li>
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
        <!-- Sidebar Filters -->
        <div class="col-lg-3 mb-4">
            <div class="sidebar">
                <!-- Categories Filter -->
                <div class="mb-4">
                    <h5 class="sidebar-title">Categories</h5>
                    <ul class="sidebar-list">
                        <li>
                            <a href="{{ route('shop.index') }}" 
                               class="{{ !request()->has('category') ? 'active' : '' }}">
                                All Categories
                            </a>
                        </li>
                        @foreach($categories as $category)
                        <li>
                            <a href="{{ route('shop.index', ['category' => $category->slug]) }}" 
                               class="{{ request('category') == $category->slug ? 'active' : '' }}">
                                {{ $category->name }}
                                <span class="badge bg-secondary float-end">{{ $category->products_count }}</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Price Filter -->
                <div class="mb-4">
                    <h5 class="sidebar-title">Filter by Price</h5>
                    <form id="price-filter-form">
                        <div class="mb-3">
                            <label class="form-label">Price Range</label>
                            <input type="range" class="form-range" id="price-range" 
                                   min="0" max="{{ ceil($maxPrice) }}" 
                                   value="{{ ceil($maxPrice) }}">
                            <div class="d-flex justify-content-between">
                                <span>$0</span>
                                <span>$<span id="price-value">{{ ceil($maxPrice) }}</span></span>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success btn-sm w-100">
                            Filter Price
                        </button>
                    </form>
                </div>

                <!-- Product Status Filter -->
                <div class="mb-4">
                    <h5 class="sidebar-title">Product Status</h5>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="featured" 
                               name="featured" {{ request()->has('featured') ? 'checked' : '' }}>
                        <label class="form-check-label" for="featured">
                            Featured Products
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="best-seller" 
                               name="best_seller" {{ request()->has('best_seller') ? 'checked' : '' }}>
                        <label class="form-check-label" for="best-seller">
                            Best Sellers
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="new-arrival" 
                               name="new_arrival" {{ request()->has('new_arrival') ? 'checked' : '' }}>
                        <label class="form-check-label" for="new-arrival">
                            New Arrivals
                        </label>
                    </div>
                </div>

                <!-- Sort Options -->
                <div class="mb-4">
                    <h5 class="sidebar-title">Sort By</h5>
                    <select class="form-select" id="sort-select">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name A-Z</option>
                        <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Highest Rated</option>
                    </select>
                </div>

                <!-- Clear Filters -->
                <div>
                    <a href="{{ route('shop.index') }}" class="btn btn-outline-secondary w-100">
                        <i class="fas fa-times me-2"></i>Clear All Filters
                    </a>
                </div>
            </div>
        </div>

        <!-- Product Grid -->
        <div class="col-lg-9">
            <!-- Search and Filter Bar -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <form action="{{ route('shop.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" 
                                   placeholder="Search products..." value="{{ request('search') }}">
                            <button class="btn btn-success" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0 mt-2">
                        Showing {{ $products->firstItem() }}-{{ $products->lastItem() }} of {{ $products->total() }} products
                    </p>
                </div>
            </div>

            <!-- Products Grid -->
            @if($products->count() > 0)
            <div class="row g-4">
                @foreach($products as $product)
                <div class="col-xl-4 col-lg-4 col-md-6">
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
                            @if($product->is_featured)
                                <span class="product-badge badge-featured">Featured</span>
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
                                <a href="https://wa.me/?text=I'm interested in {{ $product->name }} from Ghazali Food" 
                                   target="_blank" class="btn btn-outline-success">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="row mt-5">
                <div class="col-12">
                    {{ $products->links() }}
                </div>
            </div>
            @else
            <div class="text-center py-5">
                <i class="fas fa-search fa-4x text-muted mb-3"></i>
                <h4>No products found</h4>
                <p class="text-muted">Try adjusting your search or filter criteria</p>
                <a href="{{ route('shop.index') }}" class="btn btn-success">
                    Clear Filters
                </a>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Newsletter Section -->
<section class="bg-light py-5 mt-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 text-center">
                <h3 class="fw-bold mb-3">Subscribe to Our Newsletter</h3>
                <p class="text-muted mb-4">Get updates on new products and special offers!</p>
                <form class="row g-3 justify-content-center">
                    <div class="col-auto">
                        <input type="email" class="form-control" placeholder="Your email address">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-success">
                            Subscribe
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    // Price range filter
    const priceRange = document.getElementById('price-range');
    const priceValue = document.getElementById('price-value');
    
    priceRange.addEventListener('input', function() {
        priceValue.textContent = this.value;
    });
    
    // Apply filters
    document.getElementById('price-filter-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const maxPrice = priceRange.value;
        window.location.href = `{{ route('shop.index') }}?max_price=${maxPrice}`;
    });
    
    // Checkbox filters
    const checkboxes = ['featured', 'best-seller', 'new-arrival'];
    checkboxes.forEach(id => {
        const checkbox = document.getElementById(id);
        if (checkbox) {
            checkbox.addEventListener('change', function() {
                const params = new URLSearchParams(window.location.search);
                if (this.checked) {
                    params.set(this.name, 'true');
                } else {
                    params.delete(this.name);
                }
                window.location.href = `{{ route('shop.index') }}?${params.toString()}`;
            });
        }
    });
    
    // Sort select
    document.getElementById('sort-select').addEventListener('change', function() {
        const params = new URLSearchParams(window.location.search);
        params.set('sort', this.value);
        window.location.href = `{{ route('shop.index') }}?${params.toString()}`;
    });
</script>
@endpush
@endsection