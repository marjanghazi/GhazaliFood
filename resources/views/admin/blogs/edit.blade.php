@extends('layouts.admin')

@section('title', 'Edit Blog Post')
@section('page_title', 'Blogs')
@section('breadcrumb', 'Edit Post')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Edit Blog Post: {{ $blog->title }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.blogs.update', $blog) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="title" class="form-label">Title *</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                    id="title" name="title" value="{{ old('title', $blog->title) }}" required>
                                @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="slug" class="form-label">Slug *</label>
                                <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                    id="slug" name="slug" value="{{ old('slug', $blog->slug) }}" required>
                                <small class="text-muted">URL-friendly version of the title. Auto-generated from title.</small>
                                @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="excerpt" class="form-label">Brief Description *</label>
                                <textarea class="form-control @error('excerpt') is-invalid @enderror"
                                    id="excerpt" name="excerpt" rows="3" required>{{ old('excerpt', $blog->excerpt ?? $blog->brief_description) }}</textarea>
                                @error('excerpt')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="content" class="form-label">Content *</label>
                                <textarea class="form-control @error('content') is-invalid @enderror"
                                    id="content" name="content" rows="10" required>{{ old('content', $blog->content) }}</textarea>
                                @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Category *</label>
                                <select class="form-select @error('category_id') is-invalid @enderror"
                                    id="category_id" name="category_id" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $id => $name)
                                    <option value="{{ $id }}" {{ old('category_id', $blog->category_id) == $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="tags" class="form-label">Tags</label>
                                @php
                                    // Decode tags for display
                                    $tagsValue = old('tags', $blog->tags);
                                    if (is_array($tagsValue)) {
                                        $tagsValue = implode(', ', $tagsValue);
                                    } elseif (is_string($tagsValue) && $tagsValue !== 'null') {
                                        // Check if it's JSON
                                        $decoded = json_decode($tagsValue, true);
                                        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                                            $tagsValue = implode(', ', $decoded);
                                        }
                                    }
                                @endphp
                                <input type="text" class="form-control @error('tags') is-invalid @enderror"
                                    id="tags" name="tags" value="{{ $tagsValue }}"
                                    placeholder="comma, separated, tags">
                                <small class="text-muted">Separate tags with commas</small>
                                @error('tags')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="featured_image" class="form-label">Featured Image</label>
                                @if($blog->featured_image)
                                <div class="mb-2">
                                    <img src="{{ Storage::url($blog->featured_image) }}" 
                                         class="img-thumbnail" 
                                         style="max-height: 100px;" 
                                         alt="{{ $blog->title }}">
                                    <div class="form-check mt-1">
                                        <input class="form-check-input" type="checkbox" 
                                               id="remove_image" name="remove_image" value="1">
                                        <label class="form-check-label" for="remove_image">
                                            Remove current image
                                        </label>
                                    </div>
                                </div>
                                @endif
                                <input type="file" class="form-control @error('featured_image') is-invalid @enderror"
                                    id="featured_image" name="featured_image" accept="image/*">
                                <small class="text-muted">Leave empty to keep current image</small>
                                @error('featured_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="meta_title" class="form-label">SEO Title</label>
                                <input type="text" class="form-control @error('meta_title') is-invalid @enderror"
                                    id="meta_title" name="meta_title" value="{{ old('meta_title', $blog->meta_title ?? $blog->seo_meta_title) }}">
                                @error('meta_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="meta_description" class="form-label">SEO Description</label>
                                <textarea class="form-control @error('meta_description') is-invalid @enderror"
                                    id="meta_description" name="meta_description" rows="3">{{ old('meta_description', $blog->meta_description ?? $blog->seo_meta_description) }}</textarea>
                                @error('meta_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox"
                                        id="is_featured" name="is_featured" value="1" 
                                        {{ old('is_featured', $blog->is_featured ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_featured">
                                        Featured Post
                                    </label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio"
                                        id="status_published" name="status" value="published"
                                        {{ old('status', $blog->status ?? 'draft') == 'published' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="status_published">
                                        Published
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio"
                                        id="status_draft" name="status" value="draft"
                                        {{ old('status', $blog->status ?? 'draft') == 'draft' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="status_draft">
                                        Draft
                                    </label>
                                </div>
                                @error('status')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            @if($blog->published_at)
                            <div class="mb-3">
                                <label class="form-label">Published Date</label>
                                <p class="form-control-plaintext">{{ $blog->published_at->format('F d, Y H:i:s') }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Update Blog Post
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
    // Auto-generate slug from title
    document.getElementById('title').addEventListener('keyup', function() {
        const title = this.value;
        const slug = title.toLowerCase()
            .replace(/[^\w\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim();
        document.getElementById('slug').value = slug;
    });
</script>
@endpush