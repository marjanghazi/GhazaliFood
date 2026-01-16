@extends('layouts.admin')

@section('title', 'Edit Product')
@section('page_title', 'Products')
@section('breadcrumb', 'Edit Product')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Edit Product: {{ $product->name }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="name" class="form-label">Product Name *</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $product->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="category_id" class="form-label">Category *</label>
                                <select class="form-select @error('category_id') is-invalid @enderror" 
                                        id="category_id" name="category_id" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="short_description" class="form-label">Short Description *</label>
                                <textarea class="form-control @error('short_description') is-invalid @enderror" 
                                          id="short_description" name="short_description" rows="3" required>{{ old('short_description', $product->short_description) }}</textarea>
                                @error('short_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="full_description" class="form-label">Full Description *</label>
                                <textarea class="form-control @error('full_description') is-invalid @enderror" 
                                          id="full_description" name="full_description" rows="6">{{ old('full_description', $product->full_description) }}</textarea>
                                @error('full_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Product Images -->
                            <div class="mb-4">
                                <label class="form-label">Product Images</label>
                                <div class="mb-3">
                                    <div class="row">
                                        @foreach($product->media as $media)
                                            <div class="col-md-3 mb-2">
                                                <div class="position-relative">
                                                    <img src="{{ asset('storage/' . $media->media_url) }}" 
                                                         class="img-fluid rounded" alt="{{ $media->alt_text }}">
                                                    <div class="form-check position-absolute top-0 start-0 m-2">
                                                        <input class="form-check-input" type="checkbox" 
                                                               name="delete_images[]" value="{{ $media->id }}"
                                                               id="delete_{{ $media->id }}">
                                                        <label class="form-check-label text-white" for="delete_{{ $media->id }}">
                                                            Delete
                                                        </label>
                                                    </div>
                                                    @if($media->is_primary)
                                                        <span class="badge bg-primary position-absolute top-0 end-0 m-2">Primary</span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <input type="file" class="form-control" id="images" name="images[]" 
                                       accept="image/*" multiple>
                                <small class="text-muted">Upload multiple images. First image will be set as primary.</small>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="best_price" class="form-label">Price *</label>
                                <input type="number" class="form-control @error('best_price') is-invalid @enderror" 
                                       id="best_price" name="best_price" 
                                       value="{{ old('best_price', $product->best_price) }}" min="0" step="0.01" required>
                                @error('best_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="compare_at_price" class="form-label">Compare at Price</label>
                                <input type="number" class="form-control @error('compare_at_price') is-invalid @enderror" 
                                       id="compare_at_price" name="compare_at_price" 
                                       value="{{ old('compare_at_price', $product->compare_at_price) }}" min="0" step="0.01">
                                @error('compare_at_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Original price to show discount</small>
                            </div>

                            <div class="mb-3">
                                <label for="type" class="form-label">Product Type *</label>
                                <select class="form-select @error('type') is-invalid @enderror" 
                                        id="type" name="type" required>
                                    <option value="simple" {{ old('type', $product->type) == 'simple' ? 'selected' : '' }}>Simple</option>
                                    <option value="variable" {{ old('type', $product->type) == 'variable' ? 'selected' : '' }}>Variable</option>
                                    <option value="grouped" {{ old('type', $product->type) == 'grouped' ? 'selected' : '' }}>Grouped</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Status *</label>
                                <select class="form-select @error('status') is-invalid @enderror" 
                                        id="status" name="status" required>
                                    <option value="draft" {{ old('status', $product->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="published" {{ old('status', $product->status) == 'published' ? 'selected' : '' }}>Published</option>
                                    <option value="out_of_stock" {{ old('status', $product->status) == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                                    <option value="discontinued" {{ old('status', $product->status) == 'discontinued' ? 'selected' : '' }}>Discontinued</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Product Badges -->
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h6 class="card-title">Product Badges</h6>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" 
                                               id="is_featured" name="is_featured" value="1"
                                               {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_featured">
                                            Featured Product
                                        </label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" 
                                               id="is_best_seller" name="is_best_seller" value="1"
                                               {{ old('is_best_seller', $product->is_best_seller) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_best_seller">
                                            Best Seller
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" 
                                               id="is_new_arrival" name="is_new_arrival" value="1"
                                               {{ old('is_new_arrival', $product->is_new_arrival) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_new_arrival">
                                            New Arrival
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- SEO Section -->
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h6 class="card-title">SEO Settings</h6>
                                    <div class="mb-3">
                                        <label for="seo_title" class="form-label">SEO Title</label>
                                        <input type="text" class="form-control" id="seo_title" name="seo_title" 
                                               value="{{ old('seo_title', $product->seo_title) }}" maxlength="255">
                                    </div>
                                    <div class="mb-3">
                                        <label for="seo_description" class="form-label">SEO Description</label>
                                        <textarea class="form-control" id="seo_description" name="seo_description" 
                                                  rows="2">{{ old('seo_description', $product->seo_description) }}</textarea>
                                    </div>
                                    <div class="mb-0">
                                        <label for="seo_keywords" class="form-label">SEO Keywords</label>
                                        <input type="text" class="form-control" id="seo_keywords" name="seo_keywords" 
                                               value="{{ old('seo_keywords', $product->seo_keywords) }}"
                                               placeholder="comma, separated, keywords">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Variant Management (simplified) -->
                    @if($product->type == 'variable' && $variants->count() > 0)
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">Product Variants</h6>
                        </div>
                        <div class="card-body">
                            <p class="text-muted">Variant management will be implemented separately.</p>
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                To manage variants, please use the dedicated variant management section.
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Update Product
                        </button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-1"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    // Initialize CKEditor for full description
    CKEDITOR.replace('full_description', {
        toolbar: [
            { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat'] },
            { name: 'paragraph', items: ['NumberedList', 'BulletedList', 'Blockquote'] },
            { name: 'links', items: ['Link', 'Unlink'] },
            { name: 'insert', items: ['Image', 'Table'] },
            { name: 'tools', items: ['Maximize'] }
        ],
        height: 200
    });
</script>
@endpush
@endsection