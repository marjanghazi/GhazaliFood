@extends('layouts.admin')

@section('title', 'Edit Banner')
@section('page_title', 'Banners')
@section('breadcrumb', 'Edit Banner')

@section('page_actions')
<a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">
    <i class="fas fa-arrow-left me-2"></i> Back to Banners
</a>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-header">
                <h5 class="card-title mb-0">Edit Banner: {{ $banner->title }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.banners.update', $banner) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- Left Column - Main Content -->
                        <div class="col-md-8">
                            <!-- Basic Information -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h6 class="mb-0">Basic Information</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                                            id="title" name="title" value="{{ old('title', $banner->title) }}"
                                            placeholder="Enter banner title" required>
                                        @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror"
                                            id="description" name="description" rows="3"
                                            placeholder="Enter banner description (optional)">{{ old('description', $banner->description) }}</textarea>
                                        @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="link_url" class="form-label">Link URL</label>
                                        <input type="url" class="form-control @error('link_url') is-invalid @enderror"
                                            id="link_url" name="link_url" value="{{ old('link_url', $banner->link_url) }}"
                                            placeholder="https://example.com/page">
                                        @error('link_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Leave empty if banner should not be clickable</small>
                                    </div>

                                    <div class="mb-3">
                                        <label for="alt_text" class="form-label">Alt Text</label>
                                        <input type="text" class="form-control @error('alt_text') is-invalid @enderror"
                                            id="alt_text" name="alt_text" value="{{ old('alt_text', $banner->alt_text) }}"
                                            placeholder="Describe the banner for accessibility">
                                        @error('alt_text')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Desktop Banner Image -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h6 class="mb-0">Desktop Banner Image</h6>
                                </div>
                                <div class="card-body">
                                    @if($banner->banner_image)
                                    <div class="mb-3">
                                        <label class="form-label">Current Desktop Banner</label>
                                        <div class="border rounded p-3 bg-light">
                                            <img src="{{ Storage::url($banner->banner_image) }}"
                                                class="img-fluid rounded" alt="{{ $banner->alt_text }}"
                                                style="max-height: 150px;">
                                            <div class="mt-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="remove_desktop_image" id="remove_desktop_image" value="1">
                                                    <label class="form-check-label text-danger" for="remove_desktop_image">
                                                        Remove current desktop image
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    <div class="mb-3">
                                        <label for="banner_image" class="form-label">
                                            {{ $banner->banner_image ? 'Change' : 'Upload' }} Desktop Banner
                                        </label>
                                        <input type="file" class="form-control @error('banner_image') is-invalid @enderror"
                                            id="banner_image" name="banner_image" accept="image/*">
                                        @error('banner_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="mt-2">
                                            <small class="text-muted">
                                                <i class="fas fa-info-circle me-1"></i>
                                                Recommended size: 1920x600px. Max file size: 5MB. Formats: JPG, PNG, WebP
                                            </small>
                                        </div>
                                    </div>
                                    <div id="imagePreview" class="mt-3 text-center d-none">
                                        <img src="" alt="Preview" class="img-fluid rounded" style="max-height: 200px;">
                                    </div>
                                </div>
                            </div>

                            <!-- Mobile Banner Image -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h6 class="mb-0">Mobile Banner Image</h6>
                                </div>
                                <div class="card-body">
                                    @if($banner->banner_mobile_image)
                                    <div class="mb-3">
                                        <label class="form-label">Current Mobile Banner</label>
                                        <div class="border rounded p-3 bg-light">
                                            <img src="{{ Storage::url($banner->banner_mobile_image) }}"
                                                class="img-fluid rounded" alt="{{ $banner->alt_text }}"
                                                style="max-height: 100px;">
                                            <div class="mt-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="remove_mobile_image" id="remove_mobile_image" value="1">
                                                    <label class="form-check-label text-danger" for="remove_mobile_image">
                                                        Remove current mobile image
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    <div class="mb-3">
                                        <label for="banner_mobile_image" class="form-label">
                                            {{ $banner->banner_mobile_image ? 'Change' : 'Upload' }} Mobile Banner
                                        </label>
                                        <input type="file" class="form-control @error('banner_mobile_image') is-invalid @enderror"
                                            id="banner_mobile_image" name="banner_mobile_image" accept="image/*">
                                        @error('banner_mobile_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="mt-2">
                                            <small class="text-muted">
                                                <i class="fas fa-info-circle me-1"></i>
                                                Recommended size: 768x300px. If not provided, desktop image will be scaled down for mobile.
                                            </small>
                                        </div>
                                    </div>
                                    <div id="mobileImagePreview" class="mt-3 text-center d-none">
                                        <img src="" alt="Mobile Preview" class="img-fluid rounded" style="max-height: 150px;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column - Settings -->
                        <div class="col-md-4">
                            <!-- Position & Order -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h6 class="mb-0">Position & Order</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="position" class="form-label">Position <span class="text-danger">*</span></label>
                                        <select class="form-select @error('position') is-invalid @enderror"
                                            id="position" name="position" required>
                                            <option value="">Select Position</option>
                                            @foreach($positions as $key => $label)
                                            <option value="{{ $key }}" {{ old('position', $banner->position) == $key ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('position')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="display_order" class="form-label">Display Order <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('display_order') is-invalid @enderror"
                                            id="display_order" name="display_order"
                                            value="{{ old('display_order', $banner->display_order) }}"
                                            min="0" step="1" required>
                                        @error('display_order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Lower numbers display first</small>
                                    </div>
                                </div>
                            </div>

                            <!-- Status & Dates -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h6 class="mb-0">Status & Schedule</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                        <select class="form-select @error('status') is-invalid @enderror"
                                            id="status" name="status" required>
                                            <option value="active" {{ old('status', $banner->status) == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="inactive" {{ old('status', $banner->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                            <option value="scheduled" {{ old('status', $banner->status) == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                        </select>
                                        @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
                                        <input type="datetime-local" class="form-control @error('start_date') is-invalid @enderror"
                                            id="start_date" name="start_date"
                                            value="{{ old('start_date', $banner->start_date->format('Y-m-d\TH:i')) }}" required>
                                        @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="end_date" class="form-label">End Date <span class="text-danger">*</span></label>
                                        <input type="datetime-local" class="form-control @error('end_date') is-invalid @enderror"
                                            id="end_date" name="end_date"
                                            value="{{ old('end_date', $banner->end_date->format('Y-m-d\TH:i')) }}" required>
                                        @error('end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Banner Stats -->
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h6 class="mb-0">Banner Statistics</h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span>Total Clicks:</span>
                                        <span class="badge bg-primary">{{ $banner->clicks ?? 0 }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span>Created:</span>
                                        <span class="text-muted small">{{ $banner->created_at->format('M d, Y') }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span>Last Updated:</span>
                                        <span class="text-muted small">{{ $banner->updated_at->format('M d, Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-1"></i> Cancel
                        </a>
                        <div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Update Banner
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Desktop image preview
        const imageInput = document.getElementById('banner_image');
        const imagePreview = document.getElementById('imagePreview');
        const previewImg = imagePreview ? imagePreview.querySelector('img') : null;

        if (imageInput && imagePreview && previewImg) {
            imageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        imagePreview.classList.remove('d-none');
                    };
                    reader.readAsDataURL(file);
                } else {
                    imagePreview.classList.add('d-none');
                    previewImg.src = '';
                }
            });
        }

        // Mobile image preview
        const mobileImageInput = document.getElementById('banner_mobile_image');
        const mobileImagePreview = document.getElementById('mobileImagePreview');
        const mobilePreviewImg = mobileImagePreview ? mobileImagePreview.querySelector('img') : null;

        if (mobileImageInput && mobileImagePreview && mobilePreviewImg) {
            mobileImageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        mobilePreviewImg.src = e.target.result;
                        mobileImagePreview.classList.remove('d-none');
                    };
                    reader.readAsDataURL(file);
                } else {
                    mobileImagePreview.classList.add('d-none');
                    mobilePreviewImg.src = '';
                }
            });
        }

        // Validate end date is after start date
        const startDate = document.getElementById('start_date');
        const endDate = document.getElementById('end_date');

        if (startDate && endDate) {
            startDate.addEventListener('change', function() {
                endDate.min = this.value;
                if (endDate.value < this.value) {
                    endDate.value = this.value;
                }
            });
        }

        // Remove image checkboxes
        const removeDesktopCheckbox = document.getElementById('remove_desktop_image');
        if (removeDesktopCheckbox) {
            removeDesktopCheckbox.addEventListener('change', function() {
                if (this.checked && imageInput) {
                    imageInput.disabled = true;
                } else if (imageInput) {
                    imageInput.disabled = false;
                }
            });
        }

        const removeMobileCheckbox = document.getElementById('remove_mobile_image');
        if (removeMobileCheckbox) {
            removeMobileCheckbox.addEventListener('change', function() {
                if (this.checked && mobileImageInput) {
                    mobileImageInput.disabled = true;
                } else if (mobileImageInput) {
                    mobileImageInput.disabled = false;
                }
            });
        }
    });
</script>
@endsection