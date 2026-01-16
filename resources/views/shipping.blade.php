@extends('layouts.app')

@section('title', $title)
@section('description', $description)

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Shipping Policy</li>
                </ol>
            </nav>
            
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h1 class="h3 mb-0"><i class="fas fa-shipping-fast me-2"></i>Shipping Policy</h1>
                </div>
                <div class="card-body">
                    <div class="last-updated mb-4">
                        <p class="text-muted"><i class="fas fa-calendar-alt me-2"></i>Last Updated: {{ date('F d, Y') }}</p>
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Important:</strong> Due to the perishable nature of our products, we take special care in packaging and shipping to ensure your dry fruits arrive fresh and in perfect condition.
                    </div>
                    
                    <div class="policy-content">
                        <section class="mb-5">
                            <h2 class="h4 mb-3 text-primary">1. Shipping Methods</h2>
                            <p>We offer the following shipping options:</p>
                            
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Method</th>
                                            <th>Delivery Time</th>
                                            <th>Cost</th>
                                            <th>Details</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><strong>Standard Shipping</strong></td>
                                            <td>3-7 business days</td>
                                            <td>$5.99</td>
                                            <td>Free on orders over $50</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Express Shipping</strong></td>
                                            <td>2-3 business days</td>
                                            <td>$12.99</td>
                                            <td>Signature required</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Priority Shipping</strong></td>
                                            <td>1-2 business days</td>
                                            <td>$19.99</td>
                                            <td>Signature required, temperature-controlled</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Local Pickup</strong></td>
                                            <td>Same day</td>
                                            <td>Free</td>
                                            <td>Available at our store location</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </section>
                        
                        <section class="mb-5">
                            <h2 class="h4 mb-3 text-primary">2. Processing Time</h2>
                            <p>All orders are processed within 1-2 business days. Orders placed on weekends or holidays will be processed on the next business day.</p>
                            <div class="alert alert-warning">
                                <i class="fas fa-clock me-2"></i>
                                <strong>Note:</strong> Processing time does not include shipping time. You will receive a shipping confirmation email with tracking information once your order ships.
                            </div>
                        </section>
                        
                        <section class="mb-5">
                            <h2 class="h4 mb-3 text-primary">3. Shipping Destinations</h2>
                            <p>We currently ship to the following locations:</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="h6 mb-2">Domestic Shipping</h5>
                                    <ul>
                                        <li>All 50 United States</li>
                                        <li>Puerto Rico</li>
                                        <li>U.S. Virgin Islands</li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <h5 class="h6 mb-2">International Shipping</h5>
                                    <p>Currently not available. We're working to expand our shipping destinations.</p>
                                </div>
                            </div>
                        </section>
                        
                        <section class="mb-5">
                            <h2 class="h4 mb-3 text-primary">4. Shipping Restrictions</h2>
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Important Restrictions:</strong> Due to the nature of our products and customs regulations, we cannot ship to P.O. Boxes or APO/FPO addresses. A physical street address is required for delivery.
                            </div>
                        </section>
                        
                        <section class="mb-5">
                            <h2 class="h4 mb-3 text-primary">5. Order Tracking</h2>
                            <p>Once your order ships, you will receive an email with tracking information. You can also track your order by logging into your account.</p>
                            <p>If you haven't received tracking information within 3 business days of placing your order, please contact our customer service team.</p>
                        </section>
                        
                        <section class="mb-5">
                            <h2 class="h4 mb-3 text-primary">6. Delivery Issues</h2>
                            <h5 class="h6 mb-2">Failed Delivery Attempts</h5>
                            <p>If delivery is attempted and no one is available to receive the package, the carrier will leave a notice with instructions for pickup or rescheduling.</p>
                            
                            <h5 class="h6 mb-2 mt-3">Damaged or Lost Packages</h5>
                            <p>In the rare event that your package arrives damaged or is lost in transit, please contact us immediately at support@nutsandberries.com with your order number and photos of the damaged package/contents.</p>
                        </section>
                        
                        <section class="mb-5">
                            <h2 class="h4 mb-3 text-primary">7. Weather Considerations</h2>
                            <p>During extreme weather conditions (heat waves, snowstorms, etc.), we may delay shipping to ensure product quality. In such cases, we will notify you via email.</p>
                        </section>
                        
                        <section class="mb-5">
                            <h2 class="h4 mb-3 text-primary">8. Shipping for Perishable Items</h2>
                            <p>Our dry fruits are packaged in airtight, moisture-proof packaging with oxygen absorbers to ensure freshness during transit. For temperature-sensitive items, we use insulated packaging during warmer months.</p>
                        </section>
                        
                        <section class="mb-5">
                            <h2 class="h4 mb-3 text-primary">9. Changes to Shipping Policy</h2>
                            <p>We reserve the right to modify our shipping policy at any time. Changes will be effective immediately upon posting on our website.</p>
                        </section>
                        
                        <section>
                            <h2 class="h4 mb-3 text-primary">10. Contact Us</h2>
                            <p>If you have questions about our shipping policy, please contact us:</p>
                            <address>
                                <strong>Nuts & Berries Customer Service</strong><br>
                                Email: shipping@nutsandberries.com<br>
                                Phone: +1 (555) 123-4567<br>
                                Hours: Monday-Friday, 9 AM - 6 PM PST
                            </address>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection