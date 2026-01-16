@extends('layouts.admin')

@section('title', 'View Category')
@section('page_title', 'Categories')
@section('breadcrumb', 'View Category')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Category Details: {{ $category->name }}</h5>
                <div>
                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Back
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Category Information</h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <tr>
                                        <th style="width: 30%">Category Name:</th>
                                        <td>{{ $category->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Slug:</th>
                                        <td>{{ $category->slug }}</td>
                                    </tr>
                                    <tr>
                                        <th>Description:</th>
                                        <td>{{ $category->description ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Parent Category:</th>
                                        <td>{{ $category->parent_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Type:</th>
                                        <td>{!! $category->type_badge !!}</td>
                                    </tr>
                                    <tr>
                                        <th>Status:</th>
                                        <td>{!! $category->status_badge !!}</td>
                                    </tr>
                                    <tr>
                                        <th>Display Order:</th>
                                        <td>{{ $category->display_order }}</td>
                                    </tr>
                                    <tr>
                                        <th>Total Products:</th>
                                        <td>
                                            <span class="badge bg-info">{{ $category->products->count() }}</span>
                                            @if($category->products->count() > 0)
                                                <a href="{{ route('admin.products.index') }}?category={{ $category->id }}" 
                                                   class="btn btn-sm btn-outline-primary ms-2">
                                                    View Products
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- Subcategories -->
                        @if($category->children->count() > 0)
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Subcategories ({{ $category->children->count() }})</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Type</th>
                                                <th>Status</th>
                                                <th>Products</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($category->children as $subcategory)
                                            <tr>
                                                <td>{{ $subcategory->name }}</td>
                                                <td>{!! $subcategory->type_badge !!}</td>
                                                <td>{!! $subcategory->status_badge !!}</td>
                                                <td>{{ $subcategory->products->count() }}</td>
                                                <td>
                                                    <div class="btn-group btn-group-sm" role="group">
                                                        <a href="{{ route('admin.categories.show', $subcategory) }}" 
                                                           class="btn btn-outline-primary">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('admin.categories.edit', $subcategory) }}" 
                                                           class="btn btn-outline-info">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- SEO Information -->
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">SEO Information</h6>
                            </div>
                            <div class="card-body">
                                <p><strong>Meta Title:</strong></p>
                                <p class="text-muted">{{ $category->meta_title ?? 'Not set' }}</p>
                                
                                <p><strong>Meta Description:</strong></p>
                                <p class="text-muted">{{ $category->meta_description ?? 'Not set' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <!-- Category Image -->
                        <div class="card mb-3">
                            <div class="card-header">
                                <h6 class="mb-0">Category Image</h6>
                            </div>
                            <div class="card-body text-center">
                                @if($category->category_image)
                                    <img src="{{ asset('storage/' . $category->category_image) }}" 
                                         class="img-fluid rounded mb-3" alt="{{ $category->name }}" 
                                         style="max-height: 200px;">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                         style="height: 200px;">
                                        <i class="fas fa-folder fa-3x text-muted"></i>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Creation Info -->
                        <div class="card mb-3">
                            <div class="card-header">
                                <h6 class="mb-0">Creation Info</h6>
                            </div>
                            <div class="card-body">
                                <p><strong>Created By:</strong><br>
                                   {{ $category->creator->name ?? 'System' }}</p>
                                <p><strong>Created At:</strong><br>
                                   {{ $category->created_at->format('M d, Y h:i A') }}</p>
                                <p><strong>Last Updated:</strong><br>
                                   {{ $category->updated_at->format('M d, Y h:i A') }}</p>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="card mb-3">
                            <div class="card-header">
                                <h6 class="mb-0">Quick Actions</h6>
                            </div>
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <a href="{{ route('admin.products.create') }}?category={{ $category->id }}" 
                                       class="btn btn-outline-success">
                                        <i class="fas fa-plus me-1"></i> Add Product
                                    </a>
                                    
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" 
                                          class="d-grid">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" 
                                                onclick="return confirm('Are you sure you want to delete this category? All subcategories and products will need to be reassigned.');">
                                            <i class="fas fa-trash me-1"></i> Delete Category
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Statistics -->
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Statistics</h6>
                            </div>
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-6 mb-3">
                                        <div class="border rounded p-2">
                                            <div class="h4 mb-0">{{ $category->children->count() }}</div>
                                            <small class="text-muted">Subcategories</small>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <div class="border rounded p-2">
                                            <div class="h4 mb-0">{{ $category->products->count() }}</div>
                                            <small class="text-muted">Products</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection