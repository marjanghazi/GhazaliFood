<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Not Found | Ghazali Food | Premium Dry Fruits Store</title>

    <!-- SEO Meta Tags -->
    <meta name="description" content="Oops! The page you're looking for doesn't exist. Visit Ghazali Food for premium dry fruits, nuts, and berries.">
    <meta name="keywords" content="404, page not found, dry fruits, nuts, berries, Ghazali Food">
    <meta name="robots" content="noindex, nofollow">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <style>
        /* ==========================================================================
           Variables
           ========================================================================== */
        :root {
            --primary-color: #115028;
            --primary-dark: #0C4220;
            --primary-light: #1A7340;
            --accent-color: #D4AF37;
            --background-color: #FFFFFF;
            --surface-color: #F9F7F3;
            --text-primary: #011603;
            --text-secondary: #115028;
            --border-color: #E8E5DD;
            --gradient-primary: linear-gradient(135deg, #115028, #0C4220);
            --gradient-gold: linear-gradient(135deg, #D4AF37, #F0C75E);
            --space-sm: 1rem;
            --space-md: 1.5rem;
            --space-lg: 2rem;
            --space-xl: 3rem;
            --radius-md: 12px;
            --radius-lg: 16px;
            --radius-xl: 24px;
            --shadow-md: 0 4px 16px rgba(1, 22, 3, 0.08);
            --shadow-lg: 0 8px 32px rgba(1, 22, 3, 0.12);
        }

        [data-theme="dark"] {
            --primary-color: #27ae60;
            --primary-dark: #115028;
            --primary-light: #2ecc71;
            --accent-color: #F0C75E;
            --background-color: #0A0F0A;
            --surface-color: #1A1F1A;
            --text-primary: #FFFFFF;
            --text-secondary: #E0E8E0;
            --border-color: #2C332C;
            --gradient-gold: linear-gradient(135deg, #F0C75E, #D4AF37);
        }

        /* ==========================================================================
           Base Styles
           ========================================================================== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
            line-height: 1.6;
            color: var(--text-primary);
            background-color: var(--background-color);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: background-color 0.3s ease;
        }

        /* ==========================================================================
           Error Container
           ========================================================================== */
        .error-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: var(--space-xl);
            min-height: 100vh;
            position: relative;
            overflow: hidden;
        }

        .error-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 10% 20%, rgba(212, 175, 55, 0.1) 0%, transparent 40%),
                radial-gradient(circle at 90% 80%, rgba(17, 80, 40, 0.1) 0%, transparent 40%);
            z-index: -1;
        }

        /* ==========================================================================
           Error Content
           ========================================================================== */
        .error-content {
            text-align: center;
            max-width: 600px;
            padding: var(--space-xl);
            background: var(--surface-color);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--border-color);
            position: relative;
            z-index: 2;
        }

        /* ==========================================================================
           Error Code
           ========================================================================== */
        .error-code {
            font-size: 8rem;
            font-weight: 800;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1;
            margin-bottom: var(--space-md);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        /* ==========================================================================
           Error Icon
           ========================================================================== */
        .error-icon {
            width: 120px;
            height: 120px;
            background: var(--gradient-gold);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto var(--space-lg);
            font-size: 3rem;
            color: var(--text-primary);
            box-shadow: var(--shadow-md);
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        /* ==========================================================================
           Error Title
           ========================================================================== */
        .error-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: var(--space-sm);
            line-height: 1.2;
        }

        /* ==========================================================================
           Error Message
           ========================================================================== */
        .error-message {
            font-size: 1.125rem;
            color: var(--text-secondary);
            margin-bottom: var(--space-xl);
            line-height: 1.6;
        }

        /* ==========================================================================
           Action Buttons
           ========================================================================== */
        .error-actions {
            display: flex;
            gap: var(--space-md);
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: var(--space-xl);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 32px;
            font-size: 1rem;
            font-weight: 600;
            text-decoration: none;
            border: 2px solid transparent;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            gap: 8px;
            font-family: 'Inter', sans-serif;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn i {
            transition: transform 0.3s ease;
        }

        .btn:hover i {
            transform: translateX(4px);
        }

        .btn-primary {
            background: var(--gradient-primary);
            color: white;
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 50%, var(--accent-color) 100%);
        }

        .btn-outline {
            background: transparent;
            border-color: var(--primary-color);
            color: var(--primary-color);
        }

        .btn-outline:hover {
            background: var(--primary-color);
            color: white;
        }

        /* ==========================================================================
           Search Form
           ========================================================================== */
        .search-form {
            max-width: 400px;
            margin: 0 auto;
        }

        .search-wrapper {
            position: relative;
            width: 100%;
        }

        .search-input {
            width: 100%;
            padding: 14px 52px 14px 20px;
            border: 2px solid var(--border-color);
            border-radius: 50px;
            background: var(--background-color);
            color: var(--text-primary);
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--accent-color);
            box-shadow: 0 0 0 4px rgba(212, 175, 55, 0.1);
        }

        .search-btn {
            position: absolute;
            right: 6px;
            top: 50%;
            transform: translateY(-50%);
            background: var(--gradient-gold);
            border: none;
            color: var(--text-primary);
            cursor: pointer;
            padding: 8px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .search-btn:hover {
            transform: translateY(-50%) scale(1.1);
        }

        /* ==========================================================================
           Quick Links
           ========================================================================== */
        .quick-links {
            margin-top: var(--space-xl);
            padding-top: var(--space-lg);
            border-top: 1px solid var(--border-color);
        }

        .links-title {
            font-size: 1rem;
            color: var(--text-secondary);
            margin-bottom: var(--space-md);
            font-weight: 600;
        }

        .links-grid {
            display: flex;
            flex-wrap: wrap;
            gap: var(--space-sm);
            justify-content: center;
        }

        .link-item {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            background: var(--background-color);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .link-item:hover {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
            transform: translateY(-2px);
        }

        .link-item i {
            font-size: 0.75rem;
        }

        /* ==========================================================================
           Floating Elements
           ========================================================================== */
        .floating-elements {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            pointer-events: none;
            z-index: 1;
        }

        .floating-element {
            position: absolute;
            border-radius: 50%;
            background: var(--gradient-gold);
            opacity: 0.1;
            animation: floatElement 15s linear infinite;
        }

        .element-1 {
            width: 80px;
            height: 80px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .element-2 {
            width: 60px;
            height: 60px;
            bottom: 30%;
            right: 15%;
            animation-delay: 5s;
        }

        .element-3 {
            width: 40px;
            height: 40px;
            top: 40%;
            right: 20%;
            animation-delay: 10s;
        }

        @keyframes floatElement {
            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 0.1;
            }
            50% {
                transform: translateY(-100px) rotate(180deg);
                opacity: 0.3;
            }
            100% {
                transform: translateY(0) rotate(360deg);
                opacity: 0.1;
            }
        }

        /* ==========================================================================
           Footer
           ========================================================================== */
        .error-footer {
            text-align: center;
            padding: var(--space-lg);
            color: var(--text-secondary);
            font-size: 0.875rem;
            border-top: 1px solid var(--border-color);
            background: var(--surface-color);
        }

        .footer-links {
            display: flex;
            justify-content: center;
            gap: var(--space-lg);
            margin-top: var(--space-sm);
            flex-wrap: wrap;
        }

        .footer-link {
            color: var(--text-secondary);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-link:hover {
            color: var(--primary-color);
        }

        /* ==========================================================================
           Theme Toggle
           ========================================================================== */
        .theme-toggle {
            position: fixed;
            top: 20px;
            right: 20px;
            background: var(--surface-color);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            cursor: pointer;
            padding: 10px;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: var(--shadow-md);
        }

        .theme-toggle:hover {
            border-color: var(--accent-color);
            transform: rotate(30deg);
        }

        .theme-toggle i {
            position: absolute;
            transition: opacity 0.3s ease;
        }

        .theme-toggle .light-icon {
            opacity: 1;
        }

        .theme-toggle .dark-icon {
            opacity: 0;
        }

        [data-theme="dark"] .theme-toggle .light-icon {
            opacity: 0;
        }

        [data-theme="dark"] .theme-toggle .dark-icon {
            opacity: 1;
        }

        /* ==========================================================================
           Responsive Design
           ========================================================================== */
        @media (max-width: 768px) {
            .error-container {
                padding: var(--space-md);
            }

            .error-content {
                padding: var(--space-lg);
            }

            .error-code {
                font-size: 6rem;
            }

            .error-icon {
                width: 100px;
                height: 100px;
                font-size: 2.5rem;
            }

            .error-title {
                font-size: 2rem;
            }

            .error-message {
                font-size: 1rem;
            }

            .error-actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                text-align: center;
            }

            .links-grid {
                justify-content: center;
            }

            .theme-toggle {
                width: 45px;
                height: 45px;
                top: 15px;
                right: 15px;
            }
        }

        @media (max-width: 576px) {
            .error-code {
                font-size: 4rem;
            }

            .error-title {
                font-size: 1.5rem;
            }

            .error-icon {
                width: 80px;
                height: 80px;
                font-size: 2rem;
            }

            .footer-links {
                flex-direction: column;
                gap: var(--space-sm);
            }

            .floating-element {
                display: none;
            }
        }

        /* ==========================================================================
           Accessibility
           ========================================================================== */
        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }

        :focus {
            outline: 2px solid var(--accent-color);
            outline-offset: 2px;
        }
    </style>
</head>
<body>
    <!-- Theme Toggle -->
    <button class="theme-toggle" id="themeToggle" aria-label="Toggle theme">
        <i class="fas fa-sun light-icon"></i>
        <i class="fas fa-moon dark-icon"></i>
    </button>

    <!-- Error Container -->
    <main class="error-container">
        <!-- Floating Background Elements -->
        <div class="floating-elements">
            <div class="floating-element element-1"></div>
            <div class="floating-element element-2"></div>
            <div class="floating-element element-3"></div>
        </div>

        <!-- Error Content -->
        <div class="error-content animate__animated animate__fadeInUp">
            <!-- Error Icon -->
            <div class="error-icon">
                <i class="fas fa-search"></i>
            </div>

            <!-- Error Code -->
            <h1 class="error-code">404</h1>

            <!-- Error Title -->
            <h2 class="error-title">Page Not Found</h2>

            <!-- Error Message -->
            <p class="error-message">
                Oops! The page you're looking for seems to have wandered off like a mischievous almond. 
                Don't worry, we've got plenty of premium dry fruits waiting for you!
            </p>

            <!-- Action Buttons -->
            <div class="error-actions">
                <a href="{{ url('/') }}" class="btn btn-primary">
                    <i class="fas fa-home me-2"></i> Back to Home
                </a>
                <a href="{{ route('shop.index') }}" class="btn btn-outline">
                    <i class="fas fa-shopping-bag me-2"></i> Shop Now
                </a>
                <button onclick="history.back()" class="btn btn-outline">
                    <i class="fas fa-arrow-left me-2"></i> Go Back
                </button>
            </div>

            <!-- Search Form -->
            <form class="search-form" action="{{ route('shop.index') }}" method="GET">
                <div class="search-wrapper">
                    <input type="text" 
                           name="search" 
                           class="search-input" 
                           placeholder="Search for almonds, cashews, dates..."
                           aria-label="Search products">
                    <button type="submit" class="search-btn" aria-label="Search">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>

            <!-- Quick Links -->
            <div class="quick-links">
                <h3 class="links-title">Quick Links</h3>
                <div class="links-grid">
                    <a href="{{ route('shop.index') }}" class="link-item">
                        <i class="fas fa-store"></i> Shop
                    </a>
                    <a href="{{ route('blog.index') }}" class="link-item">
                        <i class="fas fa-blog"></i> Blog
                    </a>
                    <a href="{{ route('about') }}" class="link-item">
                        <i class="fas fa-info-circle"></i> About Us
                    </a>
                    <a href="{{ route('contact.index') }}" class="link-item">
                        <i class="fas fa-envelope"></i> Contact
                    </a>
                    <a href="{{ route('categories.index') }}" class="link-item">
                        <i class="fas fa-th-large"></i> Categories
                    </a>
                    <a href="{{ route('shop.index', ['new_arrival' => true]) }}" class="link-item">
                        <i class="fas fa-bell"></i> New Arrivals
                    </a>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="error-footer">
        <p>&copy; {{ date('Y') }} Ghazali Food. Premium Dry Fruits Store. All rights reserved.</p>
        <div class="footer-links">
            <a href="{{ route('policies.privacy') }}" class="footer-link">Privacy Policy</a>
            <a href="{{ route('policies.terms') }}" class="footer-link">Terms of Service</a>
            <a href="{{ route('policies.shipping') }}" class="footer-link">Shipping Policy</a>
            <a href="{{ route('contact.index') }}" class="footer-link">Contact Support</a>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Theme Toggle
            const themeToggle = document.getElementById('themeToggle');
            if (themeToggle) {
                const currentTheme = localStorage.getItem('theme') || 'light';
                document.documentElement.setAttribute('data-theme', currentTheme);
                
                themeToggle.addEventListener('click', () => {
                    const currentTheme = document.documentElement.getAttribute('data-theme');
                    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                    
                    document.documentElement.setAttribute('data-theme', newTheme);
                    localStorage.setItem('theme', newTheme);
                });
            }

            // Search form focus
            const searchInput = document.querySelector('.search-input');
            if (searchInput) {
                setTimeout(() => {
                    searchInput.focus();
                }, 500);
            }

            // Button hover effects
            const buttons = document.querySelectorAll('.btn');
            buttons.forEach(button => {
                button.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-4px)';
                });
                
                button.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });

            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href');
                    if (targetId === '#') return;
                    
                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        targetElement.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Keyboard navigation
            document.addEventListener('keydown', function(e) {
                // Escape key to go back
                if (e.key === 'Escape') {
                    history.back();
                }
                
                // Ctrl/Cmd + / to focus search
                if ((e.ctrlKey || e.metaKey) && e.key === '/') {
                    e.preventDefault();
                    if (searchInput) {
                        searchInput.focus();
                    }
                }
            });

            // Add loading animation to buttons
            document.querySelectorAll('a[href]').forEach(link => {
                link.addEventListener('click', function(e) {
                    // Don't interrupt form submissions
                    if (this.tagName === 'BUTTON' && this.type === 'submit') return;
                    
                    // Add loading animation
                    const originalContent = this.innerHTML;
                    this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Loading...';
                    this.style.pointerEvents = 'none';
                    
                    // Reset after 2 seconds (in case navigation fails)
                    setTimeout(() => {
                        this.innerHTML = originalContent;
                        this.style.pointerEvents = 'auto';
                    }, 2000);
                });
            });

            // Display current year in footer
            const yearElement = document.querySelector('footer p');
            if (yearElement) {
                yearElement.innerHTML = yearElement.innerHTML.replace('{{ date("Y") }}', new Date().getFullYear());
            }
        });

        // Handle browser back/forward buttons
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                window.location.reload();
            }
        });
    </script>
</body>
</html>