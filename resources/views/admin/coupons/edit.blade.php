@extends('layouts.admin')

@section('title', 'Edit Coupon')
@section('page_title', 'Coupons')
@section('breadcrumb', 'Edit Coupon')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Edit Coupon: {{ $coupon->code }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.coupons.update', $coupon) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="code" class="form-label">Coupon Code *</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control @error('code') is-invalid @enderror" 
                                                   id="code" name="code" value="{{ old('code', $coupon->code) }}" required>
                                            <button type="button" class="btn btn-outline-secondary" id="generate-code">
                                                <i class="fas fa-sync-alt"></i>
                                            </button>
                                        </div>
                                        @error('code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Coupon Name *</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                               id="name" name="name" value="{{ old('name', $coupon->name) }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" name="description" rows="3">{{ old('description', $coupon->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="discount_type" class="form-label">Discount Type *</label>
                                        <select class="form-select @error('discount_type') is-invalid @enderror" 
                                                id="discount_type" name="discount_type" required>
                                            <option value="fixed" {{ old('discount_type', $coupon->discount_type) == 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
                                            <option value="percentage" {{ old('discount_type', $coupon->discount_type) == 'percentage' ? 'selected' : '' }}>Percentage</option>
                                        </select>
                                        @error('discount_type')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="discount_value" class="form-label">Discount Value *</label>
                                        <input type="number" class="form-control @error('discount_value') is-invalid @enderror" 
                                               id="discount_value" name="discount_value" 
                                               value="{{ old('discount_value', $coupon->discount_value) }}" 
                                               min="0" step="0.01" required>
                                        @error('discount_value')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="min_order_amount" class="form-label">Minimum Order Amount</label>
                                        <input type="number" class="form-control @error('min_order_amount') is-invalid @enderror" 
                                               id="min_order_amount" name="min_order_amount" 
                                               value="{{ old('min_order_amount', $coupon->min_order_amount) }}" 
                                               min="0" step="0.01">
                                        @error('min_order_amount')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="max_discount_amount" class="form-label">Maximum Discount</label>
                                        <input type="number" class="form-control @error('max_discount_amount') is-invalid @enderror" 
                                               id="max_discount_amount" name="max_discount_amount" 
                                               value="{{ old('max_discount_amount', $coupon->max_discount_amount) }}" 
                                               min="0" step="0.01">
                                        @error('max_discount_amount')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Only for percentage discounts</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="applicable_to" class="form-label">Applicable To *</label>
                                <select class="form-select @error('applicable_to') is-invalid @enderror" 
                                        id="applicable_to" name="applicable_to" required>
                                    <option value="all" {{ old('applicable_to', $coupon->applicable_to) == 'all' ? 'selected' : '' }}>All Products</option>
                                    <option value="categories" {{ old('applicable_to', $coupon->applicable_to) == 'categories' ? 'selected' : '' }}>Specific Categories</option>
                                    <option value="products" {{ old('applicable_to', $coupon->applicable_to) == 'products' ? 'selected' : '' }}>Specific Products</option>
                                </select>
                                @error('applicable_to')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Category Restrictions -->
                            <div class="mb-3 restriction-section" id="category_restrictions" 
                                 style="{{ old('applicable_to', $coupon->applicable_to) == 'categories' ? 'display: block;' : 'display: none;' }}">
                                <label class="form-label">Select Categories</label>
                                <div class="border rounded p-2" style="max-height: 200px; overflow-y: auto;">
                                    @foreach($categories as $category)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" 
                                                   name="categories[]" value="{{ $category->id }}" 
                                                   id="cat_{{ $category->id }}"
                                                   {{ in_array($category->id, old('categories', $coupon->restrictions->where('restriction_type', 'category')->pluck('entity_id')->toArray())) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="cat_{{ $category->id }}">
                                                {{ $category->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Product Restrictions -->
                            <div class="mb-3 restriction-section" id="product_restrictions" 
                                 style="{{ old('applicable_to', $coupon->applicable_to) == 'products' ? 'display: block;' : 'display: none;' }}">
                                <label class="form-label">Select Products</label>
                                <div class="border rounded p-2" style="max-height: 200px; overflow-y: auto;">
                                    @foreach($products as $product)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" 
                                                   name="products[]" value="{{ $product->id }}" 
                                                   id="prod_{{ $product->id }}"
                                                   {{ in_array($product->id, old('products', $coupon->restrictions->where('restriction_type', 'product')->pluck('entity_id')->toArray())) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="prod_{{ $product->id }}">
                                                {{ Str::limit($product->name, 30) }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="usage_limit_per_user" class="form-label">Usage Limit Per User</label>
                                <input type="number" class="form-control @error('usage_limit_per_user') is-invalid @enderror" 
                                       id="usage_limit_per_user" name="usage_limit_per_user" 
                                       value="{{ old('usage_limit_per_user', $coupon->usage_limit_per_user) }}" 
                                       min="1">
                                @error('usage_limit_per_user')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="total_usage_limit" class="form-label">Total Usage Limit</label>
                                <input type="number" class="form-control @error('total_usage_limit') is-invalid @enderror" 
                                       id="total_usage_limit" name="total_usage_limit" 
                                       value="{{ old('total_usage_limit', $coupon->total_usage_limit) }}" 
                                       min="1">
                                @error('total_usage_limit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Leave empty for unlimited</small>
                            </div>

                            <div class="mb-3 form-check form-switch">
                                <input class="form-check-input" type="checkbox" 
                                       id="is_active" name="is_active" value="1" 
                                       {{ old('is_active', $coupon->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Active
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="start_date" class="form-label">Start Date *</label>
                                <input type="date" class="form-control @error('start_date') is-invalid @enderror" 
                                       id="start_date" name="start_date" 
                                       value="{{ old('start_date', $coupon->start_date->format('Y-m-d')) }}" required>
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="expiry_date" class="form-label">Expiry Date *</label>
                                <input type="date" class="form-control @error('expiry_date') is-invalid @enderror" 
                                       id="expiry_date" name="expiry_date" 
                                       value="{{ old('expiry_date', $coupon->expiry_date->format('Y-m-d')) }}" required>
                                @error('expiry_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Update Coupon
                        </button>
                        <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-1"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Show/hide restriction sections
    document.getElementById('applicable_to').addEventListener('change', function() {
        const sections = document.querySelectorAll('.restriction-section');
        sections.forEach(section => {
            section.style.display = 'none';
        });
        
        if (this.value === 'categories') {
            document.getElementById('category_restrictions').style.display = 'block';
        } else if (this.value === 'products') {
            document.getElementById('product_restrictions').style.display = 'block';
        }
    });

    // Generate random coupon code
    document.getElementById('generate-code').addEventListener('click', function() {
        const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        let code = '';
        for (let i = 0; i < 8; i++) {
            code += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        document.getElementById('code').value = code;
    });
</script>
@endpush