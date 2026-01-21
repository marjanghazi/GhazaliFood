@extends('layouts.admin')

@section('title', 'Add Hero Image | Admin Panel')
@section('page_title', 'Add Hero Image')
@section('breadcrumb', 'Hero Images')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Add Hero Image</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.hero-images.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="image_type" class="form-label">Image Type *</label>
                        <select name="image_type" id="image_type" class="form-select" required 
                                onchange="toggleFormFields(this.value)">
                            <option value="">Select Type</option>
                            @foreach($imageTypes as $value => $label)
                                <option value="{{ $value }}" {{ old('image_type') == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="position" class="form-label">Position *</label>
                        <select name="position" id="position" class="form-select" required>
                            <option value="">Select Position</option>
                            @foreach($positions as $value => $label)
                                <option value="{{ $value }}" {{ old('position') == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            
            <!-- Image Upload Fields -->
            <div id="imageFields" class="{{ old('image_type') == 'badge' ? 'd-none' : '' }}">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="image" class="form-label">Upload Image *</label>
                        <input type="file" name="image" id="image" class="form-control" 
                               accept="image/*" onchange="previewImage(this, 'imagePreview')">
                        <small class="text-muted">Max file size: 5MB. Recommended: 800x800px for main images</small>
                    </div>
                    <div class="col-md-6">
                        <div id="imagePreviewContainer" class="text-center">
                            <img id="imagePreview" src="" alt="Preview" 
                                 style="max-width: 200px; display: none;" class="img-thumbnail mt-2">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title (Optional)</label>
                            <input type="text" name="title" id="title" class="form-control" 
                                   value="{{ old('title') }}" placeholder="Enter title">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="subtitle" class="form-label">Subtitle (Optional)</label>
                            <input type="text" name="subtitle" id="subtitle" class="form-control" 
                                   value="{{ old('subtitle') }}" placeholder="Enter subtitle">
                        </div>
                    </div>
                </div>
                
                <!-- Product Label for floating images -->
                <div id="labelField" class="{{ old('image_type') == 'floating' ? '' : 'd-none' }}">
                    <div class="mb-3">
                        <label for="product_label" class="form-label">Product Label *</label>
                        <input type="text" name="product_label" id="product_label" class="form-control" 
                               value="{{ old('product_label') }}" placeholder="e.g., Almonds, Walnuts, Dates">
                        <small class="text-muted">Display label for product image</small>
                    </div>
                </div>
            </div>
            
            <!-- Badge Fields -->
            <div id="badgeFields" class="{{ old('image_type') == 'badge' ? '' : 'd-none' }}">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="icon" class="form-label">Icon *</label>
                            <input type="text" name="icon" id="icon" class="form-control" 
                                   value="{{ old('icon') }}" placeholder="e.g., fas fa-leaf">
                            <small class="text-muted">Font Awesome icon class. Example: fas fa-leaf</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="badge_text" class="form-label">Badge Text *</label>
                            <input type="text" name="badge_text" id="badge_text" class="form-control" 
                                   value="{{ old('badge_text') }}" placeholder="e.g., 100% Organic">
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Common Fields -->
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="link" class="form-label">Link (Optional)</label>
                        <input type="url" name="link" id="link" class="form-control" 
                               value="{{ old('link') }}" placeholder="https://example.com">
                        <small class="text-muted">Where should this image link to?</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="sort_order" class="form-label">Sort Order</label>
                        <input type="number" name="sort_order" id="sort_order" class="form-control" 
                               value="{{ old('sort_order') ?? 0 }}" min="0">
                    </div>
                </div>
            </div>
            
            <div class="mb-3 form-check">
                <input type="checkbox" name="is_active" id="is_active" class="form-check-input" 
                       {{ old('is_active', true) ? 'checked' : '' }}>
                <label for="is_active" class="form-check-label">Active</label>
            </div>
            
            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.hero-images.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Back
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i> Save Image
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card mt-4">
    <div class="card-body">
        <h6>Icon Reference</h6>
        <div class="row">
            <div class="col-md-6">
                <ul class="list-unstyled">
                    <li><i class="fas fa-leaf me-2"></i> fas fa-leaf - Organic</li>
                    <li><i class="fas fa-award me-2"></i> fas fa-award - Premium</li>
                    <li><i class="fas fa-shipping-fast me-2"></i> fas fa-shipping-fast - Delivery</li>
                    <li><i class="fas fa-trophy me-2"></i> fas fa-trophy - Rated #1</li>
                </ul>
            </div>
            <div class="col-md-6">
                <ul class="list-unstyled">
                    <li><i class="fas fa-heart me-2"></i> fas fa-heart - Favorite</li>
                    <li><i class="fas fa-star me-2"></i> fas fa-star - Rating</li>
                    <li><i class="fas fa-check-circle me-2"></i> fas fa-check-circle - Verified</li>
                    <li><i class="fas fa-shield-alt me-2"></i> fas fa-shield-alt - Secure</li>
                </ul>
            </div>
        </div>
        <p class="mb-0 text-muted">
            Find more icons at <a href="https://fontawesome.com/icons" target="_blank">FontAwesome</a>
        </p>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Initialize form fields based on selected type
    document.addEventListener('DOMContentLoaded', function() {
        const typeSelect = document.getElementById('image_type');
        if (typeSelect.value) {
            toggleFormFields(typeSelect.value);
        }
    });

    function toggleFormFields(type) {
        const imageFields = document.getElementById('imageFields');
        const badgeFields = document.getElementById('badgeFields');
        const labelField = document.getElementById('labelField');
        
        if (type === 'badge') {
            imageFields.classList.add('d-none');
            badgeFields.classList.remove('d-none');
            labelField.classList.add('d-none');
        } else if (type === 'floating') {
            imageFields.classList.remove('d-none');
            badgeFields.classList.add('d-none');
            labelField.classList.remove('d-none');
        } else {
            imageFields.classList.remove('d-none');
            badgeFields.classList.add('d-none');
            labelField.classList.add('d-none');
        }
    }

    function previewImage(input, previewId) {
        const preview = document.getElementById(previewId);
        const file = input.files[0];
        const reader = new FileReader();
        
        reader.onloadend = function() {
            preview.src = reader.result;
            preview.style.display = 'block';
        }
        
        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.src = '';
            preview.style.display = 'none';
        }
    }
</script>
@endpush