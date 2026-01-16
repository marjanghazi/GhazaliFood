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
                    <li class="breadcrumb-item active" aria-current="page">Refund & Return Policy</li>
                </ol>
            </nav>
            
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h1 class="h3 mb-0"><i class="fas fa-undo me-2"></i>Refund & Return Policy</h1>
                </div>
                <div class="card-body">
                    <div class="last-updated mb-4">
                        <p class="text-muted"><i class="fas fa-calendar-alt me-2"></i>Last Updated: {{ date('F d, Y') }}</p>
                    </div>
                    
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Our Guarantee:</strong> We stand behind the quality of our products. If you're not satisfied with your purchase, we'll make it right.
                    </div>
                    
                    <div class="policy-content">
                        <section class="mb-5">
                            <h2 class="h4 mb-3 text-primary">1. Return Eligibility</h2>
                            <p>To be eligible for a return, your item must be:</p>
                            <ul>
                                <li>In the same condition that you received it</li>
                                <li>In the original packaging</li>
                                <li>Unopened and sealed (for perishable items)</li>
                                <li>Returned within 30 days of delivery</li>
                            </ul>
                            
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Note:</strong> For health and safety reasons, we cannot accept returns of opened food products unless they are defective or damaged.
                            </div>
                        </section>
                        
                        <section class="mb-5">
                            <h2 class="h4 mb-3 text-primary">2. Non-Returnable Items</h2>
                            <p>The following items cannot be returned:</p>
                            <ul>
                                <li>Opened food products (unless defective)</li>
                                <li>Gift cards</li>
                                <li>Personalized or custom orders</li>
                                <li>Sale or clearance items marked as "final sale"</li>
                            </ul>
                        </section>
                        
                        <section class="mb-5">
                            <h2 class="h4 mb-3 text-primary">3. Return Process</h2>
                            <p>To initiate a return, please follow these steps:</p>
                            <ol>
                                <li><strong>Contact Us:</strong> Email returns@nutsandberries.com with your order number and reason for return</li>
                                <li><strong>Get Approval:</strong> We'll provide a Return Merchandise Authorization (RMA) number and instructions</li>
                                <li><strong>Pack Securely:</strong> Package the item securely in its original packaging</li>
                                <li><strong>Ship:</strong> Include the RMA number on the package and ship to our return address</li>
                                <li><strong>Track:</strong> Keep your shipping receipt for tracking</li>
                            </ol>
                        </section>
                        
                        <section class="mb-5">
                            <h2 class="h4 mb-3 text-primary">4. Return Shipping</h2>
                            <h5 class="h6 mb-2">Who Pays for Return Shipping?</h5>
                            <ul>
                                <li><strong>Defective/Damaged Items:</strong> We cover return shipping costs</li>
                                <li><strong>Wrong Item Shipped:</strong> We cover return shipping costs</li>
                                <li><strong>Change of Mind:</strong> Customer pays return shipping</li>
                            </ul>
                            
                            <p class="mt-3">We recommend using a trackable shipping service and purchasing shipping insurance. We cannot guarantee that we will receive your returned item.</p>
                        </section>
                        
                        <section class="mb-5">
                            <h2 class="h4 mb-3 text-primary">5. Refunds</h2>
                            <h5 class="h6 mb-2">Refund Processing</h5>
                            <p>Once we receive and inspect your return, we will notify you of the approval or rejection of your refund. If approved, your refund will be processed:</p>
                            <ul>
                                <li><strong>Credit Card/PayPal:</strong> 5-10 business days for the refund to appear on your statement</li>
                                <li><strong>Bank Transfer:</strong> 3-5 business days</li>
                            </ul>
                            
                            <h5 class="h6 mb-2 mt-3">What Will Be Refunded?</h5>
                            <ul>
                                <li>Product purchase price</li>
                                <li>Original shipping costs (if defective or wrong item)</li>
                                <li>Taxes (if applicable)</li>
                            </ul>
                            <p class="mt-2"><strong>Note:</strong> Return shipping costs are not refunded for change of mind returns.</p>
                        </section>
                        
                        <section class="mb-5">
                            <h2 class="h4 mb-3 text-primary">6. Exchanges</h2>
                            <p>We only replace items if they are defective or damaged. If you need to exchange it for the same item, contact us at support@nutsandberries.com.</p>
                            <p>For size or product exchanges, you'll need to return the original item and place a new order.</p>
                        </section>
                        
                        <section class="mb-5">
                            <h2 class="h4 mb-3 text-primary">7. Damaged or Defective Items</h2>
                            <p>If you receive a damaged or defective item, please:</p>
                            <ol>
                                <li>Contact us within 48 hours of delivery</li>
                                <li>Include photos of the damaged product and packaging</li>
                                <li>Provide your order number</li>
                            </ol>
                            <p>We will arrange for a replacement or refund, and provide a prepaid return label if needed.</p>
                        </section>
                        
                        <section class="mb-5">
                            <h2 class="h4 mb-3 text-primary">8. Late or Missing Refunds</h2>
                            <p>If you haven't received your refund within the expected timeframe, please:</p>
                            <ol>
                                <li>Check your bank account again</li>
                                <li>Contact your credit card company (processing times vary)</li>
                                <li>Contact your bank</li>
                                <li>If you've done all of the above and still haven't received your refund, contact us at accounting@nutsandberries.com</li>
                            </ol>
                        </section>
                        
                        <section class="mb-5">
                            <h2 class="h4 mb-3 text-primary">9. Sale Items</h2>
                            <p>Only regular priced items may be refunded. Sale items cannot be refunded unless defective.</p>
                        </section>
                        
                        <section class="mb-5">
                            <h2 class="h4 mb-3 text-primary">10. Gifts</h2>
                            <p>If the item was marked as a gift when purchased and shipped directly to you, you'll receive a gift credit for the value of your return.</p>
                            <p>If the item wasn't marked as a gift, or the gift giver had the order shipped to themselves, we will send a refund to the gift giver.</p>
                        </section>
                        
                        <section>
                            <h2 class="h4 mb-3 text-primary">11. Contact Us</h2>
                            <p>For questions about our refund and return policy, please contact us:</p>
                            <address>
                                <strong>Nuts & Berries Returns Department</strong><br>
                                Email: returns@nutsandberries.com<br>
                                Phone: +1 (555) 123-4567 (Option 2)<br>
                                Hours: Monday-Friday, 9 AM - 5 PM PST
                            </address>
                            <p class="mt-3"><strong>Return Address:</strong><br>
                            Nuts & Berries Returns<br>
                            456 Return Avenue, Suite 100<br>
                            Dry Fruits City, CA 90210</p>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection