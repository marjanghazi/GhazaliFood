@extends('layouts.admin')

@section('title', 'Edit Category')
@section('page_title', 'Categories')
@section('breadcrumb', 'Edit Category')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Edit Category: {{ $category->name }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="name" class="form-label">Category Name *</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $category->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" name="description" rows="4">{{ old('description', $category->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="meta_title" class="form-label">Meta Title</label>
                                <input type="text" class="form-control @error('meta_title') is-invalid @enderror" 
                                       id="meta_title" name="meta_title" value="{{ old('meta_title', $category->meta_title) }}">
                                @error('meta_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="meta_description" class="form-label">Meta Description</label>
                                <textarea class="form-control @error('meta_description') is-invalid @enderror" 
                                          id="meta_description" name="meta_description" rows="2">{{ old('meta_description', $category->meta_description) }}</textarea>
                                @error('meta_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="parent_id" class="form-label">Parent Category</label>
                                <select class="form-select @error('parent_id') is-invalid @enderror" 
                                        id="parent_id" name="parent_id">
                                    <option value="">Select Parent (Optional)</option>
                                    @foreach($categories as $parent)
                                        @if($parent->id != $category->id) <!-- Prevent self-parenting -->
                                            <option value="{{ $parent->id }}" {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
                                                {{ $parent->name }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('parent_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="type" class="form-label">Category Type *</label>
                                <select class="form-select @error('type') is-invalid @enderror" 
                                        id="type" name="type" required>
                                    <option value="normal" {{ old('type', $category->type) == 'normal' ? 'selected' : '' }}>Normal</option>
                                    <option value="featured" {{ old('type', $category->type) == 'featured' ? 'selected' : '' }}>Featured</option>
                                    <option value="popular" {{ old('type', $category->type) == 'popular' ? 'selected' : '' }}>Popular</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Status *</label>
                                <select class="form-select @error('status') is-invalid @enderror" 
                                        id="status" name="status" required>
                                    <option value="active" {{ old('status', $category->status) == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status', $category->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="display_order" class="form-label">Display Order</label>
                                <input type="number" class="form-control @error('display_order') is-invalid @enderror" 
                                       id="display_order" name="display_order" 
                                       value="{{ old('display_order', $category->display_order) }}" min="0">
                                @error('display_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Current Category Image</label>
                                @if($category->category_image)
                                    <div class="mb-2 text-center">
                                        <img src="{{ asset('storage/' . $category->category_image) }}" 
                                             class="img-fluid rounded" alt="{{ $category->name }}" 
                                             style="max-height: 150px;">
                                    </div>
                                @endif
                                <label for="category_image" class="form-label">Change Image</label>
                                <input type="file" class="form-control @error('category_image') is-invalid @enderror" 
                                       id="category_image" name="category_image" accept="image/*">
                                @error('category_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Leave empty to keep current image</small>
                            </div>

                            <!-- Category Info -->
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">Category Info</h6>
                                    <p class="mb-1"><strong>Slug:</strong> {{ $category->slug }}</p>
                                    <p class="mb-1"><strong>Created:</strong> {{ $category->created_at->format('M d, Y') }}</p>
                                    <p class="mb-1"><strong>Updated:</strong> {{ $category->updated_at->format('M d, Y') }}</p>
                                    <p class="mb-0"><strong>Created By:</strong> {{ $category->creator->name ?? 'System' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Update Category
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
    // Image preview for new image
    document.getElementById('category_image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Show preview
                const previewDiv = document.createElement('div');
                previewDiv.className = 'text-center mb-2';
                previewDiv.innerHTML = `
                    <p class="mb-1"><strong>New Image Preview:</strong></p>
                    <img src="${e.target.result}" class="img-fluid rounded" style="max-height: 150px;" alt="Preview">
                `;
                
                const currentImage = document.querySelector('label[for="category_image"]');
                if (!document.getElementById('newImagePreview')) {
                    previewDiv.id = 'newImagePreview';
                    currentImage.parentNode.insertBefore(previewDiv, currentImage);
                } else {
                    document.getElementById('newImagePreview').innerHTML = previewDiv.innerHTML;
                }
            }
            reader.readAsDataURL(file);
        } else {
            const previewDiv = document.getElementById('newImagePreview');
            if (previewDiv) {
                previewDiv.remove();
            }
        }
    });
</script>
@endpush