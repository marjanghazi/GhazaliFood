@extends('layouts.admin')

@section('title', 'Products')
@section('page_title', 'Products Management')
@section('breadcrumb', 'All Products')

@section('page_actions')
    <a href="{{ route('admin.products.create') }}" class="btn btn-success">
        <i class="fas fa-plus me-2"></i> Add New Product
    </a>
@endsection

@section('content')
<div class="card shadow">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Featured</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>
                            <img src="{{ $product->primaryImage->media_url ?? 'https://via.placeholder.com/50' }}" 
                                 class="rounded" width="50" height="50" alt="{{ $product->name }}">
                        </td>
                        <td>
                            <strong>{{ $product->name }}</strong>
                            <div class="text-muted small">{{ Str::limit($product->short_description, 50) }}</div>
                        </td>
                        <td>{{ $product->category->name ?? 'Uncategorized' }}</td>
                        <td>
                            <strong class="text-success">${{ number_format($product->best_price, 2) }}</strong>
                            @if($product->compare_at_price)
                                <div class="text-muted small">
                                    <del>${{ number_format($product->compare_at_price, 2) }}</del>
                                </div>
                            @endif
                        </td>
                        <td>
                            @php
                                $stock = 0; // Calculate from variants
                            @endphp
                            <span class="badge bg-{{ $stock > 0 ? 'success' : 'danger' }}">
                                {{ $stock > 0 ? $stock . ' in stock' : 'Out of stock' }}
                            </span>
                        </td>
                        <td>
                            <form action="{{ route('admin.products.toggle-status', $product) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-outline-{{ $product->status === 'published' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($product->status) }}
                                </button>
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('admin.products.toggle-featured', $product) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-{{ $product->is_featured ? 'warning' : 'outline-secondary' }}">
                                    <i class="fas fa-star"></i>
                                </button>
                            </form>
                        </td>
                        <td>{{ $product->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.products.show', $product) }}" 
                                   class="btn btn-sm btn-outline-primary" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.products.edit', $product) }}" 
                                   class="btn btn-sm btn-outline-info" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger confirm-delete" 
                                            data-item-name="{{ $product->name }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div>
                Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} entries
            </div>
            <div>
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
@endsection