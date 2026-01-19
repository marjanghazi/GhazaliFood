@extends('layouts.app')

@section('title', 'Login | Premium Dry Fruits Store | Ghazali Food')

@section('hero')
<!-- ==========================================================================
   Hero Section
   ========================================================================== -->
<section class="auth-hero">
    <div class="container">
        <div class="hero-wrapper">
            <div class="hero-content">
                <div class="hero-badge">
                    <i class="fas fa-shield-alt me-2"></i> Secure Login
                </div>
                <h1 class="hero-title">Welcome Back to Ghazali Food</h1>
                <p class="hero-subtitle">
                    Access your account to manage orders, track deliveries, and enjoy exclusive member benefits.
                </p>
                <div class="hero-features">
                    <div class="feature">
                        <i class="fas fa-shopping-bag"></i>
                        <span>Track Orders</span>
                    </div>
                    <div class="feature">
                        <i class="fas fa-heart"></i>
                        <span>Manage Wishlist</span>
                    </div>
                    <div class="feature">
                        <i class="fas fa-gift"></i>
                        <span>Exclusive Offers</span>
                    </div>
                </div>
            </div>
            <div class="hero-visual">
                <div class="floating-shapes">
                    <div class="shape shape-1"></div>
                    <div class="shape shape-2"></div>
                    <div class="shape shape-3"></div>
                </div>
                <div class="auth-illustration">
                    <img src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                         alt="Secure Login">
                    <div class="illustration-badge">
                        <i class="fas fa-lock me-2"></i> 256-bit SSL Encrypted
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('content')
<!-- ==========================================================================
   Login Section
   ========================================================================== -->
<section class="auth-section">
    <div class="container">
        <div class="auth-wrapper">
            <!-- Login Card -->
            <div class="auth-card">
                <div class="auth-card-header">
                    <div class="auth-icon">
                        <i class="fas fa-user-circle"></i>
                    </div>
                    <h2 class="auth-title">Sign In to Your Account</h2>
                    <p class="auth-subtitle">Enter your credentials to continue</p>
                </div>
                
                <!-- Social Login Options -->
                <div class="social-login">
                    <p class="social-login-label">Quick access with</p>
                    <div class="social-buttons">
                        <button type="button" class="social-btn google">
                            <i class="fab fa-google"></i>
                            <span>Google</span>
                        </button>
                        <button type="button" class="social-btn facebook">
                            <i class="fab fa-facebook-f"></i>
                            <span>Facebook</span>
                        </button>
                        <button type="button" class="social-btn apple">
                            <i class="fab fa-apple"></i>
                            <span>Apple</span>
                        </button>
                    </div>
                    <div class="divider">
                        <span>or continue with email</span>
                    </div>
                </div>
                
                <!-- Error Messages -->
                @if($errors->any())
                <div class="alert alert-danger animate__animated animate__shakeX">
                    <div class="alert-icon">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                    <div class="alert-content">
                        @foreach($errors->all() as $error)
                            <p class="mb-1">{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
                @endif
                
                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}" class="auth-form" id="loginForm">
                    @csrf
                    
                    <!-- Email Field -->
                    <div class="form-group">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope me-2"></i>Email Address
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-at"></i>
                            </span>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   placeholder="you@example.com"
                                   required 
                                   autofocus
                                   autocomplete="email">
                        </div>
                        @error('email')
                        <div class="invalid-feedback d-block">
                            <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                        </div>
                        @enderror
                    </div>
                    
                    <!-- Password Field -->
                    <div class="form-group">
                        <label for="password" class="form-label">
                            <i class="fas fa-key me-2"></i>Password
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </span>
                            <input type="password" 
                                   class="form-control password-input @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password" 
                                   placeholder="Enter your password"
                                   required
                                   autocomplete="current-password">
                            <button type="button" class="input-group-text toggle-password" data-target="#password">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                        <div class="invalid-feedback d-block">
                            <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                        </div>
                        @enderror
                    </div>
                    
                    <!-- Form Options -->
                    <div class="form-options">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember" name="remember">
                            <label class="form-check-label" for="remember">
                                Remember this device
                            </label>
                        </div>
                        <a href="{{ route('password.request') }}" class="forgot-password">
                            <i class="fas fa-question-circle me-1"></i> Forgot Password?
                        </a>
                    </div>
                    
                    <!-- Password Strength Meter (if new user registration) -->
                    <div class="password-strength d-none">
                        <div class="strength-meter">
                            <div class="strength-bar"></div>
                        </div>
                        <div class="strength-text">Password strength: <span class="strength-value">Weak</span></div>
                    </div>
                    
                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary btn-lg w-100 auth-submit" id="submitBtn">
                        <span class="btn-content">
                            <i class="fas fa-sign-in-alt me-2"></i> Sign In
                        </span>
                        <span class="btn-loader d-none">
                            <i class="fas fa-spinner fa-spin me-2"></i> Authenticating...
                        </span>
                    </button>
                    
                    <!-- Security Info -->
                    <div class="security-info">
                        <i class="fas fa-shield-alt me-2"></i>
                        <small>Your information is protected with 256-bit SSL encryption</small>
                    </div>
                </form>
                
                <!-- Additional Links -->
                <div class="auth-links">
                    <p class="text-center mb-3">
                        Don't have an account? 
                        <a href="{{ route('register') }}" class="link-primary">
                            <i class="fas fa-user-plus me-1"></i> Create Account
                        </a>
                    </p>
                    <p class="text-center mb-0">
                        <a href="{{ route('shop.index') }}" class="link-secondary">
                            <i class="fas fa-shopping-bag me-1"></i> Continue Shopping
                        </a>
                    </p>
                </div>
            </div>
            
            <!-- Benefits Sidebar -->
            <div class="auth-benefits">
                <div class="benefits-card">
                    <h3 class="benefits-title">
                        <i class="fas fa-crown me-2"></i> Member Benefits
                    </h3>
                    
                    <div class="benefits-list">
                        <div class="benefit-item">
                            <div class="benefit-icon">
                                <i class="fas fa-truck"></i>
                            </div>
                            <div class="benefit-content">
                                <h6>Free Shipping</h6>
                                <p>On orders over $50</p>
                            </div>
                        </div>
                        
                        <div class="benefit-item">
                            <div class="benefit-icon">
                                <i class="fas fa-percentage"></i>
                            </div>
                            <div class="benefit-content">
                                <h6>Exclusive Discounts</h6>
                                <p>Members-only offers</p>
                            </div>
                        </div>
                        
                        <div class="benefit-item">
                            <div class="benefit-icon">
                                <i class="fas fa-history"></i>
                            </div>
                            <div class="benefit-content">
                                <h6>Order Tracking</h6>
                                <p>Real-time updates</p>
                            </div>
                        </div>
                        
                        <div class="benefit-item">
                            <div class="benefit-icon">
                                <i class="fas fa-heart"></i>
                            </div>
                            <div class="benefit-content">
                                <h6>Wishlist</h6>
                                <p>Save favorite items</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="benefits-footer">
                        <p class="mb-2">
                            <i class="fas fa-star text-warning me-1"></i>
                            <strong>Pro Tip:</strong> Enable notifications to get exclusive offers
                        </p>
                        <div class="trust-badges">
                            <div class="trust-badge">
                                <i class="fas fa-shield-check"></i>
                                <span>SSL Secure</span>
                            </div>
                            <div class="trust-badge">
                                <i class="fas fa-lock"></i>
                                <span>GDPR Compliant</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
/* ==========================================================================
   Auth Hero Section
   ========================================================================== */
.auth-hero {
    background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-color) 100%);
    padding: var(--space-2xl) 0;
    position: relative;
    overflow: hidden;
}

.auth-hero::before {
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

.hero-features {
    display: flex;
    gap: var(--space-lg);
    flex-wrap: wrap;
}

.feature {
    display: flex;
    align-items: center;
    gap: var(--space-sm);
    color: white;
    font-weight: 500;
}

.feature i {
    color: var(--accent-color);
    font-size: var(--text-lg);
}

.hero-visual {
    position: relative;
}

.floating-shapes {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
}

.shape {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.1);
    animation: float 6s ease-in-out infinite;
}

.shape-1 {
    width: 60px;
    height: 60px;
    top: 10%;
    left: 10%;
    animation-delay: 0s;
}

.shape-2 {
    width: 40px;
    height: 40px;
    bottom: 20%;
    right: 15%;
    animation-delay: 2s;
}

.shape-3 {
    width: 30px;
    height: 30px;
    top: 50%;
    left: 20%;
    animation-delay: 4s;
}

@keyframes float {
    0%, 100% { transform: translateY(0) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(180deg); }
}

.auth-illustration {
    border-radius: var(--radius-xl);
    overflow: hidden;
    box-shadow: var(--shadow-xl);
    position: relative;
}

.auth-illustration img {
    width: 100%;
    height: auto;
    transition: transform 0.6s ease;
}

.auth-illustration:hover img {
    transform: scale(1.05);
}

.illustration-badge {
    position: absolute;
    bottom: 20px;
    right: 20px;
    background: rgba(0, 0, 0, 0.8);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    color: white;
    padding: 8px 16px;
    border-radius: var(--radius-full);
    font-weight: 600;
    font-size: var(--text-sm);
}

/* ==========================================================================
   Auth Section
   ========================================================================== */
.auth-section {
    padding: var(--space-2xl) 0;
    background: var(--surface-color);
}

.auth-wrapper {
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: var(--space-xl);
    max-width: 1200px;
    margin: 0 auto;
}

/* ==========================================================================
   Auth Card
   ========================================================================== */
.auth-card {
    background: var(--background-color);
    border-radius: var(--radius-xl);
    padding: var(--space-xl);
    box-shadow: var(--shadow-xl);
    border: 1px solid var(--border-color);
}

.auth-card-header {
    text-align: center;
    margin-bottom: var(--space-xl);
}

.auth-icon {
    width: 80px;
    height: 80px;
    background: var(--gradient-primary);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto var(--space-md);
    color: white;
    font-size: 2rem;
}

.auth-title {
    color: var(--text-primary);
    margin-bottom: var(--space-xs);
}

.auth-subtitle {
    color: var(--text-secondary);
    font-size: var(--text-base);
}

/* ==========================================================================
   Social Login
   ========================================================================== */
.social-login {
    margin-bottom: var(--space-xl);
}

.social-login-label {
    text-align: center;
    color: var(--text-muted);
    margin-bottom: var(--space-md);
    font-size: var(--text-sm);
}

.social-buttons {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: var(--space-sm);
    margin-bottom: var(--space-lg);
}

.social-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: var(--space-sm);
    padding: 12px;
    border: 1px solid var(--border-color);
    border-radius: var(--radius-md);
    background: var(--surface-color);
    color: var(--text-primary);
    font-weight: 500;
    transition: all 0.3s ease;
    cursor: pointer;
}

.social-btn:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
}

.social-btn.google:hover {
    background: #DB4437;
    color: white;
    border-color: #DB4437;
}

.social-btn.facebook:hover {
    background: #4267B2;
    color: white;
    border-color: #4267B2;
}

.social-btn.apple:hover {
    background: #000;
    color: white;
    border-color: #000;
}

.divider {
    display: flex;
    align-items: center;
    text-align: center;
    color: var(--text-muted);
    font-size: var(--text-sm);
}

.divider::before,
.divider::after {
    content: '';
    flex: 1;
    border-bottom: 1px solid var(--border-color);
}

.divider span {
    padding: 0 var(--space-md);
}

/* ==========================================================================
   Alert Styling
   ========================================================================== */
.alert {
    display: flex;
    align-items: flex-start;
    gap: var(--space-sm);
    padding: var(--space-md);
    border-radius: var(--radius-md);
    margin-bottom: var(--space-lg);
    border: 1px solid transparent;
}

.alert-danger {
    background: rgba(231, 76, 60, 0.1);
    border-color: rgba(231, 76, 60, 0.2);
    color: #e74c3c;
}

.alert-icon {
    font-size: 1.25rem;
    flex-shrink: 0;
}

.alert-content p:last-child {
    margin-bottom: 0;
}

/* ==========================================================================
   Form Styling
   ========================================================================== */
.form-group {
    margin-bottom: var(--space-lg);
}

.form-label {
    display: flex;
    align-items: center;
    color: var(--text-primary);
    font-weight: 500;
    margin-bottom: var(--space-sm);
}

.form-label i {
    color: var(--primary-color);
    width: 20px;
}

.input-group {
    border-radius: var(--radius-md);
    overflow: hidden;
    border: 1px solid var(--border-color);
    transition: var(--transition-normal);
}

.input-group:focus-within {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(17, 80, 40, 0.1);
}

.input-group-text {
    background: var(--surface-color);
    border: none;
    color: var(--text-muted);
    padding: 12px 16px;
}

.form-control {
    border: none;
    padding: 12px 16px;
    background: transparent;
    color: var(--text-primary);
    transition: none;
}

.form-control:focus {
    box-shadow: none;
    background: transparent;
}

.password-input {
    padding-right: 50px;
}

.toggle-password {
    background: transparent;
    border: none;
    cursor: pointer;
    color: var(--text-muted);
    transition: var(--transition-fast);
}

.toggle-password:hover {
    color: var(--primary-color);
}

.invalid-feedback {
    display: flex;
    align-items: center;
    margin-top: var(--space-xs);
    font-size: var(--text-sm);
}

/* ==========================================================================
   Form Options
   ========================================================================== */
.form-options {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: var(--space-xl);
}

.form-check {
    display: flex;
    align-items: center;
    gap: var(--space-xs);
}

.form-check-input {
    width: 18px;
    height: 18px;
    margin-top: 0;
    cursor: pointer;
}

.form-check-input:checked {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}

.form-check-label {
    color: var(--text-secondary);
    cursor: pointer;
    user-select: none;
}

.forgot-password {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 500;
    font-size: var(--text-sm);
    transition: var(--transition-fast);
}

.forgot-password:hover {
    color: var(--primary-dark);
    text-decoration: underline;
}

/* ==========================================================================
   Password Strength Meter
   ========================================================================== */
.password-strength {
    margin-bottom: var(--space-lg);
}

.strength-meter {
    height: 6px;
    background: var(--border-color);
    border-radius: var(--radius-full);
    overflow: hidden;
    margin-bottom: var(--space-xs);
}

.strength-bar {
    height: 100%;
    width: 0%;
    background: var(--danger-color);
    border-radius: var(--radius-full);
    transition: width 0.3s ease, background 0.3s ease;
}

.strength-text {
    font-size: var(--text-sm);
    color: var(--text-muted);
}

.strength-value {
    font-weight: 600;
}

/* ==========================================================================
   Submit Button
   ========================================================================== */
.auth-submit {
    position: relative;
    overflow: hidden;
    margin-bottom: var(--space-lg);
}

.auth-submit .btn-content,
.auth-submit .btn-loader {
    transition: opacity 0.3s ease;
}

.auth-submit.loading .btn-content {
    opacity: 0;
}

.auth-submit.loading .btn-loader {
    opacity: 1;
}

.btn-loader {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
}

/* ==========================================================================
   Security Info
   ========================================================================== */
.security-info {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: var(--space-xs);
    color: var(--text-muted);
    font-size: var(--text-sm);
    margin-bottom: var(--space-xl);
    padding: var(--space-sm);
    background: var(--surface-color);
    border-radius: var(--radius-md);
}

.security-info i {
    color: var(--success-color);
}

/* ==========================================================================
   Auth Links
   ========================================================================== */
.auth-links {
    border-top: 1px solid var(--border-color);
    padding-top: var(--space-xl);
}

.link-primary,
.link-secondary {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 600;
    transition: var(--transition-fast);
}

.link-primary:hover,
.link-secondary:hover {
    color: var(--primary-dark);
    text-decoration: underline;
}

/* ==========================================================================
   Benefits Sidebar
   ========================================================================== */
.auth-benefits {
    position: sticky;
    top: calc(var(--header-height) + var(--space-lg));
}

.benefits-card {
    background: var(--background-color);
    border-radius: var(--radius-xl);
    padding: var(--space-xl);
    box-shadow: var(--shadow-xl);
    border: 1px solid var(--border-color);
}

.benefits-title {
    color: var(--primary-color);
    margin-bottom: var(--space-xl);
    display: flex;
    align-items: center;
}

.benefits-title i {
    color: var(--accent-color);
}

.benefits-list {
    display: flex;
    flex-direction: column;
    gap: var(--space-lg);
    margin-bottom: var(--space-xl);
}

.benefit-item {
    display: flex;
    align-items: center;
    gap: var(--space-md);
    padding: var(--space-md);
    background: var(--surface-color);
    border-radius: var(--radius-lg);
    border: 1px solid var(--border-color);
    transition: var(--transition-normal);
}

.benefit-item:hover {
    transform: translateX(5px);
    border-color: var(--primary-color);
}

.benefit-icon {
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

.benefit-content h6 {
    color: var(--text-primary);
    margin-bottom: 4px;
}

.benefit-content p {
    color: var(--text-muted);
    font-size: var(--text-sm);
    margin: 0;
}

.benefits-footer {
    padding-top: var(--space-lg);
    border-top: 1px solid var(--border-color);
}

.benefits-footer p {
    color: var(--text-secondary);
    margin-bottom: var(--space-lg);
}

.trust-badges {
    display: flex;
    gap: var(--space-md);
    flex-wrap: wrap;
}

.trust-badge {
    display: flex;
    align-items: center;
    gap: var(--space-xs);
    padding: 8px 12px;
    background: var(--surface-color);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-md);
    color: var(--text-muted);
    font-size: var(--text-sm);
}

.trust-badge i {
    color: var(--success-color);
}

/* ==========================================================================
   Responsive Design
   ========================================================================== */
@media (max-width: 1200px) {
    .auth-wrapper {
        grid-template-columns: 1fr;
        max-width: 600px;
    }
    
    .auth-benefits {
        position: static;
        margin-top: var(--space-xl);
    }
}

@media (max-width: 768px) {
    .hero-wrapper {
        grid-template-columns: 1fr;
        text-align: center;
    }
    
    .hero-content .hero-title {
        font-size: var(--text-3xl);
    }
    
    .hero-content .hero-subtitle {
        font-size: var(--text-base);
    }
    
    .hero-features {
        justify-content: center;
    }
    
    .auth-card {
        padding: var(--space-lg);
    }
    
    .social-buttons {
        grid-template-columns: 1fr;
    }
    
    .form-options {
        flex-direction: column;
        align-items: flex-start;
        gap: var(--space-md);
    }
}

@media (max-width: 576px) {
    .hero-content .hero-title {
        font-size: var(--text-2xl);
    }
    
    .hero-content .hero-subtitle {
        font-size: var(--text-sm);
    }
    
    .auth-card {
        padding: var(--space-md);
    }
    
    .benefits-card {
        padding: var(--space-lg);
    }
    
    .trust-badges {
        flex-direction: column;
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

.animate-in {
    animation: fadeInUp 0.6s ease-out;
}

.delay-1 { animation-delay: 0.2s; }
.delay-2 { animation-delay: 0.4s; }
.delay-3 { animation-delay: 0.6s; }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ==========================================================================
    // Password Visibility Toggle
    // ==========================================================================
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const passwordInput = document.querySelector(targetId);
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });

    // ==========================================================================
    // Form Validation & Submission
    // ==========================================================================
    const loginForm = document.getElementById('loginForm');
    const submitBtn = document.getElementById('submitBtn');
    
    if (loginForm) {
        loginForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            // Validate form
            if (!validateForm()) {
                return;
            }
            
            // Show loading state
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
            
            try {
                // Simulate network delay
                await new Promise(resolve => setTimeout(resolve, 1500));
                
                // Submit form
                this.submit();
            } catch (error) {
                console.error('Login error:', error);
                showToast('An error occurred. Please try again.', 'error');
                submitBtn.classList.remove('loading');
                submitBtn.disabled = false;
            }
        });
        
        // Real-time validation
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        
        emailInput.addEventListener('blur', validateEmail);
        passwordInput.addEventListener('input', validatePassword);
    }
    
    function validateForm() {
        let isValid = true;
        
        // Validate email
        if (!validateEmail()) {
            isValid = false;
        }
        
        // Validate password
        if (!validatePassword()) {
            isValid = false;
        }
        
        return isValid;
    }
    
    function validateEmail() {
        const email = document.getElementById('email');
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        if (!email.value.trim()) {
            setFieldError(email, 'Email is required');
            return false;
        }
        
        if (!emailRegex.test(email.value)) {
            setFieldError(email, 'Please enter a valid email address');
            return false;
        }
        
        clearFieldError(email);
        return true;
    }
    
    function validatePassword() {
        const password = document.getElementById('password');
        
        if (!password.value.trim()) {
            setFieldError(password, 'Password is required');
            return false;
        }
        
        if (password.value.length < 6) {
            setFieldError(password, 'Password must be at least 6 characters');
            return false;
        }
        
        clearFieldError(password);
        return true;
    }
    
    function setFieldError(input, message) {
        const formGroup = input.closest('.form-group');
        let errorDiv = formGroup.querySelector('.invalid-feedback');
        
        if (!errorDiv) {
            errorDiv = document.createElement('div');
            errorDiv.className = 'invalid-feedback d-block';
            formGroup.appendChild(errorDiv);
        }
        
        errorDiv.innerHTML = `<i class="fas fa-exclamation-circle me-1"></i> ${message}`;
        input.classList.add('is-invalid');
    }
    
    function clearFieldError(input) {
        const formGroup = input.closest('.form-group');
        const errorDiv = formGroup.querySelector('.invalid-feedback');
        
        if (errorDiv) {
            errorDiv.remove();
        }
        
        input.classList.remove('is-invalid');
    }

    // ==========================================================================
    // Social Login Buttons
    // ==========================================================================
    document.querySelectorAll('.social-btn').forEach(button => {
        button.addEventListener('click', function() {
            const platform = this.classList.contains('google') ? 'Google' :
                           this.classList.contains('facebook') ? 'Facebook' : 'Apple';
            
            showToast(`Connecting with ${platform}...`, 'info');
            
            // In a real app, this would trigger OAuth flow
            // For now, simulate loading
            this.disabled = true;
            const originalText = this.innerHTML;
            this.innerHTML = `<i class="fas fa-spinner fa-spin"></i> Connecting...`;
            
            setTimeout(() => {
                this.innerHTML = originalText;
                this.disabled = false;
                showToast(`${platform} login is coming soon!`, 'info');
            }, 1500);
        });
    });

    // ==========================================================================
    // Password Strength Meter (for registration)
    // ==========================================================================
    const passwordInput = document.getElementById('password');
    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            const strengthBar = document.querySelector('.strength-bar');
            const strengthValue = document.querySelector('.strength-value');
            
            if (this.value.length === 0) {
                strengthBar.style.width = '0%';
                strengthBar.style.background = 'var(--danger-color)';
                strengthValue.textContent = 'None';
                return;
            }
            
            let strength = 0;
            
            // Length check
            if (this.value.length >= 8) strength += 25;
            
            // Lowercase check
            if (/[a-z]/.test(this.value)) strength += 25;
            
            // Uppercase check
            if (/[A-Z]/.test(this.value)) strength += 25;
            
            // Number or special character check
            if (/[0-9]/.test(this.value) || /[^A-Za-z0-9]/.test(this.value)) strength += 25;
            
            // Update UI
            strengthBar.style.width = strength + '%';
            
            if (strength <= 25) {
                strengthBar.style.background = 'var(--danger-color)';
                strengthValue.textContent = 'Weak';
            } else if (strength <= 50) {
                strengthBar.style.background = 'var(--warning-color)';
                strengthValue.textContent = 'Fair';
            } else if (strength <= 75) {
                strengthBar.style.background = 'var(--accent-color)';
                strengthValue.textContent = 'Good';
            } else {
                strengthBar.style.background = 'var(--success-color)';
                strengthValue.textContent = 'Strong';
            }
        });
    }

    // ==========================================================================
    // Auto-focus enhancement
    // ==========================================================================
    const emailField = document.getElementById('email');
    if (emailField && !emailField.value) {
        emailField.focus();
        
        // Add subtle animation to draw attention
        setTimeout(() => {
            emailField.style.transform = 'scale(1.02)';
            setTimeout(() => {
                emailField.style.transform = 'scale(1)';
            }, 200);
        }, 500);
    }

    // ==========================================================================
    // Remember me cookie check
    // ==========================================================================
    const rememberCheckbox = document.getElementById('remember');
    const savedEmail = localStorage.getItem('rememberedEmail');
    
    if (savedEmail && emailField) {
        emailField.value = savedEmail;
        rememberCheckbox.checked = true;
    }
    
    rememberCheckbox.addEventListener('change', function() {
        if (this.checked && emailField.value) {
            localStorage.setItem('rememberedEmail', emailField.value);
        } else {
            localStorage.removeItem('rememberedEmail');
        }
    });

    // ==========================================================================
    // Keyboard shortcuts
    // ==========================================================================
    document.addEventListener('keydown', function(e) {
        // Ctrl + Enter to submit form
        if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
            const submitBtn = document.querySelector('.auth-submit');
            if (submitBtn) {
                submitBtn.click();
            }
        }
        
        // Escape to clear form
        if (e.key === 'Escape') {
            const emailField = document.getElementById('email');
            const passwordField = document.getElementById('password');
            
            if (emailField) emailField.value = '';
            if (passwordField) passwordField.value = '';
            
            showToast('Form cleared', 'info');
        }
    });

    // ==========================================================================
    // Session timeout warning (demo)
    // ==========================================================================
    let idleTimer;
    function resetIdleTimer() {
        clearTimeout(idleTimer);
        idleTimer = setTimeout(() => {
            showToast('Session will expire soon due to inactivity', 'warning');
        }, 5 * 60 * 1000); // 5 minutes
    }
    
    ['mousemove', 'keypress', 'click', 'scroll'].forEach(event => {
        document.addEventListener(event, resetIdleTimer);
    });
    
    resetIdleTimer();

    // ==========================================================================
    // Accessibility improvements
    // ==========================================================================
    document.querySelectorAll('input').forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.style.boxShadow = '0 0 0 3px rgba(17, 80, 40, 0.2)';
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.style.boxShadow = '';
        });
    });
});

// ==========================================================================
// Toast Notification Helper
// ==========================================================================
function showToast(message, type = 'info', duration = 3000) {
    // Use existing toast function if available
    if (typeof window.showToast === 'function') {
        window.showToast(message, type);
        return;
    }
    
    // Fallback implementation
    const container = document.getElementById('toastContainer') || createToastContainer();
    const toast = document.createElement('div');
    
    const typeConfig = {
        success: { icon: 'check-circle', color: '#27ae60' },
        error: { icon: 'exclamation-circle', color: '#e74c3c' },
        warning: { icon: 'exclamation-triangle', color: '#f39c12' },
        info: { icon: 'info-circle', color: '#3498db' }
    };
    
    const config = typeConfig[type] || typeConfig.info;
    
    toast.className = `toast toast-${type} animate__animated animate__fadeInRight`;
    toast.innerHTML = `
        <div class="toast-content">
            <div class="toast-icon">
                <i class="fas fa-${config.icon}"></i>
            </div>
            <div class="toast-body">
                <span class="toast-message">${message}</span>
            </div>
        </div>
        <button class="toast-close">
            <i class="fas fa-times"></i>
        </button>
    `;
    
    toast.style.cssText = `
        background: ${config.color};
        color: white;
        border-radius: var(--radius-md);
        margin-bottom: 10px;
        min-width: 300px;
    `;
    
    container.appendChild(toast);
    
    // Auto remove
    const autoRemove = setTimeout(() => {
        toast.remove();
    }, duration);
    
    // Close button
    toast.querySelector('.toast-close').addEventListener('click', () => {
        clearTimeout(autoRemove);
        toast.remove();
    });
}

function createToastContainer() {
    const container = document.createElement('div');
    container.id = 'toastContainer';
    container.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        display: flex;
        flex-direction: column;
        gap: 10px;
    `;
    document.body.appendChild(container);
    return container;
}
</script>
@endpush