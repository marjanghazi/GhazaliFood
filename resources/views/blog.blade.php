@extends('layouts.app')

@section('title', 'Blog - Ghazali Food')

@section('hero')
<!-- Blog Hero -->
<section class="hero-section" style="background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1490818387583-1baba5e638af?ixlib=rb-4.0.3') center/cover no-repeat;">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="animate__animated animate__fadeInUp">Food Blog & Recipes</h1>
                <p class="lead animate__animated animate__fadeInUp animate__delay-1s">
                    Discover recipes, cooking tips, and food stories
                </p>
                <nav aria-label="breadcrumb" class="d-flex justify-content-center">
                    <ol class="breadcrumb bg-transparent p-0 animate__animated animate__fadeInUp animate__delay-2s">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Blog</li>
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
        <!-- Blog Posts -->
        <div class="col-lg-8">
            <div class="row g-4">
                @foreach($blogs as $blog)
                <div class="col-md-6">
                    <div class="blog-card">
                        <div class="blog-img">
                            <img src="{{ $blog->featured_image ? asset('storage/' . $blog->featured_image) : 'https://via.placeholder.com/400x250?text=Blog' }}" 
                                 alt="{{ $blog->title }}">
                        </div>
                        <div class="blog-content">
                            <div class="blog-meta d-flex justify-content-between mb-2">
                                <span>
                                    <i class="far fa-calendar me-1"></i>
                                    {{ $blog->published_at->format('M d, Y') }}
                                </span>
                                <span>
                                    <i class="far fa-folder me-1"></i>
                                    {{ $blog->category }}
                                </span>
                            </div>
                            <h5 class="blog-title">
                                <a href="{{ route('blog.show', $blog->slug) }}" class="text-decoration-none text-dark">
                                    {{ Str::limit($blog->title, 60) }}
                                </a>
                            </h5>
                            <p class="blog-excerpt">
                                {{ Str::limit($blog->brief_description, 100) }}
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="author-info d-flex align-items-center">
                                    <img src="{{ $blog->author->avatar_url ?? 'https://i.pravatar.cc/30?img=' . $blog->author_id }}" 
                                         class="rounded-circle me-2" alt="{{ $blog->author->name }}">
                                    <small>{{ $blog->author->name }}</small>
                                </div>
                                <a href="{{ route('blog.show', $blog->slug) }}" class="btn btn-sm btn-outline-success">
                                    Read More
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
                    {{ $blogs->links() }}
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="sidebar">
                <!-- Search -->
                <div class="mb-4">
                    <h5 class="sidebar-title">Search Blog</h5>
                    <form action="{{ route('blog.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Search...">
                            <button class="btn btn-success" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Categories -->
                <div class="mb-4">
                    <h5 class="sidebar-title">Categories</h5>
                    <ul class="sidebar-list">
                        <li>
                            <a href="{{ route('blog.index') }}">All Categories</a>
                        </li>
                        @foreach($categories as $category)
                        <li>
                            <a href="{{ route('blog.index', ['category' => $category]) }}">
                                {{ $category }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Recent Posts -->
                <div class="mb-4">
                    <h5 class="sidebar-title">Recent Posts</h5>
                    @foreach($recentPosts as $recent)
                    <div class="recent-post mb-3">
                        <a href="{{ route('blog.show', $recent->slug ) }}" class="text-decoration-none text-dark">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <img src="{{ $recent->featured_image ? asset('storage/' . $recent->featured_image) : 'https://via.placeholder.com/60x60?text=Post' }}" 
                                         class="rounded" width="60" height="60" alt="{{ $recent->title }}">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1">{{ Str::limit($recent->title, 40) }}</h6>
                                    <small class="text-muted">
                                        {{ $recent->published_at->format('M d, Y') }}
                                    </small>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>

                <!-- Tags -->
                <div class="mb-4">
                    <h5 class="sidebar-title">Popular Tags</h5>
                    <div class="tags">
                        <a href="#" class="btn btn-sm btn-outline-secondary mb-2">Recipes</a>
                        <a href="#" class="btn btn-sm btn-outline-secondary mb-2">Cooking Tips</a>
                        <a href="#" class="btn btn-sm btn-outline-secondary mb-2">Healthy Food</a>
                        <a href="#" class="btn btn-sm btn-outline-secondary mb-2">Ingredients</a>
                        <a href="#" class="btn btn-sm btn-outline-secondary mb-2">Nutrition</a>
                    </div>
                </div>

                <!-- Newsletter -->
                <div class="mb-4">
                    <h5 class="sidebar-title">Subscribe</h5>
                    <p class="small text-muted">Get the latest posts delivered right to your inbox.</p>
                    <form>
                        <div class="mb-3">
                            <input type="email" class="form-control form-control-sm" placeholder="Your email">
                        </div>
                        <button type="submit" class="btn btn-success btn-sm w-100">
                            Subscribe
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection