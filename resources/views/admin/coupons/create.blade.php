@extends('layouts.admin')

@section('title', 'Create Coupon')
@section('page_title', 'Create New Coupon')
@section('breadcrumb', 'Coupons')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Coupon Details</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.coupons.store') }}" method="POST" id="coupon-form">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="code" class="form-label">Coupon Code *</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('code') is-invalid @enderror" 
                                       id="code" name="code" value="{{ old('code') }}" required>
                                <button type="button" class="btn btn-outline-secondary" id="generate-code">
                                    <i class="fas fa-random"></i>
                                </button>
                            </div>
                            <div class="form-text">Unique code customers will enter at checkout.</div>
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Coupon Name *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="2">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="discount_type" class="form-label">Discount Type *</label>
                            <select class="form-select @error('discount_type') is-invalid @enderror" 
                                    id="discount_type" name="discount_type" required>
                                <option value="percentage" {{ old('discount_type') == 'percentage' ? 'selected' : '' }}>Percentage</option>
                                <option value="fixed" {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
                            </select>
                            @error('discount_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="discount_value" class="form-label">Discount Value *</label>
                            <div class="input-group">
                                @if(old('discount_type') == 'percentage')
                                    <input type="number" step="0.01" min="0" max="100" 
                                           class="form-control @error('discount_value') is-invalid @enderror" 
                                           id="discount_value" name="discount_value" value="{{ old('discount_value') }}" required>
                                    <span class="input-group-text">%</span>
                                @else
                                    <span class="input-group-text">$</span>
                                    <input type="number" step="0.01" min="0" 
                                           class="form-control @error('discount_value') is-invalid @enderror" 
                                           id="discount_value" name="discount_value" value="{{ old('discount_value') }}" required>
                                @endif
                            </div>
                            @error('discount_value')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4 mb-3" id="max-discount-container" 
                             style="{{ old('discount_type') == 'percentage' ? '' : 'display: none;' }}">
                            <label for="max_discount_amount" class="form-label">Max Discount</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" step="0.01" min="0" 
                                       class="form-control @error('max_discount_amount') is-invalid @enderror" 
                                       id="max_discount_amount" name="max_discount_amount" value="{{ old('max_discount_amount') }}">
                            </div>
                            <div class="form-text">Maximum discount for percentage coupons.</div>
                            @error('max_discount_amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="min_order_amount" class="form-label">Minimum Order</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" step="0.01" min="0" 
                                       class="form-control @error('min_order_amount') is-invalid @enderror" 
                                       id="min_order_amount" name="min_order_amount" value="{{ old('min_order_amount') }}">
                            </div>
                            <div class="form-text">Minimum order amount to use coupon.</div>
                            @error('min_order_amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="usage_limit_per_user" class="form-label">Usage per User</label>
                            <input type="number" min="1" 
                                   class="form-control @error('usage_limit_per_user') is-invalid @enderror" 
                                   id="usage_limit_per_user" name="usage_limit_per_user" value="{{ old('usage_limit_per_user', 1) }}">
                            @error('usage_limit_per_user')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="total_usage_limit" class="form-label">Total Usage Limit</label>
                            <input type="number" min="1" 
                                   class="form-control @error('total_usage_limit') is-invalid @enderror" 
                                   id="total_usage_limit" name="total_usage_limit" value="{{ old('total_usage_limit') }}">
                            <div class="form-text">Leave empty for unlimited usage.</div>
                            @error('total_usage_limit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="start_date" class="form-label">Start Date *</label>
                            <input type="date" class="form-control @error('start_date') is-invalid @enderror" 
                                   id="start_date" name="start_date" value="{{ old('start_date', date('Y-m-d')) }}" required>
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="expiry_date" class="form-label">Expiry Date *</label>
                            <input type="date" class="form-control @error('expiry_date') is-invalid @enderror" 
                                   id="expiry_date" name="expiry_date" value="{{ old('expiry_date', date('Y-m-d', strtotime('+30 days'))) }}" required>
                            @error('expiry_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="applicable_to" class="form-label">Applicable To *</label>
                        <select class="form-select @error('applicable_to') is-invalid @enderror" 
                                id="applicable_to" name="applicable_to" required>
                            <option value="all" {{ old('applicable_to') == 'all' ? 'selected' : '' }}>All Products</option>
                            <option value="categories" {{ old('applicable_to') == 'categories' ? 'selected' : '' }}>Specific Categories</option>
                            <option value="products" {{ old('applicable_to') == 'products' ? 'selected' : '' }}>Specific Products</option>
                            <option value="users" {{ old('applicable_to') == 'users' ? 'selected' : '' }}>Specific Users</option>
                        </select>
                        @error('applicable_to')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3" id="categories-container" 
                         style="{{ old('applicable_to') == 'categories' ? '' : 'display: none;' }}">
                        <label class="form-label">Select Categories</label>
                        <select class="form-select select2" id="categories" name="categories[]" multiple>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" 
                                    {{ in_array($category->id, old('categories', [])) ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3" id="products-container" 
                         style="{{ old('applicable_to') == 'products' ? '' : 'display: none;' }}">
                        <label class="form-label">Select Products</label>
                        <select class="form-select select2" id="products" name="products[]" multiple>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" 
                                    {{ in_array($product->id, old('products', [])) ? 'selected' : '' }}>
                                    {{ $product->name }} (${{ number_format($product->best_price, 2) }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="is_active" 
                               name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">
                            Activate coupon immediately
                        </label>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-2"></i> Create Coupon
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Preview -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Coupon Preview</h6>
            </div>
            <div class="card-body text-center">
                <div class="coupon-preview border rounded p-4 mb-3">
                    <h4 id="preview-code" class="text-primary">COUPONCODE</h4>
                    <h5 id="preview-discount">10% OFF</h5>
                    <p id="preview-description" class="text-muted">Valid on all products</p>
                    <small class="text-muted" id="preview-dates">Valid until Dec 31, 2023</small>
                </div>
                
                <div class="text-start small">
                    <div class="mb-2">
                        <strong>Discount Type:</strong>
                        <span id="preview-type" class="float-end">Percentage</span>
                    </div>
                    <div class="mb-2">
                        <strong>Minimum Order:</strong>
                        <span id="preview-min-order" class="float-end">$0.00</span>
                    </div>
                    <div class="mb-2">
                        <strong>Usage Limit:</strong>
                        <span id="preview-usage" class="float-end">1 per user</span>
                    </div>
                    <div class="mb-2">
                        <strong>Applicable To:</strong>
                        <span id="preview-applicable" class="float-end">All Products</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Quick Tips -->
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Coupon Tips</h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled small">
                    <li class="mb-2">
                        <i class="fas fa-lightbulb text-warning me-2"></i>
                        Use unique coupon codes to prevent abuse
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-lightbulb text-warning me-2"></i>
                        Set reasonable expiry dates
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-lightbulb text-warning me-2"></i>
                        Consider minimum order amounts
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-lightbulb text-warning me-2"></i>
                        Monitor usage limits
                    </li>
                    <li class="mb-0">
                        <i class="fas fa-lightbulb text-warning me-2"></i>
                        Test coupons before publishing
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Generate random coupon code
    $('#generate-code').click(function() {
        $.ajax({
            url: '{{ route("admin.coupons.generate-code") }}',
            type: 'GET',
            success: function(response) {
                $('#code').val(response.code);
                updatePreview();
            }
        });
    });
    
    // Toggle max discount field
    $('#discount_type').change(function() {
        if ($(this).val() === 'percentage') {
            $('#max-discount-container').show();
            $('#discount_value').attr('max', '100');
        } else {
            $('#max-discount-container').hide();
            $('#discount_value').removeAttr('max');
        }
        updatePreview();
    });
    
    // Toggle restriction fields
    $('#applicable_to').change(function() {
        $('#categories-container, #products-container').hide();
        
        if ($(this).val() === 'categories') {
            $('#categories-container').show();
        } else if ($(this).val() === 'products') {
            $('#products-container').show();
        }
        updatePreview();
    });
    
    // Update preview in real-time
    $('input, select, textarea').on('input change', function() {
        updatePreview();
    });
    
    function updatePreview() {
        // Update code
        const code = $('#code').val() || 'COUPONCODE';
        $('#preview-code').text(code);
        
        // Update discount
        const type = $('#discount_type').val();
        const value = $('#discount_value').val() || 0;
        let discountText = '';
        
        if (type === 'percentage') {
            discountText = `${value}% OFF`;
            const maxDiscount = $('#max_discount_amount').val();
            if (maxDiscount) {
                discountText += ` (Max $${maxDiscount})`;
            }
        } else {
            discountText = `$${value} OFF`;
        }
        $('#preview-discount').text(discountText);
        
        // Update description
        const description = $('#description').val() || 'Valid on all products';
        $('#preview-description').text(description);
        
        // Update dates
        const startDate = $('#start_date').val();
        const expiryDate = $('#expiry_date').val();
        if (startDate && expiryDate) {
            const start = new Date(startDate).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
            const expiry = new Date(expiryDate).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
            $('#preview-dates').text(`Valid from ${start} to ${expiry}`);
        }
        
        // Update details
        $('#preview-type').text(type === 'percentage' ? 'Percentage' : 'Fixed Amount');
        $('#preview-min-order').text($('#min_order_amount').val() ? `$${$('#min_order_amount').val()}` : '$0.00');
        
        const perUser = $('#usage_limit_per_user').val() || 1;
        const total = $('#total_usage_limit').val() || '∞';
        $('#preview-usage').text(`${perUser} per user, ${total} total`);
        
        const applicable = $('#applicable_to option:selected').text();
        $('#preview-applicable').text(applicable);
    }
    
    // Initialize preview
    updatePreview();
</script>
@endpush