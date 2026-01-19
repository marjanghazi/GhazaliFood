@extends('layouts.app')

@section('title', 'About Us | Premium Dry Fruits Store | Ghazali Food')

@section('hero')
<!-- ==========================================================================
   Hero Section
   ========================================================================== -->
<section class="about-hero">
    <div class="container">
        <div class="hero-wrapper">
            <div class="hero-content">
                <div class="hero-badge animate-bounce">
                    <i class="fas fa-award me-2"></i> Trusted Since 2010
                </div>
                <h1 class="hero-title">Our Journey with Nature's Finest</h1>
                <p class="hero-subtitle">
                    From humble beginnings to becoming the leading premium dry fruits store,
                    discover the story behind Ghazali Food's commitment to quality and tradition.
                </p>
                <div class="hero-actions">
                    <a href="#our-story" class="btn btn-primary btn-lg">
                        <i class="fas fa-book-open me-2"></i> Our Story
                    </a>
                    <a href="{{ route('shop.index') }}" class="btn btn-outline btn-lg">
                        <i class="fas fa-shopping-bag me-2"></i> Shop Now
                    </a>
                </div>
            </div>
            <div class="hero-visual">
                <div class="hero-image">
                    <img src="https://images.unsplash.com/photo-1542291025-1ec7e8e7cbc6?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                         alt="Premium Dry Fruits Collection"
                         class="img-fluid">
                    <div class="hero-image-badge">
                        <i class="fas fa-seedling me-2"></i> 100% Natural
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('content')
<!-- ==========================================================================
   Our Story Section
   ========================================================================== -->
<section class="story-section section-padding" id="our-story">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">From Our Family to Yours</h2>
            <p class="section-subtitle">A legacy of quality and tradition since 2010</p>
        </div>
        
        <div class="story-timeline">
            <div class="timeline">
                <div class="timeline-item">
                    <div class="timeline-year">2010</div>
                    <div class="timeline-content">
                        <h4>Humble Beginnings</h4>
                        <p>Started as a small family business with a passion for premium dry fruits</p>
                    </div>
                    <div class="timeline-icon">
                        <i class="fas fa-store"></i>
                    </div>
                </div>
                
                <div class="timeline-item">
                    <div class="timeline-year">2013</div>
                    <div class="timeline-content">
                        <h4>First International Sourcing</h4>
                        <p>Began sourcing directly from orchards in California and Turkey</p>
                    </div>
                    <div class="timeline-icon">
                        <i class="fas fa-globe"></i>
                    </div>
                </div>
                
                <div class="timeline-item">
                    <div class="timeline-year">2016</div>
                    <div class="timeline-content">
                        <h4>Quality Certification</h4>
                        <p>Achieved organic and premium quality certifications</p>
                    </div>
                    <div class="timeline-icon">
                        <i class="fas fa-medal"></i>
                    </div>
                </div>
                
                <div class="timeline-item">
                    <div class="timeline-year">2020</div>
                    <div class="timeline-content">
                        <h4>Online Expansion</h4>
                        <p>Launched nationwide shipping and online store</p>
                    </div>
                    <div class="timeline-icon">
                        <i class="fas fa-rocket"></i>
                    </div>
                </div>
                
                <div class="timeline-item">
                    <div class="timeline-year">Today</div>
                    <div class="timeline-content">
                        <h4>Trusted by Thousands</h4>
                        <p>Serving families across the country with premium quality</p>
                    </div>
                    <div class="timeline-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="story-quote">
            <div class="quote-icon">
                <i class="fas fa-quote-left"></i>
            </div>
            <p class="quote-text">
                "Our journey began with a simple belief: that every family deserves access to 
                the purest, highest quality dry fruits nature has to offer. This belief continues 
                to guide every decision we make."
            </p>
            <div class="quote-author">
                <strong>— Ahmed Al-Ghazali</strong><br>
                <span>Founder & CEO</span>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================================================
   Mission & Values Section
   ========================================================================== -->
<section class="values-section section-padding bg-light">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Our Guiding Principles</h2>
            <p class="section-subtitle">The values that shape everything we do</p>
        </div>
        
        <div class="values-grid">
            <div class="value-card">
                <div class="value-icon">
                    <i class="fas fa-leaf"></i>
                </div>
                <div class="value-content">
                    <h4>Pure & Natural</h4>
                    <p>100% natural products with no additives, preservatives, or artificial enhancements.</p>
                </div>
            </div>
            
            <div class="value-card">
                <div class="value-icon">
                    <i class="fas fa-medal"></i>
                </div>
                <div class="value-content">
                    <h4>Premium Quality</h4>
                    <p>Only the finest grades selected through rigorous quality control processes.</p>
                </div>
            </div>
            
            <div class="value-card">
                <div class="value-icon">
                    <i class="fas fa-globe"></i>
                </div>
                <div class="value-content">
                    <h4>Global Excellence</h4>
                    <p>Sourced from the world's best orchards to bring you unparalleled quality.</p>
                </div>
            </div>
            
            <div class="value-card">
                <div class="value-icon">
                    <i class="fas fa-handshake"></i>
                </div>
                <div class="value-content">
                    <h4>Trust & Transparency</h4>
                    <p>Complete honesty about our products, processes, and partnerships.</p>
                </div>
            </div>
            
            <div class="value-card">
                <div class="value-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="value-content">
                    <h4>Family First</h4>
                    <p>Treating every customer like family with personalized care and attention.</p>
                </div>
            </div>
            
            <div class="value-card">
                <div class="value-icon">
                    <i class="fas fa-seedling"></i>
                </div>
                <div class="value-content">
                    <h4>Sustainable Future</h4>
                    <p>Committed to ethical sourcing and environmental responsibility.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================================================
   Our Promise Section
   ========================================================================== -->
<section class="promise-section section-padding">
    <div class="container">
        <div class="promise-wrapper">
            <div class="promise-content">
                <h2 class="promise-title">Our Unwavering Promise</h2>
                <p class="promise-text">
                    At Ghazali Food, we promise to deliver only the finest quality dry fruits,
                    sourced with care and delivered with love. Your satisfaction is our greatest reward.
                </p>
                <div class="promise-features">
                    <div class="feature">
                        <i class="fas fa-check-circle"></i>
                        <span>Freshness Guaranteed</span>
                    </div>
                    <div class="feature">
                        <i class="fas fa-check-circle"></i>
                        <span>Premium Quality</span>
                    </div>
                    <div class="feature">
                        <i class="fas fa-check-circle"></i>
                        <span>100% Natural</span>
                    </div>
                    <div class="feature">
                        <i class="fas fa-check-circle"></i>
                        <span>No Compromises</span>
                    </div>
                </div>
            </div>
            <div class="promise-visual">
                <div class="promise-image">
                    <img src="https://images.unsplash.com/photo-1586201375761-83865001e31c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                         alt="Quality Promise">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================================================
   Statistics Section
   ========================================================================== -->
<section class="stats-section section-padding bg-primary">
    <div class="container">
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-number" data-count="5000">0</div>
                <div class="stat-title">Happy Families</div>
                <p class="stat-desc">Trusting us with their nutrition</p>
            </div>
            
            <div class="stat-item">
                <div class="stat-number" data-count="150">0</div>
                <div class="stat-title">Premium Products</div>
                <p class="stat-desc">Curated collection</p>
            </div>
            
            <div class="stat-item">
                <div class="stat-number" data-count="25">0</div>
                <div class="stat-title">Countries Sourced</div>
                <p class="stat-desc">Global excellence</p>
            </div>
            
            <div class="stat-item">
                <div class="stat-number" data-count="14">0</div>
                <div class="stat-title">Years of Trust</div>
                <p class="stat-desc">Since 2010</p>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================================================
   Team Section
   ========================================================================== -->
<section class="team-section section-padding">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Meet Our Family</h2>
            <p class="section-subtitle">The passionate team behind Ghazali Food</p>
        </div>
        
        <div class="team-grid">
            <div class="team-member">
                <div class="member-image">
                    <img src="https://i.pravatar.cc/300?img=11" alt="Founder">
                    <div class="member-overlay">
                        <div class="member-social">
                            <a href="#" class="social-link"><i class="fab fa-linkedin"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                        </div>
                    </div>
                </div>
                <div class="member-info">
                    <h4>Ahmed Al-Ghazali</h4>
                    <p class="member-role">Founder & CEO</p>
                    <p class="member-bio">Third-generation dry fruit trader with 25+ years of expertise</p>
                </div>
            </div>
            
            <div class="team-member">
                <div class="member-image">
                    <img src="https://i.pravatar.cc/300?img=5" alt="Quality Manager">
                    <div class="member-overlay">
                        <div class="member-social">
                            <a href="#" class="social-link"><i class="fab fa-linkedin"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                        </div>
                    </div>
                </div>
                <div class="member-info">
                    <h4>Sarah Johnson</h4>
                    <p class="member-role">Quality Assurance Director</p>
                    <p class="member-bio">Food scientist specializing in nut quality and safety</p>
                </div>
            </div>
            
            <div class="team-member">
                <div class="member-image">
                    <img src="https://i.pravatar.cc/300?img=8" alt="Sourcing Head">
                    <div class="member-overlay">
                        <div class="member-social">
                            <a href="#" class="social-link"><i class="fab fa-linkedin"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                        </div>
                    </div>
                </div>
                <div class="member-info">
                    <h4>Michael Chen</h4>
                    <p class="member-role">Global Sourcing Head</p>
                    <p class="member-bio">Expert in international agriculture and fair trade</p>
                </div>
            </div>
            
            <div class="team-member">
                <div class="member-image">
                    <img src="https://i.pravatar.cc/300?img=3" alt="Nutritionist">
                    <div class="member-overlay">
                        <div class="member-social">
                            <a href="#" class="social-link"><i class="fab fa-linkedin"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                        </div>
                    </div>
                </div>
                <div class="member-info">
                    <h4>Dr. Emma Davis</h4>
                    <p class="member-role">Chief Nutritionist</p>
                    <p class="member-bio">Registered dietitian specializing in plant-based nutrition</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================================================
   Testimonials Section
   ========================================================================== -->
<section class="testimonials-section section-padding bg-light">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Loved by Families</h2>
            <p class="section-subtitle">What our community says about us</p>
        </div>
        
        <div class="testimonials-grid">
            <div class="testimonial-card">
                <div class="testimonial-rating">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="testimonial-text">
                    "Ghazali Food has been our family's trusted source for premium dry fruits 
                    for over 5 years. The quality is consistently exceptional!"
                </p>
                <div class="testimonial-author">
                    <div class="author-image">
                        <img src="https://i.pravatar.cc/50?img=32" alt="Customer">
                    </div>
                    <div class="author-info">
                        <h6>Fatima Al-Mansoori</h6>
                        <p>Customer Since 2018</p>
                    </div>
                </div>
            </div>
            
            <div class="testimonial-card">
                <div class="testimonial-rating">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <p class="testimonial-text">
                    "As a professional chef, I demand the best ingredients. Ghazali Food 
                    consistently delivers premium quality that elevates my dishes."
                </p>
                <div class="testimonial-author">
                    <div class="author-image">
                        <img src="https://i.pravatar.cc/50?img=28" alt="Customer">
                    </div>
                    <div class="author-info">
                        <h6>Chef Rajesh Kumar</h6>
                        <p>Executive Chef, Taj Palace</p>
                    </div>
                </div>
            </div>
            
            <div class="testimonial-card">
                <div class="testimonial-rating">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="testimonial-text">
                    "The customer service is outstanding, and the product quality is unmatched. 
                    Our go-to for all our dry fruit needs!"
                </p>
                <div class="testimonial-author">
                    <div class="author-image">
                        <img src="https://i.pravatar.cc/50?img=19" alt="Customer">
                    </div>
                    <div class="author-info">
                        <h6>John & Maria Rodriguez</h6>
                        <p>Family Customers Since 2015</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================================================
   CTA Section
   ========================================================================== -->
<section class="cta-section section-padding">
    <div class="container">
        <div class="cta-wrapper">
            <div class="cta-content">
                <h2 class="cta-title">Ready to Experience Premium Quality?</h2>
                <p class="cta-text">
                    Join thousands of families who trust Ghazali Food for their daily nutrition needs.
                </p>
                <div class="cta-actions">
                    <a href="{{ route('shop.index') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-shopping-bag me-2"></i> Shop Our Collection
                    </a>
                    <a href="{{ route('contact.index') }}" class="btn btn-outline btn-lg">
                        <i class="fas fa-envelope me-2"></i> Get In Touch
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
/* ==========================================================================
   About Hero Section
   ========================================================================== */
.about-hero {
    background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-color) 100%);
    padding: var(--space-2xl) 0;
    position: relative;
    overflow: hidden;
}

.about-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: 
        radial-gradient(circle at 10% 20%, rgba(212, 175, 55, 0.1) 0%, transparent 40%),
        radial-gradient(circle at 90% 80%, rgba(17, 80, 40, 0.1) 0%, transparent 40%);
}

.hero-wrapper {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: var(--space-xl);
    align-items: center;
    position: relative;
    z-index: 2;
}

.hero-content .hero-badge {
    display: inline-flex;
    align-items: center;
    background: var(--gradient-gold);
    color: var(--text-primary);
    padding: 8px 16px;
    border-radius: var(--radius-full);
    font-weight: 600;
    margin-bottom: var(--space-lg);
    font-size: var(--text-sm);
}

.hero-content .hero-title {
    color: white;
    font-size: var(--text-4xl);
    margin-bottom: var(--space-md);
    line-height: 1.2;
}

.hero-content .hero-subtitle {
    color: rgba(255, 255, 255, 0.9);
    font-size: var(--text-lg);
    margin-bottom: var(--space-xl);
    line-height: 1.6;
}

.hero-actions {
    display: flex;
    gap: var(--space-md);
}

.hero-visual {
    position: relative;
}

.hero-image {
    border-radius: var(--radius-xl);
    overflow: hidden;
    box-shadow: var(--shadow-xl);
    position: relative;
}

.hero-image img {
    width: 100%;
    height: auto;
    transition: transform 0.6s ease;
}

.hero-image:hover img {
    transform: scale(1.05);
}

.hero-image-badge {
    position: absolute;
    bottom: 20px;
    right: 20px;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    color: white;
    padding: 8px 16px;
    border-radius: var(--radius-full);
    font-weight: 600;
    box-shadow: var(--shadow-md);
}

/* ==========================================================================
   Section Common Styles
   ========================================================================== */
.section-padding {
    padding: var(--space-2xl) 0;
}

.section-header {
    text-align: center;
    margin-bottom: var(--space-xl);
}

.section-title {
    font-size: var(--text-3xl);
    color: var(--text-primary);
    margin-bottom: var(--space-sm);
}

.section-subtitle {
    color: var(--text-secondary);
    font-size: var(--text-lg);
}

/* ==========================================================================
   Story Timeline
   ========================================================================== */
.story-timeline {
    margin: var(--space-xl) 0;
}

.timeline {
    position: relative;
    max-width: 800px;
    margin: 0 auto;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 50%;
    top: 0;
    bottom: 0;
    width: 2px;
    background: var(--gradient-gold);
    transform: translateX(-50%);
}

.timeline-item {
    display: flex;
    align-items: center;
    margin-bottom: var(--space-xl);
    position: relative;
}

.timeline-item:nth-child(odd) {
    flex-direction: row-reverse;
}

.timeline-year {
    flex: 0 0 100px;
    text-align: center;
    font-size: var(--text-xl);
    font-weight: 700;
    color: var(--primary-color);
    background: var(--surface-color);
    padding: var(--space-sm);
    border-radius: var(--radius-md);
    border: 2px solid var(--border-color);
}

.timeline-content {
    flex: 1;
    padding: var(--space-lg);
    background: var(--surface-color);
    border-radius: var(--radius-lg);
    margin: 0 var(--space-lg);
    box-shadow: var(--shadow-md);
    border: 1px solid var(--border-color);
}

.timeline-content h4 {
    color: var(--primary-color);
    margin-bottom: var(--space-xs);
}

.timeline-icon {
    width: 40px;
    height: 40px;
    background: var(--gradient-primary);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    flex-shrink: 0;
}

.story-quote {
    text-align: center;
    max-width: 800px;
    margin: var(--space-2xl) auto 0;
    padding: var(--space-xl);
    background: var(--surface-color);
    border-radius: var(--radius-xl);
    border: 1px solid var(--border-color);
}

.quote-icon {
    font-size: 2rem;
    color: var(--accent-color);
    margin-bottom: var(--space-md);
}

.quote-text {
    font-size: var(--text-lg);
    color: var(--text-secondary);
    font-style: italic;
    line-height: 1.6;
    margin-bottom: var(--space-lg);
}

.quote-author strong {
    color: var(--primary-color);
    font-size: var(--text-lg);
}

.quote-author span {
    color: var(--text-muted);
    font-size: var(--text-sm);
}

/* ==========================================================================
   Values Grid
   ========================================================================== */
.values-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: var(--space-lg);
}

.value-card {
    background: var(--surface-color);
    border-radius: var(--radius-lg);
    padding: var(--space-lg);
    display: flex;
    align-items: flex-start;
    gap: var(--space-md);
    transition: var(--transition-normal);
    border: 1px solid var(--border-color);
}

.value-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
    border-color: var(--accent-color);
}

.value-icon {
    width: 60px;
    height: 60px;
    min-width: 60px;
    background: var(--gradient-primary);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
}

.value-content h4 {
    color: var(--primary-color);
    margin-bottom: var(--space-xs);
}

.value-content p {
    color: var(--text-secondary);
    line-height: 1.6;
}

/* ==========================================================================
   Promise Section
   ========================================================================== */
.promise-wrapper {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: var(--space-xl);
    align-items: center;
}

.promise-title {
    font-size: var(--text-3xl);
    color: var(--text-primary);
    margin-bottom: var(--space-md);
}

.promise-text {
    font-size: var(--text-lg);
    color: var(--text-secondary);
    margin-bottom: var(--space-lg);
    line-height: 1.6;
}

.promise-features {
    display: grid;
    gap: var(--space-sm);
}

.feature {
    display: flex;
    align-items: center;
    gap: var(--space-sm);
}

.feature i {
    color: var(--success-color);
}

.feature span {
    font-weight: 500;
    color: var(--text-primary);
}

.promise-image {
    border-radius: var(--radius-xl);
    overflow: hidden;
    box-shadow: var(--shadow-xl);
}

.promise-image img {
    width: 100%;
    height: auto;
}

/* ==========================================================================
   Statistics Section
   ========================================================================== */
.stats-section {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: var(--space-xl);
    text-align: center;
}

.stat-item {
    padding: var(--space-lg);
}

.stat-number {
    font-size: var(--text-4xl);
    font-weight: 800;
    color: white;
    margin-bottom: var(--space-sm);
}

.stat-title {
    font-size: var(--text-lg);
    font-weight: 600;
    color: white;
    margin-bottom: var(--space-xs);
}

.stat-desc {
    color: rgba(255, 255, 255, 0.8);
    font-size: var(--text-sm);
}

/* ==========================================================================
   Team Section
   ========================================================================== */
.team-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: var(--space-lg);
}

.team-member {
    background: var(--surface-color);
    border-radius: var(--radius-lg);
    overflow: hidden;
    box-shadow: var(--shadow-md);
    transition: var(--transition-normal);
    border: 1px solid var(--border-color);
}

.team-member:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
}

.member-image {
    position: relative;
    height: 250px;
    overflow: hidden;
}

.member-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s ease;
}

.team-member:hover .member-image img {
    transform: scale(1.05);
}

.member-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to bottom, transparent, rgba(17, 80, 40, 0.8));
    display: flex;
    align-items: flex-end;
    justify-content: center;
    opacity: 0;
    transition: var(--transition-normal);
    padding: var(--space-lg);
}

.team-member:hover .member-overlay {
    opacity: 1;
}

.member-social {
    display: flex;
    gap: var(--space-sm);
    transform: translateY(20px);
    transition: transform 0.4s ease;
}

.team-member:hover .member-social {
    transform: translateY(0);
}

.social-link {
    width: 36px;
    height: 36px;
    background: var(--surface-color);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-primary);
    text-decoration: none;
    transition: var(--transition-fast);
}

.social-link:hover {
    background: var(--primary-color);
    color: white;
}

.member-info {
    padding: var(--space-lg);
    text-align: center;
}

.member-info h4 {
    color: var(--text-primary);
    margin-bottom: var(--space-xs);
}

.member-role {
    color: var(--primary-color);
    font-weight: 600;
    margin-bottom: var(--space-sm);
}

.member-bio {
    color: var(--text-secondary);
    font-size: var(--text-sm);
    line-height: 1.5;
}

/* ==========================================================================
   Testimonials Section
   ========================================================================== */
.testimonials-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: var(--space-lg);
}

.testimonial-card {
    background: var(--surface-color);
    border-radius: var(--radius-lg);
    padding: var(--space-lg);
    box-shadow: var(--shadow-md);
    border: 1px solid var(--border-color);
}

.testimonial-rating {
    color: var(--accent-color);
    margin-bottom: var(--space-md);
    font-size: var(--text-lg);
}

.testimonial-text {
    color: var(--text-secondary);
    font-style: italic;
    line-height: 1.6;
    margin-bottom: var(--space-lg);
}

.testimonial-author {
    display: flex;
    align-items: center;
    gap: var(--space-sm);
}

.author-image {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    overflow: hidden;
    flex-shrink: 0;
}

.author-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.author-info h6 {
    color: var(--text-primary);
    margin-bottom: 2px;
}

.author-info p {
    color: var(--text-muted);
    font-size: var(--text-sm);
}

/* ==========================================================================
   CTA Section
   ========================================================================== */
.cta-section {
    background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-color) 50%, var(--accent-color) 100%);
    position: relative;
    overflow: hidden;
}

.cta-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: 
        radial-gradient(circle at 20% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 80% 50%, rgba(212, 175, 55, 0.1) 0%, transparent 50%);
}

.cta-wrapper {
    position: relative;
    z-index: 2;
    text-align: center;
}

.cta-title {
    color: white;
    font-size: var(--text-3xl);
    margin-bottom: var(--space-md);
}

.cta-text {
    color: rgba(255, 255, 255, 0.9);
    font-size: var(--text-lg);
    margin-bottom: var(--space-xl);
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.cta-actions {
    display: flex;
    gap: var(--space-md);
    justify-content: center;
}

/* ==========================================================================
   Animations
   ========================================================================== */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes countUp {
    from {
        content: '0';
    }
    to {
        content: attr(data-count);
    }
}

.animated {
    animation: fadeInUp 0.6s ease-out;
}

/* ==========================================================================
   Responsive Design
   ========================================================================== */
@media (max-width: 992px) {
    .hero-wrapper {
        grid-template-columns: 1fr;
        text-align: center;
    }
    
    .hero-content .hero-title {
        font-size: var(--text-3xl);
    }
    
    .timeline::before {
        left: 40px;
    }
    
    .timeline-item,
    .timeline-item:nth-child(odd) {
        flex-direction: row;
    }
    
    .timeline-year {
        flex: 0 0 80px;
    }
    
    .promise-wrapper {
        grid-template-columns: 1fr;
    }
    
    .cta-actions {
        flex-direction: column;
    }
    
    .cta-actions .btn {
        width: 100%;
        text-align: center;
    }
}

@media (max-width: 768px) {
    .hero-content .hero-title {
        font-size: var(--text-2xl);
    }
    
    .hero-content .hero-subtitle {
        font-size: var(--text-base);
    }
    
    .hero-actions {
        flex-direction: column;
    }
    
    .hero-actions .btn {
        width: 100%;
        text-align: center;
    }
    
    .section-title {
        font-size: var(--text-2xl);
    }
    
    .values-grid {
        grid-template-columns: 1fr;
    }
    
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .team-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .testimonials-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 576px) {
    .timeline::before {
        left: 20px;
    }
    
    .timeline-year {
        flex: 0 0 60px;
        font-size: var(--text-base);
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .team-grid {
        grid-template-columns: 1fr;
    }
    
    .cta-title {
        font-size: var(--text-2xl);
    }
    
    .cta-text {
        font-size: var(--text-base);
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ==========================================================================
    // Animated Counter for Statistics
    // ==========================================================================
    const statNumbers = document.querySelectorAll('.stat-number');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const statNumber = entry.target;
                const target = parseInt(statNumber.getAttribute('data-count'));
                if (!isNaN(target)) {
                    animateCounter(statNumber, 0, target, 2000);
                }
                observer.unobserve(statNumber);
            }
        });
    }, {
        threshold: 0.5,
        rootMargin: '50px'
    });

    statNumbers.forEach(stat => observer.observe(stat));

    function animateCounter(element, start, end, duration) {
        let startTimestamp = null;
        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
            const currentValue = Math.floor(progress * (end - start) + start);
            element.textContent = currentValue;
            if (progress < 1) {
                window.requestAnimationFrame(step);
            }
        };
        window.requestAnimationFrame(step);
    }

    // ==========================================================================
    // Timeline Animation
    // ==========================================================================
    const timelineItems = document.querySelectorAll('.timeline-item');
    
    const timelineObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animated');
                timelineObserver.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.2,
        rootMargin: '50px'
    });

    timelineItems.forEach(item => timelineObserver.observe(item));

    // ==========================================================================
    // Team Member Hover Effects
    // ==========================================================================
    const teamMembers = document.querySelectorAll('.team-member');
    
    teamMembers.forEach(member => {
        member.addEventListener('mouseenter', function() {
            this.style.zIndex = '10';
        });
        
        member.addEventListener('mouseleave', function() {
            this.style.zIndex = '1';
        });
    });

    // ==========================================================================
    // Value Cards Animation
    // ==========================================================================
    const valueCards = document.querySelectorAll('.value-card');
    
    const valueObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.classList.add('animated');
                }, index * 100);
                valueObserver.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '50px'
    });

    valueCards.forEach(card => valueObserver.observe(card));

    // ==========================================================================
    // Testimonial Cards Animation
    // ==========================================================================
    const testimonialCards = document.querySelectorAll('.testimonial-card');
    
    const testimonialObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.classList.add('animated');
                }, index * 150);
                testimonialObserver.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '50px'
    });

    testimonialCards.forEach(card => testimonialObserver.observe(card));

    // ==========================================================================
    // Smooth Scrolling for Anchor Links
    // ==========================================================================
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 100,
                    behavior: 'smooth'
                });
            }
        });
    });

    // ==========================================================================
    // Parallax Effect for Hero Section
    // ==========================================================================
    window.addEventListener('scroll', function() {
        const scrolled = window.pageYOffset;
        const hero = document.querySelector('.about-hero');
        if (hero) {
            const rate = scrolled * -0.5;
            hero.style.backgroundPosition = `center ${rate}px`;
        }
    });

    // ==========================================================================
    // Social Links Interaction
    // ==========================================================================
    document.querySelectorAll('.social-link').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const platform = this.querySelector('i').className.includes('linkedin') ? 'LinkedIn' : 'Twitter';
            showToast(`Opening ${platform} profile`, 'info');
        });
    });
});

// ==========================================================================
// Toast Notification Helper Function
// ==========================================================================
function showToast(message, type = 'info') {
    // Use existing toast function if available
    if (typeof window.showToast === 'function') {
        window.showToast(message, type);
        return;
    }
    
    // Fallback simple notification
    console.log(`${type}: ${message}`);
}

// ==========================================================================
// Loading Animation for Images
// ==========================================================================
document.addEventListener('DOMContentLoaded', function() {
    const images = document.querySelectorAll('img');
    
    images.forEach(img => {
        img.addEventListener('load', function() {
            this.classList.add('loaded');
        });
    });
});
</script>
@endpush