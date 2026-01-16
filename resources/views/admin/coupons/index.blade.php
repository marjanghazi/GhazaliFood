@extends('layouts.admin')

@section('title', 'Coupons')
@section('page_title', 'Coupon Management')
@section('breadcrumb', 'All Coupons')

@section('page_actions')
    <a href="{{ route('admin.coupons.create') }}" class="btn btn-success">
        <i class="fas fa-plus me-2"></i> Create Coupon
    </a>
@endsection

@section('content')
<div class="card shadow">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover data-table">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Discount</th>
                        <th>Min. Order</th>
                        <th>Usage</th>
                        <th>Validity</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($coupons as $coupon)
                    <tr>
                        <td>
                            <strong class="text-primary">{{ $coupon->code }}</strong>
                            <div class="text-muted small">{{ $coupon->applicable_to }}</div>
                        </td>
                        <td>
                            <strong>{{ $coupon->name }}</strong>
                            @if($coupon->description)
                                <div class="text-muted small">{{ Str::limit($coupon->description, 50) }}</div>
                            @endif
                        </td>
                        <td>
                            <strong class="text-success">
                                @if($coupon->discount_type === 'percentage')
                                    {{ $coupon->discount_value }}%
                                @else
                                    ${{ number_format($coupon->discount_value, 2) }}
                                @endif
                            </strong>
                            @if($coupon->max_discount_amount && $coupon->discount_type === 'percentage')
                                <div class="text-muted small">Max: ${{ number_format($coupon->max_discount_amount, 2) }}</div>
                            @endif
                        </td>
                        <td>
                            @if($coupon->min_order_amount > 0)
                                ${{ number_format($coupon->min_order_amount, 2) }}
                            @else
                                <span class="text-muted">No minimum</span>
                            @endif
                        </td>
                        <td>
                            <div class="progress" style="height: 6px;">
                                @php
                                    $usagePercent = $coupon->total_usage_limit 
                                        ? ($coupon->used_count / $coupon->total_usage_limit) * 100 
                                        : 0;
                                @endphp
                                <div class="progress-bar bg-{{ $usagePercent > 80 ? 'danger' : 'success' }}" 
                                     style="width: {{ min($usagePercent, 100) }}%">
                                </div>
                            </div>
                            <small class="text-muted">
                                {{ $coupon->used_count }} / {{ $coupon->total_usage_limit ?? '∞' }}
                            </small>
                        </td>
                        <td>
                            <div class="small">
                                <div>From: {{ $coupon->start_date->format('M d, Y') }}</div>
                                <div>To: {{ $coupon->expiry_date->format('M d, Y') }}</div>
                                @if($coupon->expiry_date->isPast())
                                    <span class="badge bg-danger">Expired</span>
                                @elseif($coupon->start_date->isFuture())
                                    <span class="badge bg-warning">Upcoming</span>
                                @else
                                    <span class="badge bg-success">Active</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <form action="{{ route('admin.coupons.toggle-status', $coupon) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-{{ $coupon->is_active ? 'success' : 'secondary' }}">
                                    {{ $coupon->is_active ? 'Active' : 'Inactive' }}
                                </button>
                            </form>
                        </td>
                        <td>{{ $coupon->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.coupons.show', $coupon) }}" 
                                   class="btn btn-sm btn-outline-primary" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.coupons.edit', $coupon) }}" 
                                   class="btn btn-sm btn-outline-info" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger confirm-delete" 
                                            data-item-name="Coupon {{ $coupon->code }}">
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
                Showing {{ $coupons->firstItem() }} to {{ $coupons->lastItem() }} of {{ $coupons->total() }} entries
            </div>
            <div>
                {{ $coupons->links() }}
            </div>
        </div>
    </div>
</div>
@endsection