@extends('layouts.front')

@section('title', $blog->title)
@section('meta_description', $blog->brief_description)
@section('meta_keywords', $blog->seo_meta_keywords)

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <article class="blog-post">
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('blog.index') }}">Blog</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $blog->category }}</li>
                    </ol>
                </nav>

                <!-- Title -->
                <h1 class="display-5 fw-bold mb-3">{{ $blog->title }}</h1>

                <!-- Meta Info -->
                <div class="d-flex align-items-center text-muted mb-4">
                    <div class="d-flex align-items-center me-4">
                        <i class="fas fa-user me-2"></i>
                        <span>{{ $blog->author->name ?? 'Admin' }}</span>
                    </div>
                    <div class="d-flex align-items-center me-4">
                        <i class="fas fa-calendar me-2"></i>
                        <span>{{ $blog->published_at->format('F d, Y') }}</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="fas fa-eye me-2"></i>
                        <span>{{ $blog->view_count }} views</span>
                    </div>
                </div>

                <!-- Featured Image -->
                @if($blog->featured_image)
                    <div class="mb-5">
                        <img src="{{ asset('storage/' . $blog->featured_image) }}" 
                             class="img-fluid rounded shadow" alt="{{ $blog->title }}">
                    </div>
                @endif

                <!-- Brief Description -->
                @if($blog->brief_description)
                    <div class="lead mb-5 p-4 bg-light rounded">
                        {{ $blog->brief_description }}
                    </div>
                @endif

                <!-- Content -->
                <div class="blog-content mb-5">
                    {!! $blog->content !!}
                </div>

                <!-- Tags -->
                @if($blog->tags)
                    <div class="mb-5">
                        <h5 class="mb-3">Tags:</h5>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach(explode(',', $blog->tags) as $tag)
                                <a href="#" class="badge bg-secondary text-decoration-none">
                                    {{ trim($tag) }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Share Buttons -->
                <div class="card mb-5">
                    <div class="card-body">
                        <h5 class="card-title">Share this post</h5>
                        <div class="d-flex gap-2">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                               class="btn btn-outline-primary" target="_blank">
                                <i class="fab fa-facebook-f me-2"></i> Facebook
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($blog->title) }}" 
                               class="btn btn-outline-info" target="_blank">
                                <i class="fab fa-twitter me-2"></i> Twitter
                            </a>
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}&title={{ urlencode($blog->title) }}" 
                               class="btn btn-outline-primary" target="_blank">
                                <i class="fab fa-linkedin me-2"></i> LinkedIn
                            </a>
                        </div>
                    </div>
                </div>
            </article>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Recent Posts -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Recent Posts</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        @foreach($recentPosts as $recent)
                            <a href="{{ route('blog.show', $recent->slug) }}" 
                               class="list-group-item list-group-item-action d-flex align-items-center">
                                @if($recent->featured_image)
                                    <img src="{{ asset('storage/' . $recent->featured_image) }}" 
                                         class="rounded me-3" width="60" height="60" alt="{{ $recent->title }}">
                                @endif
                                <div>
                                    <h6 class="mb-1">{{ Str::limit($recent->title, 40) }}</h6>
                                    <small class="text-muted">{{ $recent->published_at->format('M d, Y') }}</small>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Categories -->
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Categories</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        @foreach($categories as $category)
                            <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                {{ $category }}
                                <span class="badge bg-primary rounded-pill">14</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Newsletter -->
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Subscribe</h5>
                </div>
                <div class="card-body">
                    <p>Get the latest posts delivered right to your inbox.</p>
                    <form>
                        <div class="mb-3">
                            <input type="email" class="form-control" placeholder="Your email address" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            Subscribe
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .blog-content {
        line-height: 1.8;
        font-size: 1.1rem;
    }
    .blog-content p {
        margin-bottom: 1.5rem;
    }
    .blog-content h2 {
        margin-top: 2.5rem;
        margin-bottom: 1.5rem;
        color: #2c3e50;
    }
    .blog-content h3 {
        margin-top: 2rem;
        margin-bottom: 1rem;
        color: #34495e;
    }
    .blog-content img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 1.5rem 0;
    }
    .blog-content blockquote {
        border-left: 4px solid #3498db;
        padding-left: 1.5rem;
        margin: 1.5rem 0;
        font-style: italic;
        color: #555;
    }
    .blog-content ul, .blog-content ol {
        margin-bottom: 1.5rem;
        padding-left: 2rem;
    }
</style>
@endpush