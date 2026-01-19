@extends('layouts.admin')

@section('title', 'Add New Product')
@section('page_title', 'Add New Product')
@section('breadcrumb', 'Products')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<style>
    .form-section {
        background: #fff;
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid #e9ecef;
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #edf2f7;
    }

    .image-preview-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 12px;
        margin-top: 10px;
    }

    .image-preview-card {
        position: relative;
        border: 1px solid #e9ecef;
        border-radius: 6px;
        overflow: hidden;
    }

    .image-preview-card img {
        width: 100%;
        height: 100px;
        object-fit: cover;
    }

    .image-info {
        padding: 8px;
        background: #f8f9fa;
        border-top: 1px solid #e9ecef;
    }

    .image-info small {
        font-size: 0.75rem;
        color: #6c757d;
        display: block;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .primary-badge {
        position: absolute;
        top: 5px;
        left: 5px;
        background: #28a745;
        color: white;
        font-size: 0.65rem;
        padding: 2px 6px;
        border-radius: 3px;
        z-index: 1;
    }

    .flag-checkboxes {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 8px;
    }

    .flag-checkbox {
        background: #f8f9fa;
        padding: 8px 12px;
        border-radius: 6px;
        border: 1px solid #e9ecef;
    }

    .flag-checkbox .form-check-input {
        margin-top: 0.2rem;
    }

    .flag-checkbox .form-check-label {
        font-size: 0.9rem;
        color: #495057;
    }

    @media (max-width: 768px) {
        .form-section {
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .image-preview-container {
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            gap: 8px;
        }

        .image-preview-card img {
            height: 80px;
        }

        .flag-checkboxes {
            grid-template-columns: 1fr;
        }
    }

    .product-save-actions {
        position: sticky;
        bottom: 0;
        background: white;
        padding: 1rem;
        border-top: 1px solid #e9ecef;
        margin-top: 2rem;
        z-index: 1000;
        box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.05);
    }

    .loading-spinner {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.8);
        z-index: 9999;
        justify-content: center;
        align-items: center;
    }

    .loading-spinner.show {
        display: flex;
    }

    .char-counter {
        font-size: 0.75rem;
        color: #6c757d;
    }

    .char-counter.warning {
        color: #ffc107;
    }

    .char-counter.danger {
        color: #dc3545;
    }

    .form-control.is-invalid {
        border-color: #dc3545;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-3 px-md-4">
    <!-- Loading Spinner -->
    <div class="loading-spinner" id="loadingSpinner">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">Add New Product</h1>
                    <p class="text-muted mb-0">Fill in the essential details to add a new product</p>
                </div>
                <div class="d-none d-md-block">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i> Back to Products
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <h5 class="alert-heading">
            <i class="fas fa-exclamation-triangle me-2"></i>Please fix the following errors:
        </h5>
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="product-form">
        @csrf

        <div class="row">
            <!-- Left Column - Main Form -->
            <div class="col-lg-8 mb-4">
                <!-- Basic Information Section -->
                <div class="form-section">
                    <h6 class="section-title">
                        <i class="fas fa-info-circle me-2"></i>Basic Information
                    </h6>

                    <div class="row g-3">
                        <div class="col-md-8">
                            <label for="name" class="form-label fw-medium">Product Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror form-control-lg"
                                id="name" name="name" value="{{ old('name') }}" required
                                placeholder="Enter product name" autofocus>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="slug" class="form-label fw-medium">URL Slug <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                id="slug" name="slug" value="{{ old('slug') }}" required
                                placeholder="product-url-slug">
                            <small class="text-muted">Used in product URL</small>
                            @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="category_id" class="form-label fw-medium">Category <span class="text-danger">*</span></label>
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

                        <div class="col-md-4">
                            <label for="quantity" class="form-label fw-medium">Stock Quantity <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('quantity') is-invalid @enderror"
                                id="quantity" name="quantity" value="{{ old('quantity', 0) }}"
                                min="0" required placeholder="0">
                            @error('quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="sku" class="form-label fw-medium">SKU (Optional)</label>
                            <input type="text" class="form-control @error('sku') is-invalid @enderror"
                                id="sku" name="sku" value="{{ old('sku') }}"
                                placeholder="ABC123">
                            <small class="text-muted">Stock Keeping Unit</small>
                            @error('sku')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="description" class="form-label fw-medium">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                id="description" name="description" rows="4"
                                placeholder="Describe your product..."
                                required>{{ old('description') }}</textarea>
                            <div class="d-flex justify-content-between mt-1">
                                <small class="text-muted">Detailed product description</small>
                                <small id="descriptionCounter" class="char-counter">0 characters</small>
                            </div>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Pricing Section -->
                <div class="form-section">
                    <h6 class="section-title">
                        <i class="fas fa-tag me-2"></i>Pricing
                    </h6>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="best_price" class="form-label fw-medium">Price <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">$</span>
                                <input type="number" step="0.01" min="0"
                                    class="form-control @error('best_price') is-invalid @enderror"
                                    id="best_price" name="best_price" value="{{ old('best_price') }}"
                                    placeholder="0.00" required>
                            </div>
                            <small class="text-muted d-block mt-1">Current selling price</small>
                            @error('best_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="compare_at_price" class="form-label fw-medium">Compare at Price (Optional)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">$</span>
                                <input type="number" step="0.01" min="0"
                                    class="form-control @error('compare_at_price') is-invalid @enderror"
                                    id="compare_at_price" name="compare_at_price" value="{{ old('compare_at_price') }}"
                                    placeholder="0.00">
                            </div>
                            <small class="text-muted d-block mt-1">Original price for discount display</small>
                            @error('compare_at_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="cost_price" class="form-label fw-medium">Cost Price (Optional)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">$</span>
                                <input type="number" step="0.01" min="0"
                                    class="form-control @error('cost_price') is-invalid @enderror"
                                    id="cost_price" name="cost_price" value="{{ old('cost_price') }}"
                                    placeholder="0.00">
                            </div>
                            <small class="text-muted d-block mt-1">Your cost price for profit calculation</small>
                            @error('cost_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Product Images Section -->
                <div class="form-section">
                    <h6 class="section-title">
                        <i class="fas fa-images me-2"></i>Product Images
                    </h6>
                    <p class="text-muted mb-3">Upload product images. The first image will be set as primary.</p>

                    <div class="mb-3">
                        <label for="images" class="form-label fw-medium">Upload Images (Optional)</label>
                        <div class="border rounded p-3 bg-light">
                            <input type="file" class="form-control @error('images.*') is-invalid @enderror"
                                id="images" name="images[]" multiple accept="image/*">
                            <small class="text-muted d-block mt-1">You can upload multiple images at once</small>
                        </div>
                        @error('images.*')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div id="imagePreview" class="image-preview-container"></div>
                </div>
            </div>

            <!-- Right Column - Sidebar -->
            <div class="col-lg-4 mb-4">
                <!-- Product Status & Flags -->
                <div class="form-section">
                    <h6 class="section-title">
                        <i class="fas fa-sliders-h me-2"></i>Settings
                    </h6>

                    <div class="mb-4">
                        <label for="status" class="form-label fw-medium">Status <span class="text-danger">*</span></label>
                        <select class="form-select @error('status') is-invalid @enderror"
                            id="status" name="status" required>
                            <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                            <option value="out_of_stock" {{ old('status') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                            <option value="discontinued" {{ old('status') == 'discontinued' ? 'selected' : '' }}>Discontinued</option>
                        </select>
                        <small class="text-muted d-block mt-1">
                            <strong>Draft:</strong> Hidden from customers<br>
                            <strong>Published:</strong> Visible to customers<br>
                            <strong>Out of Stock:</strong> Visible but can't be purchased<br>
                            <strong>Discontinued:</strong> Hidden and won't appear in search
                        </small>
                        <small class="text-muted d-block mt-1">
                            <strong>Draft:</strong> Hidden from customers<br>
                            <strong>Published:</strong> Visible to customers<br>
                            <strong>Archived:</strong> Hidden and won't appear in search
                        </small>
                        @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-medium mb-2">Product Flags</label>
                        <div class="flag-checkboxes">
                            <div class="flag-checkbox">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_featured"
                                        name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_featured">
                                        <i class="fas fa-star text-warning me-1"></i> Featured Product
                                    </label>
                                </div>
                            </div>
                            <div class="flag-checkbox">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_bestseller"
                                        name="is_bestseller" value="1" {{ old('is_bestseller') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_bestseller">
                                        <i class="fas fa-fire text-danger me-1"></i> Best Seller
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="weight" class="form-label fw-medium">Weight (Optional)</label>
                        <div class="input-group">
                            <input type="number" step="0.01" min="0"
                                class="form-control @error('weight') is-invalid @enderror"
                                id="weight" name="weight" value="{{ old('weight') }}"
                                placeholder="0.00">
                            <span class="input-group-text bg-light">kg</span>
                        </div>
                        @error('weight')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Categories -->
                <div class="form-section">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="section-title mb-0">
                            <i class="fas fa-folder me-2"></i>Categories
                        </h6>
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-plus"></i> New
                        </a>
                    </div>

                    <div class="list-group list-group-flush">
                        @foreach($categories as $category)
                        <div class="list-group-item border-0 py-2 px-0 d-flex justify-content-between align-items-center">
                            <span class="text-dark">{{ Str::limit($category->name, 25) }}</span>
                            <span class="badge bg-primary rounded-pill">{{ $category->products_count ?? 0 }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Save Actions (Bottom) -->
        <div class="product-save-actions">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-6 mb-2 mb-md-0">
                        <div class="d-flex align-items-center">
                            <div class="me-3 d-none d-md-block">
                                <i class="fas fa-save fa-2x text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Save Product</h6>
                                <small class="text-muted">Save your changes or continue editing later</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i> Cancel
                            </a>
                            <button type="submit" name="draft" value="1" class="btn btn-outline-primary">
                                <i class="fas fa-save me-2"></i> Save Draft
                            </button>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check me-2"></i> Save Product
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    // Auto-generate slug from product name
    document.getElementById('name').addEventListener('input', function() {
        const slugInput = document.getElementById('slug');
        if (!slugInput.value || slugInput.value === '') {
            const slug = this.value
                .toLowerCase()
                .replace(/[^\w\s-]/g, '') // Remove special chars
                .replace(/\s+/g, '-') // Replace spaces with dashes
                .replace(/--+/g, '-') // Replace multiple dashes with single dash
                .trim();
            slugInput.value = slug;
        }
    });

    // Character counter for description
    const descriptionInput = document.getElementById('description');
    const descriptionCounter = document.getElementById('descriptionCounter');

    function updateDescriptionCounter() {
        const length = descriptionInput.value.length;
        descriptionCounter.textContent = `${length} characters`;

        if (length < 50) {
            descriptionCounter.className = 'char-counter danger';
        } else if (length < 100) {
            descriptionCounter.className = 'char-counter warning';
        } else {
            descriptionCounter.className = 'char-counter';
        }
    }

    descriptionInput.addEventListener('input', updateDescriptionCounter);
    updateDescriptionCounter(); // Initial call

    // Image preview
    document.getElementById('images').addEventListener('change', function(e) {
        const preview = document.getElementById('imagePreview');
        preview.innerHTML = '';

        const files = Array.from(e.target.files);

        if (files.length === 0) return;

        files.forEach((file, index) => {
            if (!file.type.match('image.*')) return;

            const reader = new FileReader();
            reader.onload = function(e) {
                const card = document.createElement('div');
                card.className = 'image-preview-card';
                card.innerHTML = `
                    ${index === 0 ? '<span class="primary-badge">Primary</span>' : ''}
                    <img src="${e.target.result}" alt="${file.name}">
                    <div class="image-info">
                        <small>${file.name.length > 15 ? file.name.substring(0, 15) + '...' : file.name}</small>
                    </div>
                `;
                preview.appendChild(card);
            }
            reader.readAsDataURL(file);
        });
    });

    // Form submission handling
    document.getElementById('product-form').addEventListener('submit', function(e) {
        // Hide any existing error alerts
        const alert = document.querySelector('.alert');
        if (alert) {
            alert.remove();
        }

        // Show loading spinner
        const loadingSpinner = document.getElementById('loadingSpinner');
        loadingSpinner.classList.add('show');

        // Validate required fields
        const requiredFields = this.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                field.classList.add('is-invalid');

                // Create error message if it doesn't exist
                if (!field.nextElementSibling || !field.nextElementSibling.classList.contains('invalid-feedback')) {
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'invalid-feedback';
                    errorDiv.textContent = 'This field is required';
                    field.parentNode.insertBefore(errorDiv, field.nextSibling);
                }
            } else {
                field.classList.remove('is-invalid');
                const errorDiv = field.nextElementSibling;
                if (errorDiv && errorDiv.classList.contains('invalid-feedback')) {
                    errorDiv.remove();
                }
            }
        });

        if (!isValid) {
            e.preventDefault();
            loadingSpinner.classList.remove('show');

            // Scroll to first error
            const firstError = this.querySelector('.is-invalid');
            if (firstError) {
                firstError.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
                firstError.focus();
            }

            return false;
        }

        return true; // Allow form submission
    });

    // Remove loading spinner if user navigates away
    window.addEventListener('beforeunload', function() {
        const loadingSpinner = document.getElementById('loadingSpinner');
        loadingSpinner.classList.remove('show');
    });

    // Auto-calculate profit if both price and cost price are entered
    const bestPriceInput = document.getElementById('best_price');
    const costPriceInput = document.getElementById('cost_price');

    if (bestPriceInput && costPriceInput) {
        bestPriceInput.addEventListener('input', calculateProfit);
        costPriceInput.addEventListener('input', calculateProfit);
    }

    function calculateProfit() {
        const price = parseFloat(bestPriceInput.value) || 0;
        const costPrice = parseFloat(costPriceInput.value) || 0;

        if (price > 0 && costPrice > 0) {
            const profit = price - costPrice;
            const profitMargin = (profit / price) * 100;
            // You can display this info if you want
        }
    }

    // Display validation errors if they exist
@if($errors->any())
     setTimeout(() => {
        const firstErrorField = document.querySelector('.is-invalid');
        if (firstErrorField) {
            firstErrorField.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
            firstErrorField.focus();
        }
    }, 100);
    @endif
</script>
@endpush