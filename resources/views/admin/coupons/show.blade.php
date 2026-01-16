@extends('layouts.admin')

@section('title', 'View Coupon')
@section('page_title', 'Coupons')
@section('breadcrumb', 'View Coupon')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Coupon Details: {{ $coupon->code }}</h5>
                <div>
                    <a href="{{ route('admin.coupons.edit', $coupon) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>
                    <a href="{{ route('admin.coupons.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Back
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Coupon Information</h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <tr>
                                        <th style="width: 30%">Coupon Code:</th>
                                        <td>
                                            <span class="badge bg-primary fs-6">{{ $coupon->code }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Coupon Name:</th>
                                        <td>{{ $coupon->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Description:</th>
                                        <td>{{ $coupon->description ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Discount Type:</th>
                                        <td>
                                            <span class="badge bg-{{ $coupon->discount_type == 'percentage' ? 'info' : 'success' }}">
                                                {{ ucfirst($coupon->discount_type) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Discount Value:</th>
                                        <td>
                                            @if($coupon->discount_type == 'percentage')
                                                {{ $coupon->discount_value }}%
                                            @else
                                                ${{ number_format($coupon->discount_value, 2) }}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Minimum Order Amount:</th>
                                        <td>${{ number_format($coupon->min_order_amount, 2) }}</td>
                                    </tr>
                                    @if($coupon->max_discount_amount)
                                    <tr>
                                        <th>Maximum Discount:</th>
                                        <td>${{ number_format($coupon->max_discount_amount, 2) }}</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <th>Usage Limits:</th>
                                        <td>
                                            Per User: {{ $coupon->usage_limit_per_user }}<br>
                                            Total: {{ $coupon->total_usage_limit ?? 'Unlimited' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Used Count:</th>
                                        <td>{{ $coupon->used_count }}</td>
                                    </tr>
                                    <tr>
                                        <th>Applicable To:</th>
                                        <td>
                                            <span class="badge bg-secondary">{{ ucfirst($coupon->applicable_to) }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Status:</th>
                                        <td>
                                            @php
                                                $now = now();
                                                $isExpired = $coupon->expiry_date < $now;
                                                $isActive = $coupon->is_active && !$isExpired;
                                            @endphp
                                            <span class="badge bg-{{ $isActive ? 'success' : ($isExpired ? 'danger' : 'warning') }}">
                                                {{ $isActive ? 'Active' : ($isExpired ? 'Expired' : 'Inactive') }}
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        @if($coupon->applicable_to != 'all' && $coupon->restrictions->count() > 0)
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Restrictions</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Type</th>
                                                <th>Entity</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($coupon->restrictions as $restriction)
                                            <tr>
                                                <td>{{ ucfirst($restriction->restriction_type) }}</td>
                                                <td>
                                                    @php
                                                        $entity = null;
                                                        switch($restriction->restriction_type) {
                                                            case 'category':
                                                                $entity = \App\Models\Category::find($restriction->entity_id);
                                                                break;
                                                            case 'product':
                                                                $entity = \App\Models\Product::find($restriction->entity_id);
                                                                break;
                                                            case 'user':
                                                                $entity = \App\Models\User::find($restriction->entity_id);
                                                                break;
                                                        }
                                                    @endphp
                                                    {{ $entity->name ?? 'ID: ' . $restriction->entity_id }}
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="col-md-4">
                        <div class="card mb-3">
                            <div class="card-header">
                                <h6 class="mb-0">Validity Period</h6>
                            </div>
                            <div class="card-body">
                                <p><strong>Start Date:</strong><br>
                                   {{ $coupon->start_date->format('M d, Y') }}</p>
                                <p><strong>Expiry Date:</strong><br>
                                   {{ $coupon->expiry_date->format('M d, Y') }}</p>
                                <p><strong>Days Remaining:</strong><br>
                                   @php
                                       $daysRemaining = now()->diffInDays($coupon->expiry_date, false);
                                   @endphp
                                   @if($daysRemaining > 0)
                                       <span class="text-success">{{ $daysRemaining }} days</span>
                                   @elseif($daysRemaining == 0)
                                       <span class="text-warning">Expires today</span>
                                   @else
                                       <span class="text-danger">Expired {{ abs($daysRemaining) }} days ago</span>
                                   @endif
                                </p>
                            </div>
                        </div>

                        <div class="card mb-3">
                            <div class="card-header">
                                <h6 class="mb-0">Creation Info</h6>
                            </div>
                            <div class="card-body">
                                <p><strong>Created By:</strong><br>
                                   {{ $coupon->creator->name ?? 'System' }}</p>
                                <p><strong>Created At:</strong><br>
                                   {{ $coupon->created_at->format('M d, Y h:i A') }}</p>
                                <p><strong>Last Updated:</strong><br>
                                   {{ $coupon->updated_at->format('M d, Y h:i A') }}</p>
                            </div>
                        </div>

                        <div class="card mb-3">
                            <div class="card-header">
                                <h6 class="mb-0">Quick Actions</h6>
                            </div>
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <button type="button" class="btn btn-outline-primary copy-coupon" 
                                            data-code="{{ $coupon->code }}">
                                        <i class="fas fa-copy me-1"></i> Copy Code
                                    </button>
                                    
                                    <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" 
                                          class="d-grid">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" 
                                                onclick="return confirm('Are you sure you want to delete this coupon?');">
                                            <i class="fas fa-trash me-1"></i> Delete Coupon
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <h6><i class="fas fa-info-circle me-2"></i> Usage Instructions</h6>
                            <p class="mb-0">Share this code with customers: <code>{{ $coupon->code }}</code></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Copy coupon code to clipboard
    document.querySelectorAll('.copy-coupon').forEach(button => {
        button.addEventListener('click', function() {
            const code = this.getAttribute('data-code');
            navigator.clipboard.writeText(code).then(() => {
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fas fa-check me-1"></i> Copied!';
                setTimeout(() => {
                    this.innerHTML = originalText;
                }, 2000);
            });
        });
    });
</script>
@endpush