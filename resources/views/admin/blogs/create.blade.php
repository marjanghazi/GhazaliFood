@extends('layouts.admin')

@section('title', 'Create Blog Post')
@section('page_title', 'Blogs')
@section('breadcrumb', 'Create Post')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Create New Blog Post</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="title" class="form-label">Title *</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                       id="title" name="title" value="{{ old('title') }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="brief_description" class="form-label">Brief Description *</label>
                                <textarea class="form-control @error('brief_description') is-invalid @enderror" 
                                          id="brief_description" name="brief_description" rows="3" required>{{ old('brief_description') }}</textarea>
                                @error('brief_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="content" class="form-label">Content *</label>
                                <textarea class="form-control @error('content') is-invalid @enderror" 
                                          id="content" name="content" rows="10" required>{{ old('content') }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="category" class="form-label">Category *</label>
                                <select class="form-select @error('category') is-invalid @enderror" 
                                        id="category" name="category" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category }}" {{ old('category') == $category ? 'selected' : '' }}>
                                            {{ $category }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="tags" class="form-label">Tags</label>
                                <input type="text" class="form-control @error('tags') is-invalid @enderror" 
                                       id="tags" name="tags" value="{{ old('tags') }}"
                                       placeholder="comma, separated, tags">
                                @error('tags')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="featured_image" class="form-label">Featured Image *</label>
                                <input type="file" class="form-control @error('featured_image') is-invalid @enderror" 
                                       id="featured_image" name="featured_image" accept="image/*">
                                @error('featured_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="seo_meta_title" class="form-label">SEO Title</label>
                                <input type="text" class="form-control @error('seo_meta_title') is-invalid @enderror" 
                                       id="seo_meta_title" name="seo_meta_title" value="{{ old('seo_meta_title') }}">
                                @error('seo_meta_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="seo_meta_description" class="form-label">SEO Description</label>
                                <textarea class="form-control @error('seo_meta_description') is-invalid @enderror" 
                                          id="seo_meta_description" name="seo_meta_description" rows="3">{{ old('seo_meta_description') }}</textarea>
                                @error('seo_meta_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="seo_meta_keywords" class="form-label">SEO Keywords</label>
                                <input type="text" class="form-control @error('seo_meta_keywords') is-invalid @enderror" 
                                       id="seo_meta_keywords" name="seo_meta_keywords" value="{{ old('seo_meta_keywords') }}"
                                       placeholder="comma, separated, keywords">
                                @error('seo_meta_keywords')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" 
                                           id="is_published" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_published">
                                        Publish Immediately
                                    </label>
                                </div>
                            </div>

                            <div class="mb-3" id="publish_date_container" style="display: none;">
                                <label for="published_at" class="form-label">Publish Date</label>
                                <input type="datetime-local" class="form-control" 
                                       id="published_at" name="published_at" value="{{ old('published_at') }}">
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Create Blog Post
                        </button>
                        <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-1"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Toggle publish date field
    document.getElementById('is_published').addEventListener('change', function() {
        const container = document.getElementById('publish_date_container');
        container.style.display = this.checked ? 'block' : 'none';
    });

    // Initialize publish date field based on initial state
    document.addEventListener('DOMContentLoaded', function() {
        const checkbox = document.getElementById('is_published');
        const container = document.getElementById('publish_date_container');
        container.style.display = checkbox.checked ? 'block' : 'none';
    });
</script>
@endpush