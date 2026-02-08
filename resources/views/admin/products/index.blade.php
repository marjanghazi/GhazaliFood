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
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th width="50">ID</th>
                        <th width="70">Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Featured</th>
                        <th>Created</th>
                        <th width="150">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>
                            @php
                                $imageUrl = $product->primaryImage ? 
                                    asset('storage/' . $product->primaryImage->image_path) : 
                                    asset('images/default-product.png');
                            @endphp
                            <img src="{{ $imageUrl }}" 
                                 class="rounded border" 
                                 width="50" 
                                 height="50" 
                                 alt="{{ $product->name }}"
                                 style="object-fit: cover;">
                        </td>
                        <td>
                            <div class="fw-bold">{{ $product->name }}</div>
                            <small class="text-muted">{{ Str::limit($product->description, 30) }}</small>
                        </td>
                        <td>{{ $product->category->name ?? '-' }}</td>
                        <td>
                            <div class="fw-bold text-success">${{ number_format($product->best_price, 2) }}</div>
                            @if($product->compare_at_price)
                                <small class="text-muted">
                                    <del>${{ number_format($product->compare_at_price, 2) }}</del>
                                </small>
                            @endif
                        </td>
                        <td>
                            @php
                                $stockClass = $product->stock_quantity > 0 ? 'success' : 'danger';
                                $stockText = $product->stock_quantity > 0 ? 
                                    $product->stock_quantity . ' in stock' : 
                                    'Out of stock';
                            @endphp
                            <span class="badge bg-{{ $stockClass }}">{{ $stockText }}</span>
                        </td>
                        <td>
                            <span class="badge bg-{{ $product->status == 'published' ? 'success' : 'secondary' }}">
                                {{ ucfirst($product->status) }}
                            </span>
                        </td>
                        <td>
                            <form action="{{ route('admin.products.toggle-featured', $product) }}" method="POST" class="d-inline">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-{{ $product->is_featured ? 'warning' : 'outline-secondary' }}">
                                    <i class="fas fa-star"></i>
                                </button>
                            </form>
                        </td>
                        <td>{{ $product->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('admin.products.show', $product) }}" 
                                   class="btn btn-outline-primary" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.products.edit', $product) }}" 
                                   class="btn btn-outline-info" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger confirm-delete" 
                                            title="Delete" data-item-name="{{ $product->name }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center py-4">
                            <i class="fas fa-box-open fa-2x text-muted mb-3"></i>
                            <p class="text-muted">No products found. <a href="{{ route('admin.products.create') }}">Create your first product</a></p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($products->hasPages())
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div class="text-muted">
                Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} entries
            </div>
            <div>
                {{ $products->links() }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Delete confirmation
        $('.confirm-delete').on('click', function(e) {
            e.preventDefault();
            var itemName = $(this).data('item-name');
            var form = $(this).closest('form');
            
            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to delete: " + itemName,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush