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
                    <li class="breadcrumb-item active" aria-current="page">Terms of Service</li>
                </ol>
            </nav>
            
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h1 class="h3 mb-0"><i class="fas fa-file-contract me-2"></i>Terms of Service</h1>
                </div>
                <div class="card-body">
                    <div class="last-updated mb-4">
                        <p class="text-muted"><i class="fas fa-calendar-alt me-2"></i>Last Updated: {{ date('F d, Y') }}</p>
                    </div>
                    
                    <div class="policy-content">
                        <section class="mb-5">
                            <h2 class="h4 mb-3 text-primary">1. Acceptance of Terms</h2>
                            <p>By accessing and using the Nuts & Berries website, you accept and agree to be bound by the terms and provision of this agreement. If you do not agree to abide by these terms, please do not use our website.</p>
                        </section>
                        
                        <section class="mb-5">
                            <h2 class="h4 mb-3 text-primary">2. User Accounts</h2>
                            <p>To make purchases on our website, you must create an account. You are responsible for:</p>
                            <ul>
                                <li>Maintaining the confidentiality of your account credentials</li>
                                <li>All activities that occur under your account</li>
                                <li>Providing accurate and complete information</li>
                                <li>Keeping your information up to date</li>
                            </ul>
                        </section>
                        
                        <section class="mb-5">
                            <h2 class="h4 mb-3 text-primary">3. Products and Services</h2>
                            <h3 class="h5 mb-2">Product Descriptions</h3>
                            <p>We strive to display accurate product descriptions, images, and prices. However, we do not guarantee that product descriptions or other content is accurate, complete, reliable, current, or error-free.</p>
                            
                            <h3 class="h5 mb-2 mt-4">Pricing</h3>
                            <p>All prices are in US dollars and are subject to change without notice. We reserve the right to modify or discontinue any product at any time.</p>
                            
                            <h3 class="h5 mb-2 mt-4">Availability</h3>
                            <p>All products are subject to availability. We cannot guarantee that products will be in stock at the time of your order.</p>
                        </section>
                        
                        <section class="mb-5">
                            <h2 class="h4 mb-3 text-primary">4. Orders and Payment</h2>
                            <h3 class="h5 mb-2">Order Acceptance</h3>
                            <p>Your receipt of an order confirmation does not signify our acceptance of your order. We reserve the right to accept or decline your order for any reason.</p>
                            
                            <h3 class="h5 mb-2 mt-4">Payment Methods</h3>
                            <p>We accept various payment methods including credit cards and PayPal. All payments are processed through secure payment gateways.</p>
                            
                            <h3 class="h5 mb-2 mt-4">Sales Tax</h3>
                            <p>Sales tax will be charged based on your shipping address and applicable tax laws.</p>
                        </section>
                        
                        <section class="mb-5">
                            <h2 class="h4 mb-3 text-primary">5. Shipping and Delivery</h2>
                            <p>Shipping costs and delivery times vary based on location and shipping method selected. We are not responsible for delays caused by carriers or customs.</p>
                        </section>
                        
                        <section class="mb-5">
                            <h2 class="h4 mb-3 text-primary">6. Returns and Refunds</h2>
                            <p>Please refer to our <a href="{{ route('policies.refund') }}">Refund & Return Policy</a> for detailed information about returns, exchanges, and refunds.</p>
                        </section>
                        
                        <section class="mb-5">
                            <h2 class="h4 mb-3 text-primary">7. Intellectual Property</h2>
                            <p>All content on our website, including text, graphics, logos, images, and software, is the property of Nuts & Berries and protected by copyright laws. You may not reproduce, distribute, or create derivative works without our permission.</p>
                        </section>
                        
                        <section class="mb-5">
                            <h2 class="h4 mb-3 text-primary">8. User Conduct</h2>
                            <p>You agree not to:</p>
                            <ul>
                                <li>Use our website for any unlawful purpose</li>
                                <li>Violate any local, state, national, or international law</li>
                                <li>Impersonate any person or entity</li>
                                <li>Interfere with the operation of our website</li>
                                <li>Attempt to gain unauthorized access to our systems</li>
                            </ul>
                        </section>
                        
                        <section class="mb-5">
                            <h2 class="h4 mb-3 text-primary">9. Limitation of Liability</h2>
                            <p>Nuts & Berries shall not be liable for any indirect, incidental, special, consequential, or punitive damages resulting from your use of or inability to use our website or services.</p>
                        </section>
                        
                        <section class="mb-5">
                            <h2 class="h4 mb-3 text-primary">10. Indemnification</h2>
                            <p>You agree to indemnify and hold Nuts & Berries harmless from any claims, losses, damages, liabilities, including legal fees, arising from your violation of these terms or your use of our website.</p>
                        </section>
                        
                        <section class="mb-5">
                            <h2 class="h4 mb-3 text-primary">11. Governing Law</h2>
                            <p>These terms shall be governed by and construed in accordance with the laws of the State of California, without regard to its conflict of law provisions.</p>
                        </section>
                        
                        <section class="mb-5">
                            <h2 class="h4 mb-3 text-primary">12. Changes to Terms</h2>
                            <p>We reserve the right to modify these terms at any time. Changes will be effective immediately upon posting on our website. Your continued use of our website constitutes acceptance of the modified terms.</p>
                        </section>
                        
                        <section>
                            <h2 class="h4 mb-3 text-primary">13. Contact Information</h2>
                            <p>If you have any questions about these Terms of Service, please contact us:</p>
                            <address>
                                <strong>Nuts & Berries</strong><br>
                                123 Nut Street, Dry Fruits City<br>
                                Email: legal@nutsandberries.com<br>
                                Phone: +1 (555) 123-4567
                            </address>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection