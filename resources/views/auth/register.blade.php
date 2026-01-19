@extends('layouts.app')

@section('title', 'Register | Premium Dry Fruits Store | Ghazali Food')

@section('hero')
<!-- Hero Section -->
<section class="register-hero">
    <div class="container">
        <div class="hero-wrapper">
            <div class="hero-content">
                <h1 class="hero-title">Join Ghazali Food</h1>
                <p class="hero-subtitle">
                    Create your account and discover premium dry fruits, exclusive offers,
                    and personalized shopping experience.
                </p>
                <div class="hero-badge">
                    <i class="fas fa-gift me-2"></i> Get 15% off your first order
                </div>
            </div>
            <div class="hero-visual">
                <img src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                    alt="Join Our Community">
            </div>
        </div>
    </div>
</section>
@endsection

@section('content')
<!-- Registration Section -->
<section class="register-section">
    <div class="container">
        <div class="register-wrapper">
            <!-- Registration Card -->
            <div class="register-card">
                <div class="register-header">
                    <h2 class="register-title">Create Account</h2>
                    <p class="register-subtitle">Fill in your details to get started</p>
                </div>

                <!-- Error Messages -->
                @if($errors->any())
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <div>
                        @foreach($errors->all() as $error)
                        <p class="mb-1">{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Registration Form -->
                <form method="POST" action="{{ route('register') }}" class="register-form" id="registerForm">
                    @csrf

                    <!-- Full Name -->
                    <div class="form-group">
                        <label for="name" class="form-label">
                            <i class="fas fa-user me-2"></i> Full Name
                        </label>
                        <input type="text"
                            class="form-control @error('name') is-invalid @enderror"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Enter your full name"
                            required
                            autofocus>
                        @error('name')
                        <div class="invalid-feedback">
                            <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope me-2"></i> Email Address
                        </label>
                        <input type="email"
                            class="form-control @error('email') is-invalid @enderror"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="you@example.com"
                            required>
                        @error('email')
                        <div class="invalid-feedback">
                            <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div class="form-group">
                        <label for="phone" class="form-label">
                            <i class="fas fa-phone me-2"></i> Phone Number <span class="optional">(Optional)</span>
                        </label>
                        <input type="tel"
                            class="form-control @error('phone') is-invalid @enderror"
                            id="phone"
                            name="phone"
                            value="{{ old('phone') }}"
                            placeholder="+1 (555) 123-4567">
                        @error('phone')
                        <div class="invalid-feedback">
                            <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock me-2"></i> Password
                        </label>
                        <div class="password-input-wrapper">
                            <input type="password"
                                class="form-control @error('password') is-invalid @enderror"
                                id="password"
                                name="password"
                                placeholder="Create a password"
                                required>
                            <button type="button" class="password-toggle" data-target="#password">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                        <div class="invalid-feedback">
                            <i class="fas fa-exclamation-circle me-1"></i> {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">
                            <i class="fas fa-lock me-2"></i> Confirm Password
                        </label>
                        <div class="password-input-wrapper">
                            <input type="password"
                                class="form-control"
                                id="password_confirmation"
                                name="password_confirmation"
                                placeholder="Confirm your password"
                                required>
                            <button type="button" class="password-toggle" data-target="#password_confirmation">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="password-match">
                            <i class="fas fa-times-circle"></i>
                            <span>Passwords don't match</span>
                        </div>
                    </div>

                    <!-- Terms Agreement -->
                    <!-- Terms Agreement -->
                    <div class="terms-agreement">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="agree_terms" name="agree_terms" required value="1">
                            <label class="form-check-label" for="agree_terms">
                                I agree to the <a href="{{ route('policies.terms') }}" class="link-primary" target="_blank">Terms of Service</a>
                                and <a href="{{ route('policies.privacy') }}" class="link-primary" target="_blank">Privacy Policy</a>
                            </label>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary btn-lg w-100 register-submit">
                        <i class="fas fa-user-plus me-2"></i> Create Account
                    </button>

                    <!-- Security Note -->
                    <div class="security-note">
                        <i class="fas fa-shield-alt me-2"></i>
                        <small>Your information is protected with SSL encryption</small>
                    </div>
                </form>

                <!-- Already have account -->
                <div class="have-account">
                    <p class="text-center">
                        Already have an account?
                        <a href="{{ route('login') }}" class="link-primary">
                            <i class="fas fa-sign-in-alt me-1"></i> Sign In
                        </a>
                    </p>
                </div>
            </div>

            <!-- Benefits Sidebar -->
            <div class="register-benefits">
                <h3 class="benefits-title">
                    <i class="fas fa-crown me-2"></i> Member Benefits
                </h3>

                <div class="benefits-list">
                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-percentage"></i>
                        </div>
                        <div class="benefit-content">
                            <h5>15% First Order Discount</h5>
                            <p>Use code: WELCOME15</p>
                        </div>
                    </div>

                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-truck"></i>
                        </div>
                        <div class="benefit-content">
                            <h5>Free Shipping</h5>
                            <p>On orders over $50</p>
                        </div>
                    </div>

                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-heart"></i>
                        </div>
                        <div class="benefit-content">
                            <h5>Save Favorites</h5>
                            <p>Create your wishlist</p>
                        </div>
                    </div>

                    <div class="benefit-item">
                        <div class="benefit-icon">
                            <i class="fas fa-history"></i>
                        </div>
                        <div class="benefit-content">
                            <h5>Order Tracking</h5>
                            <p>Real-time updates</p>
                        </div>
                    </div>
                </div>

                <div class="benefits-footer">
                    <div class="trust-badges">
                        <div class="trust-badge">
                            <i class="fas fa-shield-check"></i>
                            <span>Secure Payment</span>
                        </div>
                        <div class="trust-badge">
                            <i class="fas fa-lock"></i>
                            <span>Privacy Protected</span>
                        </div>
                        <div class="trust-badge">
                            <i class="fas fa-heart"></i>
                            <span>Family Owned</span>
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
   Register Hero
   ========================================================================== */
    .register-hero {
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-color) 100%);
        padding: var(--space-xl) 0;
        position: relative;
        overflow: hidden;
    }

    .register-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: radial-gradient(circle at 20% 50%, rgba(212, 175, 55, 0.1) 0%, transparent 50%);
    }

    .hero-wrapper {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: var(--space-xl);
        align-items: center;
        position: relative;
        z-index: 2;
    }

    .hero-content .hero-title {
        color: white;
        font-size: var(--text-3xl);
        margin-bottom: var(--space-md);
        line-height: 1.2;
    }

    .hero-content .hero-subtitle {
        color: rgba(255, 255, 255, 0.9);
        font-size: var(--text-lg);
        margin-bottom: var(--space-lg);
        line-height: 1.6;
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        background: var(--gradient-gold);
        color: var(--text-primary);
        padding: 8px 16px;
        border-radius: var(--radius-full);
        font-weight: 600;
        font-size: var(--text-sm);
    }

    .hero-visual {
        border-radius: var(--radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-xl);
    }

    .hero-visual img {
        width: 100%;
        height: auto;
        display: block;
    }

    /* ==========================================================================
   Register Section
   ========================================================================== */
    .register-section {
        padding: var(--space-xl) 0;
        background: var(--surface-color);
    }

    .register-wrapper {
        display: grid;
        grid-template-columns: 1fr 400px;
        gap: var(--space-xl);
        max-width: 1200px;
        margin: 0 auto;
    }

    /* ==========================================================================
   Register Card
   ========================================================================== */
    .register-card {
        background: var(--background-color);
        border-radius: var(--radius-lg);
        padding: var(--space-xl);
        box-shadow: var(--shadow-lg);
        border: 1px solid var(--border-color);
    }

    .register-header {
        text-align: center;
        margin-bottom: var(--space-xl);
    }

    .register-title {
        color: var(--text-primary);
        font-size: var(--text-2xl);
        margin-bottom: var(--space-xs);
    }

    .register-subtitle {
        color: var(--text-secondary);
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
    }

    .alert-error {
        background: rgba(231, 76, 60, 0.1);
        border: 1px solid rgba(231, 76, 60, 0.2);
        color: #e74c3c;
    }

    .alert i {
        margin-top: 2px;
        flex-shrink: 0;
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

    .optional {
        color: var(--text-muted);
        font-weight: normal;
        font-size: var(--text-sm);
        margin-left: var(--space-xs);
    }

    .form-control {
        padding: 12px 16px;
        border: 2px solid var(--border-color);
        border-radius: var(--radius-md);
        background: var(--surface-color);
        color: var(--text-primary);
        width: 100%;
        transition: var(--transition-normal);
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(17, 80, 40, 0.1);
    }

    .form-control.is-invalid {
        border-color: var(--danger-color);
    }

    .invalid-feedback {
        display: flex;
        align-items: center;
        margin-top: var(--space-xs);
        color: var(--danger-color);
        font-size: var(--text-sm);
    }

    .invalid-feedback i {
        font-size: var(--text-xs);
    }

    /* ==========================================================================
   Password Input
   ========================================================================== */
    .password-input-wrapper {
        position: relative;
    }

    .password-toggle {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: var(--text-muted);
        cursor: pointer;
        padding: 4px;
        font-size: var(--text-lg);
        transition: var(--transition-fast);
    }

    .password-toggle:hover {
        color: var(--primary-color);
    }

    .password-match {
        display: flex;
        align-items: center;
        gap: var(--space-xs);
        margin-top: var(--space-xs);
        color: var(--danger-color);
        font-size: var(--text-sm);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .password-match.visible {
        opacity: 1;
    }

    .password-match.valid {
        color: var(--success-color);
    }

    .password-match.valid i {
        content: 'fa-check-circle';
    }

    /* ==========================================================================
   Terms Agreement
   ========================================================================== */
    .terms-agreement {
        margin: var(--space-xl) 0;
        padding: var(--space-md);
        background: var(--surface-color);
        border-radius: var(--radius-md);
        border: 1px solid var(--border-color);
    }

    .form-check {
        display: flex;
        align-items: flex-start;
        gap: var(--space-sm);
    }

    .form-check-input {
        margin-top: 4px;
        width: 18px;
        height: 18px;
        cursor: pointer;
    }

    .form-check-input:checked {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .form-check-label {
        color: var(--text-secondary);
        line-height: 1.5;
        cursor: pointer;
    }

    .link-primary {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 500;
    }

    .link-primary:hover {
        text-decoration: underline;
    }

    /* ==========================================================================
   Submit Button
   ========================================================================== */
    .register-submit {
        padding: 14px;
        font-size: var(--text-lg);
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .register-submit:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    /* ==========================================================================
   Security Note
   ========================================================================== */
    .security-note {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: var(--space-xs);
        color: var(--text-muted);
        font-size: var(--text-sm);
        margin-top: var(--space-lg);
        padding-top: var(--space-md);
        border-top: 1px solid var(--border-color);
    }

    .security-note i {
        color: var(--success-color);
    }

    /* ==========================================================================
   Have Account
   ========================================================================== */
    .have-account {
        margin-top: var(--space-xl);
        padding-top: var(--space-lg);
        border-top: 1px solid var(--border-color);
    }

    .have-account p {
        color: var(--text-secondary);
        margin: 0;
    }

    /* ==========================================================================
   Benefits Sidebar
   ========================================================================== */
    .register-benefits {
        background: var(--background-color);
        border-radius: var(--radius-lg);
        padding: var(--space-xl);
        box-shadow: var(--shadow-lg);
        border: 1px solid var(--border-color);
        height: fit-content;
        position: sticky;
        top: calc(var(--header-height) + var(--space-lg));
    }

    .benefits-title {
        color: var(--primary-color);
        margin-bottom: var(--space-lg);
        display: flex;
        align-items: center;
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
        border-radius: var(--radius-md);
        border: 1px solid var(--border-color);
        transition: var(--transition-normal);
    }

    .benefit-item:hover {
        transform: translateX(5px);
        border-color: var(--primary-color);
    }

    .benefit-icon {
        width: 48px;
        height: 48px;
        min-width: 48px;
        background: var(--gradient-primary);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.25rem;
    }

    .benefit-content h5 {
        color: var(--text-primary);
        margin-bottom: 4px;
        font-size: var(--text-base);
    }

    .benefit-content p {
        color: var(--text-muted);
        font-size: var(--text-sm);
        margin: 0;
    }

    .trust-badges {
        display: flex;
        gap: var(--space-sm);
        flex-wrap: wrap;
        justify-content: center;
    }

    .trust-badge {
        display: flex;
        align-items: center;
        gap: var(--space-xs);
        padding: 6px 12px;
        background: var(--surface-color);
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        color: var(--text-muted);
        font-size: var(--text-sm);
    }

    .trust-badge i {
        color: var(--success-color);
        font-size: var(--text-sm);
    }

    /* ==========================================================================
   Responsive Design
   ========================================================================== */
    @media (max-width: 992px) {
        .register-wrapper {
            grid-template-columns: 1fr;
            max-width: 600px;
        }

        .register-benefits {
            position: static;
            margin-top: var(--space-xl);
        }
    }

    @media (max-width: 768px) {
        .hero-wrapper {
            grid-template-columns: 1fr;
            text-align: center;
            gap: var(--space-lg);
        }

        .hero-content .hero-title {
            font-size: var(--text-2xl);
        }

        .hero-content .hero-subtitle {
            font-size: var(--text-base);
        }

        .hero-visual {
            max-width: 500px;
            margin: 0 auto;
        }

        .register-card {
            padding: var(--space-lg);
        }

        .register-benefits {
            padding: var(--space-lg);
        }
    }

    @media (max-width: 576px) {
        .hero-content .hero-title {
            font-size: var(--text-xl);
        }

        .hero-content .hero-subtitle {
            font-size: var(--text-sm);
        }

        .register-card {
            padding: var(--space-md);
        }

        .register-benefits {
            padding: var(--space-md);
        }

        .trust-badges {
            flex-direction: column;
            align-items: center;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Password visibility toggle
        document.querySelectorAll('.password-toggle').forEach(button => {
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

        // Password match validation
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('password_confirmation');
        const passwordMatch = document.querySelector('.password-match');

        function checkPasswordMatch() {
            if (!passwordInput || !confirmPasswordInput || !passwordMatch) return;

            const password = passwordInput.value;
            const confirmPassword = confirmPasswordInput.value;

            if (confirmPassword.length === 0) {
                passwordMatch.classList.remove('visible', 'valid');
                return;
            }

            passwordMatch.classList.add('visible');

            if (password === confirmPassword) {
                passwordMatch.classList.add('valid');
                passwordMatch.querySelector('i').className = 'fas fa-check-circle';
                passwordMatch.querySelector('span').textContent = 'Passwords match';
            } else {
                passwordMatch.classList.remove('valid');
                passwordMatch.querySelector('i').className = 'fas fa-times-circle';
                passwordMatch.querySelector('span').textContent = 'Passwords don\'t match';
            }
        }

        if (passwordInput && confirmPasswordInput) {
            passwordInput.addEventListener('input', checkPasswordMatch);
            confirmPasswordInput.addEventListener('input', checkPasswordMatch);
        }

        // Form validation on submit
        const registerForm = document.getElementById('registerForm');
        const submitBtn = document.querySelector('.register-submit');

        if (registerForm) {
            registerForm.addEventListener('submit', async function(e) {
                const termsCheckbox = document.getElementById('terms');

                if (!termsCheckbox.checked) {
                    e.preventDefault();
                    showToast('Please agree to the Terms of Service and Privacy Policy', 'error');
                    termsCheckbox.focus();
                    return;
                }

                // Check password match
                if (passwordInput.value !== confirmPasswordInput.value) {
                    e.preventDefault();
                    showToast('Passwords do not match', 'error');
                    confirmPasswordInput.focus();
                    return;
                }

                // Simple password strength check
                if (passwordInput.value.length < 6) {
                    e.preventDefault();
                    showToast('Password must be at least 6 characters', 'error');
                    passwordInput.focus();
                    return;
                }

                // Add loading state
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Creating Account...';
            });
        }

        // Toast notification function
        function showToast(message, type = 'info') {
            // Use existing toast function if available
            if (typeof window.showToast === 'function') {
                window.showToast(message, type);
                return;
            }

            // Simple fallback
            console.log(`${type}: ${message}`);
            alert(message);
        }

        // Phone number formatting (optional)
        const phoneInput = document.getElementById('phone');
        if (phoneInput) {
            phoneInput.addEventListener('input', function(e) {
                let value = this.value.replace(/\D/g, '');

                if (value.length > 0) {
                    value = '+' + value;
                }

                this.value = value;
            });
        }

        // Auto-focus email if name is already filled
        const nameInput = document.getElementById('name');
        const emailInput = document.getElementById('email');

        if (nameInput && emailInput && nameInput.value && !emailInput.value) {
            emailInput.focus();
        }

        // Terms links open in new tab
        document.querySelectorAll('.link-primary[href*="policies"]').forEach(link => {
            link.setAttribute('target', '_blank');
            link.setAttribute('rel', 'noopener noreferrer');
        });
    });
</script>
@endpush