@extends('layouts.admin')

@section('title', 'Products Report')
@section('page_title', 'Reports')
@section('breadcrumb', 'Products Report')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Products Performance Report</h5>
                <div class="card-tools">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search products..." id="productSearch">
                        <button class="btn btn-outline-secondary" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <!-- Summary Card -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <h6 class="card-title">Total Products</h6>
                                <h3 class="card-text">{{ $products->total() }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <h6 class="card-title">Total Revenue</h6>
                                <h3 class="card-text">${{ number_format($totalRevenue, 2) }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <h6 class="card-title">Avg. Price</h6>
                                <h3 class="card-text">
                                    ${{ number_format($products->avg('best_price'), 2) }}
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-warning text-white">
                            <div class="card-body">
                                <h6 class="card-title">Avg. Rating</h6>
                                <h3 class="card-text">
                                    {{ number_format($products->avg('average_rating'), 1) }}/5
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Products Table -->
                <div class="table-responsive">
                    <table class="table table-hover" id="productsTable">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Orders</th>
                                <th>Revenue</th>
                                <th>Rating</th>
                                <th>Reviews</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            @if($product->media->count() > 0)
                                                <img src="{{ asset('storage/' . $product->media->first()->media_url) }}" 
                                                     class="rounded" width="40" height="40" alt="{{ $product->name }}">
                                            @else
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                                     style="width: 40px; height: 40px;">
                                                    <i class="fas fa-box text-muted"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <strong>{{ $product->name }}</strong>
                                            <div class="text-muted small">{{ $product->sku ?? 'N/A' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $product->category->name ?? 'Uncategorized' }}</td>
                                <td>${{ number_format($product->best_price, 2) }}</td>
                                <td>{{ $product->orders_count ?? 0 }}</td>
                                <td>
                                    ${{ number_format(($product->orders_count ?? 0) * $product->best_price, 2) }}
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="star-rating me-2">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= floor($product->average_rating) ? 'text-warning' : 'text-muted' }} fa-xs"></i>
                                            @endfor
                                        </div>
                                        <span>{{ number_format($product->average_rating, 1) }}</span>
                                    </div>
                                </td>
                                <td>{{ $product->total_reviews }}</td>
                                <td>
                                    <span class="badge bg-{{ $product->status == 'published' ? 'success' : ($product->status == 'draft' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($product->status) }}
                                    </span>
                                </td>
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
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($products->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $products->links() }}
                    </div>
                @endif

                <!-- Export Options -->
                <div class="mt-4">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Export Data</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <button class="btn btn-outline-success w-100" onclick="exportToCSV()">
                                        <i class="fas fa-file-csv me-2"></i> Export as CSV
                                    </button>
                                </div>
                                <div class="col-md-4">
                                    <button class="btn btn-outline-danger w-100" onclick="exportToPDF()">
                                        <i class="fas fa-file-pdf me-2"></i> Export as PDF
                                    </button>
                                </div>
                                <div class="col-md-4">
                                    <button class="btn btn-outline-primary w-100" onclick="printReport()">
                                        <i class="fas fa-print me-2"></i> Print Report
                                    </button>
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
    .star-rating {
        color: #ffc107;
    }
    #productsTable tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.02);
    }
</style>
@endpush

@push('scripts')
<script>
    // Search functionality
    document.getElementById('productSearch').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('#productsTable tbody tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });

    // Export functions
    function exportToCSV() {
        alert('CSV export functionality will be implemented here.');
        // You would implement AJAX call to export endpoint
    }

    function exportToPDF() {
        alert('PDF export functionality will be implemented here.');
        // You would implement AJAX call to PDF generation endpoint
    }

    function printReport() {
        window.print();
    }
</script>
@endpush