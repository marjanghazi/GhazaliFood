@extends('layouts.admin')

@section('title', 'Product Reviews')
@section('page_title', 'Review Management')
@section('breadcrumb', 'All Reviews')

@section('content')
<div class="card shadow">
    <div class="card-body">
        <!-- Filters -->
        <div class="row mb-4">
            <div class="col-md-4 mb-2">
                <select class="form-select form-select-sm" id="statusFilter">
                    <option value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>
            <div class="col-md-4 mb-2">
                <select class="form-select form-select-sm" id="ratingFilter">
                    <option value="">All Ratings</option>
                    <option value="5">5 Stars</option>
                    <option value="4">4 Stars</option>
                    <option value="3">3 Stars</option>
                    <option value="2">2 Stars</option>
                    <option value="1">1 Star</option>
                </select>
            </div>
            <div class="col-md-4 mb-2">
                <input type="date" class="form-control form-control-sm" id="dateFilter" placeholder="Filter by date">
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover data-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Customer</th>
                        <th>Rating</th>
                        <th>Review</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Verified</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reviews as $review)
                    <tr class="review-row" 
                        data-status="{{ $review->status }}"
                        data-rating="{{ $review->rating }}"
                        data-date="{{ $review->created_at->format('Y-m-d') }}">
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="{{ $review->product->primaryImage->media_url ?? 'https://via.placeholder.com/40' }}" 
                                     class="rounded me-2" width="40" height="40" 
                                     style="object-fit: cover;" alt="{{ $review->product->name }}">
                                <div>
                                    <strong>{{ Str::limit($review->product->name, 30) }}</strong>
                                    <div class="text-muted small">SKU: {{ $review->product->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div>{{ $review->user->name }}</div>
                            <small class="text-muted">{{ $review->user->email }}</small>
                        </td>
                        <td>
                            <div class="rating">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star{{ $i > $review->rating ? '-o' : '' }} text-warning"></i>
                                @endfor
                            </div>
                            <small class="text-muted">{{ $review->rating }}/5</small>
                        </td>
                        <td>
                            @if($review->title)
                                <strong>{{ $review->title }}</strong><br>
                            @endif
                            {{ Str::limit($review->comment, 60) }}
                            @if($review->pros || $review->cons)
                                <div class="small text-muted mt-1">
                                    @if($review->pros)
                                        <div>✓ {{ Str::limit($review->pros, 30) }}</div>
                                    @endif
                                    @if($review->cons)
                                        <div>✗ {{ Str::limit($review->cons, 30) }}</div>
                                    @endif
                                </div>
                            @endif
                        </td>
                        <td>
                            @php
                                $statusColors = [
                                    'pending' => 'warning',
                                    'approved' => 'success',
                                    'rejected' => 'danger'
                                ];
                            @endphp
                            <span class="badge bg-{{ $statusColors[$review->status] }}">
                                {{ ucfirst($review->status) }}
                            </span>
                        </td>
                        <td>{{ $review->created_at->format('M d, Y') }}</td>
                        <td>
                            @if($review->is_verified_purchase)
                                <span class="badge bg-success">Verified</span>
                            @else
                                <span class="badge bg-secondary">Unverified</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.reviews.show', $review) }}" 
                                   class="btn btn-sm btn-outline-primary" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                @if($review->status === 'pending')
                                <form action="{{ route('admin.reviews.approve', $review) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-success" title="Approve">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.reviews.reject', $review) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Reject">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                                @endif
                                
                                <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger confirm-delete" 
                                            data-item-name="Review by {{ $review->user->name }}">
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
                Showing {{ $reviews->firstItem() }} to {{ $reviews->lastItem() }} of {{ $reviews->total() }} entries
            </div>
            <div>
                {{ $reviews->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Filter reviews
    $(document).ready(function() {
        $('#statusFilter, #ratingFilter, #dateFilter').change(function() {
            filterReviews();
        });
        
        function filterReviews() {
            const status = $('#statusFilter').val();
            const rating = $('#ratingFilter').val();
            const date = $('#dateFilter').val();
            
            $('.review-row').each(function() {
                const rowStatus = $(this).data('status');
                const rowRating = $(this).data('rating');
                const rowDate = $(this).data('date');
                
                let show = true;
                
                if (status && rowStatus !== status) show = false;
                if (rating && rowRating != rating) show = false;
                if (date && rowDate !== date) show = false;
                
                $(this).toggle(show);
            });
        }
    });
</script>
@endpush