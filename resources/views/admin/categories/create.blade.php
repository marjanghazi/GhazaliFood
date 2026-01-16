@extends('layouts.admin')

@section('title', 'Create Category')
@section('page_title', 'Categories')
@section('breadcrumb', 'Create Category')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Create New Category</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="name" class="form-label">Category Name *</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" name="description" rows="4">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="meta_title" class="form-label">Meta Title</label>
                                <input type="text" class="form-control @error('meta_title') is-invalid @enderror" 
                                       id="meta_title" name="meta_title" value="{{ old('meta_title') }}">
                                @error('meta_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">For SEO purposes (max 255 characters)</small>
                            </div>

                            <div class="mb-3">
                                <label for="meta_description" class="form-label">Meta Description</label>
                                <textarea class="form-control @error('meta_description') is-invalid @enderror" 
                                          id="meta_description" name="meta_description" rows="2">{{ old('meta_description') }}</textarea>
                                @error('meta_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">For SEO purposes (max 500 characters)</small>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="parent_id" class="form-label">Parent Category</label>
                                <select class="form-select @error('parent_id') is-invalid @enderror" 
                                        id="parent_id" name="parent_id">
                                    <option value="">Select Parent (Optional)</option>
                                    @foreach($categories as $parent)
                                        <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                            {{ $parent->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('parent_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Leave empty for main category</small>
                            </div>

                            <div class="mb-3">
                                <label for="type" class="form-label">Category Type *</label>
                                <select class="form-select @error('type') is-invalid @enderror" 
                                        id="type" name="type" required>
                                    <option value="normal" {{ old('type') == 'normal' ? 'selected' : '' }}>Normal</option>
                                    <option value="featured" {{ old('type') == 'featured' ? 'selected' : '' }}>Featured</option>
                                    <option value="popular" {{ old('type') == 'popular' ? 'selected' : '' }}>Popular</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Status *</label>
                                <select class="form-select @error('status') is-invalid @enderror" 
                                        id="status" name="status" required>
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="display_order" class="form-label">Display Order</label>
                                <input type="number" class="form-control @error('display_order') is-invalid @enderror" 
                                       id="display_order" name="display_order" 
                                       value="{{ old('display_order', 0) }}" min="0">
                                @error('display_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Lower numbers appear first</small>
                            </div>

                            <div class="mb-3">
                                <label for="category_image" class="form-label">Category Image</label>
                                <input type="file" class="form-control @error('category_image') is-invalid @enderror" 
                                       id="category_image" name="category_image" accept="image/*">
                                @error('category_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Recommended size: 400x400px</small>
                            </div>

                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">Preview</h6>
                                    <div id="imagePreview" class="text-center mb-3" style="display: none;">
                                        <img id="previewImage" class="img-fluid rounded" 
                                             style="max-height: 150px;" alt="Preview">
                                    </div>
                                    <div id="noImagePreview" class="text-center py-4">
                                        <i class="fas fa-image fa-3x text-muted mb-3"></i>
                                        <p class="text-muted mb-0">No image selected</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Create Category
                        </button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
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
    // Image preview
    document.getElementById('category_image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewImage').src = e.target.result;
                document.getElementById('imagePreview').style.display = 'block';
                document.getElementById('noImagePreview').style.display = 'none';
            }
            reader.readAsDataURL(file);
        } else {
            document.getElementById('imagePreview').style.display = 'none';
            document.getElementById('noImagePreview').style.display = 'block';
        }
    });
</script>
@endpush