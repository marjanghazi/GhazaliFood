@extends('layouts.app')

@section('title', 'Blog | Health Tips & Recipes | Premium Dry Fruits Store | Nuts & Berries')

@section('hero')
<!-- Hero Section -->
<section class="hero-section blog-hero">
    <div class="container">
        <div class="row align-items-center min-vh-70">
            <div class="col-lg-6">
                <div class="hero-content animate-slide-up">
                    <div class="hero-badge animate-bounce">
                        <i class="fas fa-newspaper me-2"></i> Latest Insights
                    </div>
                    <h1 class="hero-title">The Nuts & Berries Blog</h1>
                    <p class="hero-subtitle">
                        Discover delicious recipes, health benefits, and expert tips
                        for incorporating premium dry fruits into your daily life.
                    </p>
                    <div class="hero-buttons">
                        <a href="#latest-posts" class="btn btn-primary btn-lg">
                            <i class="fas fa-book-open me-2"></i> Read Articles
                        </a>
                        <a href="#newsletter" class="btn btn-outline btn-lg">
                            <i class="fas fa-envelope me-2"></i> Subscribe
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-image-wrapper">
                    <div class="hero-image">
                        <img src="https://images.unsplash.com/photo-1490818387583-1baba5e638af?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                            alt="Premium Dry Fruits Blog"
                            class="img-fluid rounded-3">
                        <div class="hero-image-badge">
                            <i class="fas fa-heart me-2"></i> Healthy Living
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('content')
<!-- Blog Content -->
<section class="py-5" id="latest-posts">
    <div class="container">
        <!-- Page Header -->
        <div class="page-header mb-5">
            <h2 class="page-title">Latest Articles</h2>
            <p class="page-subtitle">Expert insights on dry fruits, nutrition, and healthy living</p>
            
            <!-- Quick Stats -->
            <div class="quick-stats mt-4">
                <div class="stat-item">
                    <i class="fas fa-newspaper stat-icon"></i>
                    <div class="stat-content">
                        <span class="stat-number">{{ $totalPosts ?? 0 }}</span>
                        <span class="stat-label">Total Articles</span>
                    </div>
                </div>
                <div class="stat-item">
                    <i class="fas fa-users stat-icon"></i>
                    <div class="stat-content">
                        <span class="stat-number">{{ $authorsCount ?? 5 }}+</span>
                        <span class="stat-label">Expert Writers</span>
                    </div>
                </div>
                <div class="stat-item">
                    <i class="fas fa-tags stat-icon"></i>
                    <div class="stat-content">
                        <span class="stat-number">{{ count($categories ?? []) }}</span>
                        <span class="stat-label">Categories</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Blog Posts -->
            <div class="col-lg-8">
                <!-- Filter Bar -->
                <div class="filter-bar mb-4">
                    <div class="row g-3 align-items-center">
                        <div class="col-md-6">
                            <div class="view-options">
                                <button class="view-option active" data-view="grid">
                                    <i class="fas fa-th-large"></i>
                                </button>
                                <button class="view-option" data-view="list">
                                    <i class="fas fa-list"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="sort-options">
                                <select class="form-select" id="sort-articles">
                                    <option value="latest">Latest First</option>
                                    <option value="popular">Most Popular</option>
                                    <option value="trending">Trending</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Blog Grid/List -->
                <div class="blog-container grid-view" id="blogContainer">
                    @foreach($blogs as $blog)
                    <div class="blog-card">
                        <div class="blog-card-inner">
                            <div class="blog-image">
                                <img src="{{ $blog->featured_image ? asset('storage/' . $blog->featured_image) : 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80' }}"
                                    alt="{{ $blog->title }}">
                                <div class="blog-image-overlay">
                                    <a href="{{ route('blog.show', $blog->slug) }}" class="btn btn-primary btn-sm">
                                        Read Article
                                    </a>
                                </div>
                                <div class="blog-category">
                                    {{ $blog->category }}
                                </div>
                                @if($blog->is_featured ?? false)
                                <div class="blog-featured">
                                    <i class="fas fa-star"></i>
                                </div>
                                @endif
                            </div>
                            
                            <div class="blog-content">
                                <div class="blog-meta">
                                    <span class="blog-date">
                                        <i class="far fa-calendar me-1"></i>
                                        {{ $blog->published_at->format('M d, Y') }}
                                    </span>
                                    <span class="blog-read-time">
                                        <i class="far fa-clock me-1"></i>
                                        {{ $blog->read_time ?? '5' }} min read
                                    </span>
                                    @if($blog->views_count ?? 0 > 0)
                                    <span class="blog-views">
                                        <i class="far fa-eye me-1"></i>
                                        {{ $blog->views_count ?? 0 }}
                                    </span>
                                    @endif
                                </div>

                                <h3 class="blog-title">
                                    <a href="{{ route('blog.show', $blog->slug ) }}">
                                        {{ Str::limit($blog->title, 70) }}
                                    </a>
                                </h3>

                                <p class="blog-excerpt">
                                    {{ Str::limit($blog->brief_description, 120) }}
                                </p>

                                <div class="blog-tags">
                                    @php
                                        $tags = explode(',', $blog->tags ?? '');
                                    @endphp
                                    @foreach(array_slice($tags, 0, 3) as $tag)
                                        @if(trim($tag))
                                        <span class="blog-tag">{{ trim($tag) }}</span>
                                        @endif
                                    @endforeach
                                </div>

                                <div class="blog-footer">
                                    <div class="blog-author">
                                        <img src="{{ $blog->author->avatar_url ?? 'https://i.pravatar.cc/40?img=' . $blog->author_id }}"
                                            class="blog-author-avatar"
                                            alt="{{ $blog->author->name }}">
                                        <div class="blog-author-info">
                                            <span class="blog-author-name">{{ $blog->author->name }}</span>
                                            <span class="blog-author-title">{{ $blog->author->title ?? 'Nutrition Expert' }}</span>
                                        </div>
                                    </div>
                                    <a href="{{ route('blog.show', $blog->slug) }}" class="blog-read-more">
                                        Continue Reading <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($blogs->hasPages())
                <div class="pagination-wrapper mt-5">
                    <div class="pagination-container">
                        <div class="pagination-info">
                            <span class="pagination-text">
                                Showing {{ $blogs->firstItem() }}-{{ $blogs->lastItem() }} 
                                of {{ $blogs->total() }} articles
                            </span>
                        </div>
                        <div class="pagination-links">
                            {{ $blogs->onEachSide(1)->links('vendor.pagination.custom') }}
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="blog-sidebar">
                    <!-- Search -->
                    <div class="sidebar-widget search-widget">
                        <h4 class="widget-title">
                            <i class="fas fa-search me-2"></i> Search Articles
                        </h4>
                        <form action="{{ route('blog.index') }}" method="GET" class="blog-search-form">
                            <div class="input-group">
                                <input type="text"
                                    class="form-control"
                                    name="search"
                                    placeholder="Search for articles..."
                                    value="{{ request('search') }}"
                                    aria-label="Search articles">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                            <div class="search-suggestions mt-2">
                                <small class="text-muted">Try: recipes, health benefits, cooking tips</small>
                            </div>
                        </form>
                    </div>

                    <!-- Categories -->
                    <div class="sidebar-widget categories-widget">
                        <h4 class="widget-title">
                            <i class="fas fa-folder me-2"></i> Categories
                        </h4>
                        <div class="categories-list">
                            <a href="{{ route('blog.index') }}"
                                class="category-item {{ !request('category') ? 'active' : '' }}">
                                <div class="category-content">
                                    <i class="fas fa-th-large me-2"></i>
                                    <span class="category-name">All Articles</span>
                                </div>
                                <span class="category-count">{{ $totalPosts ?? 0 }}</span>
                            </a>
                            @foreach($categories as $category)
                            @php
                                $categoryName = is_array($category) ? $category['name'] : $category;
                                $categorySlug = is_array($category) ? $category['slug'] : strtolower(str_replace(' ', '-', $category));
                                $categoryCount = is_array($category) ? $category['posts_count'] : 0;
                            @endphp
                            <a href="{{ route('blog.index', ['category' => $categorySlug]) }}"
                                class="category-item {{ request('category') == $categorySlug ? 'active' : '' }}">
                                <div class="category-content">
                                    <i class="fas fa-folder me-2"></i>
                                    <span class="category-name">{{ $categoryName }}</span>
                                </div>
                                <span class="category-count">{{ $categoryCount }}</span>
                            </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Recent Posts -->
                    <div class="sidebar-widget recent-posts-widget">
                        <h4 class="widget-title">
                            <i class="fas fa-history me-2"></i> Recent Articles
                        </h4>
                        <div class="recent-posts-list">
                            @foreach($recentPosts as $recent)
                            <div class="recent-post-item">
                                <a href="{{ route('blog.show', $recent->slug) }}" class="recent-post-link">
                                    <div class="recent-post-image">
                                        <img src="{{ $recent->featured_image ? asset('storage/' . $recent->featured_image) : 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80' }}"
                                            alt="{{ $recent->title }}">
                                    </div>
                                    <div class="recent-post-content">
                                        <h6 class="recent-post-title">{{ Str::limit($recent->title, 50) }}</h6>
                                        <div class="recent-post-meta">
                                            <span class="recent-post-date">
                                                <i class="far fa-calendar me-1"></i>
                                                {{ $recent->published_at->format('M d') }}
                                            </span>
                                            <span class="recent-post-category">
                                                {{ $recent->category }}
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Newsletter -->
                    <div class="sidebar-widget newsletter-widget" id="newsletter">
                        <div class="newsletter-card">
                            <div class="newsletter-header">
                                <div class="newsletter-icon">
                                    <i class="fas fa-paper-plane"></i>
                                </div>
                                <h5>Subscribe to Our Blog</h5>
                            </div>
                            <p class="newsletter-text">
                                Get the latest articles, recipes, and health tips delivered to your inbox.
                            </p>
                            <form class="newsletter-form" id="sidebar-newsletter-form">
                                <div class="form-group">
                                    <input type="email"
                                        class="form-control"
                                        placeholder="Your email address"
                                        required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-paper-plane me-2"></i> Subscribe Now
                                </button>
                                <p class="newsletter-disclaimer">
                                    <i class="fas fa-lock me-1"></i> We respect your privacy. Unsubscribe at any time.
                                </p>
                            </form>
                        </div>
                    </div>

                    <!-- Popular Tags -->
                    <div class="sidebar-widget tags-widget">
                        <h4 class="widget-title">
                            <i class="fas fa-tags me-2"></i> Popular Topics
                        </h4>
                        <div class="tags-cloud">
                            @php
                                $tags = ['Recipes', 'Health Benefits', 'Nutrition', 'Cooking Tips', 'Wellness',
                                'Almonds', 'Walnuts', 'Pistachios', 'Dates', 'Apricots', 'Organic',
                                'Healthy Snacks', 'Superfoods', 'Heart Health', 'Weight Management'];
                            @endphp
                            @foreach($tags as $tag)
                            <a href="{{ route('blog.index', ['tag' => $tag]) }}"
                                class="tag-item {{ request('tag') == $tag ? 'active' : '' }}">
                                {{ $tag }}
                            </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Featured Products -->
                    <div class="sidebar-widget products-widget">
                        <h4 class="widget-title">
                            <i class="fas fa-gift me-2"></i> Featured Products
                        </h4>
                        <div class="products-list">
                            <div class="product-item">
                                <a href="#" class="product-link">
                                    <div class="product-image">
                                        <img src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80"
                                            alt="Premium Almonds">
                                    </div>
                                    <div class="product-content">
                                        <h6 class="product-title">California Almonds</h6>
                                        <div class="product-price">$24.99</div>
                                    </div>
                                </a>
                            </div>
                            <div class="product-item">
                                <a href="#" class="product-link">
                                    <div class="product-image">
                                        <img src="https://images.unsplash.com/photo-1598965675045-45c0c0f58c00?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80"
                                            alt="Turkish Apricots">
                                    </div>
                                    <div class="product-content">
                                        <h6 class="product-title">Turkish Apricots</h6>
                                        <div class="product-price">$18.99</div>
                                    </div>
                                </a>
                            </div>
                            <div class="product-item">
                                <a href="#" class="product-link">
                                    <div class="product-image">
                                        <img src="https://images.unsplash.com/photo-1551183053-bf91a1d81141?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80"
                                            alt="Iranian Pistachios">
                                    </div>
                                    <div class="product-content">
                                        <h6 class="product-title">Iranian Pistachios</h6>
                                        <div class="product-price">$29.99</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="widget-footer">
                            <a href="{{ route('shop.index') }}" class="btn btn-outline btn-sm w-100">
                                <i class="fas fa-store me-2"></i> Shop All Products
                            </a>
                        </div>
                    </div>

                    <!-- Social Follow -->
                    <div class="sidebar-widget social-widget">
                        <h4 class="widget-title">
                            <i class="fas fa-share-alt me-2"></i> Follow Us
                        </h4>
                        <div class="social-links">
                            <a href="#" class="social-link facebook" aria-label="Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="social-link instagram" aria-label="Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="social-link twitter" aria-label="Twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="social-link pinterest" aria-label="Pinterest">
                                <i class="fab fa-pinterest-p"></i>
                            </a>
                            <a href="#" class="social-link youtube" aria-label="YouTube">
                                <i class="fab fa-youtube"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Article -->
@if($featuredBlog)
<section class="featured-article-section py-5">
    <div class="container">
        <div class="section-header mb-5">
            <h2 class="section-title">Featured Article</h2>
            <p class="section-subtitle">Don't miss our most popular post</p>
        </div>

        <div class="featured-article-card">
            <div class="featured-article-wrapper">
                <div class="featured-article-image">
                    <img src="{{ $featuredBlog->featured_image ? asset('storage/' . $featuredBlog->featured_image) : 'https://images.unsplash.com/photo-1490818387583-1baba5e638af?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80' }}"
                        alt="{{ $featuredBlog->title }}">
                    <div class="featured-badge">
                        <i class="fas fa-star me-2"></i> Featured
                    </div>
                </div>
                <div class="featured-article-content">
                    <div class="featured-category">
                        {{ $featuredBlog->category }}
                    </div>
                    <h3 class="featured-title">{{ $featuredBlog->title }}</h3>
                    <p class="featured-excerpt">
                        {{ Str::limit($featuredBlog->brief_description, 200) }}
                    </p>
                    <div class="featured-meta">
                        <div class="featured-author">
                            <img src="{{ $featuredBlog->author->avatar_url ?? 'https://i.pravatar.cc/40?img=' . $featuredBlog->author_id }}"
                                alt="{{ $featuredBlog->author->name }}">
                            <div>
                                <div class="author-name">{{ $featuredBlog->author->name }}</div>
                                <div class="article-date">
                                    <i class="far fa-calendar me-1"></i>
                                    {{ $featuredBlog->published_at->format('F d, Y') }}
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('blog.show', $featuredBlog->slug) }}" class="btn btn-primary btn-lg">
                            Read Full Article <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Newsletter Section -->
<section class="newsletter-section py-5">
    <div class="container">
        <div class="newsletter-container">
            <div class="newsletter-content">
                <h2 class="newsletter-title">Never Miss an Update</h2>
                <p class="newsletter-text">
                    Subscribe to our newsletter for exclusive recipes, health tips,
                    special offers, and the latest articles from our blog.
                </p>
            </div>
            <div class="newsletter-form-wrapper">
                <form class="newsletter-form" id="main-newsletter-form">
                    <div class="input-group">
                        <input type="email"
                            class="form-control"
                            placeholder="Enter your email address"
                            required
                            aria-label="Email for newsletter">
                        <button type="submit" class="btn btn-primary btn-lg">
                            Subscribe <i class="fas fa-paper-plane ms-2"></i>
                        </button>
                    </div>
                    <p class="newsletter-disclaimer">
                        <i class="fas fa-lock me-1"></i> We respect your privacy. Unsubscribe at any time.
                    </p>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    /* Blog Hero Section */
    .blog-hero {
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-color) 100%);
        position: relative;
        overflow: hidden;
        padding: var(--space-2xl) 0;
    }

    .blog-hero::before {
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

    .hero-content .hero-badge {
        display: inline-flex;
        align-items: center;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        color: white;
        padding: 8px 16px;
        border-radius: var(--radius-full);
        font-weight: 600;
        margin-bottom: var(--space-lg);
        font-size: var(--text-sm);
    }

    .hero-content .hero-title {
        color: white;
        font-size: var(--text-4xl);
        margin-bottom: var(--space-md);
    }

    .hero-content .hero-subtitle {
        color: rgba(255, 255, 255, 0.9);
        font-size: var(--text-lg);
        margin-bottom: var(--space-xl);
        line-height: 1.6;
    }

    .hero-buttons {
        display: flex;
        gap: var(--space-md);
    }

    .hero-image-wrapper {
        position: relative;
    }

    .hero-image {
        border-radius: var(--radius-xl);
        overflow: hidden;
        box-shadow: var(--shadow-xl);
        position: relative;
    }

    .hero-image img {
        width: 100%;
        height: auto;
        transition: transform 0.6s ease;
    }

    .hero-image:hover img {
        transform: scale(1.05);
    }

    .hero-image-badge {
        position: absolute;
        bottom: 20px;
        right: 20px;
        background: var(--gradient-gold);
        color: var(--text-primary);
        padding: 8px 16px;
        border-radius: var(--radius-full);
        font-weight: 700;
        box-shadow: var(--shadow-lg);
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    /* Page Header */
    .page-header {
        text-align: center;
        padding-bottom: var(--space-lg);
        border-bottom: 2px solid var(--border-color);
    }

    .page-title {
        font-size: var(--text-3xl);
        color: var(--text-primary);
        margin-bottom: var(--space-sm);
    }

    .page-subtitle {
        color: var(--text-secondary);
        font-size: var(--text-lg);
    }

    .quick-stats {
        display: flex;
        justify-content: center;
        gap: var(--space-xl);
        margin-top: var(--space-lg);
    }

    .stat-item {
        text-align: center;
    }

    .stat-icon {
        font-size: 2rem;
        color: var(--primary-color);
        margin-bottom: var(--space-xs);
    }

    .stat-number {
        display: block;
        font-size: var(--text-2xl);
        font-weight: 700;
        color: var(--text-primary);
    }

    .stat-label {
        display: block;
        font-size: var(--text-sm);
        color: var(--text-muted);
    }

    /* Filter Bar */
    .filter-bar {
        background: var(--surface-color);
        padding: var(--space-md);
        border-radius: var(--radius-lg);
        border: 1px solid var(--border-color);
    }

    .view-options {
        display: flex;
        gap: var(--space-xs);
    }

    .view-option {
        background: var(--background-color);
        border: 1px solid var(--border-color);
        color: var(--text-muted);
        width: 40px;
        height: 40px;
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: var(--transition-normal);
    }

    .view-option:hover {
        border-color: var(--primary-color);
        color: var(--primary-color);
    }

    .view-option.active {
        background: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
    }

    .sort-options .form-select {
        background: var(--background-color);
        border: 1px solid var(--border-color);
        color: var(--text-primary);
        padding: 10px 16px;
        border-radius: var(--radius-md);
        font-weight: 500;
    }

    /* Blog Container */
    .blog-container {
        transition: all 0.3s ease;
    }

    .grid-view {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: var(--space-lg);
    }

    .list-view .blog-card {
        display: flex;
        flex-direction: row;
    }

    .list-view .blog-image {
        flex: 0 0 300px;
        height: auto;
    }

    .list-view .blog-content {
        flex: 1;
    }

    /* Blog Card */
    .blog-card {
        animation: fadeIn 0.6s ease-out;
    }

    .blog-card-inner {
        background: var(--surface-color);
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-md);
        transition: all 0.3s ease;
        height: 100%;
        border: 1px solid var(--border-color);
    }

    .blog-card:hover .blog-card-inner {
        transform: translateY(-5px);
        box-shadow: var(--shadow-xl);
        border-color: var(--accent-color);
    }

    .blog-image {
        position: relative;
        height: 220px;
        overflow: hidden;
    }

    .blog-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .blog-card:hover .blog-image img {
        transform: scale(1.1);
    }

    .blog-image-overlay {
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

    .blog-card:hover .blog-image-overlay {
        opacity: 1;
    }

    .blog-category {
        position: absolute;
        top: 20px;
        left: 20px;
        background: var(--gradient-primary);
        color: white;
        padding: 6px 16px;
        border-radius: var(--radius-full);
        font-size: var(--text-sm);
        font-weight: 600;
        z-index: 2;
    }

    .blog-featured {
        position: absolute;
        top: 20px;
        right: 20px;
        background: var(--gradient-gold);
        color: var(--text-primary);
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 2;
    }

    .blog-content {
        padding: var(--space-lg);
    }

    .blog-meta {
        display: flex;
        align-items: center;
        gap: var(--space-md);
        margin-bottom: var(--space-sm);
        font-size: var(--text-sm);
        color: var(--text-muted);
        flex-wrap: wrap;
    }

    .blog-meta i {
        color: var(--primary-color);
    }

    .blog-title {
        font-size: var(--text-xl);
        margin-bottom: var(--space-sm);
        line-height: 1.4;
    }

    .blog-title a {
        color: var(--text-primary);
        text-decoration: none;
        transition: var(--transition-fast);
    }

    .blog-title a:hover {
        color: var(--primary-color);
    }

    .blog-excerpt {
        color: var(--text-secondary);
        margin-bottom: var(--space-lg);
        line-height: 1.6;
        font-size: var(--text-base);
    }

    .blog-tags {
        display: flex;
        gap: var(--space-xs);
        flex-wrap: wrap;
        margin-bottom: var(--space-lg);
    }

    .blog-tag {
        background: var(--background-color);
        color: var(--text-secondary);
        padding: 4px 10px;
        border-radius: var(--radius-full);
        font-size: var(--text-xs);
        font-weight: 500;
        transition: var(--transition-fast);
    }

    .blog-tag:hover {
        background: var(--primary-color);
        color: white;
    }

    .blog-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: var(--space-md);
        border-top: 1px solid var(--border-color);
    }

    .blog-author {
        display: flex;
        align-items: center;
        gap: var(--space-sm);
    }

    .blog-author-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--border-color);
    }

    .blog-author-info {
        display: flex;
        flex-direction: column;
    }

    .blog-author-name {
        font-weight: 600;
        font-size: var(--text-sm);
    }

    .blog-author-title {
        font-size: var(--text-xs);
        color: var(--text-muted);
    }

    .blog-read-more {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 600;
        font-size: var(--text-sm);
        transition: var(--transition-fast);
        display: flex;
        align-items: center;
    }

    .blog-read-more:hover {
        color: var(--primary-dark);
        transform: translateX(5px);
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

    /* Sidebar */
    .blog-sidebar {
        position: sticky;
        top: calc(var(--header-height) + var(--space-lg));
    }

    .sidebar-widget {
        background: var(--surface-color);
        border-radius: var(--radius-lg);
        padding: var(--space-lg);
        margin-bottom: var(--space-lg);
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border-color);
        transition: var(--transition-normal);
    }

    .sidebar-widget:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .widget-title {
        font-size: var(--text-lg);
        color: var(--primary-color);
        margin-bottom: var(--space-md);
        padding-bottom: var(--space-sm);
        border-bottom: 2px solid var(--border-color);
        display: flex;
        align-items: center;
    }

    /* Search Widget */
    .search-widget .input-group {
        border-radius: var(--radius-md);
        overflow: hidden;
    }

    .search-widget .form-control {
        border: 2px solid var(--border-color);
        border-right: none;
    }

    .search-widget .btn {
        border: 2px solid var(--primary-color);
        background: var(--primary-color);
        color: white;
    }

    .search-suggestions {
        font-size: var(--text-sm);
    }

    /* Categories Widget */
    .categories-list {
        display: flex;
        flex-direction: column;
        gap: var(--space-xs);
    }

    .category-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: var(--space-sm);
        border-radius: var(--radius-md);
        color: var(--text-secondary);
        text-decoration: none;
        transition: var(--transition-fast);
        border-left: 3px solid transparent;
    }

    .category-item:hover,
    .category-item.active {
        background: var(--primary-light);
        color: white;
        border-left-color: var(--accent-color);
    }

    .category-content {
        display: flex;
        align-items: center;
    }

    .category-name {
        font-weight: 500;
    }

    .category-count {
        background: var(--border-color);
        color: var(--text-muted);
        padding: 2px 8px;
        border-radius: var(--radius-full);
        font-size: var(--text-xs);
        font-weight: 600;
        min-width: 30px;
        text-align: center;
    }

    .category-item:hover .category-count,
    .category-item.active .category-count {
        background: white;
        color: var(--primary-color);
    }

    /* Recent Posts Widget */
    .recent-posts-list {
        display: flex;
        flex-direction: column;
        gap: var(--space-md);
    }

    .recent-post-item {
        padding-bottom: var(--space-md);
        border-bottom: 1px solid var(--border-color);
    }

    .recent-post-item:last-child {
        padding-bottom: 0;
        border-bottom: none;
    }

    .recent-post-link {
        display: flex;
        gap: var(--space-sm);
        text-decoration: none;
        transition: var(--transition-fast);
    }

    .recent-post-link:hover {
        transform: translateX(5px);
    }

    .recent-post-image {
        width: 80px;
        height: 80px;
        flex-shrink: 0;
        border-radius: var(--radius-md);
        overflow: hidden;
    }

    .recent-post-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .recent-post-content {
        flex: 1;
    }

    .recent-post-title {
        color: var(--text-primary);
        font-size: var(--text-sm);
        margin-bottom: 6px;
        line-height: 1.4;
        font-weight: 600;
    }

    .recent-post-meta {
        display: flex;
        align-items: center;
        gap: var(--space-sm);
        font-size: var(--text-xs);
        color: var(--text-muted);
    }

    .recent-post-category {
        background: var(--border-color);
        color: var(--text-muted);
        padding: 2px 8px;
        border-radius: var(--radius-sm);
        font-size: 11px;
    }

    /* Newsletter Widget */
    .newsletter-card {
        text-align: center;
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        border-radius: var(--radius-lg);
        padding: var(--space-xl);
        color: white;
    }

    .newsletter-header {
        margin-bottom: var(--space-md);
    }

    .newsletter-icon {
        width: 60px;
        height: 60px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto var(--space-md);
        color: white;
        font-size: 1.5rem;
    }

    .newsletter-card h5 {
        margin-bottom: var(--space-sm);
        color: white;
    }

    .newsletter-text {
        color: rgba(255, 255, 255, 0.9);
        margin-bottom: var(--space-lg);
        line-height: 1.5;
    }

    .newsletter-form .form-control {
        margin-bottom: var(--space-sm);
        border: 2px solid rgba(255, 255, 255, 0.2);
        background: rgba(255, 255, 255, 0.1);
        color: white;
    }

    .newsletter-form .form-control::placeholder {
        color: rgba(255, 255, 255, 0.7);
    }

    .newsletter-disclaimer {
        font-size: var(--text-xs);
        color: rgba(255, 255, 255, 0.7);
        margin-top: var(--space-sm);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Tags Widget */
    .tags-cloud {
        display: flex;
        flex-wrap: wrap;
        gap: var(--space-xs);
    }

    .tag-item {
        padding: 6px 12px;
        background: var(--border-color);
        color: var(--text-secondary);
        border-radius: var(--radius-md);
        text-decoration: none;
        font-size: var(--text-sm);
        transition: var(--transition-fast);
    }

    .tag-item:hover,
    .tag-item.active {
        background: var(--gradient-primary);
        color: white;
    }

    /* Products Widget */
    .products-list {
        display: flex;
        flex-direction: column;
        gap: var(--space-md);
    }

    .product-item {
        padding-bottom: var(--space-md);
        border-bottom: 1px solid var(--border-color);
    }

    .product-item:last-child {
        padding-bottom: 0;
        border-bottom: none;
    }

    .product-link {
        display: flex;
        gap: var(--space-sm);
        text-decoration: none;
        transition: var(--transition-fast);
    }

    .product-link:hover {
        transform: translateX(5px);
    }

    .product-image {
        width: 60px;
        height: 60px;
        flex-shrink: 0;
        border-radius: var(--radius-md);
        overflow: hidden;
    }

    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-content {
        flex: 1;
    }

    .product-title {
        color: var(--text-primary);
        font-size: var(--text-sm);
        margin-bottom: 4px;
        font-weight: 600;
    }

    .product-price {
        font-weight: 700;
        color: var(--primary-color);
        font-size: var(--text-sm);
    }

    .widget-footer {
        margin-top: var(--space-lg);
    }

    /* Social Widget */
    .social-links {
        display: flex;
        justify-content: center;
        gap: var(--space-sm);
    }

    .social-link {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-decoration: none;
        transition: var(--transition-normal);
        font-size: 16px;
    }

    .social-link.facebook { background: #1877f2; }
    .social-link.instagram { background: linear-gradient(45deg, #405de6, #5851db, #833ab4, #c13584, #e1306c, #fd1d1d); }
    .social-link.twitter { background: #1da1f2; }
    .social-link.pinterest { background: #e60023; }
    .social-link.youtube { background: #ff0000; }

    .social-link:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-md);
    }

    /* Featured Article Section */
    .featured-article-section {
        background: linear-gradient(135deg, #f8f9fa 0%, var(--surface-color) 100%);
    }

    .section-header {
        text-align: center;
        margin-bottom: var(--space-xl);
    }

    .section-title {
        font-size: var(--text-3xl);
        color: var(--text-primary);
        margin-bottom: var(--space-sm);
    }

    .section-subtitle {
        color: var(--text-secondary);
        font-size: var(--text-lg);
    }

    .featured-article-card {
        background: var(--surface-color);
        border-radius: var(--radius-xl);
        overflow: hidden;
        box-shadow: var(--shadow-xl);
        border: 1px solid var(--border-color);
    }

    .featured-article-wrapper {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: var(--space-xl);
    }

    .featured-article-image {
        position: relative;
        min-height: 400px;
    }

    .featured-article-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .featured-badge {
        position: absolute;
        top: 20px;
        right: 20px;
        background: var(--gradient-gold);
        color: var(--primary-dark);
        padding: 8px 20px;
        border-radius: var(--radius-full);
        font-weight: 700;
        box-shadow: var(--shadow-md);
        display: flex;
        align-items: center;
    }

    .featured-article-content {
        padding: var(--space-xl);
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .featured-category {
        display: inline-block;
        background: var(--gradient-primary);
        color: white;
        padding: 6px 16px;
        border-radius: var(--radius-full);
        font-size: var(--text-sm);
        font-weight: 600;
        margin-bottom: var(--space-md);
    }

    .featured-title {
        font-size: var(--text-3xl);
        margin-bottom: var(--space-md);
        line-height: 1.3;
        color: var(--text-primary);
    }

    .featured-excerpt {
        font-size: var(--text-lg);
        color: var(--text-secondary);
        margin-bottom: var(--space-xl);
        line-height: 1.6;
    }

    .featured-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: var(--space-md);
    }

    .featured-author {
        display: flex;
        align-items: center;
        gap: var(--space-sm);
    }

    .featured-author img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--border-color);
    }

    .author-name {
        font-weight: 600;
        color: var(--text-primary);
    }

    .article-date {
        font-size: var(--text-sm);
        color: var(--text-muted);
        display: flex;
        align-items: center;
    }

    /* Newsletter Section */
    .newsletter-section {
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-color) 50%, var(--accent-color) 100%);
        position: relative;
        overflow: hidden;
    }

    .newsletter-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            radial-gradient(circle at 20% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 80% 50%, rgba(212, 175, 55, 0.1) 0%, transparent 50%);
    }

    .newsletter-container {
        position: relative;
        z-index: 2;
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

    .newsletter-form-wrapper {
        flex: 1;
        max-width: 500px;
    }

    .newsletter-form .input-group {
        display: flex;
        gap: var(--space-sm);
    }

    .newsletter-form .form-control {
        flex: 1;
        padding: 16px 24px;
        border: 2px solid rgba(255, 255, 255, 0.2);
        border-radius: var(--radius-full);
        background: rgba(255, 255, 255, 0.1);
        color: white;
        font-size: var(--text-base);
        transition: var(--transition-normal);
    }

    .newsletter-form .form-control:focus {
        outline: none;
        border-color: white;
        background: rgba(255, 255, 255, 0.2);
    }

    .newsletter-form .form-control::placeholder {
        color: rgba(255, 255, 255, 0.7);
    }

    /* Animations */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-slide-up {
        animation: slideUp 0.8s ease;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .delay-1 {
        animation-delay: 0.2s;
    }

    .delay-2 {
        animation-delay: 0.4s;
    }

    /* Loading States */
    .blog-card.loading {
        animation: shimmer 2s infinite linear;
        background: linear-gradient(90deg, var(--border-color) 25%, var(--surface-color) 50%, var(--border-color) 75%);
        background-size: 1000px 100%;
    }

    @keyframes shimmer {
        0% {
            background-position: -1000px 0;
        }
        100% {
            background-position: 1000px 0;
        }
    }

    /* Responsive Design */
    @media (max-width: 1200px) {
        .grid-view {
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        }
        
        .featured-article-wrapper {
            gap: var(--space-lg);
        }
    }

    @media (max-width: 992px) {
        .blog-sidebar {
            position: static;
            margin-top: var(--space-xl);
        }
        
        .featured-article-wrapper {
            grid-template-columns: 1fr;
        }
        
        .featured-article-image {
            min-height: 300px;
        }
        
        .hero-content .hero-title {
            font-size: var(--text-3xl);
        }
        
        .newsletter-container {
            flex-direction: column;
            text-align: center;
        }
        
        .newsletter-form-wrapper {
            max-width: 100%;
        }
    }

    @media (max-width: 768px) {
        .grid-view {
            grid-template-columns: 1fr;
        }
        
        .list-view .blog-card {
            flex-direction: column;
        }
        
        .list-view .blog-image {
            flex: 0 0 200px;
        }
        
        .hero-content .hero-title {
            font-size: var(--text-2xl);
        }
        
        .hero-content .hero-subtitle {
            font-size: var(--text-base);
        }
        
        .hero-buttons {
            flex-direction: column;
        }
        
        .hero-buttons .btn {
            width: 100%;
            text-align: center;
        }
        
        .featured-title {
            font-size: var(--text-2xl);
        }
        
        .quick-stats {
            flex-direction: column;
            gap: var(--space-lg);
        }
        
        .filter-bar {
            flex-direction: column;
            gap: var(--space-md);
        }
        
        .pagination-container {
            flex-direction: column;
            text-align: center;
        }
    }

    @media (max-width: 576px) {
        .hero-content .hero-title {
            font-size: var(--text-xl);
        }
        
        .hero-content .hero-subtitle {
            font-size: var(--text-sm);
        }
        
        .page-title {
            font-size: var(--text-2xl);
        }
        
        .page-subtitle {
            font-size: var(--text-base);
        }
        
        .featured-title {
            font-size: var(--text-xl);
        }
        
        .featured-excerpt {
            font-size: var(--text-base);
        }
        
        .featured-meta {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .featured-meta .btn {
            width: 100%;
            text-align: center;
        }
        
        .newsletter-form .input-group {
            flex-direction: column;
        }
        
        .newsletter-form .btn {
            width: 100%;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // View toggle functionality
        const viewOptions = document.querySelectorAll('.view-option');
        const blogContainer = document.getElementById('blogContainer');
        
        viewOptions.forEach(option => {
            option.addEventListener('click', function() {
                const viewType = this.dataset.view;
                
                // Update active state
                viewOptions.forEach(opt => opt.classList.remove('active'));
                this.classList.add('active');
                
                // Update view
                blogContainer.classList.remove('grid-view', 'list-view');
                blogContainer.classList.add(`${viewType}-view`);
            });
        });

        // Sort functionality
        const sortSelect = document.getElementById('sort-articles');
        if (sortSelect) {
            sortSelect.addEventListener('change', function() {
                const sortValue = this.value;
                // In a real app, this would trigger an AJAX request or page reload
                showToast(`Sorting articles by: ${this.options[this.selectedIndex].text}`, 'info');
            });
        }

        // Search form enhancement
        const searchForm = document.querySelector('.blog-search-form');
        if (searchForm) {
            searchForm.addEventListener('submit', function(e) {
                const searchInput = this.querySelector('input[name="search"]');
                if (!searchInput.value.trim()) {
                    e.preventDefault();
                    searchInput.classList.add('is-invalid');
                    showToast('Please enter a search term', 'error');
                }
            });
        }

        // Newsletter forms
        const newsletterForms = document.querySelectorAll('.newsletter-form');
        newsletterForms.forEach(form => {
            form.addEventListener('submit', async function(e) {
                e.preventDefault();

                const emailInput = this.querySelector('input[type="email"]');
                const submitBtn = this.querySelector('button[type="submit"]');

                if (!isValidEmail(emailInput.value)) {
                    showToast('Please enter a valid email address', 'error');
                    return;
                }

                const originalText = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Subscribing...';

                try {
                    // Simulate API call
                    await new Promise(resolve => setTimeout(resolve, 1500));

                    showToast('Successfully subscribed to our newsletter!', 'success');
                    emailInput.value = '';

                } catch (error) {
                    showToast('Subscription failed. Please try again.', 'error');
                } finally {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                }
            });
        });

        // Category filtering with animation
        const categoryLinks = document.querySelectorAll('.category-item');
        categoryLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                if (!this.classList.contains('active')) {
                    // Show loading animation
                    showLoading();
                    
                    // In a real app, this would be handled by the link href
                    // Here we just simulate a brief loading state
                    setTimeout(() => {
                        hideLoading();
                    }, 500);
                }
            });
        });

        // Blog card hover effects
        const blogCards = document.querySelectorAll('.blog-card');
        blogCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.zIndex = '10';
            });

            card.addEventListener('mouseleave', function() {
                this.style.zIndex = '1';
            });
        });

        // Featured product click
        const productItems = document.querySelectorAll('.product-link');
        productItems.forEach(product => {
            product.addEventListener('click', function(e) {
                e.preventDefault();
                const title = this.querySelector('.product-title').textContent;
                showToast(`Viewing ${title} in shop`, 'info');
            });
        });

        // Social share buttons (simulated)
        const socialLinks = document.querySelectorAll('.social-link');
        socialLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const platform = this.classList[1]; // facebook, instagram, etc.
                showToast(`Sharing on ${platform.charAt(0).toUpperCase() + platform.slice(1)}`, 'info');
            });
        });

        // Lazy load images for better performance
        const lazyImages = document.querySelectorAll('.blog-image img, .recent-post-image img');
        
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src || img.src;
                    img.classList.add('loaded');
                    observer.unobserve(img);
                }
            });
        }, {
            rootMargin: '50px 0px',
            threshold: 0.1
        });

        lazyImages.forEach(img => imageObserver.observe(img));

        // Scroll animations for blog cards
        const blogObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animation = 'fadeIn 0.6s ease-out';
                    blogObserver.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1
        });

        blogCards.forEach(card => blogObserver.observe(card));

        // Email validation helper
        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        // Loading functions
        function showLoading() {
            // In a real app, show a loading overlay
            blogContainer.style.opacity = '0.5';
            blogContainer.style.pointerEvents = 'none';
        }

        function hideLoading() {
            blogContainer.style.opacity = '1';
            blogContainer.style.pointerEvents = 'auto';
        }

        // Initialize tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });

    // Toast notification function (using existing from main.js)
    function showToast(message, type = 'info') {
        if (window.showToast) {
            window.showToast(message, type);
        } else {
            // Fallback simple toast
            console.log(`${type}: ${message}`);
        }
    }
</script>
@endpush