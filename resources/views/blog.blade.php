@extends('layouts.app')

@section('title', 'Blog | Health Tips & Recipes | Premium Dry Fruits Store | Nuts & Berries')

@section('hero')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center min-vh-70">
            <div class="col-lg-6">
                <h1 class="hero-title animate-slide-up">The Nuts & Berries Blog</h1>
                <p class="hero-subtitle animate-slide-up delay-1">
                    Discover delicious recipes, health benefits, and expert tips
                    for incorporating premium dry fruits into your daily life.
                </p>
                <div class="hero-buttons animate-slide-up delay-2">
                    <a href="#latest-posts" class="btn btn-primary btn-lg">
                        Read Articles <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                    <a href="#newsletter" class="btn btn-outline btn-lg">
                        Subscribe
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-image">
                    <img src="https://images.unsplash.com/photo-1490818387583-1baba5e638af?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                        alt="Premium Dry Fruits Blog"
                        class="img-fluid rounded-3">
                    <div class="hero-badge animate-bounce">
                        <i class="fas fa-heart me-2"></i> Healthy Living
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
        <div class="row">
            <!-- Blog Posts -->
            <div class="col-lg-8">
                <div class="section-header mb-5">
                    <h2 class="section-title">Latest Articles</h2>
                    <p class="text-muted">Expert insights on dry fruits, nutrition, and healthy living</p>
                </div>

                <div class="blog-grid">
                    @foreach($blogs as $blog)
                    <div class="blog-card">
                        <div class="blog-image">
                            <img src="{{ $blog->featured_image ? asset('storage/' . $blog->featured_image) : 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80' }}"
                                alt="{{ $blog->title }}">
                            <div class="blog-category">
                                {{ $blog->category }}
                            </div>
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
                            </div>

                            <h3 class="blog-title">
                                <a href="{{ route('blog.show', $blog->slug) }}">
                                    {{ Str::limit($blog->title, 70) }}
                                </a>
                            </h3>

                            <p class="blog-excerpt">
                                {{ Str::limit($blog->brief_description, 120) }}
                            </p>

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
                                    Read More <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($blogs->hasPages())
                <div class="blog-pagination mt-5">
                    {{ $blogs->links('vendor.pagination.custom') }}
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="sidebar">
                    <!-- Search -->
                    <div class="sidebar-widget">
                        <h4 class="sidebar-title">Search Articles</h4>
                        <form action="{{ route('blog.index') }}" method="GET" class="blog-search-form">
                            <div class="input-group">
                                <input type="text"
                                    class="form-control"
                                    name="search"
                                    placeholder="Search articles..."
                                    value="{{ request('search') }}">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Categories -->
                    <!-- Categories -->
                    <div class="sidebar-widget">
                        <h4 class="sidebar-title">Categories</h4>
                        <div class="sidebar-categories">
                            <a href="{{ route('blog.index') }}"
                                class="sidebar-category {{ !request('category') ? 'active' : '' }}">
                                All Articles
                                <span class="category-count">{{ $totalPosts ?? 0 }}</span>
                            </a>
                            @foreach($categories as $category)
                            @php
                            // Determine if current category is array or object
                            $categoryName = is_array($category) ? $category['name'] : $category;
                            $categorySlug = is_array($category) ? $category['slug'] : strtolower(str_replace(' ', '-', $category));
                            $categoryCount = is_array($category) ? $category['posts_count'] : 0;
                            @endphp
                            <a href="{{ route('blog.index', ['category' => $categorySlug]) }}"
                                class="sidebar-category {{ request('category') == $categorySlug ? 'active' : '' }}">
                                {{ $categoryName }}
                                <span class="category-count">{{ $categoryCount }}</span>
                            </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Recent Posts -->
                    <div class="sidebar-widget">
                        <h4 class="sidebar-title">Recent Articles</h4>
                        <div class="sidebar-recent-posts">
                            @foreach($recentPosts as $recent)
                            <div class="recent-post">
                                <a href="{{ route('blog.show', $recent->slug) }}" class="recent-post-link">
                                    <div class="recent-post-image">
                                        <img src="{{ $recent->featured_image ? asset('storage/' . $recent->featured_image) : 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80' }}"
                                            alt="{{ $recent->title }}">
                                    </div>
                                    <div class="recent-post-content">
                                        <h6 class="recent-post-title">{{ Str::limit($recent->title, 50) }}</h6>
                                        <span class="recent-post-date">
                                            {{ $recent->published_at->format('M d, Y') }}
                                        </span>
                                    </div>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Popular Tags -->
                    <div class="sidebar-widget">
                        <h4 class="sidebar-title">Popular Topics</h4>
                        <div class="sidebar-tags">
                            @php
                            $tags = ['Recipes', 'Health Benefits', 'Nutrition', 'Cooking Tips', 'Wellness',
                            'Almonds', 'Walnuts', 'Pistachios', 'Dates', 'Apricots', 'Organic',
                            'Healthy Snacks', 'Superfoods', 'Heart Health', 'Weight Management'];
                            @endphp
                            @foreach($tags as $tag)
                            <a href="{{ route('blog.index', ['tag' => $tag]) }}"
                                class="sidebar-tag {{ request('tag') == $tag ? 'active' : '' }}">
                                {{ $tag }}
                            </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Newsletter -->
                    <div class="sidebar-widget" id="newsletter">
                        <div class="sidebar-newsletter">
                            <div class="newsletter-icon">
                                <i class="fas fa-newspaper"></i>
                            </div>
                            <h5>Subscribe to Our Blog</h5>
                            <p class="text-muted">
                                Get the latest articles, recipes, and health tips delivered to your inbox.
                            </p>
                            <form class="sidebar-newsletter-form">
                                <div class="form-group">
                                    <input type="email"
                                        class="form-control"
                                        placeholder="Your email address"
                                        required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-paper-plane me-2"></i> Subscribe
                                </button>
                                <p class="form-text text-muted mt-2">
                                    We respect your privacy. Unsubscribe at any time.
                                </p>
                            </form>
                        </div>
                    </div>

                    <!-- Featured Products -->
                    <div class="sidebar-widget">
                        <h4 class="sidebar-title">Featured Products</h4>
                        <div class="sidebar-products">
                            <div class="sidebar-product">
                                <div class="sidebar-product-image">
                                    <img src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80"
                                        alt="Premium Almonds">
                                </div>
                                <div class="sidebar-product-content">
                                    <h6 class="sidebar-product-title">California Almonds</h6>
                                    <div class="sidebar-product-price">$24.99</div>
                                </div>
                            </div>
                            <div class="sidebar-product">
                                <div class="sidebar-product-image">
                                    <img src="https://images.unsplash.com/photo-1598965675045-45c0c0f58c00?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80"
                                        alt="Turkish Apricots">
                                </div>
                                <div class="sidebar-product-content">
                                    <h6 class="sidebar-product-title">Turkish Apricots</h6>
                                    <div class="sidebar-product-price">$18.99</div>
                                </div>
                            </div>
                            <div class="sidebar-product">
                                <div class="sidebar-product-image">
                                    <img src="https://images.unsplash.com/photo-1551183053-bf91a1d81141?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80"
                                        alt="Iranian Pistachios">
                                </div>
                                <div class="sidebar-product-content">
                                    <h6 class="sidebar-product-title">Iranian Pistachios</h6>
                                    <div class="sidebar-product-price">$29.99</div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-3">
                            <a href="{{ route('shop.index') }}" class="btn btn-outline btn-sm">
                                Shop All Products <i class="fas fa-arrow-right ms-1"></i>
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
<section class="py-5 bg-light">
    <div class="container">
        <div class="section-header mb-5">
            <h2 class="section-title">Featured Article</h2>
            <p class="text-muted">Don't miss our most popular post</p>
        </div>

        <div class="featured-article">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="featured-article-image">
                        <img src="{{ $featuredBlog->featured_image ? asset('storage/' . $featuredBlog->featured_image) : 'https://images.unsplash.com/photo-1490818387583-1baba5e638af?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80' }}"
                            alt="{{ $featuredBlog->title }}">
                        <div class="featured-badge">Featured</div>
                    </div>
                </div>
                <div class="col-lg-6">
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
                                    <div class="article-date">{{ $featuredBlog->published_at->format('F d, Y') }}</div>
                                </div>
                            </div>
                            <a href="{{ route('blog.show', $featuredBlog->slug) }}" class="btn btn-primary">
                                Read Full Article
                            </a>
                        </div>
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
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h2 class="text-white mb-3">Never Miss an Update</h2>
                <p class="text-white mb-0">
                    Subscribe to our newsletter for exclusive recipes, health tips,
                    special offers, and the latest articles from our blog.
                </p>
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
                    <p class="form-text text-white mt-2">
                        We respect your privacy. Unsubscribe at any time.
                    </p>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    /* Blog Grid */
    .blog-grid {
        display: grid;
        gap: var(--space-xl);
    }

    .blog-card {
        background: var(--surface-color);
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-md);
        transition: var(--transition-normal);
    }

    .blog-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-xl);
    }

    .blog-image {
        position: relative;
        height: 250px;
        overflow: hidden;
    }

    .blog-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .blog-card:hover .blog-image img {
        transform: scale(1.05);
    }

    .blog-category {
        position: absolute;
        top: 20px;
        left: 20px;
        background: var(--gradient-primary);
        color: white;
        padding: 6px 12px;
        border-radius: var(--radius-full);
        font-size: var(--text-sm);
        font-weight: 600;
    }

    .blog-content {
        padding: var(--space-lg);
    }

    .blog-meta {
        display: flex;
        gap: var(--space-lg);
        margin-bottom: var(--space-sm);
        font-size: var(--text-sm);
        color: var(--text-muted);
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
    }

    .blog-read-more:hover {
        color: var(--primary-dark);
    }

    /* Pagination */
    .blog-pagination {
        text-align: center;
    }

    .blog-pagination .pagination {
        justify-content: center;
    }

    .blog-pagination .page-item .page-link {
        border: 2px solid var(--border-color);
        color: var(--primary-color);
        margin: 0 4px;
        border-radius: var(--radius-md);
        transition: var(--transition-fast);
    }

    .blog-pagination .page-item.active .page-link {
        background: var(--gradient-primary);
        border-color: var(--primary-color);
        color: white;
    }

    .blog-pagination .page-item .page-link:hover {
        background: var(--primary-light);
        border-color: var(--primary-color);
        color: white;
    }

    /* Sidebar */
    .sidebar {
        position: sticky;
        top: 100px;
    }

    .sidebar-widget {
        background: var(--surface-color);
        border-radius: var(--radius-lg);
        padding: var(--space-lg);
        margin-bottom: var(--space-lg);
        box-shadow: var(--shadow-md);
    }

    .sidebar-title {
        font-size: var(--text-lg);
        color: var(--primary-color);
        margin-bottom: var(--space-md);
        padding-bottom: var(--space-sm);
        border-bottom: 2px solid var(--border-color);
    }

    /* Search Form */
    .blog-search-form .input-group {
        border-radius: var(--radius-md);
        overflow: hidden;
    }

    .blog-search-form .form-control {
        border: 2px solid var(--border-color);
        border-right: none;
    }

    .blog-search-form .btn {
        border: 2px solid var(--primary-color);
        background: var(--primary-color);
        color: white;
    }

    /* Categories */
    .sidebar-categories {
        display: flex;
        flex-direction: column;
        gap: var(--space-sm);
    }

    .sidebar-category {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: var(--space-sm);
        border-radius: var(--radius-md);
        color: var(--text-secondary);
        text-decoration: none;
        transition: var(--transition-fast);
    }

    .sidebar-category:hover,
    .sidebar-category.active {
        background: var(--primary-light);
        color: white;
        padding-left: var(--space-md);
    }

    .category-count {
        background: var(--border-color);
        color: var(--text-muted);
        padding: 2px 8px;
        border-radius: var(--radius-full);
        font-size: var(--text-xs);
        font-weight: 600;
    }

    .sidebar-category.active .category-count {
        background: white;
        color: var(--primary-color);
    }

    /* Recent Posts */
    .sidebar-recent-posts {
        display: flex;
        flex-direction: column;
        gap: var(--space-md);
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
        width: 60px;
        height: 60px;
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
        margin-bottom: 4px;
        line-height: 1.4;
    }

    .recent-post-date {
        font-size: var(--text-xs);
        color: var(--text-muted);
    }

    /* Tags */
    .sidebar-tags {
        display: flex;
        flex-wrap: wrap;
        gap: var(--space-xs);
    }

    .sidebar-tag {
        padding: 6px 12px;
        background: var(--border-color);
        color: var(--text-secondary);
        border-radius: var(--radius-md);
        text-decoration: none;
        font-size: var(--text-sm);
        transition: var(--transition-fast);
    }

    .sidebar-tag:hover,
    .sidebar-tag.active {
        background: var(--gradient-primary);
        color: white;
    }

    /* Newsletter Widget */
    .sidebar-newsletter {
        text-align: center;
    }

    .newsletter-icon {
        width: 60px;
        height: 60px;
        background: var(--gradient-primary);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto var(--space-md);
        color: white;
        font-size: 1.5rem;
    }

    .sidebar-newsletter h5 {
        margin-bottom: var(--space-sm);
        color: var(--primary-color);
    }

    .sidebar-newsletter-form .form-control {
        margin-bottom: var(--space-sm);
    }

    /* Featured Products */
    .sidebar-products {
        display: flex;
        flex-direction: column;
        gap: var(--space-md);
    }

    .sidebar-product {
        display: flex;
        align-items: center;
        gap: var(--space-sm);
        padding: var(--space-sm);
        border-radius: var(--radius-md);
        background: var(--background-color);
        transition: var(--transition-fast);
    }

    .sidebar-product:hover {
        transform: translateX(5px);
        box-shadow: var(--shadow-sm);
    }

    .sidebar-product-image {
        width: 50px;
        height: 50px;
        border-radius: var(--radius-md);
        overflow: hidden;
        flex-shrink: 0;
    }

    .sidebar-product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .sidebar-product-title {
        font-size: var(--text-sm);
        margin-bottom: 2px;
        color: var(--text-primary);
    }

    .sidebar-product-price {
        font-weight: 600;
        color: var(--primary-color);
        font-size: var(--text-sm);
    }

    /* Featured Article */
    .featured-article {
        background: var(--surface-color);
        border-radius: var(--radius-xl);
        overflow: hidden;
        box-shadow: var(--shadow-xl);
    }

    .featured-article-image {
        position: relative;
        height: 400px;
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
        padding: 8px 16px;
        border-radius: var(--radius-full);
        font-weight: 700;
        box-shadow: var(--shadow-md);
    }

    .featured-article-content {
        padding: var(--space-xl);
        height: 100%;
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
    }

    .author-name {
        font-weight: 600;
        color: var(--text-primary);
    }

    .article-date {
        font-size: var(--text-sm);
        color: var(--text-muted);
    }

    /* Responsive Design */
    @media (max-width: 992px) {
        .sidebar {
            position: static;
            margin-top: var(--space-xl);
        }

        .featured-article-image {
            height: 300px;
        }

        .featured-title {
            font-size: var(--text-2xl);
        }
    }

    @media (max-width: 768px) {
        .blog-grid {
            gap: var(--space-lg);
        }

        .blog-image {
            height: 200px;
        }

        .blog-title {
            font-size: var(--text-lg);
        }

        .blog-footer {
            flex-direction: column;
            gap: var(--space-md);
            align-items: flex-start;
        }

        .blog-read-more {
            align-self: flex-end;
        }

        .featured-article-content {
            padding: var(--space-lg);
        }

        .featured-meta {
            flex-direction: column;
            align-items: flex-start;
        }
    }

    @media (max-width: 576px) {
        .blog-meta {
            flex-direction: column;
            gap: var(--space-xs);
        }

        .featured-title {
            font-size: var(--text-xl);
        }

        .featured-excerpt {
            font-size: var(--text-base);
        }

        .sidebar-product {
            flex-direction: column;
            text-align: center;
        }
    }

    /* Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .blog-card,
    .sidebar-widget,
    .featured-article {
        animation: fadeInUp 0.6s ease-out;
    }

    .blog-card:nth-child(2) {
        animation-delay: 0.1s;
    }

    .blog-card:nth-child(3) {
        animation-delay: 0.2s;
    }

    .blog-card:nth-child(4) {
        animation-delay: 0.3s;
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
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Blog search form submission with validation
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

        // Newsletter form submission
        const newsletterForms = document.querySelectorAll('.newsletter-form, .sidebar-newsletter-form');
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

        // Blog category filtering
        const categoryLinks = document.querySelectorAll('.sidebar-category');
        categoryLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                if (this.classList.contains('active')) {
                    e.preventDefault();
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

        // Featured product hover effects
        const featuredProducts = document.querySelectorAll('.sidebar-product');
        featuredProducts.forEach(product => {
            product.addEventListener('click', function(e) {
                e.preventDefault();
                const title = this.querySelector('.sidebar-product-title').textContent;
                showToast(`Added ${title} to cart!`, 'success');
            });
        });

        // Load more functionality (for infinite scroll)
        let isLoading = false;
        let page = 2;
        const loadMoreObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !isLoading) {
                    loadMoreArticles();
                }
            });
        }, {
            threshold: 0.1
        });

        const loadMoreTrigger = document.getElementById('loadMoreTrigger');
        if (loadMoreTrigger) {
            loadMoreObserver.observe(loadMoreTrigger);
        }

        async function loadMoreArticles() {
            if (isLoading) return;

            isLoading = true;

            try {
                const response = await fetch(`/api/blog?page=${page}`);
                const data = await response.json();

                if (data.success && data.blogs.length > 0) {
                    // Append new blog cards
                    const blogGrid = document.querySelector('.blog-grid');
                    data.blogs.forEach(blog => {
                        const blogCard = createBlogCard(blog);
                        blogGrid.appendChild(blogCard);
                    });

                    page++;

                    if (!data.hasMore) {
                        loadMoreObserver.disconnect();
                    }
                }
            } catch (error) {
                console.error('Error loading more articles:', error);
            } finally {
                isLoading = false;
            }
        }

        function createBlogCard(blog) {
            const card = document.createElement('div');
            card.className = 'blog-card';
            card.innerHTML = `
            <div class="blog-image">
                <img src="${blog.featured_image || 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80'}" 
                     alt="${blog.title}">
                <div class="blog-category">
                    ${blog.category}
                </div>
            </div>
            <div class="blog-content">
                <div class="blog-meta">
                    <span class="blog-date">
                        <i class="far fa-calendar me-1"></i>
                        ${blog.published_at}
                    </span>
                    <span class="blog-read-time">
                        <i class="far fa-clock me-1"></i>
                        ${blog.read_time || '5'} min read
                    </span>
                </div>
                <h3 class="blog-title">
                    <a href="/blog/${blog.slug}">
                        ${blog.title}
                    </a>
                </h3>
                <p class="blog-excerpt">
                    ${blog.excerpt}
                </p>
                <div class="blog-footer">
                    <div class="blog-author">
                        <img src="${blog.author.avatar || 'https://i.pravatar.cc/40'}" 
                             class="blog-author-avatar" 
                             alt="${blog.author.name}">
                        <div class="blog-author-info">
                            <span class="blog-author-name">${blog.author.name}</span>
                            <span class="blog-author-title">${blog.author.title || 'Nutrition Expert'}</span>
                        </div>
                    </div>
                    <a href="/blog/${blog.slug}" class="blog-read-more">
                        Read More <i class="fas fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        `;
            return card;
        }

        // Intersection Observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '50px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-slide-up');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        // Observe elements
        document.querySelectorAll('.blog-card, .sidebar-widget, .featured-article')
            .forEach(el => observer.observe(el));

        // Email validation helper
        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }
    });

    // Toast notification function
    function showToast(message, type = 'info') {
        const container = document.getElementById('toastContainer');
        if (!container) {
            const container = document.createElement('div');
            container.id = 'toastContainer';
            container.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        `;
            document.body.appendChild(container);
        }

        const toast = document.createElement('div');
        toast.className = 'toast-notification';
        toast.innerHTML = `
        <div class="toast-content">
            <i class="fas ${type === 'success' ? 'fa-check-circle' : 
                         type === 'error' ? 'fa-exclamation-circle' : 
                         'fa-info-circle'} me-2"></i>
            ${message}
        </div>
    `;

        toast.style.cssText = `
        background: ${type === 'success' ? '#27ae60' : 
                     type === 'error' ? '#e74c3c' : '#3498db'};
        color: white;
        padding: 12px 20px;
        margin-bottom: 10px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        animation: slideInRight 0.3s ease;
    `;

        container.appendChild(toast);

        setTimeout(() => {
            toast.style.animation = 'slideOutRight 0.3s ease forwards';
            setTimeout(() => {
                if (toast.parentElement === container) {
                    container.removeChild(toast);
                }
            }, 300);
        }, 3000);
    }

    // Add CSS for toast animations
    const style = document.createElement('style');
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
    
    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
`;
    document.head.appendChild(style);
</script>
@endpush