@extends('layouts.admin')

@section('title', 'Edit Banner')
@section('page_title', 'Banners')
@section('breadcrumb', 'Edit Banner')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Edit Banner: {{ $banner->title }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.banners.update', $banner) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="title" class="form-label">Title *</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                       id="title" name="title" value="{{ old('title', $banner->title) }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" name="description" rows="3">{{ old('description', $banner->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="link_url" class="form-label">Link URL</label>
                                <input type="url" class="form-control @error('link_url') is-invalid @enderror" 
                                       id="link_url" name="link_url" value="{{ old('link_url', $banner->link_url) }}">
                                @error('link_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="alt_text" class="form-label">Alt Text</label>
                                <input type="text" class="form-control @error('alt_text') is-invalid @enderror" 
                                       id="alt_text" name="alt_text" value="{{ old('alt_text', $banner->alt_text) }}">
                                @error('alt_text')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="position" class="form-label">Position *</label>
                                <select class="form-select @error('position') is-invalid @enderror" 
                                        id="position" name="position" required>
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
                                <label for="display_order" class="form-label">Display Order</label>
                                <input type="number" class="form-control @error('display_order') is-invalid @enderror" 
                                       id="display_order" name="display_order" 
                                       value="{{ old('display_order', $banner->display_order) }}" min="0">
                                @error('display_order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Lower numbers display first</small>
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Status *</label>
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
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="start_date" class="form-label">Start Date *</label>
                                <input type="datetime-local" class="form-control @error('start_date') is-invalid @enderror" 
                                       id="start_date" name="start_date" 
                                       value="{{ old('start_date', $banner->start_date->format('Y-m-d\TH:i')) }}" required>
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="end_date" class="form-label">End Date *</label>
                                <input type="datetime-local" class="form-control @error('end_date') is-invalid @enderror" 
                                       id="end_date" name="end_date" 
                                       value="{{ old('end_date', $banner->end_date->format('Y-m-d\TH:i')) }}" required>
                                @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Current Banner Image</label>
                                @if($banner->banner_image)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $banner->banner_image) }}" 
                                             class="img-fluid rounded" alt="{{ $banner->alt_text }}" style="max-height: 200px;">
                                    </div>
                                @endif
                                <label for="banner_image" class="form-label">Change Banner Image</label>
                                <input type="file" class="form-control @error('banner_image') is-invalid @enderror" 
                                       id="banner_image" name="banner_image" accept="image/*">
                                @error('banner_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Recommended size: 1920x600px for desktop</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Current Mobile Banner Image</label>
                                @if($banner->banner_mobile_image)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $banner->banner_mobile_image) }}" 
                                             class="img-fluid rounded" alt="{{ $banner->alt_text }}" style="max-height: 200px;">
                                    </div>
                                @endif
                                <label for="banner_mobile_image" class="form-label">Change Mobile Banner Image</label>
                                <input type="file" class="form-control @error('banner_mobile_image') is-invalid @enderror" 
                                       id="banner_mobile_image" name="banner_mobile_image" accept="image/*">
                                @error('banner_mobile_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Recommended size: 768x300px for mobile</small>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Update Banner
                        </button>
                        <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-1"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection