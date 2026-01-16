@extends('layouts.admin')

@section('title', 'Add New Product')
@section('page_title', 'Add New Product')
@section('breadcrumb', 'Products')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Product Information</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="product-form">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Product Name *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="category_id" class="form-label">Category *</label>
                            <select class="form-select @error('category_id') is-invalid @enderror" 
                                    id="category_id" name="category_id" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="short_description" class="form-label">Short Description *</label>
                        <textarea class="form-control @error('short_description') is-invalid @enderror" 
                                  id="short_description" name="short_description" rows="3" required>{{ old('short_description') }}</textarea>
                        <div class="form-text">Brief description shown in product listings.</div>
                        @error('short_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="full_description" class="form-label">Full Description *</label>
                        <textarea class="form-control summernote @error('full_description') is-invalid @enderror" 
                                  id="full_description" name="full_description">{{ old('full_description') }}</textarea>
                        @error('full_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="best_price" class="form-label">Price *</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" step="0.01" min="0" 
                                       class="form-control @error('best_price') is-invalid @enderror" 
                                       id="best_price" name="best_price" value="{{ old('best_price') }}" required>
                            </div>
                            @error('best_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="compare_at_price" class="form-label">Compare at Price</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" step="0.01" min="0" 
                                       class="form-control @error('compare_at_price') is-invalid @enderror" 
                                       id="compare_at_price" name="compare_at_price" value="{{ old('compare_at_price') }}">
                            </div>
                            <div class="form-text">Original price for discount display.</div>
                            @error('compare_at_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="type" class="form-label">Product Type *</label>
                            <select class="form-select @error('type') is-invalid @enderror" 
                                    id="type" name="type" required>
                                <option value="simple" {{ old('type') == 'simple' ? 'selected' : '' }}>Simple</option>
                                <option value="variable" {{ old('type') == 'variable' ? 'selected' : '' }}>Variable</option>
                                <option value="grouped" {{ old('type') == 'grouped' ? 'selected' : '' }}>Grouped</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">Status *</label>
                            <select class="form-select @error('status') is-invalid @enderror" 
                                    id="status" name="status" required>
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                                <option value="out_of_stock" {{ old('status') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                                <option value="discontinued" {{ old('status') == 'discontinued' ? 'selected' : '' }}>Discontinued</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Product Flags</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_featured" 
                                       name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_featured">
                                    Featured Product
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_best_seller" 
                                       name="is_best_seller" value="1" {{ old('is_best_seller') ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_best_seller">
                                    Best Seller
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_new_arrival" 
                                       name="is_new_arrival" value="1" {{ old('is_new_arrival') ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_new_arrival">
                                    New Arrival
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="images" class="form-label">Product Images</label>
                        <input type="file" class="form-control @error('images.*') is-invalid @enderror" 
                               id="images" name="images[]" multiple accept="image/*">
                        <div class="form-text">Upload multiple images. First image will be primary.</div>
                        @error('images.*')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div id="imagePreview" class="row mb-3"></div>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="seo_title" class="form-label">SEO Title</label>
                            <input type="text" class="form-control @error('seo_title') is-invalid @enderror" 
                                   id="seo_title" name="seo_title" value="{{ old('seo_title') }}">
                            @error('seo_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-8 mb-3">
                            <label for="seo_keywords" class="form-label">SEO Keywords</label>
                            <input type="text" class="form-control @error('seo_keywords') is-invalid @enderror" 
                                   id="seo_keywords" name="seo_keywords" value="{{ old('seo_keywords') }}">
                            <div class="form-text">Comma separated keywords.</div>
                            @error('seo_keywords')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="seo_description" class="form-label">SEO Description</label>
                        <textarea class="form-control @error('seo_description') is-invalid @enderror" 
                                  id="seo_description" name="seo_description" rows="2">{{ old('seo_description') }}</textarea>
                        @error('seo_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-2"></i> Save Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Product Status Card -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button type="submit" form="product-form" class="btn btn-success">
                        <i class="fas fa-save me-2"></i> Save Product
                    </button>
                    <button type="submit" form="product-form" name="draft" value="1" class="btn btn-outline-secondary">
                        <i class="fas fa-file-alt me-2"></i> Save as Draft
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-2"></i> Cancel
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Categories Card -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Categories</h6>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-plus"></i>
                </a>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    @foreach($categories as $category)
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        {{ $category->name }}
                        <span class="badge bg-primary rounded-pill">{{ $category->products_count ?? 0 }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        
        <!-- Recent Products -->
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Recent Products</h6>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    @foreach(\App\Models\Product::latest()->limit(5)->get() as $recent)
                    <a href="{{ route('admin.products.edit', $recent) }}" 
                       class="list-group-item list-group-item-action d-flex align-items-center">
                        <img src="{{ $recent->primaryImage->media_url ?? 'https://via.placeholder.com/40' }}" 
                             class="rounded me-2" width="40" height="40" alt="{{ $recent->name }}">
                        <div>
                            <strong class="d-block">{{ Str::limit($recent->name, 25) }}</strong>
                            <small class="text-muted">${{ number_format($recent->best_price, 2) }}</small>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    // Initialize Summernote
    $(document).ready(function() {
        $('.summernote').summernote({
            height: 200,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    });

    // Image preview
    document.getElementById('images').addEventListener('change', function(e) {
        const preview = document.getElementById('imagePreview');
        preview.innerHTML = '';
        
        Array.from(e.target.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const col = document.createElement('div');
                col.className = 'col-md-3 mb-2';
                col.innerHTML = `
                    <div class="card">
                        <img src="${e.target.result}" class="card-img-top" style="height: 100px; object-fit: cover;">
                        <div class="card-body p-2">
                            <small class="text-muted">${file.name}</small>
                        </div>
                    </div>
                `;
                preview.appendChild(col);
            }
            reader.readAsDataURL(file);
        });
    });
    
    // Auto-generate SEO title from product name
    document.getElementById('name').addEventListener('input', function() {
        const seoTitle = document.getElementById('seo_title');
        if (!seoTitle.value) {
            seoTitle.value = this.value + ' - Ghazali Food';
        }
    });
</script>
@endpush