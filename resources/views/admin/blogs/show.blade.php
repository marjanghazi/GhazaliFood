@extends('layouts.admin')

@section('title', 'View Blog Post')
@section('page_title', 'Blogs')
@section('breadcrumb', 'View Post')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Blog Post Details</h5>
                <div>
                    <a href="{{ route('admin.blogs.edit', $blog) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>
                    <a href="{{ route('admin.blogs.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Back
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-4">
                            <h2 class="mb-3">{{ $blog->title }}</h2>
                            <div class="d-flex align-items-center text-muted mb-3">
                                <i class="fas fa-user me-2"></i>
                                <span class="me-3">{{ $blog->author->name ?? 'Unknown Author' }}</span>
                                <i class="fas fa-calendar me-2"></i>
                                <span class="me-3">{{ $blog->created_at->format('M d, Y') }}</span>
                                <i class="fas fa-eye me-2"></i>
                                <span>{{ $blog->view_count }} views</span>
                            </div>
                            
                            @if($blog->brief_description)
                                <div class="alert alert-light">
                                    <p class="lead mb-0">{{ $blog->brief_description }}</p>
                                </div>
                            @endif
                        </div>

                        @if($blog->featured_image)
                            <div class="mb-4">
                                <img src="{{ asset('storage/' . $blog->featured_image) }}" 
                                     class="img-fluid rounded" alt="{{ $blog->title }}">
                            </div>
                        @endif

                        <div class="blog-content mb-4">
                            {!! $blog->content !!}
                        </div>

                        @if($blog->tags)
                            <div class="mb-4">
                                <h6>Tags:</h6>
                                <div>
                                    @foreach(explode(',', $blog->tags) as $tag)
                                        <span class="badge bg-info me-1">{{ trim($tag) }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="col-md-4">
                        <div class="card bg-light mb-3">
                            <div class="card-header">
                                <h6 class="mb-0">Post Information</h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <td><strong>Status:</strong></td>
                                        <td>
                                            <span class="badge bg-{{ $blog->status == 'published' ? 'success' : ($blog->status == 'draft' ? 'warning' : 'secondary') }}">
                                                {{ ucfirst($blog->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Category:</strong></td>
                                        <td>{{ $blog->category }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Published:</strong></td>
                                        <td>
                                            @if($blog->is_published && $blog->published_at)
                                                {{ $blog->published_at->format('M d, Y h:i A') }}
                                            @else
                                                Not Published
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Created:</strong></td>
                                        <td>{{ $blog->created_at->format('M d, Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Updated:</strong></td>
                                        <td>{{ $blog->updated_at->format('M d, Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Author:</strong></td>
                                        <td>{{ $blog->author->name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Views:</strong></td>
                                        <td>{{ $blog->view_count }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="card bg-light mb-3">
                            <div class="card-header">
                                <h6 class="mb-0">SEO Information</h6>
                            </div>
                            <div class="card-body">
                                <p><strong>SEO Title:</strong></p>
                                <p class="text-muted">{{ $blog->seo_meta_title ?? 'Not set' }}</p>
                                
                                <p><strong>SEO Description:</strong></p>
                                <p class="text-muted">{{ $blog->seo_meta_description ?? 'Not set' }}</p>
                                
                                <p><strong>SEO Keywords:</strong></p>
                                <p class="text-muted">{{ $blog->seo_meta_keywords ?? 'Not set' }}</p>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST" 
                                  onsubmit="return confirm('Are you sure you want to delete this blog post?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger w-100">
                                    <i class="fas fa-trash me-1"></i> Delete Post
                                </button>
                            </form>
                        </div>
                    </div>
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
    .blog-content img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 20px 0;
    }
    .blog-content p {
        margin-bottom: 1.5rem;
    }
    .blog-content h1, 
    .blog-content h2, 
    .blog-content h3, 
    .blog-content h4 {
        margin-top: 2rem;
        margin-bottom: 1rem;
    }
</style>
@endpush