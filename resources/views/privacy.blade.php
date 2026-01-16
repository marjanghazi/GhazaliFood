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
                    <li class="breadcrumb-item active" aria-current="page">Privacy Policy</li>
                </ol>
            </nav>
            
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h1 class="h3 mb-0"><i class="fas fa-shield-alt me-2"></i>Privacy Policy</h1>
                </div>
                <div class="card-body">
                    <div class="last-updated mb-4">
                        <p class="text-muted"><i class="fas fa-calendar-alt me-2"></i>Last Updated: {{ date('F d, Y') }}</p>
                    </div>
                    
                    <div class="policy-content">
                        <section class="mb-5">
                            <h2 class="h4 mb-3 text-primary">1. Introduction</h2>
                            <p>Welcome to Nuts & Berries ("we," "our," or "us"). We are committed to protecting your personal information and your right to privacy. If you have any questions or concerns about this privacy policy, or our practices with regards to your personal information, please contact us at privacy@nutsandberries.com.</p>
                            <p>This Privacy Policy applies to all information collected through our website, mobile application, and/or any related services, sales, marketing, or events (we refer to them collectively in this Privacy Policy as the "Services").</p>
                        </section>
                        
                        <section class="mb-5">
                            <h2 class="h4 mb-3 text-primary">2. Information We Collect</h2>
                            <h3 class="h5 mb-2">Personal Information</h3>
                            <p>We collect personal information that you voluntarily provide to us when you:</p>
                            <ul>
                                <li>Register on our website</li>
                                <li>Place an order</li>
                                <li>Subscribe to our newsletter</li>
                                <li>Contact us through forms</li>
                                <li>Participate in surveys or promotions</li>
                            </ul>
                            <p>The personal information we collect may include:</p>
                            <ul>
                                <li>Name and contact details (email address, phone number)</li>
                                <li>Shipping and billing addresses</li>
                                <li>Payment information (credit card details are processed securely through our payment gateway)</li>
                                <li>Account credentials (username, password)</li>
                            </ul>
                        </section>
                        
                        <section class="mb-5">
                            <h2 class="h4 mb-3 text-primary">3. How We Use Your Information</h2>
                            <p>We use the information we collect to:</p>
                            <ul>
                                <li>Process and fulfill your orders</li>
                                <li>Send order confirmations and shipping updates</li>
                                <li>Respond to customer service requests</li>
                                <li>Send marketing communications (with your consent)</li>
                                <li>Improve our website and services</li>
                                <li>Prevent fraudulent activities</li>
                                <li>Comply with legal obligations</li>
                            </ul>
                        </section>
                        
                        <section class="mb-5">
                            <h2 class="h4 mb-3 text-primary">4. Information Sharing</h2>
                            <p>We do not sell, trade, or rent your personal information to third parties. We may share your information with:</p>
                            <ul>
                                <li><strong>Service Providers:</strong> Payment processors, shipping companies, email service providers</li>
                                <li><strong>Legal Requirements:</strong> When required by law or to protect our rights</li>
                                <li><strong>Business Transfers:</strong> In connection with a merger, acquisition, or sale of assets</li>
                            </ul>
                        </section>
                        
                        <section class="mb-5">
                            <h2 class="h4 mb-3 text-primary">5. Data Security</h2>
                            <p>We implement appropriate technical and organizational security measures to protect your personal information. This includes:</p>
                            <ul>
                                <li>SSL encryption for data transmission</li>
                                <li>Secure payment processing</li>
                                <li>Regular security assessments</li>
                                <li>Access controls to personal data</li>
                            </ul>
                        </section>
                        
                        <section class="mb-5">
                            <h2 class="h4 mb-3 text-primary">6. Your Rights</h2>
                            <p>You have the right to:</p>
                            <ul>
                                <li>Access your personal information</li>
                                <li>Correct inaccurate information</li>
                                <li>Request deletion of your information</li>
                                <li>Opt-out of marketing communications</li>
                                <li>Data portability</li>
                            </ul>
                            <p>To exercise these rights, please contact us at privacy@nutsandberries.com.</p>
                        </section>
                        
                        <section class="mb-5">
                            <h2 class="h4 mb-3 text-primary">7. Cookies and Tracking Technologies</h2>
                            <p>We use cookies and similar tracking technologies to collect information about your browsing behavior. You can control cookies through your browser settings.</p>
                        </section>
                        
                        <section class="mb-5">
                            <h2 class="h4 mb-3 text-primary">8. Changes to This Policy</h2>
                            <p>We may update this privacy policy from time to time. We will notify you of any changes by posting the new policy on this page and updating the "Last Updated" date.</p>
                        </section>
                        
                        <section>
                            <h2 class="h4 mb-3 text-primary">9. Contact Us</h2>
                            <p>If you have questions or concerns about this Privacy Policy, please contact us:</p>
                            <address>
                                <strong>Nuts & Berries</strong><br>
                                123 Nut Street, Dry Fruits City<br>
                                Email: privacy@nutsandberries.com<br>
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