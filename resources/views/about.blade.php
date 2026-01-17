@extends('layouts.app')

@section('title', 'About Us | Premium Dry Fruits Store | Nuts & Berries')

@section('hero')
<!-- ==========================================================================
   Hero Section
   ========================================================================== -->

<section class="hero-section">
    <div class="container">
        <div class="row align-items-center min-vh-70">
            <div class="col-lg-6">
                <h1 class="hero-title animate-slide-up">Our Story & Legacy</h1>
                <p class="hero-subtitle animate-slide-up delay-1">
                    Discover the journey of Nuts & Berries - from a passionate family business 
                    to becoming the leading premium dry fruits store you trust today.
                </p>
                <div class="hero-buttons animate-slide-up delay-2">
                    <a href="{{ route('shop.index') }}" class="btn btn-primary btn-lg">
                        Shop Now <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                    <a href="#values" class="btn btn-outline btn-lg">
                        Our Values
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-image">
                    <img src="https://images.unsplash.com/photo-1542291025-1ec7e8e7cbc6?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                         alt="Premium Dry Fruits Collection"
                         class="img-fluid rounded-3">
                    <div class="hero-badge animate-bounce">
                        <i class="fas fa-award me-2"></i> Since 2010
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('content')
<!-- ==========================================================================
   Our Journey Section
   ========================================================================== -->

<section class="py-5">
    <div class="container">
        <div class="row align-items-center mb-5">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="story-image">
                    <img src="https://images.unsplash.com/photo-1586201375761-83865001e31c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                         alt="Our Journey"
                         class="img-fluid rounded-3">
                    <div class="story-badge">
                        <i class="fas fa-seedling me-2"></i> Family Owned
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="section-header">
                    <h2 class="section-title">Our Humble Beginnings</h2>
                    <p class="text-muted mb-4">A journey of passion and quality</p>
                </div>
                
                <div class="story-content">
                    <p class="lead mb-4">
                        Founded in 2010, <strong>Nuts & Berries</strong> began with a simple vision: to bring 
                        the world's finest dry fruits directly to your table.
                    </p>
                    <p class="mb-4">
                        What started as a small family business has blossomed into a trusted name 
                        in premium dry fruits. Our founder, a third-generation dry fruit trader, 
                        combined traditional knowledge with modern quality standards to create 
                        something truly special.
                    </p>
                    <p class="mb-0">
                        Today, we source from the world's best orchards and farms, maintaining 
                        our commitment to 100% natural, organic, and premium quality products 
                        that families have trusted for over a decade.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================================================
   Mission & Vision Section
   ========================================================================== -->

<section class="features-section py-5 bg-light">
    <div class="container">
        <div class="section-header mb-5">
            <h2 class="section-title">Our Commitment</h2>
            <p class="text-muted">Driven by purpose, guided by values</p>
        </div>
        
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon" style="background: var(--gradient-primary);">
                    <i class="fas fa-bullseye"></i>
                </div>
                <h5 class="feature-title">Our Mission</h5>
                <p class="text-muted">
                    To deliver the purest, highest quality dry fruits while promoting 
                    healthy living through natural nutrition.
                </p>
            </div>
            <div class="feature-card">
                <div class="feature-icon" style="background: var(--gradient-secondary);">
                    <i class="fas fa-eye"></i>
                </div>
                <h5 class="feature-title">Our Vision</h5>
                <p class="text-muted">
                    To become the most trusted global brand for premium dry fruits, 
                    setting new standards in quality and sustainability.
                </p>
            </div>
            <div class="feature-card">
                <div class="feature-icon" style="background: var(--gradient-accent);">
                    <i class="fas fa-heart"></i>
                </div>
                <h5 class="feature-title">Our Passion</h5>
                <p class="text-muted">
                    We're passionate about bringing joy and health to families through 
                    nature's finest offerings.
                </p>
            </div>
            <div class="feature-card">
                <div class="feature-icon" style="background: var(--gradient-gold);">
                    <i class="fas fa-handshake"></i>
                </div>
                <h5 class="feature-title">Our Promise</h5>
                <p class="text-muted">
                    Uncompromising quality, complete transparency, and your complete 
                    satisfaction—guaranteed.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================================================
   Our Values Section
   ========================================================================== -->

<section class="py-5" id="values">
    <div class="container">
        <div class="section-header mb-5">
            <h2 class="section-title">Our Core Values</h2>
            <p class="text-muted">The principles that guide everything we do</p>
        </div>
        
        <div class="values-grid">
            <div class="value-card">
                <div class="value-icon">
                    <i class="fas fa-leaf"></i>
                </div>
                <div class="value-content">
                    <h5>100% Natural</h5>
                    <p class="text-muted">
                        No preservatives, no additives. Just pure, natural goodness 
                        from nature's finest sources.
                    </p>
                </div>
            </div>
            
            <div class="value-card">
                <div class="value-icon">
                    <i class="fas fa-medal"></i>
                </div>
                <div class="value-content">
                    <h5>Premium Quality</h5>
                    <p class="text-muted">
                        We select only the finest grades. Every product undergoes 
                        rigorous quality checks before reaching you.
                    </p>
                </div>
            </div>
            
            <div class="value-card">
                <div class="value-icon">
                    <i class="fas fa-globe"></i>
                </div>
                <div class="value-content">
                    <h5>Global Sourcing</h5>
                    <p class="text-muted">
                        Sourced from the world's best orchards—from California almonds 
                        to Turkish apricots and Iranian pistachios.
                    </p>
                </div>
            </div>
            
            <div class="value-card">
                <div class="value-icon">
                    <i class="fas fa-seedling"></i>
                </div>
                <div class="value-content">
                    <h5>Sustainability</h5>
                    <p class="text-muted">
                        Committed to ethical sourcing and sustainable farming 
                        practices that respect our planet.
                    </p>
                </div>
            </div>
            
            <div class="value-card">
                <div class="value-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="value-content">
                    <h5>Customer First</h5>
                    <p class="text-muted">
                        Your satisfaction is our priority. We're here to serve you 
                        with care and attention.
                    </p>
                </div>
            </div>
            
            <div class="value-card">
                <div class="value-icon">
                    <i class="fas fa-lightbulb"></i>
                </div>
                <div class="value-content">
                    <h5>Innovation</h5>
                    <p class="text-muted">
                        Continuously improving our processes and products to serve 
                        you better.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================================================
   Stats Section
   ========================================================================== -->

<section class="py-5 bg-light">
    <div class="container">
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number">5000+</div>
                <div class="stat-title">Happy Families</div>
                <p class="stat-desc text-muted">Trusting us for their daily nutrition</p>
            </div>
            
            <div class="stat-card">
                <div class="stat-number">150+</div>
                <div class="stat-title">Premium Products</div>
                <p class="stat-desc text-muted">Curated from across the globe</p>
            </div>
            
            <div class="stat-card">
                <div class="stat-number">25+</div>
                <div class="stat-title">Countries Sourced</div>
                <p class="stat-desc text-muted">From world's finest orchards</p>
            </div>
            
            <div class="stat-card">
                <div class="stat-number">14+</div>
                <div class="stat-title">Years of Trust</div>
                <p class="stat-desc text-muted">Serving since 2010</p>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================================================
   Team Section
   ========================================================================== -->

<section class="py-5">
    <div class="container">
        <div class="section-header mb-5">
            <h2 class="section-title">Meet Our Family</h2>
            <p class="text-muted">The passionate team behind Nuts & Berries</p>
        </div>
        
        <div class="team-grid">
            <div class="team-card">
                <div class="team-image">
                    <img src="https://i.pravatar.cc/300?img=11" alt="Founder">
                    <div class="team-social">
                        <a href="#" class="social-link"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
                <div class="team-info">
                    <h5>Ahmed Al-Ghazali</h5>
                    <p class="team-role">Founder & CEO</p>
                    <p class="team-desc text-muted">
                        Third-generation dry fruit trader with over 25 years of experience
                    </p>
                </div>
            </div>
            
            <div class="team-card">
                <div class="team-image">
                    <img src="https://i.pravatar.cc/300?img=5" alt="Quality Manager">
                    <div class="team-social">
                        <a href="#" class="social-link"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
                <div class="team-info">
                    <h5>Sarah Johnson</h5>
                    <p class="team-role">Quality Assurance Director</p>
                    <p class="team-desc text-muted">
                        Food scientist specializing in nut quality and safety
                    </p>
                </div>
            </div>
            
            <div class="team-card">
                <div class="team-image">
                    <img src="https://i.pravatar.cc/300?img=8" alt="Sourcing Head">
                    <div class="team-social">
                        <a href="#" class="social-link"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
                <div class="team-info">
                    <h5>Michael Chen</h5>
                    <p class="team-role">Global Sourcing Head</p>
                    <p class="team-desc text-muted">
                        Expert in international agriculture and fair trade
                    </p>
                </div>
            </div>
            
            <div class="team-card">
                <div class="team-image">
                    <img src="https://i.pravatar.cc/300?img=3" alt="Nutritionist">
                    <div class="team-social">
                        <a href="#" class="social-link"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
                <div class="team-info">
                    <h5>Dr. Emma Davis</h5>
                    <p class="team-role">Chief Nutritionist</p>
                    <p class="team-desc text-muted">
                        Registered dietitian specializing in plant-based nutrition
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================================================
   Testimonials Section
   ========================================================================== -->

<section class="testimonials-section py-5 bg-light">
    <div class="container">
        <div class="section-header mb-5">
            <h2 class="section-title">Trusted By Families</h2>
            <p class="text-muted">What our community says about us</p>
        </div>
        
        <div class="testimonial-slider">
            <div class="testimonial-card">
                <div class="testimonial-rating">
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star text-warning"></i>
                </div>
                <p class="testimonial-text">
                    "Nuts & Berries has been our family's trusted source for premium dry fruits 
                    for over 5 years. The quality is consistently exceptional!"
                </p>
                <div class="testimonial-author">
                    <div class="author-avatar">
                        <img src="https://i.pravatar.cc/50?img=32" alt="Customer">
                    </div>
                    <div class="author-info">
                        <h6>Fatima Al-Mansoori</h6>
                        <small>Regular Customer Since 2018</small>
                    </div>
                </div>
            </div>
            
            <div class="testimonial-card">
                <div class="testimonial-rating">
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star-half-alt text-warning"></i>
                </div>
                <p class="testimonial-text">
                    "As a professional chef, I demand the best ingredients. Nuts & Berries 
                    consistently delivers premium quality that elevates my dishes."
                </p>
                <div class="testimonial-author">
                    <div class="author-avatar">
                        <img src="https://i.pravatar.cc/50?img=28" alt="Customer">
                    </div>
                    <div class="author-info">
                        <h6>Chef Rajesh Kumar</h6>
                        <small>Executive Chef, Taj Palace</small>
                    </div>
                </div>
            </div>
            
            <div class="testimonial-card">
                <div class="testimonial-rating">
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star text-warning"></i>
                    <i class="fas fa-star text-warning"></i>
                </div>
                <p class="testimonial-text">
                    "The customer service is outstanding, and the product quality is unmatched. 
                    Our go-to for all our dry fruit needs!"
                </p>
                <div class="testimonial-author">
                    <div class="author-avatar">
                        <img src="https://i.pravatar.cc/50?img=19" alt="Customer">
                    </div>
                    <div class="author-info">
                        <h6>John & Maria Rodriguez</h6>
                        <small>Family Customers Since 2015</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ==========================================================================
   Newsletter Section
   ========================================================================== -->

<section class="newsletter-section py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h2 class="text-white mb-3">Join Our Healthy Journey</h2>
                <p class="text-white mb-0">
                    Subscribe for exclusive offers, nutrition tips, and updates on our 
                    premium dry fruit collection!
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
<!-- ==========================================================================
   Custom Styles for About Page
   ========================================================================== -->

<style>
/* ==========================================================================
   Story Section Styles
   ========================================================================== */

.story-image {
    position: relative;
}

.story-badge {
    position: absolute;
    bottom: 20px;
    left: 20px;
    background: var(--gradient-gold);
    color: var(--primary-dark);
    padding: 8px 16px;
    border-radius: var(--radius-full);
    font-weight: 600;
    box-shadow: var(--shadow-md);
}

/* ==========================================================================
   Values Grid Styles
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
    box-shadow: var(--shadow-md);
    transition: var(--transition-normal);
    display: flex;
    align-items: flex-start;
    gap: var(--space-md);
}

.value-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
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

.value-content h5 {
    margin-bottom: var(--space-xs);
    color: var(--primary-color);
}

/* ==========================================================================
   Stats Grid Styles
   ========================================================================== */

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: var(--space-xl);
    text-align: center;
}

.stat-card {
    padding: var(--space-lg);
}

.stat-number {
    font-size: var(--text-4xl);
    font-weight: 800;
    color: var(--primary-color);
    margin-bottom: var(--space-xs);
}

.stat-title {
    font-size: var(--text-lg);
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: var(--space-xs);
}

.stat-desc {
    font-size: var(--text-sm);
}

/* ==========================================================================
   Team Grid Styles
   ========================================================================== */

.team-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: var(--space-lg);
}

.team-card {
    background: var(--surface-color);
    border-radius: var(--radius-lg);
    overflow: hidden;
    box-shadow: var(--shadow-md);
    transition: var(--transition-normal);
}

.team-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
}

.team-image {
    position: relative;
    height: 250px;
    overflow: hidden;
}

.team-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s ease;
}

.team-card:hover .team-image img {
    transform: scale(1.05);
}

.team-social {
    position: absolute;
    bottom: 15px;
    right: 15px;
    display: flex;
    gap: var(--space-xs);
    opacity: 0;
    transform: translateY(10px);
    transition: var(--transition-normal);
}

.team-card:hover .team-social {
    opacity: 1;
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

.team-info {
    padding: var(--space-md);
    text-align: center;
}

.team-info h5 {
    margin-bottom: 4px;
    color: var(--text-primary);
}

.team-role {
    color: var(--primary-color);
    font-weight: 600;
    margin-bottom: var(--space-xs);
}

.team-desc {
    font-size: var(--text-sm);
    line-height: 1.5;
}

/* ==========================================================================
   Newsletter Form Styles
   ========================================================================== */

.newsletter-form .form-control {
    padding: 12px 20px;
    border: 2px solid var(--border-color);
    border-radius: var(--radius-md);
    background: var(--surface-color);
    color: var(--text-primary);
    width: 100%;
    transition: var(--transition-normal);
}

.newsletter-form .form-control:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.1);
}

.form-text {
    font-size: var(--text-sm);
}

/* ==========================================================================
   Responsive Adjustments
   ========================================================================== */

@media (max-width: 768px) {
    .values-grid {
        grid-template-columns: 1fr;
    }
    
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: var(--space-md);
    }
    
    .stat-number {
        font-size: var(--text-3xl);
    }
    
    .team-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 576px) {
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .team-grid {
        grid-template-columns: 1fr;
    }
    
    .value-card {
        flex-direction: column;
        text-align: center;
    }
    
    .value-icon {
        margin: 0 auto;
    }
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

.story-content > *,
.feature-card,
.value-card,
.stat-card,
.team-card {
    animation: fadeInUp 0.6s ease-out;
}

.delay-1 { animation-delay: 0.2s; }
.delay-2 { animation-delay: 0.4s; }
.delay-3 { animation-delay: 0.6s; }
.delay-4 { animation-delay: 0.8s; }
</style>
@endpush

@push('scripts')
<!-- ==========================================================================
   Custom JavaScript for About Page
   ========================================================================== -->

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ==========================================================================
    // Intersection Observer for Animations
    // ==========================================================================
    
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '50px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animated');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Observe all elements with animation classes
    document.querySelectorAll('.story-content > *, .feature-card, .value-card, .stat-card, .team-card')
        .forEach(el => observer.observe(el));

    // ==========================================================================
    // Newsletter Form Submission
    // ==========================================================================
    
    const newsletterForm = document.querySelector('.newsletter-form');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const emailInput = this.querySelector('input[type="email"]');
            const email = emailInput.value;
            
            // Simple validation
            if (!email || !email.includes('@')) {
                showToast('Please enter a valid email address', 'error');
                return;
            }
            
            try {
                const response = await fetch('/api/newsletter/subscribe', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ email: email })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showToast('Successfully subscribed to our newsletter!', 'success');
                    emailInput.value = '';
                } else {
                    showToast(data.message || 'Subscription failed', 'error');
                }
            } catch (error) {
                console.error('Newsletter subscription error:', error);
                showToast('Network error. Please try again.', 'error');
            }
        });
    }

    // ==========================================================================
    // Team Card Hover Effect Enhancement
    // ==========================================================================
    
    document.querySelectorAll('.team-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.zIndex = '10';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.zIndex = '1';
        });
    });

    // ==========================================================================
    // Stat Counters Animation
    // ==========================================================================
    
    const statNumbers = document.querySelectorAll('.stat-number');
    const observerStats = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const statNumber = entry.target;
                const targetValue = parseInt(statNumber.textContent);
                if (!isNaN(targetValue)) {
                    animateCounter(statNumber, 0, targetValue, 2000);
                }
                observerStats.unobserve(statNumber);
            }
        });
    }, observerOptions);

    statNumbers.forEach(stat => observerStats.observe(stat));

    function animateCounter(element, start, end, duration) {
        let startTimestamp = null;
        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
            const currentValue = Math.floor(progress * (end - start) + start);
            element.textContent = currentValue + (element.textContent.includes('+') ? '+' : '');
            if (progress < 1) {
                window.requestAnimationFrame(step);
            }
        };
        window.requestAnimationFrame(step);
    }
});

// ==========================================================================
// Toast Notification Function
// ==========================================================================

function showToast(message, type = 'info', duration = 3000) {
    const container = document.getElementById('toastContainer');
    if (!container) return;
    
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.innerHTML = `
        <div class="toast-content">
            <i class="fas ${type === 'success' ? 'fa-check-circle' : 
                         type === 'error' ? 'fa-exclamation-circle' : 
                         type === 'warning' ? 'fa-exclamation-triangle' : 'fa-info-circle'}"></i>
            <span>${message}</span>
        </div>
        <button class="toast-close">
            <i class="fas fa-times"></i>
        </button>
    `;
    
    container.appendChild(toast);
    
    // Show toast
    setTimeout(() => {
        toast.classList.add('show');
    }, 10);
    
    // Auto remove after duration
    const autoRemove = setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => {
            toast.remove();
        }, 300);
    }, duration);
    
    // Close button
    toast.querySelector('.toast-close').addEventListener('click', () => {
        clearTimeout(autoRemove);
        toast.classList.remove('show');
        setTimeout(() => {
            toast.remove();
        }, 300);
    });
}
</script>
@endpush