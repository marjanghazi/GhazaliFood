@extends('layouts.app')

@section('title', 'Shop - Premium Dry Fruits Store | Ghazali Food')

@section('hero')
<!-- Shop Hero -->
<section class="hero-section">
    <div class="container">
        <div class="hero-content text-center">
            <h1 class="hero-title animate__animated animate__slideUp">Our Premium Collection</h1>
            <p class="hero-subtitle animate__animated animate__slideUp delay-1">
                Discover exquisite selection of 100% natural, organic dry fruits, nuts, and berries
            </p>
            <nav class="breadcrumb-wrapper animate__animated animate__slideUp delay-2">
                <div class="breadcrumb">
                    <a href="{{ url('/') }}" class="breadcrumb-item">Home</a>
                    <span class="breadcrumb-separator">/</span>
                    <span class="breadcrumb-item active">Shop</span>
                </div>
            </nav>
        </div>
    </div>
</section>
@endsection

@section('content')
<div class="container py-5">
    <div class="shop-container">
        <!-- Sidebar Filters -->
        <div class="shop-sidebar">
            <div class="sidebar-content">
                <!-- Categories Filter -->
                <div class="sidebar-section">
                    <h5 class="sidebar-title">Categories</h5>
                    <ul class="sidebar-list">
                        <li>
                            <a href="{{ route('shop.index') }}"
                                class="sidebar-link {{ !request()->has('category') ? 'active' : '' }}">
                                <span class="sidebar-text">All Categories</span>
                                <span class="sidebar-badge">{{ $totalProducts ?? 0 }}</span>
                            </a>
                        </li>
                        @foreach($categories as $category)
                        <li>
                            <a href="{{ route('shop.index', ['category' => $category->slug]) }}"
                                class="sidebar-link {{ request('category') == $category->slug ? 'active' : '' }}">
                                <span class="sidebar-text">{{ $category->name }}</span>
                                <span class="sidebar-badge">{{ $category->products_count ?? 0 }}</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Price Filter -->
                <div class="sidebar-section">
                    <h5 class="sidebar-title">Filter by Price</h5>
                    <form id="price-filter-form" class="price-filter">
                        <div class="price-range-wrapper">
                            <div class="price-display">
                                <span class="price-label">Price Range:</span>
                                <span class="price-value">$0 - $<span id="price-value">{{ ceil($maxPrice) }}</span></span>
                            </div>
                            <div class="price-slider-container">
                                <input type="range" class="price-slider" id="price-range"
                                    min="0" max="{{ ceil($maxPrice) }}"
                                    value="{{ ceil($maxPrice) }}">
                            </div>
                            <div class="price-labels">
                                <span>$0</span>
                                <span>${{ ceil($maxPrice) }}</span>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mt-3">
                            <i class="fas fa-filter me-2"></i>Apply Price Filter
                        </button>
                    </form>
                </div>

                <!-- Product Status Filter -->
                <div class="sidebar-section">
                    <h5 class="sidebar-title">Product Status</h5>
                    <div class="filter-checkboxes">
                        <div class="checkbox-item">
                            <input class="checkbox-input" type="checkbox" id="featured"
                                name="featured" {{ request()->has('featured') ? 'checked' : '' }}>
                            <label class="checkbox-label" for="featured">
                                <i class="fas fa-star me-2"></i>Featured Products
                            </label>
                        </div>
                        <div class="checkbox-item">
                            <input class="checkbox-input" type="checkbox" id="best-seller"
                                name="best_seller" {{ request()->has('best_seller') ? 'checked' : '' }}>
                            <label class="checkbox-label" for="best-seller">
                                <i class="fas fa-fire me-2"></i>Best Sellers
                            </label>
                        </div>
                        <div class="checkbox-item">
                            <input class="checkbox-input" type="checkbox" id="new-arrival"
                                name="new_arrival" {{ request()->has('new_arrival') ? 'checked' : '' }}>
                            <label class="checkbox-label" for="new-arrival">
                                <i class="fas fa-bell me-2"></i>New Arrivals
                            </label>
                        </div>
                        @if(request()->has('sale'))
                        <div class="checkbox-item">
                            <input class="checkbox-input" type="checkbox" id="sale"
                                name="sale" checked>
                            <label class="checkbox-label" for="sale">
                                <i class="fas fa-tag me-2"></i>On Sale
                            </label>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Sort Options -->
                <div class="sidebar-section">
                    <h5 class="sidebar-title">Sort By</h5>
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
                <div class="sidebar-section">
                    <a href="{{ route('shop.index') }}" class="btn btn-outline w-100">
                        <i class="fas fa-redo me-2"></i>Clear All Filters
                    </a>
                </div>
            </div>
        </div>

        <!-- Product Grid -->
        <div class="shop-main">
            <!-- Search and Filter Bar -->
            <div class="shop-header">
                <div class="search-filter-bar">
                    <form action="{{ route('shop.index') }}" method="GET" class="shop-search-form">
                        <div class="search-wrapper">
                            <i class="fas fa-search search-icon"></i>
                            <input type="text" class="search-input" name="search"
                                placeholder="Search almonds, cashews, dates..."
                                value="{{ request('search') }}"
                                aria-label="Search products">
                            <button class="search-btn" type="submit">
                                <i class="fas fa-arrow-right"></i>
                            </button>
                        </div>
                    </form>
                    <div class="results-info">
                        <span class="results-text">
                            Showing {{ $products->firstItem() }}-{{ $products->lastItem() }}
                            of {{ $products->total() }} products
                        </span>
                    </div>
                </div>

                <!-- Active Filters -->
                @if(request()->anyFilled(['category', 'search', 'featured', 'best_seller', 'new_arrival', 'sale', 'max_price']))
                <div class="active-filters">
                    <span class="filters-label">Active Filters:</span>
                    <div class="filters-tags">
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
                        @if(request('best_seller'))
                        <span class="filter-tag">
                            Best Seller
                            <a href="{{ route('shop.index', request()->except('best_seller')) }}" class="remove-filter">
                                <i class="fas fa-times"></i>
                            </a>
                        </span>
                        @endif
                        @if(request('new_arrival'))
                        <span class="filter-tag">
                            New Arrival
                            <a href="{{ route('shop.index', request()->except('new_arrival')) }}" class="remove-filter">
                                <i class="fas fa-times"></i>
                            </a>
                        </span>
                        @endif
                        @if(request('sale'))
                        <span class="filter-tag">
                            On Sale
                            <a href="{{ route('shop.index', request()->except('sale')) }}" class="remove-filter">
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
            </div>

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
                                @if($i <= floor($product->average_rating))
                                <i class="fas fa-star"></i>
                                @elseif($i - 0.5 <= $product->average_rating)
                                <i class="fas fa-star-half-alt"></i>
                                @else
                                <i class="far fa-star"></i>
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

                        <div class="product-meta">
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
            <div class="pagination-wrapper">
                <div class="pagination-container">
                    <div class="pagination-info">
                        <span class="pagination-text">
                            Page {{ $products->currentPage() }} of {{ $products->lastPage() }}
                        </span>
                    </div>
                    <div class="pagination-links">
                        {{ $products->onEachSide(1)->links() }}
                    </div>
                    <div class="pagination-per-page">
                        <select class="form-select" id="per-page-select">
                            <option value="12" {{ request('per_page') == 12 ? 'selected' : '' }}>12 per page</option>
                            <option value="24" {{ request('per_page') == 24 ? 'selected' : '' }}>24 per page</option>
                            <option value="36" {{ request('per_page') == 36 ? 'selected' : '' }}>36 per page</option>
                            <option value="48" {{ request('per_page') == 48 ? 'selected' : '' }}>48 per page</option>
                        </select>
                    </div>
                </div>
            </div>
            @else
            <div class="empty-state">
                <div class="empty-state-content">
                    <div class="empty-state-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <h4>No products found</h4>
                    <p class="empty-state-text">Try adjusting your search or filter criteria</p>
                    <div class="empty-state-actions">
                        <a href="{{ route('shop.index') }}" class="btn btn-primary">
                            <i class="fas fa-redo me-2"></i>Clear All Filters
                        </a>
                        <a href="{{ route('shop.index', ['new_arrival' => true]) }}" class="btn btn-outline">
                            <i class="fas fa-bell me-2"></i>View New Arrivals
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Newsletter Section -->
<section class="newsletter-section">
    <div class="container">
        <div class="newsletter-container">
            <div class="newsletter-content">
                <h2 class="newsletter-title">Stay Updated</h2>
                <p class="newsletter-text">Subscribe to our newsletter for exclusive offers, new arrivals, and health tips!</p>
            </div>
            <form class="newsletter-form">
                <div class="newsletter-input-group">
                    <input type="email"
                        class="newsletter-input"
                        placeholder="Enter your email address"
                        required
                        aria-label="Email for newsletter">
                    <button type="submit" class="newsletter-btn">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
                <p class="newsletter-note">We respect your privacy. Unsubscribe at any time.</p>
            </form>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    /* Hero Section */
    .hero-section {
        padding: var(--space-2xl) 0 var(--space-xl);
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-color) 100%);
        position: relative;
        overflow: hidden;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            radial-gradient(circle at 10% 20%, rgba(212, 175, 55, 0.1) 0%, transparent 40%),
            radial-gradient(circle at 90% 80%, rgba(17, 80, 40, 0.1) 0%, transparent 40%);
    }

    .hero-content {
        position: relative;
        z-index: 2;
        text-align: center;
        max-width: 800px;
        margin: 0 auto;
    }

    .hero-title {
        font-size: var(--text-4xl);
        color: white;
        margin-bottom: var(--space-md);
        font-weight: 700;
    }

    .hero-subtitle {
        font-size: var(--text-lg);
        color: rgba(255, 255, 255, 0.9);
        margin-bottom: var(--space-xl);
        line-height: 1.6;
    }

    .breadcrumb-wrapper {
        margin-top: var(--space-lg);
    }

    .breadcrumb {
        display: inline-flex;
        align-items: center;
        gap: var(--space-xs);
        background: rgba(255, 255, 255, 0.1);
        padding: var(--space-sm) var(--space-lg);
        border-radius: var(--radius-full);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }

    .breadcrumb-item {
        color: rgba(255, 255, 255, 0.9);
        text-decoration: none;
        font-size: var(--text-sm);
        font-weight: 500;
        transition: var(--transition-fast);
    }

    .breadcrumb-item:hover {
        color: white;
    }

    .breadcrumb-item.active {
        color: var(--accent-color);
        font-weight: 600;
    }

    .breadcrumb-separator {
        color: rgba(255, 255, 255, 0.6);
        font-size: var(--text-xs);
    }

    /* Shop Container */
    .shop-container {
        display: grid;
        grid-template-columns: 300px 1fr;
        gap: var(--space-xl);
    }

    /* Sidebar */
    .shop-sidebar {
        position: sticky;
        top: calc(var(--header-height) + var(--space-lg));
        height: fit-content;
    }

    .sidebar-content {
        background: var(--surface-color);
        border-radius: var(--radius-lg);
        padding: var(--space-lg);
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border-color);
    }

    .sidebar-section {
        margin-bottom: var(--space-xl);
    }

    .sidebar-section:last-child {
        margin-bottom: 0;
    }

    .sidebar-title {
        font-size: var(--text-lg);
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: var(--space-md);
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
        padding: var(--space-sm) var(--space-md);
        color: var(--text-secondary);
        text-decoration: none;
        border-radius: var(--radius-md);
        transition: var(--transition-normal);
        border-left: 3px solid transparent;
    }

    .sidebar-link:hover {
        background: var(--primary-color);
        color: white;
        border-left-color: var(--accent-color);
        transform: translateX(5px);
    }

    .sidebar-link.active {
        background: linear-gradient(90deg, var(--primary-color) 0%, transparent 100%);
        color: white;
        border-left-color: var(--accent-color);
    }

    .sidebar-text {
        font-weight: 500;
    }

    .sidebar-badge {
        background: var(--surface-color);
        color: var(--text-primary);
        font-size: var(--text-xs);
        padding: 2px 8px;
        border-radius: var(--radius-full);
        font-weight: 600;
        min-width: 30px;
        text-align: center;
    }

    .sidebar-link:hover .sidebar-badge {
        background: white;
        color: var(--primary-color);
    }

    .sidebar-link.active .sidebar-badge {
        background: white;
        color: var(--primary-color);
    }

    /* Price Filter */
    .price-filter {
        width: 100%;
    }

    .price-range-wrapper {
        padding: var(--space-md) 0;
    }

    .price-display {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: var(--space-lg);
        padding: var(--space-md);
        background: var(--background-color);
        border-radius: var(--radius-md);
        border: 1px solid var(--border-color);
    }

    .price-label {
        font-weight: 500;
        color: var(--text-primary);
        font-size: var(--text-sm);
    }

    .price-value {
        font-weight: 700;
        color: var(--primary-color);
        font-size: var(--text-lg);
    }

    .price-slider-container {
        padding: var(--space-lg) 0;
    }

    .price-slider {
        width: 100%;
        height: 6px;
        -webkit-appearance: none;
        background: var(--border-color);
        border-radius: var(--radius-full);
        outline: none;
    }

    .price-slider::-webkit-slider-thumb {
        -webkit-appearance: none;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        background: var(--primary-color);
        cursor: pointer;
        border: 3px solid white;
        box-shadow: var(--shadow-md);
        transition: var(--transition-normal);
    }

    .price-slider::-webkit-slider-thumb:hover {
        background: var(--accent-color);
        transform: scale(1.1);
    }

    .price-slider::-moz-range-thumb {
        width: 22px;
        height: 22px;
        border-radius: 50%;
        background: var(--primary-color);
        cursor: pointer;
        border: 3px solid white;
        box-shadow: var(--shadow-md);
    }

    .price-labels {
        display: flex;
        justify-content: space-between;
        font-size: var(--text-sm);
        color: var(--text-muted);
        margin-top: var(--space-sm);
    }

    /* Filter Checkboxes */
    .filter-checkboxes {
        display: flex;
        flex-direction: column;
        gap: var(--space-sm);
    }

    .checkbox-item {
        display: flex;
        align-items: center;
    }

    .checkbox-input {
        display: none;
    }

    .checkbox-label {
        display: flex;
        align-items: center;
        padding: var(--space-sm) var(--space-md);
        color: var(--text-secondary);
        border-radius: var(--radius-md);
        cursor: pointer;
        transition: var(--transition-normal);
        width: 100%;
        user-select: none;
        border: 1px solid transparent;
    }

    .checkbox-label:hover {
        background: var(--background-color);
        border-color: var(--border-color);
    }

    .checkbox-input:checked + .checkbox-label {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    .checkbox-label i {
        width: 20px;
        text-align: center;
    }

    /* Sort Options */
    .sort-options .form-select {
        background: var(--background-color);
        border: 1px solid var(--border-color);
        color: var(--text-primary);
        padding: var(--space-sm) var(--space-md);
        border-radius: var(--radius-md);
        font-weight: 500;
        transition: var(--transition-normal);
    }

    .sort-options .form-select:focus {
        border-color: var(--accent-color);
        box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.1);
    }

    /* Shop Header */
    .shop-header {
        margin-bottom: var(--space-xl);
    }

    .search-filter-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: var(--space-lg);
        margin-bottom: var(--space-md);
    }

    .shop-search-form {
        flex: 1;
        max-width: 500px;
    }

    .search-wrapper {
        position: relative;
        width: 100%;
    }

    .search-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        font-size: 16px;
    }

    .search-input {
        width: 100%;
        padding: 12px 52px 12px 44px;
        border: 2px solid var(--border-color);
        border-radius: var(--radius-full);
        background: var(--surface-color);
        color: var(--text-primary);
        font-size: var(--text-base);
        transition: var(--transition-normal);
        font-weight: 500;
    }

    .search-input:focus {
        outline: none;
        border-color: var(--accent-color);
        box-shadow: 0 0 0 4px rgba(212, 175, 55, 0.1);
    }

    .search-btn {
        position: absolute;
        right: 6px;
        top: 50%;
        transform: translateY(-50%);
        background: var(--gradient-gold);
        border: none;
        color: var(--text-primary);
        cursor: pointer;
        padding: 8px;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: var(--transition-normal);
    }

    .search-btn:hover {
        transform: translateY(-50%) scale(1.1) rotate(10deg);
    }

    .results-info {
        flex-shrink: 0;
    }

    .results-text {
        font-size: var(--text-sm);
        color: var(--text-muted);
        font-weight: 500;
    }

    /* Active Filters */
    .active-filters {
        background: var(--surface-color);
        padding: var(--space-md);
        border-radius: var(--radius-md);
        border: 1px solid var(--border-color);
    }

    .filters-label {
        display: block;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: var(--space-sm);
        font-size: var(--text-sm);
    }

    .filters-tags {
        display: flex;
        flex-wrap: wrap;
        gap: var(--space-xs);
    }

    .filter-tag {
        display: inline-flex;
        align-items: center;
        gap: var(--space-xs);
        background: var(--primary-color);
        color: white;
        padding: 6px 12px;
        border-radius: var(--radius-full);
        font-size: var(--text-xs);
        font-weight: 500;
        transition: var(--transition-fast);
    }

    .filter-tag:hover {
        background: var(--primary-dark);
    }

    .remove-filter {
        color: white;
        text-decoration: none;
        opacity: 0.8;
        transition: var(--transition-fast);
        display: flex;
        align-items: center;
        justify-content: center;
        width: 16px;
        height: 16px;
        border-radius: 50%;
    }

    .remove-filter:hover {
        opacity: 1;
        background: rgba(255, 255, 255, 0.2);
    }

    /* Products Grid */
    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: var(--space-lg);
        margin-bottom: var(--space-2xl);
    }

    .product-card {
        background: var(--surface-color);
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-md);
        transition: all 0.3s ease;
        height: 100%;
        border: 1px solid var(--border-color);
    }

    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-xl);
        border-color: var(--accent-color);
    }

    .product-image {
        position: relative;
        height: 240px;
        overflow: hidden;
    }

    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .product-card:hover .product-image img {
        transform: scale(1.1);
    }

    .product-badge {
        position: absolute;
        top: 12px;
        left: 12px;
        padding: 6px 12px;
        font-size: var(--text-xs);
        font-weight: 700;
        border-radius: var(--radius-full);
        color: white;
        z-index: 2;
        text-transform: uppercase;
    }

    .badge-new {
        background: var(--gradient-primary);
    }

    .badge-sale {
        background: var(--gradient-gold);
        color: var(--text-primary);
    }

    .badge-featured {
        background: var(--primary-color);
    }

    .product-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to bottom, transparent, rgba(17, 80, 40, 0.8));
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: var(--transition-normal);
    }

    .product-card:hover .product-overlay {
        opacity: 1;
    }

    .product-actions {
        display: flex;
        gap: var(--space-xs);
        transform: translateY(20px);
        transition: transform 0.4s ease;
    }

    .product-card:hover .product-actions {
        transform: translateY(0);
    }

    .product-actions .btn {
        width: 44px;
        height: 44px;
        padding: 0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .product-actions .btn:hover {
        transform: scale(1.1);
    }

    .product-content {
        padding: var(--space-lg);
    }

    .product-category {
        font-size: var(--text-xs);
        color: var(--text-muted);
        margin-bottom: var(--space-xs);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .product-title {
        font-size: var(--text-lg);
        font-weight: 700;
        margin-bottom: var(--space-sm);
        line-height: 1.4;
    }

    .product-title a {
        color: var(--text-primary);
        text-decoration: none;
        transition: var(--transition-fast);
    }

    .product-title a:hover {
        color: var(--accent-color);
    }

    .product-rating {
        display: flex;
        align-items: center;
        gap: 4px;
        margin-bottom: var(--space-sm);
    }

    .product-rating i {
        color: var(--accent-color);
        font-size: 14px;
    }

    .rating-count {
        font-size: var(--text-sm);
        color: var(--text-muted);
        margin-left: 4px;
    }

    .product-price {
        display: flex;
        align-items: center;
        gap: var(--space-sm);
        margin-bottom: var(--space-md);
    }

    .current-price {
        font-size: var(--text-xl);
        font-weight: 700;
        color: var(--primary-color);
    }

    .old-price {
        font-size: var(--text-sm);
        color: var(--text-muted);
        text-decoration: line-through;
    }

    .discount {
        font-size: var(--text-xs);
        font-weight: 700;
        color: var(--danger-color);
        background: rgba(231, 76, 60, 0.1);
        padding: 2px 6px;
        border-radius: var(--radius-sm);
    }

    .product-meta {
        display: flex;
        gap: var(--space-xs);
        flex-wrap: wrap;
    }

    .meta-tag {
        font-size: var(--text-xs);
        padding: 4px 8px;
        border-radius: var(--radius-sm);
        display: inline-flex;
        align-items: center;
        font-weight: 500;
    }

    .meta-tag.featured {
        background: rgba(17, 80, 40, 0.1);
        color: var(--primary-color);
    }

    .meta-tag.best-seller {
        background: rgba(212, 175, 55, 0.1);
        color: var(--accent-color);
    }

    /* Pagination */
    .pagination-wrapper {
        background: var(--surface-color);
        padding: var(--space-lg);
        border-radius: var(--radius-lg);
        border: 1px solid var(--border-color);
    }

    .pagination-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: var(--space-md);
    }

    .pagination-info {
        flex-shrink: 0;
    }

    .pagination-text {
        font-size: var(--text-sm);
        color: var(--text-muted);
        font-weight: 500;
    }

    .pagination-links {
        flex: 1;
        display: flex;
        justify-content: center;
    }

    .pagination-per-page {
        flex-shrink: 0;
    }

    .pagination-per-page .form-select {
        background: var(--background-color);
        border: 1px solid var(--border-color);
        color: var(--text-primary);
        padding: var(--space-xs) var(--space-sm);
        border-radius: var(--radius-md);
        font-size: var(--text-sm);
    }

    /* Empty State */
    .empty-state {
        background: var(--surface-color);
        border-radius: var(--radius-lg);
        padding: var(--space-2xl);
        text-align: center;
        border: 1px solid var(--border-color);
    }

    .empty-state-content {
        max-width: 500px;
        margin: 0 auto;
    }

    .empty-state-icon {
        width: 80px;
        height: 80px;
        background: var(--background-color);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto var(--space-lg);
        color: var(--text-muted);
        font-size: 32px;
    }

    .empty-state h4 {
        font-size: var(--text-xl);
        color: var(--text-primary);
        margin-bottom: var(--space-sm);
        font-weight: 600;
    }

    .empty-state-text {
        color: var(--text-secondary);
        margin-bottom: var(--space-xl);
        line-height: 1.6;
    }

    .empty-state-actions {
        display: flex;
        gap: var(--space-md);
        justify-content: center;
        flex-wrap: wrap;
    }

    /* Newsletter Section */
    .newsletter-section {
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-color) 50%, var(--accent-color) 100%);
        padding: var(--space-xl) 0;
        margin-top: var(--space-2xl);
        position: relative;
        overflow: hidden;
    }

    .newsletter-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: var(--space-xl);
    }

    .newsletter-content {
        flex: 1;
    }

    .newsletter-title {
        color: white;
        font-size: var(--text-2xl);
        font-weight: 700;
        margin-bottom: var(--space-sm);
    }

    .newsletter-text {
        color: rgba(255, 255, 255, 0.9);
        font-size: var(--text-lg);
        line-height: 1.5;
    }

    .newsletter-form {
        flex: 1;
        max-width: 500px;
    }

    .newsletter-input-group {
        display: flex;
        gap: var(--space-xs);
        margin-bottom: var(--space-sm);
    }

    .newsletter-input {
        flex: 1;
        padding: 14px 20px;
        border: 2px solid rgba(255, 255, 255, 0.2);
        border-radius: var(--radius-full);
        background: rgba(255, 255, 255, 0.1);
        color: white;
        font-size: var(--text-base);
        transition: var(--transition-normal);
    }

    .newsletter-input:focus {
        outline: none;
        border-color: white;
        background: rgba(255, 255, 255, 0.15);
    }

    .newsletter-input::placeholder {
        color: rgba(255, 255, 255, 0.7);
    }

    .newsletter-btn {
        background: white;
        border: none;
        color: var(--primary-color);
        padding: 14px 28px;
        border-radius: var(--radius-full);
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition-normal);
        display: flex;
        align-items: center;
        gap: var(--space-xs);
    }

    .newsletter-btn:hover {
        background: var(--gradient-gold);
        color: white;
        transform: translateY(-2px);
    }

    .newsletter-note {
        color: rgba(255, 255, 255, 0.7);
        font-size: var(--text-xs);
        margin-top: var(--space-xs);
    }

    /* Responsive Design */
    @media (max-width: 1200px) {
        .shop-container {
            grid-template-columns: 280px 1fr;
        }
    }

    @media (max-width: 992px) {
        .shop-container {
            grid-template-columns: 1fr;
        }

        .shop-sidebar {
            position: static;
        }

        .search-filter-bar {
            flex-direction: column;
            align-items: stretch;
        }

        .shop-search-form {
            max-width: 100%;
        }

        .results-info {
            text-align: center;
        }

        .products-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .pagination-container {
            flex-direction: column;
            text-align: center;
        }

        .newsletter-container {
            flex-direction: column;
            text-align: center;
        }

        .newsletter-form {
            max-width: 100%;
        }
    }

    @media (max-width: 768px) {
        .hero-title {
            font-size: var(--text-3xl);
        }

        .hero-subtitle {
            font-size: var(--text-base);
        }

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
        .hero-title {
            font-size: var(--text-2xl);
        }

        .hero-subtitle {
            font-size: var(--text-sm);
        }

        .breadcrumb {
            padding: var(--space-xs) var(--space-md);
            font-size: var(--text-xs);
        }

        .sidebar-content {
            padding: var(--space-md);
        }

        .active-filters {
            padding: var(--space-sm);
        }

        .filters-tags {
            justify-content: center;
        }

        .product-image {
            height: 200px;
        }
    }

    /* Custom Pagination Styles */
    .pagination {
        display: flex;
        gap: var(--space-xs);
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .page-item {
        display: flex;
    }

    .page-item.active .page-link {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    .page-item.disabled .page-link {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .page-link {
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
        font-weight: 500;
        transition: var(--transition-fast);
    }

    .page-link:hover {
        background: var(--primary-light);
        color: white;
        border-color: var(--primary-light);
    }

    .page-item.active .page-link {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
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
        document.querySelectorAll('.checkbox-input').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const params = new URLSearchParams(window.location.search);
                if (this.checked) {
                    params.set(this.name, 'true');
                } else {
                    params.delete(this.name);
                }
                window.location.href = `{{ route('shop.index') }}?${params.toString()}`;
            });
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
                params.set('page', '1');
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
                        document.querySelectorAll('.cart-btn .badge').forEach(element => {
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
                        // Update button icon
                        const icon = this.querySelector('i');
                        if (data.in_wishlist) {
                            icon.classList.remove('far');
                            icon.classList.add('fas', 'text-danger');
                        } else {
                            icon.classList.remove('fas', 'text-danger');
                            icon.classList.add('far');
                        }

                        // Update wishlist count
                        document.querySelectorAll('.wishlist-btn .badge').forEach(element => {
                            element.textContent = data.wishlist_count || 0;
                            element.style.display = data.wishlist_count > 0 ? 'flex' : 'none';
                        });

                        showToast(data.message, 'success');
                    }
                } catch (error) {
                    console.error('Error toggling wishlist:', error);
                    showToast('Network error. Please try again.', 'error');
                }
            });
        });

        // Toast notification function
        window.showToast = function(message, type = 'success') {
            const container = document.getElementById('toastContainer');
            if (!container) return;

            const toast = document.createElement('div');
            toast.className = `toast toast-${type} animate__animated animate__fadeInRight`;
            toast.innerHTML = `
                <div class="toast-content">
                    <div class="toast-icon">
                        <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
                    </div>
                    <div class="toast-body">
                        <span class="toast-message">${message}</span>
                    </div>
                </div>
                <button class="toast-close">
                    <i class="fas fa-times"></i>
                </button>
            `;

            container.appendChild(toast);

            setTimeout(() => {
                toast.classList.add('show');
            }, 10);

            const autoRemove = setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }, 5000);

            toast.querySelector('.toast-close').addEventListener('click', () => {
                clearTimeout(autoRemove);
                toast.classList.remove('show');
                setTimeout(() => {
                    toast.remove();
                }, 300);
            });
        };
    });
</script>
@endpush