@extends('layouts.admin')

@section('title', 'View Product')
@section('page_title', 'Products')
@section('breadcrumb', 'View Product')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Product Details: {{ $product->name }}</h5>
                <div>
                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Back
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <!-- Product Images -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Product Images</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @if($product->media->count() > 0)
                                        @foreach($product->media as $media)
                                            <div class="col-md-3 mb-3">
                                                <div class="position-relative">
                                                    <img src="{{ asset('storage/' . $media->media_url) }}" 
                                                         class="img-fluid rounded" alt="{{ $media->alt_text }}">
                                                    @if($media->is_primary)
                                                        <span class="badge bg-primary position-absolute top-0 start-0 m-2">
                                                            Primary
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="col-12 text-center py-4">
                                            <i class="fas fa-image fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">No images uploaded</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Product Information -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Product Information</h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <tr>
                                        <th style="width: 30%">Product Name:</th>
                                        <td>{{ $product->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Category:</th>
                                        <td>{{ $product->category->name ?? 'Uncategorized' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Slug:</th>
                                        <td>{{ $product->slug }}</td>
                                    </tr>
                                    <tr>
                                        <th>Product Type:</th>
                                        <td>
                                            <span class="badge bg-info">{{ ucfirst($product->type) }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Status:</th>
                                        <td>
                                            <span class="badge bg-{{ $product->status == 'published' ? 'success' : ($product->status == 'draft' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($product->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Price:</th>
                                        <td>
                                            <strong>${{ number_format($product->best_price, 2) }}</strong>
                                            @if($product->compare_at_price)
                                                <del class="text-muted ms-2">${{ number_format($product->compare_at_price, 2) }}</del>
                                                <span class="badge bg-danger ms-2">
                                                    Save {{ number_format((($product->compare_at_price - $product->best_price) / $product->compare_at_price) * 100, 0) }}%
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Rating:</th>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="star-rating me-2">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="fas fa-star {{ $i <= floor($product->average_rating) ? 'text-warning' : 'text-muted' }}"></i>
                                                    @endfor
                                                </div>
                                                <span class="me-2">{{ number_format($product->average_rating, 1) }}/5</span>
                                                <small class="text-muted">({{ $product->total_reviews }} reviews)</small>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Badges:</th>
                                        <td>
                                            @if($product->is_featured)
                                                <span class="badge bg-primary me-1">Featured</span>
                                            @endif
                                            @if($product->is_best_seller)
                                                <span class="badge bg-success me-1">Best Seller</span>
                                            @endif
                                            @if($product->is_new_arrival)
                                                <span class="badge bg-info me-1">New Arrival</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Description</h6>
                            </div>
                            <div class="card-body">
                                <h6>Short Description:</h6>
                                <p class="mb-3">{{ $product->short_description }}</p>
                                
                                <h6>Full Description:</h6>
                                <div class="product-description">
                                    {!! $product->full_description !!}
                                </div>
                            </div>
                        </div>

                        <!-- Variants -->
                        @if($product->variants->count() > 0)
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Product Variants</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Variant</th>
                                                <th>Price</th>
                                                <th>Stock</th>
                                                <th>SKU</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($product->variants as $variant)
                                                @php
                                                    $productVariant = $variant->productVariants->first();
                                                @endphp
                                                @if($productVariant)
                                                <tr>
                                                    <td>{{ $variant->name }}: {{ $variant->value }}</td>
                                                    <td>${{ number_format($productVariant->price, 2) }}</td>
                                                    <td>
                                                        <span class="badge bg-{{ $productVariant->stock_quantity > 10 ? 'success' : ($productVariant->stock_quantity > 0 ? 'warning' : 'danger') }}">
                                                            {{ $productVariant->stock_quantity }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $productVariant->sku }}</td>
                                                    <td>
                                                        <span class="badge bg-{{ $productVariant->status == 'active' ? 'success' : 'danger' }}">
                                                            {{ ucfirst($productVariant->status) }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Reviews -->
                        @if($product->reviews->count() > 0)
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Recent Reviews</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @foreach($product->reviews->take(3) as $review)
                                    <div class="col-md-12 mb-3">
                                        <div class="border rounded p-3">
                                            <div class="d-flex justify-content-between mb-2">
                                                <div>
                                                    <strong>{{ $review->user->name ?? 'Anonymous' }}</strong>
                                                    <div class="star-rating d-inline-block ms-2">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }} fa-xs"></i>
                                                        @endfor
                                                    </div>
                                                </div>
                                                <small class="text-muted">{{ $review->created_at->format('M d, Y') }}</small>
                                            </div>
                                            @if($review->title)
                                                <h6 class="mb-2">{{ $review->title }}</h6>
                                            @endif
                                            <p class="mb-2">{{ $review->comment }}</p>
                                            @if($review->is_verified_purchase)
                                                <small class="text-success">
                                                    <i class="fas fa-check-circle"></i> Verified Purchase
                                                </small>
                                            @endif
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @if($product->reviews->count() > 3)
                                    <div class="text-center mt-3">
                                        <a href="#" class="btn btn-sm btn-outline-primary">
                                            View All Reviews ({{ $product->reviews->count() }})
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="col-md-4">
                        <!-- SEO Information -->
                        <div class="card mb-3">
                            <div class="card-header">
                                <h6 class="mb-0">SEO Information</h6>
                            </div>
                            <div class="card-body">
                                <p><strong>SEO Title:</strong></p>
                                <p class="text-muted">{{ $product->seo_title ?? 'Not set' }}</p>
                                
                                <p><strong>SEO Description:</strong></p>
                                <p class="text-muted">{{ $product->seo_description ?? 'Not set' }}</p>
                                
                                <p><strong>SEO Keywords:</strong></p>
                                <p class="text-muted">{{ $product->seo_keywords ?? 'Not set' }}</p>
                            </div>
                        </div>

                        <!-- Creation Info -->
                        <div class="card mb-3">
                            <div class="card-header">
                                <h6 class="mb-0">Creation Info</h6>
                            </div>
                            <div class="card-body">
                                <p><strong>Created By:</strong><br>
                                   {{ $product->creator->name ?? 'System' }}</p>
                                <p><strong>Created At:</strong><br>
                                   {{ $product->created_at->format('M d, Y h:i A') }}</p>
                                <p><strong>Last Updated:</strong><br>
                                   {{ $product->updated_at->format('M d, Y h:i A') }}</p>
                            </div>
                        </div>

                        <!-- Quick Stats -->
                        <div class="card mb-3">
                            <div class="card-header">
                                <h6 class="mb-0">Quick Stats</h6>
                            </div>
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-6 mb-3">
                                        <div class="border rounded p-2">
                                            <div class="h4 mb-0">{{ $product->reviews->count() }}</div>
                                            <small class="text-muted">Reviews</small>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <div class="border rounded p-2">
                                            <div class="h4 mb-0">{{ $product->orders->count() }}</div>
                                            <small class="text-muted">Orders</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Quick Actions</h6>
                            </div>
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" 
                                          class="d-grid">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" 
                                                onclick="return confirm('Are you sure you want to delete this product? This action cannot be undone.');">
                                            <i class="fas fa-trash me-1"></i> Delete Product
                                        </button>
                                    </form>
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

@push('styles')
<style>
    .product-description {
        line-height: 1.6;
    }
    .product-description p {
        margin-bottom: 1rem;
    }
    .product-description ul, .product-description ol {
        margin-bottom: 1rem;
        padding-left: 2rem;
    }
    .star-rating {
        color: #ffc107;
    }
</style>
@endpush