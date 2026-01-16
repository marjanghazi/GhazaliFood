@extends('layouts.admin')

@section('title', 'Categories')
@section('page_title', 'Category Management')
@section('breadcrumb', 'All Categories')

@section('page_actions')
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i> Create Category
    </a>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="categoriesTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Parent</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Products</th>
                                <th>Order</th>
                                <th>Created By</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                            <tr>
                                <td>{{ $category->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($category->category_image)
                                            <img src="{{ asset('storage/' . $category->category_image) }}" 
                                                 class="rounded me-3" width="40" height="40" alt="{{ $category->name }}">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center me-3" 
                                                 style="width: 40px; height: 40px;">
                                                <i class="fas fa-folder text-muted"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <strong>{{ $category->name }}</strong>
                                            @if($category->slug)
                                                <div class="text-muted small">{{ $category->slug }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $category->parent_name }}</td>
                                <td>{!! $category->type_badge !!}</td>
                                <td>{!! $category->status_badge !!}</td>
                                <td>
                                    <span class="badge bg-info">{{ $category->products_count ?? 0 }}</span>
                                </td>
                                <td>{{ $category->display_order }}</td>
                                <td>{{ $category->creator->name ?? 'System' }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.categories.show', $category) }}"
                                           class="btn btn-sm btn-outline-primary" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.categories.edit', $category) }}"
                                           class="btn btn-sm btn-outline-info" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.categories.destroy', $category) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                    title="Delete"
                                                    onclick="return confirm('Are you sure you want to delete this category? All subcategories and products will need to be reassigned.');">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-folder-open fa-3x mb-3"></i>
                                        <p>No categories found. Create your first category!</p>
                                        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i> Create Category
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($categories->hasPages())
                    <div class="d-flex justify-content-center mt-3">
                        {{ $categories->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    #categoriesTable tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.02);
    }
</style>
@endpush

@push('scripts')
<script>
    // Add search functionality
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.createElement('input');
        searchInput.type = 'text';
        searchInput.className = 'form-control mb-3';
        searchInput.placeholder = 'Search categories...';
        searchInput.id = 'categorySearch';
        
        const cardBody = document.querySelector('.card-body');
        cardBody.insertBefore(searchInput, cardBody.firstChild);
        
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#categoriesTable tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    });
</script>
@endpush