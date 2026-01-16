@extends('layouts.app')

@section('title', 'Contact Us | Premium Dry Fruits Store | Nuts & Berries')

@section('hero')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center min-vh-70">
            <div class="col-lg-6">
                <h1 class="hero-title animate-slide-up">Get In Touch</h1>
                <p class="hero-subtitle animate-slide-up delay-1">
                    Have questions about our premium dry fruits? Need assistance with your order?
                    We're here to help! Reach out to us anytime.
                </p>
                <div class="hero-buttons animate-slide-up delay-2">
                    <a href="#contact-form" class="btn btn-primary btn-lg">
                        Send Message <i class="fas fa-paper-plane ms-2"></i>
                    </a>
                    <a href="#faq" class="btn btn-outline btn-lg">
                        View FAQs
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-image">
                    <img src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                         alt="Premium Dry Fruits Collection"
                         class="img-fluid rounded-3">
                    <div class="hero-badge animate-bounce">
                        <i class="fas fa-headset me-2"></i> 24/7 Support
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('content')
<!-- Contact Section -->
<section class="py-5">
    <div class="container">
        <div class="section-header mb-5">
            <h2 class="section-title">Contact Information</h2>
            <p class="text-muted">Multiple ways to reach us</p>
        </div>
        
        <div class="row">
            <!-- Contact Info -->
            <div class="col-lg-4 mb-5 mb-lg-0">
                <div class="contact-info-grid">
                    <div class="contact-card">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="contact-content">
                            <h5 class="contact-title">Visit Our Store</h5>
                            <p class="contact-text">
                                123 Nut Street, Suite 101<br>
                                Dry Fruit Valley, DF 12345<br>
                                California, USA
                            </p>
                        </div>
                    </div>
                    
                    <div class="contact-card">
                        <div class="contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="contact-content">
                            <h5 class="contact-title">Call Us</h5>
                            <p class="contact-text">
                                <a href="tel:+12345678900" class="contact-link">+1 (234) 567-8900</a><br>
                                <a href="tel:+12345678901" class="contact-link">+1 (234) 567-8901</a>
                            </p>
                            <small class="text-muted">Mon-Fri: 9AM-8PM | Sat-Sun: 10AM-6PM</small>
                        </div>
                    </div>
                    
                    <div class="contact-card">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact-content">
                            <h5 class="contact-title">Email Us</h5>
                            <p class="contact-text">
                                <a href="mailto:info@nutsberries.com" class="contact-link">
                                    info@nutsberries.com
                                </a><br>
                                <a href="mailto:support@nutsberries.com" class="contact-link">
                                    support@nutsberries.com
                                </a>
                            </p>
                        </div>
                    </div>
                    
                    <div class="contact-card">
                        <div class="contact-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="contact-content">
                            <h5 class="contact-title">Business Hours</h5>
                            <p class="contact-text">
                                <strong>Store Hours:</strong><br>
                                Monday - Friday: 9:00 AM - 8:00 PM<br>
                                Saturday - Sunday: 10:00 AM - 6:00 PM
                            </p>
                            <p class="contact-text mb-0">
                                <strong>Online Support:</strong><br>
                                24/7 via email & chat
                            </p>
                        </div>
                    </div>
                    
                    <div class="social-links mt-4">
                        <p class="mb-3 text-muted">Follow us on social media:</p>
                        <div class="social-buttons">
                            <a href="#" class="social-btn facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="social-btn twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="social-btn instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="social-btn pinterest">
                                <i class="fab fa-pinterest"></i>
                            </a>
                            <a href="#" class="social-btn youtube">
                                <i class="fab fa-youtube"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="col-lg-8">
                <div class="contact-form-wrapper" id="contact-form">
                    <div class="contact-form-card">
                        <div class="form-header">
                            <h3 class="form-title">Send Us a Message</h3>
                            <p class="form-subtitle text-muted">
                                Fill out the form below and we'll get back to you within 24 hours
                            </p>
                        </div>
                        
                        @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        @endif
                        
                        <form action="{{ route('contact.store') }}" method="POST" class="contact-form">
                            @csrf
                            
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="form-group">
                                        <label for="name" class="form-label">Full Name *</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-user"></i>
                                            </span>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                                   id="name" name="name" value="{{ old('name') }}" 
                                                   placeholder="Enter your full name" required>
                                        </div>
                                        @error('name')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-4">
                                    <div class="form-group">
                                        <label for="email" class="form-label">Email Address *</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-envelope"></i>
                                            </span>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                                   id="email" name="email" value="{{ old('email') }}" 
                                                   placeholder="Enter your email" required>
                                        </div>
                                        @error('email')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="form-group">
                                        <label for="phone" class="form-label">Phone Number</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-phone"></i>
                                            </span>
                                            <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                                   id="phone" name="phone" value="{{ old('phone') }}" 
                                                   placeholder="Optional">
                                        </div>
                                        @error('phone')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6 mb-4">
                                    <div class="form-group">
                                        <label for="subject" class="form-label">Subject *</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-tag"></i>
                                            </span>
                                            <input type="text" class="form-control @error('subject') is-invalid @enderror" 
                                                   id="subject" name="subject" value="{{ old('subject') }}" 
                                                   placeholder="What is this regarding?" required>
                                        </div>
                                        @error('subject')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <div class="form-group">
                                    <label for="feedback_type" class="form-label">Inquiry Type *</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-question-circle"></i>
                                        </span>
                                        <select class="form-select @error('feedback_type') is-invalid @enderror" 
                                                id="feedback_type" name="feedback_type" required>
                                            <option value="">Select inquiry type...</option>
                                            <option value="general" {{ old('feedback_type') == 'general' ? 'selected' : '' }}>
                                                General Inquiry
                                            </option>
                                            <option value="order" {{ old('feedback_type') == 'order' ? 'selected' : '' }}>
                                                Order Support
                                            </option>
                                            <option value="product" {{ old('feedback_type') == 'product' ? 'selected' : '' }}>
                                                Product Question
                                            </option>
                                            <option value="wholesale" {{ old('feedback_type') == 'wholesale' ? 'selected' : '' }}>
                                                Wholesale Inquiry
                                            </option>
                                            <option value="collaboration" {{ old('feedback_type') == 'collaboration' ? 'selected' : '' }}>
                                                Collaboration
                                            </option>
                                            <option value="other" {{ old('feedback_type') == 'other' ? 'selected' : '' }}>
                                                Other
                                            </option>
                                        </select>
                                    </div>
                                    @error('feedback_type')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <div class="form-group">
                                    <label for="message" class="form-label">Message *</label>
                                    <textarea class="form-control @error('message') is-invalid @enderror" 
                                              id="message" name="message" rows="6" 
                                              placeholder="Please provide details about your inquiry..." required>{{ old('message') }}</textarea>
                                    <div class="form-text">
                                        Please include order number if related to an existing order
                                    </div>
                                    @error('message')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input @error('privacy') is-invalid @enderror" 
                                           type="checkbox" id="privacy" name="privacy" required>
                                    <label class="form-check-label" for="privacy">
                                        I agree to the <a href="{{ route('policies.privacy') }}" class="text-primary">Privacy Policy</a> and 
                                        <a href="{{ route('policies.terms') }}" class="text-primary">Terms of Service</a> *
                                    </label>
                                    @error('privacy')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="newsletter" name="newsletter">
                                    <label class="form-check-label" for="newsletter">
                                        Subscribe to our newsletter for exclusive offers, health tips, 
                                        and new product updates
                                    </label>
                                </div>
                            </div>
                            
                            <div class="form-submit">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-paper-plane me-2"></i> Send Message
                                </button>
                                <button type="reset" class="btn btn-outline btn-lg ms-3">
                                    <i class="fas fa-redo me-2"></i> Clear Form
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="section-header mb-5">
            <h2 class="section-title">Visit Our Store</h2>
            <p class="text-muted">Find us on the map</p>
        </div>
        
        <div class="map-container">
            <div class="map-wrapper rounded-3 overflow-hidden shadow-lg">
                <div class="ratio ratio-16x9">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3024.2219901290355!2d-74.00369368400567!3d40.71312937933185!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c25a316ff11b35%3A0x9c2c2b1b1c1c1c1c!2s123%20Food%20St%2C%20New%20York%2C%20NY%2010001!5e0!3m2!1sen!2sus!4v1623932000000!5m2!1sen!2sus" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
            
            <div class="map-info mt-4 text-center">
                <div class="row">
                    <div class="col-md-4 mb-3 mb-md-0">
                        <div class="map-detail">
                            <i class="fas fa-car text-primary mb-2 fa-lg"></i>
                            <h6>Parking Available</h6>
                            <p class="text-muted mb-0">Free parking for customers</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3 mb-md-0">
                        <div class="map-detail">
                            <i class="fas fa-wheelchair text-primary mb-2 fa-lg"></i>
                            <h6>Accessible</h6>
                            <p class="text-muted mb-0">Wheelchair accessible entrance</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="map-detail">
                            <i class="fas fa-truck text-primary mb-2 fa-lg"></i>
                            <h6>Delivery Zone</h6>
                            <p class="text-muted mb-0">Local delivery available</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-5" id="faq">
    <div class="container">
        <div class="section-header mb-5">
            <h2 class="section-title">Frequently Asked Questions</h2>
            <p class="text-muted">Quick answers to common questions</p>
        </div>
        
        <div class="faq-container">
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="faq-accordion">
                        <div class="faq-item">
                            <button class="faq-question" type="button">
                                <span class="faq-icon">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                                <span class="faq-text">What is your shipping policy?</span>
                                <span class="faq-arrow">
                                    <i class="fas fa-chevron-down"></i>
                                </span>
                            </button>
                            <div class="faq-answer">
                                <p>We offer free shipping on all orders over $50 within the continental US. 
                                Standard shipping takes 3-5 business days, while expedited options are available 
                                at checkout for faster delivery.</p>
                            </div>
                        </div>
                        
                        <div class="faq-item">
                            <button class="faq-question" type="button">
                                <span class="faq-icon">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                                <span class="faq-text">Are your products organic?</span>
                                <span class="faq-arrow">
                                    <i class="fas fa-chevron-down"></i>
                                </span>
                            </button>
                            <div class="faq-answer">
                                <p>Yes! All our dry fruits are 100% certified organic, sourced from trusted 
                                organic farms worldwide. We never use preservatives, additives, or artificial 
                                colors in any of our products.</p>
                            </div>
                        </div>
                        
                        <div class="faq-item">
                            <button class="faq-question" type="button">
                                <span class="faq-icon">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                                <span class="faq-text">Do you offer bulk/wholesale pricing?</span>
                                <span class="faq-arrow">
                                    <i class="fas fa-chevron-down"></i>
                                </span>
                            </button>
                            <div class="faq-answer">
                                <p>Absolutely! We offer special wholesale pricing for restaurants, cafes, 
                                and bulk purchases. Contact our sales team at 
                                <a href="mailto:wholesale@nutsberries.com">wholesale@nutsberries.com</a> 
                                for custom quotes and volume discounts.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6 mb-4">
                    <div class="faq-accordion">
                        <div class="faq-item">
                            <button class="faq-question" type="button">
                                <span class="faq-icon">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                                <span class="faq-text">How do I store dry fruits?</span>
                                <span class="faq-arrow">
                                    <i class="fas fa-chevron-down"></i>
                                </span>
                            </button>
                            <div class="faq-answer">
                                <p>For maximum freshness, store dry fruits in airtight containers in a cool, 
                                dark place. Most dry fruits last 6-12 months when stored properly. Nuts are 
                                best stored in the refrigerator to maintain their natural oils.</p>
                            </div>
                        </div>
                        
                        <div class="faq-item">
                            <button class="faq-question" type="button">
                                <span class="faq-icon">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                                <span class="faq-text">What is your return policy?</span>
                                <span class="faq-arrow">
                                    <i class="fas fa-chevron-down"></i>
                                </span>
                            </button>
                            <div class="faq-answer">
                                <p>We offer a 30-day satisfaction guarantee. If you're not completely happy 
                                with your purchase, contact us within 30 days for a full refund or exchange. 
                                Products must be in original, unopened packaging.</p>
                            </div>
                        </div>
                        
                        <div class="faq-item">
                            <button class="faq-question" type="button">
                                <span class="faq-icon">
                                    <i class="fas fa-question-circle"></i>
                                </span>
                                <span class="faq-text">Do you ship internationally?</span>
                                <span class="faq-arrow">
                                    <i class="fas fa-chevron-down"></i>
                                </span>
                            </button>
                            <div class="faq-answer">
                                <p>Yes! We ship to over 50 countries worldwide. International shipping costs 
                                and delivery times vary by destination. You'll see available shipping options 
                                and costs during checkout.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-5">
                <p class="text-muted mb-3">Can't find your answer?</p>
                <a href="#contact-form" class="btn btn-outline-primary">
                    <i class="fas fa-question-circle me-2"></i> Ask Your Question
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Live Chat -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h3 class="mb-3">Need Immediate Assistance?</h3>
                <p class="text-muted mb-4">
                    Our live chat support team is available 24/7 to help with urgent inquiries, 
                    order tracking, and product questions.
                </p>
                <div class="d-flex gap-3">
                    <a href="#" class="btn btn-primary" id="liveChatBtn">
                        <i class="fas fa-comment-dots me-2"></i> Start Live Chat
                    </a>
                    <a href="tel:+12345678900" class="btn btn-outline">
                        <i class="fas fa-phone me-2"></i> Call Now
                    </a>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="support-badge">
                    <i class="fas fa-headset fa-3x text-primary mb-3"></i>
                    <h5 class="mb-2">24/7 Support</h5>
                    <p class="text-muted mb-0">Average response time: 2 minutes</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Newsletter Section -->
<section class="newsletter-section py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h2 class="text-white mb-3">Stay Connected</h2>
                <p class="text-white mb-0">
                    Subscribe to our newsletter for exclusive offers, health tips, 
                    recipes, and new product launches!
                </p>
            </div>
            <div class="col-lg-6">
                <form class="newsletter-form">
                    <div class="form-group">
                        <input type="email" 
                               class="form-control" 
                               placeholder="Enter your email address" 
                               required
                               aria-label="Email for newsletter">
                    </div>
                    <button type="submit" class="btn btn-light btn-lg mt-3">
                        Subscribe <i class="fas fa-paper-plane ms-2"></i>
                    </button>
                    <p class="form-text text-white mt-2">
                        We respect your privacy. Unsubscribe at any time.
                    </p>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
/* Contact Info Grid */
.contact-info-grid {
    display: flex;
    flex-direction: column;
    gap: var(--space-md);
}

.contact-card {
    background: var(--surface-color);
    border-radius: var(--radius-lg);
    padding: var(--space-lg);
    box-shadow: var(--shadow-md);
    transition: var(--transition-normal);
    display: flex;
    align-items: flex-start;
    gap: var(--space-md);
}

.contact-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
    border-left: 4px solid var(--primary-color);
}

.contact-icon {
    width: 50px;
    height: 50px;
    min-width: 50px;
    background: var(--gradient-primary);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.25rem;
}

.contact-content h5 {
    margin-bottom: var(--space-xs);
    color: var(--primary-color);
}

.contact-text {
    color: var(--text-secondary);
    margin-bottom: var(--space-xs);
    line-height: 1.6;
}

.contact-link {
    color: var(--primary-color);
    text-decoration: none;
    transition: var(--transition-fast);
}

.contact-link:hover {
    color: var(--primary-dark);
    text-decoration: underline;
}

/* Social Buttons */
.social-buttons {
    display: flex;
    gap: var(--space-sm);
    flex-wrap: wrap;
}

.social-btn {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: var(--transition-normal);
    color: white;
}

.social-btn.facebook { background: #1877F2; }
.social-btn.twitter { background: #1DA1F2; }
.social-btn.instagram { background: #E4405F; }
.social-btn.pinterest { background: #BD081C; }
.social-btn.youtube { background: #FF0000; }

.social-btn:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-md);
    color: white;
}

/* Contact Form */
.contact-form-wrapper {
    position: relative;
}

.contact-form-card {
    background: var(--surface-color);
    border-radius: var(--radius-lg);
    padding: var(--space-xl);
    box-shadow: var(--shadow-xl);
}

.form-header {
    text-align: center;
    margin-bottom: var(--space-xl);
}

.form-title {
    color: var(--primary-color);
    margin-bottom: var(--space-xs);
}

.form-subtitle {
    color: var(--text-muted);
}

.form-group {
    margin-bottom: var(--space-md);
}

.form-label {
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: var(--space-xs);
    display: block;
}

.input-group-text {
    background: var(--gradient-primary);
    color: white;
    border: none;
    border-right: none;
}

.form-control, .form-select {
    border: 2px solid var(--border-color);
    padding: 12px 16px;
    border-radius: var(--radius-md);
    transition: var(--transition-normal);
    background: var(--surface-color);
    color: var(--text-primary);
}

.form-control:focus, .form-select:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(139, 69, 19, 0.1);
    outline: none;
}

.form-submit {
    display: flex;
    justify-content: center;
    margin-top: var(--space-xl);
}

/* Map Styles */
.map-wrapper {
    border: 3px solid white;
    box-shadow: var(--shadow-xl) !important;
}

.map-detail {
    padding: var(--space-md);
}

.map-detail h6 {
    color: var(--primary-color);
    margin-bottom: var(--space-xs);
}

/* FAQ Styles */
.faq-container {
    max-width: 1000px;
    margin: 0 auto;
}

.faq-accordion {
    display: flex;
    flex-direction: column;
    gap: var(--space-sm);
}

.faq-item {
    border: 1px solid var(--border-color);
    border-radius: var(--radius-md);
    overflow: hidden;
    background: var(--surface-color);
}

.faq-question {
    width: 100%;
    padding: var(--space-md);
    background: none;
    border: none;
    text-align: left;
    display: flex;
    align-items: center;
    gap: var(--space-sm);
    cursor: pointer;
    transition: var(--transition-fast);
}

.faq-question:hover {
    background: var(--border-color);
}

.faq-icon {
    color: var(--primary-color);
    font-size: 1.25rem;
}

.faq-text {
    flex: 1;
    font-weight: 600;
    color: var(--text-primary);
}

.faq-arrow {
    transition: var(--transition-normal);
}

.faq-item.active .faq-arrow {
    transform: rotate(180deg);
}

.faq-answer {
    padding: 0 var(--space-md);
    max-height: 0;
    overflow: hidden;
    transition: var(--transition-normal);
}

.faq-item.active .faq-answer {
    padding: 0 var(--space-md) var(--space-md);
    max-height: 500px;
}

/* Live Chat */
.support-badge {
    text-align: center;
    padding: var(--space-lg);
    background: var(--surface-color);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-md);
}

#liveChatBtn {
    position: relative;
    overflow: hidden;
}

#liveChatBtn::after {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: linear-gradient(
        45deg,
        transparent 30%,
        rgba(255, 255, 255, 0.1) 50%,
        transparent 70%
    );
    animation: shimmer 3s infinite linear;
}

/* Animations */
@keyframes shimmer {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}

/* Responsive Design */
@media (max-width: 768px) {
    .contact-form-card {
        padding: var(--space-lg);
    }
    
    .contact-card {
        flex-direction: column;
        text-align: center;
    }
    
    .contact-icon {
        margin: 0 auto;
    }
    
    .form-submit {
        flex-direction: column;
        gap: var(--space-sm);
    }
    
    .social-buttons {
        justify-content: center;
    }
    
    .faq-question {
        padding: var(--space-md) var(--space-sm);
    }
    
    .support-badge {
        margin-top: var(--space-lg);
    }
}

@media (max-width: 576px) {
    .contact-form-card {
        padding: var(--space-md);
    }
    
    .contact-card {
        padding: var(--space-md);
    }
    
    .faq-text {
        font-size: var(--text-sm);
    }
}

/* Loading State */
.form-submit button.loading {
    position: relative;
    color: transparent;
}

.form-submit button.loading::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 20px;
    height: 20px;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-top-color: white;
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
}

@keyframes spin {
    to { transform: translate(-50%, -50%) rotate(360deg); }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // FAQ Accordion
    const faqQuestions = document.querySelectorAll('.faq-question');
    
    faqQuestions.forEach(question => {
        question.addEventListener('click', function() {
            const faqItem = this.parentElement;
            const isActive = faqItem.classList.contains('active');
            
            // Close all FAQ items
            document.querySelectorAll('.faq-item').forEach(item => {
                item.classList.remove('active');
            });
            
            // Open clicked item if it wasn't active
            if (!isActive) {
                faqItem.classList.add('active');
            }
        });
    });
    
    // Form Validation and Submission
    const contactForm = document.querySelector('.contact-form');
    if (contactForm) {
        contactForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            // Show loading state
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
            
            // Validate form
            const isValid = validateContactForm();
            
            if (!isValid) {
                submitBtn.classList.remove('loading');
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
                return;
            }
            
            try {
                // For demo purposes - in production, this would be an actual fetch request
                await new Promise(resolve => setTimeout(resolve, 1500)); // Simulate API call
                
                showToast('Message sent successfully! We\'ll get back to you soon.', 'success');
                
                // Reset form
                this.reset();
                
            } catch (error) {
                console.error('Form submission error:', error);
                showToast('Failed to send message. Please try again.', 'error');
            } finally {
                submitBtn.classList.remove('loading');
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        });
    }
    
    // Form validation function
    function validateContactForm() {
        let isValid = true;
        
        // Clear previous errors
        document.querySelectorAll('.is-invalid').forEach(el => {
            el.classList.remove('is-invalid');
        });
        
        document.querySelectorAll('.invalid-feedback').forEach(el => {
            el.remove();
        });
        
        // Check required fields
        const requiredFields = contactForm.querySelectorAll('[required]');
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                showFieldError(field, 'This field is required');
                isValid = false;
            }
        });
        
        // Validate email format
        const emailField = document.getElementById('email');
        if (emailField.value && !isValidEmail(emailField.value)) {
            emailField.classList.add('is-invalid');
            showFieldError(emailField, 'Please enter a valid email address');
            isValid = false;
        }
        
        // Validate phone format if provided
        const phoneField = document.getElementById('phone');
        if (phoneField.value && !isValidPhone(phoneField.value)) {
            phoneField.classList.add('is-invalid');
            showFieldError(phoneField, 'Please enter a valid phone number');
            isValid = false;
        }
        
        return isValid;
    }
    
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
    
    function isValidPhone(phone) {
        const phoneRegex = /^[\+]?[1-9][\d]{0,15}$/;
        return phoneRegex.test(phone.replace(/[\s\-\(\)]/g, ''));
    }
    
    function showFieldError(field, message) {
        const errorDiv = document.createElement('div');
        errorDiv.className = 'invalid-feedback d-block';
        errorDiv.textContent = message;
        
        const parent = field.parentElement;
        if (parent.classList.contains('input-group')) {
            parent.parentElement.appendChild(errorDiv);
        } else {
            parent.appendChild(errorDiv);
        }
    }
    
    // Live Chat Button
    const liveChatBtn = document.getElementById('liveChatBtn');
    if (liveChatBtn) {
        liveChatBtn.addEventListener('click', function(e) {
            e.preventDefault();
            showToast('Live chat will be available soon!', 'info');
            // In production, this would open your live chat widget
        });
    }
    
    // Map interaction
    const mapIframe = document.querySelector('iframe');
    if (mapIframe) {
        mapIframe.addEventListener('load', function() {
            console.log('Map loaded successfully');
        });
    }
    
    // Form character counter for message field
    const messageField = document.getElementById('message');
    if (messageField) {
        const counter = document.createElement('div');
        counter.className = 'form-text text-end mt-1';
        counter.id = 'message-counter';
        messageField.parentElement.appendChild(counter);
        
        messageField.addEventListener('input', function() {
            const remaining = 1000 - this.value.length;
            counter.textContent = `${remaining} characters remaining`;
            counter.style.color = remaining < 100 ? 'var(--danger-color)' : 'var(--text-muted)';
        });
        
        // Trigger initial count
        messageField.dispatchEvent(new Event('input'));
    }
    
    // Clear form button
    const clearBtn = contactForm?.querySelector('button[type="reset"]');
    if (clearBtn) {
        clearBtn.addEventListener('click', function() {
            // Reset character counter
            if (messageField) {
                messageField.dispatchEvent(new Event('input'));
            }
            
            // Clear validation errors
            document.querySelectorAll('.is-invalid').forEach(el => {
                el.classList.remove('is-invalid');
            });
            document.querySelectorAll('.invalid-feedback').forEach(el => {
                el.remove();
            });
            
            showToast('Form cleared', 'info');
        });
    }
    
    // Intersection Observer for animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '50px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-slide-up');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    // Observe elements
    document.querySelectorAll('.contact-card, .contact-form-card, .map-container, .faq-item, .support-badge')
        .forEach(el => observer.observe(el));
});

// Toast notification function
function showToast(message, type = 'info') {
    // Check if toast container exists, create if not
    let container = document.getElementById('toastContainer');
    if (!container) {
        container = document.createElement('div');
        container.id = 'toastContainer';
        container.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        `;
        document.body.appendChild(container);
    }
    
    const toast = document.createElement('div');
    toast.className = `toast-notification ${type}`;
    toast.style.cssText = `
        background: ${type === 'success' ? '#27ae60' : 
                     type === 'error' ? '#e74c3c' : 
                     type === 'warning' ? '#f39c12' : '#3498db'};
        color: white;
        padding: 12px 20px;
        margin-bottom: 10px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        animation: slideIn 0.3s ease, fadeOut 0.3s ease 2.7s forwards;
    `;
    
    const icon = type === 'success' ? '✓' :
                 type === 'error' ? '✗' :
                 type === 'warning' ? '⚠' : 'ℹ';
    
    toast.innerHTML = `
        <span style="margin-right: 8px; font-weight: bold;">${icon}</span>
        ${message}
    `;
    
    container.appendChild(toast);
    
    // Remove toast after 3 seconds
    setTimeout(() => {
        if (toast.parentElement === container) {
            container.removeChild(toast);
        }
    }, 3000);
}

// Add CSS for toast animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes fadeOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);
</script>
@endpush