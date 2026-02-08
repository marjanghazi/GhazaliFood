@extends('layouts.admin')

@section('title', 'Add New Product')
@section('page_title', 'Add New Product')
@section('breadcrumb', 'Products')

@section('styles')
<style>
    .form-card {
        background: #fff;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        border: 1px solid #e0e0e0;
    }
    
    .card-title {
        font-size: 16px;
        font-weight: 600;
        color: #333;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 2px solid #f0f0f0;
    }
    
    .image-preview {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 10px;
    }
    
    .preview-img {
        width: 100px;
        height: 100px;
        border: 2px solid #ddd;
        border-radius: 5px;
        overflow: hidden;
        position: relative;
    }
    
    .preview-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .primary-badge {
        position: absolute;
        top: 5px;
        left: 5px;
        background: #28a745;
        color: white;
        font-size: 10px;
        padding: 2px 5px;
        border-radius: 3px;
    }
    
    .remove-btn {
        position: absolute;
        top: 5px;
        right: 5px;
        background: #dc3545;
        color: white;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 12px;
    }
    
    .required {
        color: #dc3545;
    }
    
    .help-text {
        font-size: 13px;
        color: #666;
        margin-top: 5px;
    }
    
    .save-bar {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background: white;
        padding: 15px;
        border-top: 1px solid #ddd;
        z-index: 1000;
        box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
    }
    
    @media (max-width: 768px) {
        .form-card {
            padding: 15px;
        }
        
        .preview-img {
            width: 80px;
            height: 80px;
        }
        
        .save-bar {
            position: relative;
            margin-top: 20px;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-1">Add New Product</h1>
                    <p class="text-muted mb-0">Create a new product for your store</p>
                </div>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </div>
    </div>

    <!-- Errors -->
    @if ($errors->any())
    <div class="alert alert-danger mb-4">
        <strong>Please fix errors:</strong>
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Form -->
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="row">
            <!-- Left Column -->
            <div class="col-lg-8">
                <!-- Basic Info -->
                <div class="form-card">
                    <h6 class="card-title"><i class="fas fa-info-circle me-2"></i>Product Details</h6>
                    
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label">Product Name <span class="required">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   name="name" value="{{ old('name') }}" placeholder="Enter product name" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label class="form-label">URL Slug <span class="required">*</span></label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                                   id="slug" name="slug" value="{{ old('slug') }}" placeholder="auto-generates" required>
                            @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <div class="help-text">Leave blank to auto-generate</div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Description <span class="required">*</span></label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  name="description" rows="4" placeholder="Product description" required>{{ old('description') }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Category <span class="required">*</span></label>
                            <select class="form-select @error('category_id') is-invalid @enderror" name="category_id" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Stock Quantity <span class="required">*</span></label>
                            <input type="number" class="form-control @error('quantity') is-invalid @enderror" 
                                   name="quantity" value="{{ old('quantity', 0) }}" min="0" required>
                            @error('quantity')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <!-- Pricing -->
                <div class="form-card">
                    <h6 class="card-title"><i class="fas fa-dollar-sign me-2"></i>Pricing</h6>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Price <span class="required">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" step="0.01" min="0" 
                                       class="form-control @error('best_price') is-invalid @enderror" 
                                       name="best_price" value="{{ old('best_price') }}" placeholder="0.00" required>
                            </div>
                            @error('best_price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <div class="help-text">Selling price</div>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Compare Price</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" step="0.01" min="0" 
                                       class="form-control @error('compare_at_price') is-invalid @enderror" 
                                       name="compare_at_price" value="{{ old('compare_at_price') }}" placeholder="0.00">
                            </div>
                            @error('compare_at_price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <div class="help-text">Original price (for discount)</div>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Cost Price</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" step="0.01" min="0" 
                                       class="form-control @error('cost_price') is-invalid @enderror" 
                                       name="cost_price" value="{{ old('cost_price') }}" placeholder="0.00">
                            </div>
                            @error('cost_price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <div class="help-text">Your cost</div>
                        </div>
                    </div>
                </div>

                <!-- Images -->
                <div class="form-card">
                    <h6 class="card-title"><i class="fas fa-images me-2"></i>Product Images</h6>
                    
                    <div class="mb-3">
                        <label class="form-label">Upload Images</label>
                        <input type="file" class="form-control @error('images.*') is-invalid @enderror" 
                               id="images" name="images[]" multiple accept="image/*">
                        @error('images.*')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div class="help-text">First image will be primary. Max 2MB each.</div>
                    </div>
                    
                    <div id="imagePreview" class="image-preview"></div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-lg-4">
                <!-- Settings -->
                <div class="form-card">
                    <h6 class="card-title"><i class="fas fa-cog me-2"></i>Settings</h6>
                    
                    <div class="mb-4">
                        <label class="form-label">Status <span class="required">*</span></label>
                        <select class="form-select @error('status') is-invalid @enderror" name="status" required>
                            <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                            <option value="out_of_stock" {{ old('status') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                            <option value="discontinued" {{ old('status') == 'discontinued' ? 'selected' : '' }}>Discontinued</option>
                        </select>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label d-block">Product Flags</label>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="is_featured" 
                                   name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_featured">
                                <i class="fas fa-star text-warning me-1"></i> Featured
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="is_bestseller" 
                                   name="is_bestseller" value="1" {{ old('is_bestseller') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_bestseller">
                                <i class="fas fa-fire text-danger me-1"></i> Best Seller
                            </label>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">SKU (Optional)</label>
                        <input type="text" class="form-control @error('sku') is-invalid @enderror" 
                               name="sku" value="{{ old('sku') }}" placeholder="ABC123">
                        @error('sku')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Barcode (Optional)</label>
                        <input type="text" class="form-control @error('barcode') is-invalid @enderror" 
                               name="barcode" value="{{ old('barcode') }}" placeholder="123456789012">
                        @error('barcode')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <!-- Additional Info -->
                <div class="form-card">
                    <h6 class="card-title"><i class="fas fa-weight me-2"></i>Additional Information</h6>
                    
                    <div class="mb-3">
                        <label class="form-label">Weight (kg)</label>
                        <input type="number" step="0.01" min="0" 
                               class="form-control @error('weight') is-invalid @enderror" 
                               name="weight" value="{{ old('weight') }}" placeholder="0.00">
                        @error('weight')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Dimensions</label>
                        <input type="text" class="form-control @error('dimensions') is-invalid @enderror" 
                               name="dimensions" value="{{ old('dimensions') }}" placeholder="L x W x H">
                        @error('dimensions')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <!-- SEO -->
                <div class="form-card">
                    <h6 class="card-title"><i class="fas fa-search me-2"></i>SEO</h6>
                    
                    <div class="mb-3">
                        <label class="form-label">Meta Title</label>
                        <input type="text" class="form-control @error('meta_title') is-invalid @enderror" 
                               name="meta_title" value="{{ old('meta_title') }}">
                        @error('meta_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Meta Description</label>
                        <textarea class="form-control @error('meta_description') is-invalid @enderror" 
                                  name="meta_description" rows="3">{{ old('meta_description') }}</textarea>
                        @error('meta_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Save Buttons -->
        <div class="save-bar">
            <div class="d-flex justify-content-between">
                <div>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-light">
                        <i class="fas fa-times me-1"></i> Cancel
                    </a>
                </div>
                <div>
                    <button type="submit" name="draft" value="1" class="btn btn-outline-primary me-2">
                        <i class="fas fa-save me-1"></i> Save Draft
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-check me-1"></i> Save Product
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    // Auto-generate slug
    document.querySelector('[name="name"]').addEventListener('input', function() {
        const slugInput = document.getElementById('slug');
        if (!slugInput.value) {
            const slug = this.value
                .toLowerCase()
                .replace(/[^\w\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/--+/g, '-')
                .trim();
            slugInput.value = slug;
        }
    });

    // Image preview
    document.getElementById('images').addEventListener('change', function(e) {
        const preview = document.getElementById('imagePreview');
        preview.innerHTML = '';
        
        const files = Array.from(e.target.files);
        
        files.forEach((file, index) => {
            if (!file.type.match('image.*')) return;
            
            if (file.size > 2 * 1024 * 1024) {
                alert(`${file.name} is too large. Max 2MB.`);
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'preview-img';
                div.innerHTML = `
                    ${index === 0 ? '<span class="primary-badge">Main</span>' : ''}
                    <img src="${e.target.result}" alt="${file.name}">
                    <div class="remove-btn" onclick="removeImage(${index})">×</div>
                `;
                preview.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    });

    // Remove image
    window.removeImage = function(index) {
        const input = document.getElementById('images');
        const files = Array.from(input.files);
        files.splice(index, 1);
        
        const dataTransfer = new DataTransfer();
        files.forEach(file => dataTransfer.items.add(file));
        input.files = dataTransfer.files;
        
        // Update preview
        const event = new Event('change');
        input.dispatchEvent(event);
    };

    // Auto focus first field
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('[name="name"]').focus();
    });
</script>
@endpush