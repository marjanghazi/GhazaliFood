@extends('layouts.app')

@section('title', 'Shop - Premium Dry Fruits Store | Nuts & Berries')

@section('hero')
<!-- Shop Hero -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center min-vh-60">
            <div class="col-12 text-center">
                <h1 class="hero-title animate-slide-up">Our Premium Collection</h1>
                <p class="lead animate-slide-up delay-1">
                    Discover exquisite selection of 100% natural, organic dry fruits, nuts, and berries
                </p>
                <nav class="breadcrumb-wrapper animate-slide-up delay-2">
                    <div class="breadcrumb">
                        <a href="{{ url('/') }}" class="breadcrumb-item">Home</a>
                        <span class="breadcrumb-separator">/</span>
                        <span class="breadcrumb-item active">Shop</span>
                    </div>
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
            <div class="sidebar bg-surface p-4 rounded-3">
                <!-- Categories Filter -->
                <div class="mb-5">
                    <h5 class="sidebar-title mb-4">Categories</h5>
                    <ul class="sidebar-list">
                        <li>
                            <a href="{{ route('shop.index') }}"
                                class="sidebar-link {{ !request()->has('category') ? 'active' : '' }}">
                                All Categories
                                <span class="badge-count">{{ $totalProducts ?? 0 }}</span>
                            </a>
                        </li>
                        @foreach($categories as $category)
                        <li>
                            <a href="{{ route('shop.index', ['category' => $category->slug]) }}"
                                class="sidebar-link {{ request('category') == $category->slug ? 'active' : '' }}">
                                {{ $category->name }}
                                <span class="badge-count">{{ $category->products_count ?? 0 }}</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Price Filter -->
                <div class="mb-5">
                    <h5 class="sidebar-title mb-4">Filter by Price</h5>
                    <form id="price-filter-form">
                        <div class="price-range-wrapper">
                            <div class="price-display">
                                <span class="price-label">Price Range:</span>
                                <span class="price-value">$0 - $<span id="price-value">{{ ceil($maxPrice) }}</span></span>
                            </div>
                            <input type="range" class="price-slider" id="price-range"
                                min="0" max="{{ ceil($maxPrice) }}"
                                value="{{ ceil($maxPrice) }}">
                            <div class="price-labels d-flex justify-content-between">
                                <span>$0</span>
                                <span>${{ ceil($maxPrice) }}</span>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mt-3">
                            Apply Price Filter
                        </button>
                    </form>
                </div>

                <!-- Product Status Filter -->
                <div class="mb-5">
                    <h5 class="sidebar-title mb-4">Product Status</h5>
                    <div class="filter-checkboxes">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="featured"
                                name="featured" {{ request()->has('featured') ? 'checked' : '' }}>
                            <label class="form-check-label" for="featured">
                                <i class="fas fa-star me-2"></i>Featured Products
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="best-seller"
                                name="best_seller" {{ request()->has('best_seller') ? 'checked' : '' }}>
                            <label class="form-check-label" for="best-seller">
                                <i class="fas fa-fire me-2"></i>Best Sellers
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="new-arrival"
                                name="new_arrival" {{ request()->has('new_arrival') ? 'checked' : '' }}>
                            <label class="form-check-label" for="new-arrival">
                                <i class="fas fa-bell me-2"></i>New Arrivals
                            </label>
                        </div>
                        @if(request()->has('sale'))
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="sale"
                                name="sale" checked>
                            <label class="form-check-label" for="sale">
                                <i class="fas fa-tag me-2"></i>On Sale
                            </label>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Sort Options -->
                <div class="mb-5">
                    <h5 class="sidebar-title mb-4">Sort By</h5>
                    <div class="sort-options">
                        <select class="form-select" id="sort-select">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name A-Z</option>
                            <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Highest Rated</option>
                            <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                        </select>
                    </div>
                </div>

                <!-- Clear Filters -->
                <div>
                    <a href="{{ route('shop.index') }}" class="btn btn-outline w-100">
                        <i class="fas fa-redo me-2"></i>Clear All Filters
                    </a>
                </div>
            </div>
        </div>

        <!-- Product Grid -->
        <div class="col-lg-9">
            <!-- Search and Filter Bar -->
            <div class="filter-bar mb-5">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <form action="{{ route('shop.index') }}" method="GET" class="search-form">
                            <div class="input-group">
                                <input type="text" class="form-control search-input" name="search"
                                    placeholder="Search for almonds, cashews, dates..."
                                    value="{{ request('search') }}"
                                    aria-label="Search products">
                                <button class="btn btn-primary search-btn" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <div class="results-count">
                            <span class="text-muted">
                                Showing {{ $products->firstItem() }}-{{ $products->lastItem() }}
                                of {{ $products->total() }} products
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active Filters -->
            @if(request()->anyFilled(['category', 'search', 'featured', 'best_seller', 'new_arrival', 'sale', 'max_price']))
            <div class="active-filters mb-4">
                <div class="d-flex flex-wrap gap-2">
                    <span class="filter-label">Active Filters:</span>
                    @if(request('category'))
                    <span class="filter-tag">
                        {{ $categories->firstWhere('slug', request('category'))->name ?? request('category') }}
                        <a href="{{ route('shop.index', request()->except('category')) }}" class="remove-filter">
                            <i class="fas fa-times"></i>
                        </a>
                    </span>
                    @endif
                    @if(request('search'))
                    <span class="filter-tag">
                        Search: "{{ request('search') }}"
                        <a href="{{ route('shop.index', request()->except('search')) }}" class="remove-filter">
                            <i class="fas fa-times"></i>
                        </a>
                    </span>
                    @endif
                    @if(request('featured'))
                    <span class="filter-tag">
                        Featured
                        <a href="{{ route('shop.index', request()->except('featured')) }}" class="remove-filter">
                            <i class="fas fa-times"></i>
                        </a>
                    </span>
                    @endif
                    @if(request('max_price'))
                    <span class="filter-tag">
                        Max: ${{ request('max_price') }}
                        <a href="{{ route('shop.index', request()->except('max_price')) }}" class="remove-filter">
                            <i class="fas fa-times"></i>
                        </a>
                    </span>
                    @endif
                </div>
            </div>
            @endif

            <!-- Products Grid -->
            @if($products->count() > 0)
            <div class="products-grid">
                @foreach($products as $product)
                <div class="product-card">
                    <div class="product-image">
                        <a href="{{ route('shop.show', $product->slug) }}">
                            <img src="{{ $product->primaryImage->media_url ?? 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80' }}"
                                alt="{{ $product->name }}"
                                class="img-fluid">
                        </a>

                        @if($product->is_new_arrival)
                        <span class="product-badge badge-new">New</span>
                        @endif

                        @if($product->compare_at_price && $product->compare_at_price > $product->best_price)
                        <span class="product-badge badge-sale">Sale</span>
                        @endif

                        @if($product->is_featured)
                        <span class="product-badge badge-featured">Featured</span>
                        @endif

                        <div class="product-overlay">
                            <div class="product-actions">
                                <button class="btn btn-primary add-to-cart-btn"
                                    data-product-id="{{ $product->id }}"
                                    title="Add to cart">
                                    <i class="fas fa-cart-plus"></i>
                                </button>

                                @auth
                                <button class="btn btn-outline wishlist-toggle-btn"
                                    data-product-id="{{ $product->id }}"
                                    title="Add to wishlist">
                                    <i class="{{ App\Models\Wishlist::isInWishlist($product->id) ? 'fas text-danger' : 'far' }} fa-heart"></i>
                                </button>
                                @endauth

                                <a href="{{ route('shop.show', $product->slug) }}"
                                    class="btn btn-outline"
                                    title="Quick view">
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
                                @if($i <=floor($product->average_rating))
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
                            <span class="discount">-{{ $product->discount_percentage }}%</span>
                            @endif
                        </div>

                        <div class="product-meta mt-2">
                            @if($product->is_featured)
                            <span class="meta-tag featured">
                                <i class="fas fa-star me-1"></i>Featured
                            </span>
                            @endif
                            @if($product->is_best_seller)
                            <span class="meta-tag best-seller">
                                <i class="fas fa-fire me-1"></i>Best Seller
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="pagination-wrapper mt-5">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="pagination-info">
                        <span class="text-muted">
                            Page {{ $products->currentPage() }} of {{ $products->lastPage() }}
                        </span>
                    </div>
                    <!-- Pagination -->
                    <div class="pagination-wrapper mt-5">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="pagination-info">
                                <span class="text-muted">
                                    Page {{ $products->currentPage() }} of {{ $products->lastPage() }}
                                </span>
                            </div>
                            <div class="pagination-links">
                                {{ $products->links() }}
                            </div>
                            <div class="pagination-per-page">
                                <select class="form-select form-select-sm" id="per-page-select">
                                    <option value="12" {{ request('per_page') == 12 ? 'selected' : '' }}>12 per page</option>
                                    <option value="24" {{ request('per_page') == 24 ? 'selected' : '' }}>24 per page</option>
                                    <option value="48" {{ request('per_page') == 48 ? 'selected' : '' }}>48 per page</option>
                                    <option value="96" {{ request('per_page') == 96 ? 'selected' : '' }}>96 per page</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="empty-state text-center py-5">
                <div class="empty-state-icon">
                    <i class="fas fa-search fa-4x text-muted mb-3"></i>
                </div>
                <h4 class="mb-3">No products found</h4>
                <p class="text-muted mb-4">Try adjusting your search or filter criteria</p>
                <div class="empty-state-actions">
                    <a href="{{ route('shop.index') }}" class="btn btn-primary me-2">
                        Clear All Filters
                    </a>
                    <a href="{{ route('shop.index', ['new_arrival' => true]) }}" class="btn btn-outline">
                        View New Arrivals
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Newsletter Section -->
<section class="newsletter-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h2 class="text-white mb-3">Stay Updated</h2>
                <p class="text-white mb-4">Subscribe to our newsletter for exclusive offers, new arrivals, and health tips!</p>
            </div>
            <div class="col-lg-6">
                <form class="newsletter-form">
                    <div class="input-group">
                        <input type="email"
                            class="form-control"
                            placeholder="Enter your email address"
                            required
                            aria-label="Email for newsletter">
                        <button type="submit" class="btn btn-light">
                            Subscribe <i class="fas fa-paper-plane ms-2"></i>
                        </button>
                    </div>
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
        padding-bottom: var(--space-xl);
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-color) 100%);
        color: white;
        text-align: center;
    }

    .hero-section .hero-title {
        color: white;
        font-size: var(--text-4xl);
        margin-bottom: var(--space-md);
    }

    .hero-section .lead {
        color: rgba(255, 255, 255, 0.9);
        font-size: var(--text-lg);
        max-width: 600px;
        margin: 0 auto var(--space-lg);
    }

    .breadcrumb-wrapper {
        margin-top: var(--space-lg);
    }

    .breadcrumb {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: var(--space-xs);
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .breadcrumb-item {
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        font-size: var(--text-sm);
        transition: var(--transition-fast);
    }

    .breadcrumb-item:hover {
        color: white;
    }

    .breadcrumb-item.active {
        color: var(--secondary-color);
        font-weight: 600;
    }

    .breadcrumb-separator {
        color: rgba(255, 255, 255, 0.6);
    }

    /* Sidebar Styles */
    .sidebar {
        position: sticky;
        top: 100px;
        background: var(--surface-color);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        transition: var(--transition-normal);
    }

    .sidebar-title {
        font-size: var(--text-lg);
        font-weight: 600;
        color: var(--text-primary);
        padding-bottom: var(--space-sm);
        border-bottom: 2px solid var(--border-color);
    }

    .sidebar-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .sidebar-list li {
        margin-bottom: var(--space-xs);
    }

    .sidebar-link {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: var(--space-xs) var(--space-sm);
        color: var(--text-secondary);
        text-decoration: none;
        border-radius: var(--radius-sm);
        transition: var(--transition-fast);
    }

    .sidebar-link:hover {
        background: var(--primary-light);
        color: white;
        transform: translateX(5px);
    }

    .sidebar-link.active {
        background: var(--primary-color);
        color: white;
        font-weight: 500;
    }

    .sidebar-link .badge-count {
        background: var(--surface-color);
        color: var(--text-primary);
        font-size: var(--text-xs);
        padding: 2px 6px;
        border-radius: var(--radius-full);
    }

    .sidebar-link.active .badge-count {
        background: white;
        color: var(--primary-color);
    }

    /* Price Range Slider */
    .price-range-wrapper {
        padding: var(--space-md) 0;
    }

    .price-display {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: var(--space-md);
        padding: var(--space-sm);
        background: var(--background-color);
        border-radius: var(--radius-md);
    }

    .price-label {
        font-weight: 500;
        color: var(--text-primary);
    }

    .price-value {
        font-weight: 700;
        color: var(--primary-color);
    }

    .price-slider {
        width: 100%;
        height: 6px;
        -webkit-appearance: none;
        appearance: none;
        background: var(--border-color);
        border-radius: var(--radius-full);
        outline: none;
        margin: var(--space-md) 0;
    }

    .price-slider::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: var(--primary-color);
        cursor: pointer;
        border: 3px solid var(--surface-color);
        box-shadow: var(--shadow-sm);
    }

    .price-slider::-moz-range-thumb {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: var(--primary-color);
        cursor: pointer;
        border: 3px solid var(--surface-color);
        box-shadow: var(--shadow-sm);
    }

    .price-labels {
        font-size: var(--text-sm);
        color: var(--text-muted);
    }

    /* Filter Checkboxes */
    .filter-checkboxes .form-check {
        margin-bottom: var(--space-sm);
        padding-left: 0;
    }

    .filter-checkboxes .form-check-input {
        margin-right: var(--space-xs);
    }

    .filter-checkboxes .form-check-label {
        display: flex;
        align-items: center;
        cursor: pointer;
        padding: var(--space-xs) var(--space-sm);
        border-radius: var(--radius-sm);
        transition: var(--transition-fast);
    }

    .filter-checkboxes .form-check-label:hover {
        background: var(--background-color);
    }

    .filter-checkboxes .form-check-input:checked+.form-check-label {
        background: var(--primary-light);
        color: white;
    }

    /* Active Filters */
    .active-filters {
        background: var(--background-color);
        padding: var(--space-md);
        border-radius: var(--radius-md);
    }

    .filter-label {
        font-weight: 500;
        color: var(--text-primary);
    }

    .filter-tag {
        display: inline-flex;
        align-items: center;
        gap: var(--space-xs);
        background: var(--primary-color);
        color: white;
        padding: 4px 12px;
        border-radius: var(--radius-full);
        font-size: var(--text-sm);
    }

    .filter-tag .remove-filter {
        color: white;
        text-decoration: none;
        opacity: 0.8;
        transition: var(--transition-fast);
    }

    .filter-tag .remove-filter:hover {
        opacity: 1;
    }

    /* Empty State */
    .empty-state {
        background: var(--surface-color);
        border-radius: var(--radius-lg);
        padding: var(--space-xl);
        box-shadow: var(--shadow-md);
    }

    .empty-state-icon {
        margin-bottom: var(--space-lg);
    }

    .empty-state h4 {
        margin-bottom: var(--space-md);
        color: var(--text-primary);
    }

    .empty-state p {
        margin-bottom: var(--space-xl);
    }

    .empty-state-actions {
        display: flex;
        gap: var(--space-md);
        justify-content: center;
        flex-wrap: wrap;
    }

    /* Product Meta Tags */
    .product-meta {
        display: flex;
        gap: var(--space-xs);
        flex-wrap: wrap;
    }

    .meta-tag {
        font-size: var(--text-xs);
        padding: 2px 8px;
        border-radius: var(--radius-sm);
        display: inline-flex;
        align-items: center;
    }

    .meta-tag.featured {
        background: rgba(139, 69, 19, 0.1);
        color: var(--primary-color);
    }

    .meta-tag.best-seller {
        background: rgba(218, 165, 32, 0.1);
        color: var(--secondary-color);
    }

    /* Pagination */
    .pagination-wrapper {
        background: var(--surface-color);
        padding: var(--space-lg);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
    }

    .pagination-info {
        font-size: var(--text-sm);
    }

    .pagination-per-page select {
        max-width: 150px;
    }

    /* Custom Pagination */
    .custom-pagination {
        display: flex;
        gap: var(--space-xs);
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .custom-pagination .page-item {
        display: flex;
    }

    .custom-pagination .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 40px;
        height: 40px;
        padding: 0 var(--space-sm);
        border: 2px solid var(--border-color);
        border-radius: var(--radius-md);
        background: var(--surface-color);
        color: var(--text-primary);
        text-decoration: none;
        transition: var(--transition-fast);
        font-weight: 500;
    }

    .custom-pagination .page-link:hover {
        background: var(--primary-light);
        color: white;
        border-color: var(--primary-light);
    }

    .custom-pagination .page-item.active .page-link {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    .custom-pagination .page-item.disabled .page-link {
        opacity: 0.5;
        cursor: not-allowed;
        background: var(--border-color);
    }

    /* Responsive Design */
    @media (max-width: 992px) {
        .hero-section {
            padding-top: 100px;
        }

        .hero-section .hero-title {
            font-size: var(--text-3xl);
        }

        .sidebar {
            position: static;
            margin-bottom: var(--space-lg);
        }

        .products-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .pagination-wrapper {
            flex-direction: column;
            gap: var(--space-md);
        }

        .pagination-info,
        .pagination-per-page {
            text-align: center;
        }
    }

    @media (max-width: 768px) {
        .products-grid {
            grid-template-columns: 1fr;
        }

        .empty-state-actions {
            flex-direction: column;
        }

        .empty-state-actions .btn {
            width: 100%;
        }
    }

    @media (max-width: 576px) {
        .filter-bar .row {
            flex-direction: column;
            gap: var(--space-md);
        }

        .filter-bar .col-md-8,
        .filter-bar .col-md-4 {
            width: 100%;
        }

        .pagination-wrapper .d-flex {
            flex-direction: column;
            gap: var(--space-md);
            align-items: center;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Price range filter
        const priceRange = document.getElementById('price-range');
        const priceValue = document.getElementById('price-value');

        if (priceRange && priceValue) {
            priceRange.addEventListener('input', function() {
                priceValue.textContent = this.value;
            });

            document.getElementById('price-filter-form').addEventListener('submit', function(e) {
                e.preventDefault();
                const maxPrice = priceRange.value;
                if (maxPrice > 0) {
                    const params = new URLSearchParams(window.location.search);
                    params.set('max_price', maxPrice);
                    window.location.href = `{{ route('shop.index') }}?${params.toString()}`;
                }
            });
        }

        // Checkbox filters
        const checkboxes = ['featured', 'best-seller', 'new-arrival', 'sale'];
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
        const sortSelect = document.getElementById('sort-select');
        if (sortSelect) {
            sortSelect.addEventListener('change', function() {
                const params = new URLSearchParams(window.location.search);
                params.set('sort', this.value);
                window.location.href = `{{ route('shop.index') }}?${params.toString()}`;
            });
        }

        // Items per page select
        const perPageSelect = document.getElementById('per-page-select');
        if (perPageSelect) {
            perPageSelect.addEventListener('change', function() {
                const params = new URLSearchParams(window.location.search);
                params.set('per_page', this.value);
                params.set('page', '1'); // Reset to first page
                window.location.href = `{{ route('shop.index') }}?${params.toString()}`;
            });
        }

        // Add to cart functionality
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

        // Wishlist toggle
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

        // Toast notification function
        function showToast(message, type = 'info') {
            const container = document.getElementById('toastContainer');
            if (!container) return;

            const toast = document.createElement('div');
            toast.className = `toast show align-items-center text-white bg-${type === 'error' ? 'danger' : type} border-0`;
            toast.setAttribute('role', 'alert');
            toast.setAttribute('aria-live', 'assertive');
            toast.setAttribute('aria-atomic', 'true');

            toast.innerHTML = `
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas ${getToastIcon(type)} me-2"></i>
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            `;

            container.appendChild(toast);

            // Initialize Bootstrap toast
            const bsToast = new bootstrap.Toast(toast, {
                delay: 3000
            });
            bsToast.show();

            // Remove toast after it hides
            toast.addEventListener('hidden.bs.toast', () => {
                toast.remove();
            });
        }

        function getToastIcon(type) {
            switch (type) {
                case 'success':
                    return 'fa-check-circle';
                case 'error':
                    return 'fa-exclamation-circle';
                case 'warning':
                    return 'fa-exclamation-triangle';
                default:
                    return 'fa-info-circle';
            }
        }
    });
</script>
@endpush