@extends('layouts.app')

@section('title', 'Checkout - Ghazali Food')

@section('hero')
<section class="hero-section" style="background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?ixlib=rb-4.0.3') center/cover no-repeat;">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="animate__animated animate__fadeInUp">Checkout</h1>
                <nav aria-label="breadcrumb" class="d-flex justify-content-center">
                    <ol class="breadcrumb bg-transparent p-0 animate__animated animate__fadeInUp animate__delay-1s">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('cart') }}">Cart</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
@endsection

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Billing Information -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4">
                    <h5 class="card-title fw-bold mb-4">Billing Information</h5>
                    
                    <form id="checkout-form">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="first_name" class="form-label">First Name *</label>
                                <input type="text" class="form-control" id="first_name" required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="last_name" class="form-label">Last Name *</label>
                                <input type="text" class="form-control" id="last_name" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address *</label>
                            <input type="email" class="form-control" id="email" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number *</label>
                            <input type="tel" class="form-control" id="phone" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="address" class="form-label">Address *</label>
                            <input type="text" class="form-control" id="address" required>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="city" class="form-label">City *</label>
                                <input type="text" class="form-control" id="city" required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="state" class="form-label">State *</label>
                                <input type="text" class="form-control" id="state" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="zip_code" class="form-label">ZIP Code *</label>
                                <input type="text" class="form-control" id="zip_code" required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="country" class="form-label">Country *</label>
                                <select class="form-select" id="country" required>
                                    <option value="">Select Country</option>
                                    <option value="US">United States</option>
                                    <option value="CA">Canada</option>
                                    <option value="GB">United Kingdom</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Payment Method -->
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h5 class="card-title fw-bold mb-4">Payment Method</h5>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment_method" 
                                   id="credit_card" value="credit_card" checked>
                            <label class="form-check-label" for="credit_card">
                                Credit/Debit Card
                            </label>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment_method" 
                                   id="paypal" value="paypal">
                            <label class="form-check-label" for="paypal">
                                PayPal
                            </label>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment_method" 
                                   id="cod" value="cod">
                            <label class="form-check-label" for="cod">
                                Cash on Delivery
                            </label>
                        </div>
                    </div>
                    
                    <div id="credit-card-info">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="card_number" class="form-label">Card Number *</label>
                                <input type="text" class="form-control" id="card_number" 
                                       placeholder="1234 5678 9012 3456">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="expiry_date" class="form-label">Expiry Date *</label>
                                <input type="text" class="form-control" id="expiry_date" 
                                       placeholder="MM/YY">
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="cvv" class="form-label">CVV *</label>
                                <input type="text" class="form-control" id="cvv" placeholder="123">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="card_name" class="form-label">Name on Card *</label>
                            <input type="text" class="form-control" id="card_name">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Order Summary -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 sticky-top" style="top: 20px;">
                <div class="card-body p-4">
                    <h5 class="card-title fw-bold mb-4">Order Summary</h5>
                    
                    <div class="order-items mb-3">
                        @php
                            $cartItems = Session::get('cart', []);
                            $subtotal = 0;
                        @endphp
                        
                        @foreach($cartItems as $item)
                        <div class="d-flex justify-content-between mb-2">
                            <div>
                                <span class="fw-medium">{{ $item['name'] }}</span>
                                <small class="text-muted d-block">Qty: {{ $item['quantity'] }}</small>
                            </div>
                            <span>${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                            @php $subtotal += $item['price'] * $item['quantity']; @endphp
                        </div>
                        @endforeach
                    </div>
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal</span>
                        <span>${{ number_format($subtotal, 2) }}</span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>Shipping</span>
                        <span class="text-success">Free</span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tax</span>
                        <span>${{ number_format($subtotal * 0.08, 2) }}</span>
                    </div>
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between mb-4">
                        <h6 class="fw-bold">Total</h6>
                        <h6 class="fw-bold">${{ number_format($subtotal + ($subtotal * 0.08), 2) }}</h6>
                    </div>
                    
                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" id="terms_agree" required>
                        <label class="form-check-label" for="terms_agree">
                            I agree to the <a href="#" class="text-success">Terms and Conditions</a>
                        </label>
                    </div>
                    
                    <button type="button" class="btn btn-success btn-lg w-100" id="place-order">
                        Place Order <i class="fas fa-check ms-2"></i>
                    </button>
                    
                    <div class="text-center mt-3">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/a/a4/Mastercard_2019_logo.svg" 
                             class="me-2" height="30" alt="Mastercard">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg" 
                             class="me-2" height="30" alt="Visa">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" 
                             height="30" alt="PayPal">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Show/hide credit card info based on payment method
        $('input[name="payment_method"]').change(function() {
            if ($(this).val() === 'credit_card') {
                $('#credit-card-info').show();
            } else {
                $('#credit-card-info').hide();
            }
        });
        
        // Place order
        $('#place-order').click(function(e) {
            e.preventDefault();
            
            // Validate form
            if (!validateCheckoutForm()) {
                showToast('Error', 'Please fill all required fields correctly', 'error');
                return;
            }
            
            if (!$('#terms_agree').is(':checked')) {
                showToast('Error', 'Please agree to the terms and conditions', 'error');
                return;
            }
            
            // Show processing message
            $(this).html('<i class="fas fa-spinner fa-spin me-2"></i> Processing...');
            $(this).prop('disabled', true);
            
            // Simulate order processing
            setTimeout(function() {
                showToast('Success', 'Order placed successfully!', 'success');
                
                // Clear cart
                $.ajax({
                    url: '{{ route("cart.clear") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function() {
                        // Redirect to thank you page
                        setTimeout(function() {
                            window.location.href = '{{ url("/") }}';
                        }, 2000);
                    }
                });
            }, 2000);
        });
        
        function validateCheckoutForm() {
            let isValid = true;
            
            // Simple validation
            $('input[required], select[required]').each(function() {
                if (!$(this).val()) {
                    isValid = false;
                    $(this).addClass('is-invalid');
                } else {
                    $(this).removeClass('is-invalid');
                }
            });
            
            return isValid;
        }
    });
</script>
@endpush