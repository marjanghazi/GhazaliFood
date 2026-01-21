@extends('layouts.admin')

@section('title', 'Hero Images Management | Admin Panel')
@section('page_title', 'Hero Images Management')
@section('breadcrumb', 'Hero Images')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0">Hero Images Management</h4>
    <a href="{{ route('admin.hero-images.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i> Add New Image
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th width="60">Sort</th>
                        <th>Preview</th>
                        <th>Type</th>
                        <th>Position</th>
                        <th>Title/Label</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="sortableHeroImages">
                    @forelse($heroImages as $image)
                    <tr class="hero-image-item" data-id="{{ $image->id }}">
                        <td>
                            <i class="fas fa-arrows-alt sortable-handle"></i>
                        </td>
                        <td>
                            @if($image->full_image_url)
                                <img src="{{ $image->full_image_url }}" 
                                     class="image-preview" 
                                     alt="{{ $image->title ?? $image->product_label ?? 'Hero Image' }}">
                            @elseif($image->icon)
                                <div class="image-preview d-flex align-items-center justify-content-center bg-light">
                                    <i class="{{ $image->icon }} fa-lg text-primary"></i>
                                </div>
                            @else
                                <div class="image-preview d-flex align-items-center justify-content-center bg-light">
                                    <i class="fas fa-image text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <span class="badge 
                                @if($image->image_type == 'main') bg-primary
                                @elseif($image->image_type == 'floating') bg-info
                                @elseif($image->image_type == 'badge') bg-warning
                                @else bg-secondary @endif">
                                {{ ucfirst($image->image_type) }}
                            </span>
                        </td>
                        <td>{{ $image->position }}</td>
                        <td>
                            {{ $image->title ?? $image->product_label ?? $image->badge_text ?? 'N/A' }}
                        </td>
                        <td>
                            <span class="{{ $image->is_active ? 'status-active' : 'status-inactive' }}">
                                {{ $image->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.hero-images.edit', $image->id) }}" 
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                <form action="{{ route('admin.hero-images.destroy', $image->id) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('Are you sure you want to delete this image?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                
                                <form action="{{ route('admin.hero-images.toggle-status', $image->id) }}" 
                                      method="POST" 
                                      class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm 
                                        {{ $image->is_active ? 'btn-outline-warning' : 'btn-outline-success' }}">
                                        <i class="fas fa-power-off"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <div class="text-muted">
                                <i class="fas fa-images fa-3x mb-3"></i>
                                <p>No hero images found. Add your first image!</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-4">
    <div class="card">
        <div class="card-body">
            <h6>Hero Section Structure</h6>
            <div class="row">
                <div class="col-md-6">
                    <div class="alert alert-info">
                        <strong>Main Image:</strong> 1 required<br>
                        <strong>Floating Images:</strong> Up to 4 positions<br>
                        <strong>Badges:</strong> Up to 3 positions<br>
                        <small class="text-muted">Arrange items by dragging the sort handle</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="alert alert-light">
                        <h6>Tips:</h6>
                        <ul class="mb-0">
                            <li>Recommended image size: 800x800px for main image</li>
                            <li>Floating images: 400x400px</li>
                            <li>Use high-quality, optimized images</li>
                            <li>Keep product labels short and descriptive</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection