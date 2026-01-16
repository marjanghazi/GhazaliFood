@extends('layouts.app')

@section('title', 'Contact Us - Ghazali Food')

@section('hero')
<!-- Contact Hero -->
<section class="hero-section" style="background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?ixlib=rb-4.0.3') center/cover no-repeat;">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="animate__animated animate__fadeInUp">Contact Us</h1>
                <p class="lead animate__animated animate__fadeInUp animate__delay-1s">
                    We'd love to hear from you
                </p>
                <nav aria-label="breadcrumb" class="d-flex justify-content-center">
                    <ol class="breadcrumb bg-transparent p-0 animate__animated animate__fadeInUp animate__delay-2s">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
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
        <!-- Contact Info -->
        <div class="col-lg-4 mb-4">
            <div class="contact-info-card p-4 bg-white rounded-3 shadow-sm h-100">
                <h3 class="fw-bold mb-4">Get in Touch</h3>
                
                <div class="contact-item d-flex mb-4">
                    <div class="contact-icon me-3">
                        <i class="fas fa-map-marker-alt fa-2x text-success"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">Address</h5>
                        <p class="text-muted mb-0">
                            123 Food Street<br>
                            Culinary City, CC 12345
                        </p>
                    </div>
                </div>
                
                <div class="contact-item d-flex mb-4">
                    <div class="contact-icon me-3">
                        <i class="fas fa-phone fa-2x text-success"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">Phone</h5>
                        <p class="text-muted mb-0">
                            +1 (234) 567-8900<br>
                            +1 (234) 567-8901
                        </p>
                    </div>
                </div>
                
                <div class="contact-item d-flex mb-4">
                    <div class="contact-icon me-3">
                        <i class="fas fa-envelope fa-2x text-success"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">Email</h5>
                        <p class="text-muted mb-0">
                            info@ghazalifood.com<br>
                            support@ghazalifood.com
                        </p>
                    </div>
                </div>
                
                <div class="contact-item d-flex">
                    <div class="contact-icon me-3">
                        <i class="fas fa-clock fa-2x text-success"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">Business Hours</h5>
                        <p class="text-muted mb-0">
                            Monday - Friday: 9:00 AM - 8:00 PM<br>
                            Saturday - Sunday: 10:00 AM - 6:00 PM
                        </p>
                    </div>
                </div>
                
                <div class="social-icons mt-4">
                    <a href="#" class="btn btn-outline-success me-2">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="btn btn-outline-success me-2">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="btn btn-outline-success me-2">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="btn btn-outline-success">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="col-lg-8">
            <div class="contact-form-card p-4 bg-white rounded-3 shadow-sm">
                <h3 class="fw-bold mb-4">Send us a Message</h3>
                
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif
                
                <form action="{{ route('contact.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Full Name *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email Address *</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" value="{{ old('phone') }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="subject" class="form-label">Subject *</label>
                            <input type="text" class="form-control @error('subject') is-invalid @enderror" 
                                   id="subject" name="subject" value="{{ old('subject') }}" required>
                            @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="feedback_type" class="form-label">Inquiry Type *</label>
                        <select class="form-select @error('feedback_type') is-invalid @enderror" 
                                id="feedback_type" name="feedback_type" required>
                            <option value="">Select type...</option>
                            <option value="general" {{ old('feedback_type') == 'general' ? 'selected' : '' }}>General Inquiry</option>
                            <option value="complaint" {{ old('feedback_type') == 'complaint' ? 'selected' : '' }}>Complaint</option>
                            <option value="suggestion" {{ old('feedback_type') == 'suggestion' ? 'selected' : '' }}>Suggestion</option>
                            <option value="support" {{ old('feedback_type') == 'support' ? 'selected' : '' }}>Support</option>
                            <option value="other" {{ old('feedback_type') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('feedback_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="message" class="form-label">Message *</label>
                        <textarea class="form-control @error('message') is-invalid @enderror" 
                                  id="message" name="message" rows="5" required>{{ old('message') }}</textarea>
                        @error('message')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="privacy" name="privacy" required>
                            <label class="form-check-label" for="privacy">
                                I agree to the <a href="#" class="text-success">Privacy Policy</a> and 
                                <a href="#" class="text-success">Terms of Service</a>
                            </label>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="fas fa-paper-plane me-2"></i> Send Message
                    </button>
                </form>
            </div>
            
            <!-- Map -->
            <div class="map-card mt-4 p-4 bg-white rounded-3 shadow-sm">
                <h4 class="fw-bold mb-3">Our Location</h4>
                <div class="ratio ratio-16x9">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3024.2219901290355!2d-74.00369368400567!3d40.71312937933185!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c25a316ff11b35%3A0x9c2c2b1b1c1c1c1c!2s123%20Food%20St%2C%20New%20York%2C%20NY%2010001!5e0!3m2!1sen!2sus!4v1623932000000!5m2!1sen!2sus" 
                            style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FAQ Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h2 class="fw-bold mb-3">Frequently Asked Questions</h2>
                <p class="text-muted">Find answers to common questions</p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="accordion" id="faqAccordion1">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" 
                                    data-bs-target="#faq1">
                                What are your delivery hours?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion1">
                            <div class="accordion-body">
                                We deliver from 9:00 AM to 8:00 PM, Monday through Friday, 
                                and 10:00 AM to 6:00 PM on weekends.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                    data-bs-target="#faq2">
                                Do you offer international shipping?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion1">
                            <div class="accordion-body">
                                Currently, we only ship within the United States. 
                                We're working on expanding our international shipping options.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                    data-bs-target="#faq3">
                                How can I track my order?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion1">
                            <div class="accordion-body">
                                Once your order ships, you'll receive a tracking number via email. 
                                You can use this number on our website or the carrier's website to track your package.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6 mb-4">
                <div class="accordion" id="faqAccordion2">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                    data-bs-target="#faq4">
                                What is your return policy?
                            </button>
                        </h2>
                        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion2">
                            <div class="accordion-body">
                                We offer a 30-day return policy for unopened and unused products. 
                                Please contact our customer service team to initiate a return.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                    data-bs-target="#faq5">
                                Do you have physical stores?
                            </button>
                        </h2>
                        <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion2">
                            <div class="accordion-body">
                                Currently, we operate exclusively online. This allows us to keep 
                                our prices competitive and offer nationwide delivery.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                    data-bs-target="#faq6">
                                How do I contact customer support?
                            </button>
                        </h2>
                        <div id="faq6" class="accordion-collapse collapse" data-bs-parent="#faqAccordion2">
                            <div class="accordion-body">
                                You can reach our customer support team through the contact form on this page, 
                                email us at support@ghazalifood.com, or call us at +1 (234) 567-8900.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection