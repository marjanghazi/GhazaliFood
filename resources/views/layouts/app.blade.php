<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Premium Dry Fruits Store | Nuts & Berries')</title>

    <!-- SEO Meta Tags -->
    <meta name="description" content="@yield('description', 'Premium quality dry fruits, nuts, and berries. 100% natural, organic, and sourced from the finest orchards worldwide.')">
    <meta name="keywords" content="dry fruits, nuts, berries, organic, healthy snacks, premium quality">
    <meta name="author" content="Nuts & Berries">
    <meta property="og:title" content="@yield('title', 'Premium Dry Fruits Store')">
    <meta property="og:description" content="Premium quality dry fruits delivered to your doorstep">
    <meta property="og:image" content="{{ asset('images/og-image.jpg') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    @stack('styles')
</head>
<body>
    <!-- Announcement Bar -->
    @php
        $announcements = \App\Models\Announcement::active()
            ->orderBy('display_order')
            ->get();
        
        $config = config('announcement');
        $announcementEnabled = $config['enabled'] ?? true;
        $defaultMessage = $config['message'] ?? 'Free shipping on orders over $50!';
    @endphp

    @if($announcementEnabled && ($announcements->count() > 0 || $defaultMessage))
        <div class="announcement-bar" id="announcementBar">
            <div class="container">
                <div class="announcement-content">
                    @if($announcements->count() > 0)
                        @foreach($announcements as $announcement)
                            <div class="announcement-item" style="
                                @if($announcement->background_color) background-color: {{ $announcement->background_color }}; @endif
                                @if($announcement->text_color) color: {{ $announcement->text_color }}; @endif
                            ">
                                @if($announcement->link_url)
                                    <a href="{{ $announcement->link_url }}" style="
                                        @if($announcement->text_color) color: {{ $announcement->text_color }}; @endif
                                        text-decoration: none;
                                    ">
                                        <i class="fas fa-gift me-2"></i> {{ $announcement->text }}
                                    </a>
                                @else
                                    <i class="fas fa-gift me-2"></i> {{ $announcement->text }}
                                @endif
                                
                                @if($announcement->is_closable)
                                    <button class="announcement-close" data-id="{{ $announcement->id }}">
                                        <i class="fas fa-times"></i>
                                    </button>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <div class="announcement-item">
                            <i class="fas fa-gift me-2"></i> {{ $defaultMessage }}
                        </div>
                    @endif
                </div>
                <button class="announcement-toggle" id="announcementToggle">
                    <i class="fas fa-chevron-up"></i>
                </button>
            </div>
        </div>
    @endif

    <!-- Main Header -->
    <header class="main-header" id="mainHeader">
        <div class="container">
            <div class="header-container">
                <!-- Mobile Toggle -->
                <button class="mobile-toggle" id="mobileToggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>

                <!-- Logo -->
                <a href="{{ url('/') }}" class="logo">
                    <div class="logo-icon">
                        <i class="fas fa-seedling"></i>
                    </div>
                    <div class="logo-text">
                        <h1>Ghazali Food</h1>
                    </div>
                </a>

                <!-- Main Navigation -->
                <nav class="main-nav" id="mainNav">
                    <!-- Mobile Close Button -->
                    <button class="mobile-close" id="mobileClose">
                        <i class="fas fa-times"></i>
                    </button>

                    <!-- Navigation Links -->
                    <ul class="nav-menu">
                        <li class="nav-item">
                            <a href="{{ url('/') }}" class="nav-link {{ request()->is('/') ? 'active' : '' }}">
                                Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('shop.index') }}" class="nav-link {{ request()->is('shop*') ? 'active' : '' }}">
                                Shop
                            </a>
                        </li>
                        
                        <!-- Categories Dropdown -->
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle">
                                Categories <i class="fas fa-chevron-down ms-1"></i>
                            </a>
                            <div class="dropdown-menu">
                                @php
                                    $categories = App\Models\Category::with(['children' => function($query) {
                                        $query->active()->orderBy('display_order');
                                    }])
                                    ->whereNull('parent_id')
                                    ->active()
                                    ->orderBy('display_order')
                                    ->limit(8)
                                    ->get();
                                @endphp
                                
                                @foreach($categories as $category)
                                    <div class="dropdown-group">
                                        <a href="{{ route('shop.index', ['category' => $category->slug]) }}" 
                                           class="dropdown-item">
                                            <i class="fas fa-chevron-right me-2"></i>
                                            {{ $category->name }}
                                            @if($category->children->count() > 0)
                                                <i class="fas fa-chevron-right float-end mt-1"></i>
                                            @endif
                                        </a>
                                        @if($category->children->count() > 0)
                                            <div class="submenu">
                                                @foreach($category->children as $child)
                                                    <a href="{{ route('shop.index', ['category' => $child->slug]) }}" 
                                                       class="submenu-item">
                                                        {{ $child->name }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                                
                                @if($categories->count() > 0)
                                    <div class="dropdown-divider"></div>
                                    <a href="{{ route('categories.index') }}" class="dropdown-view-all">
                                        View All Categories <i class="fas fa-arrow-right ms-2"></i>
                                    </a>
                                @endif
                            </div>
                        </li>
                        
                        <li class="nav-item">
                            <a href="{{ route('blog.index') }}" class="nav-link {{ request()->is('blog*') ? 'active' : '' }}">
                                Blog
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('about') }}" class="nav-link {{ request()->is('about') ? 'active' : '' }}">
                                About
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('contact.index') }}" class="nav-link {{ request()->is('contact*') ? 'active' : '' }}">
                                Contact
                            </a>
                        </li>
                    </ul>

                    <!-- Search Box -->
                    <div class="search-container">
                        <form action="{{ route('shop.index') }}" method="GET" class="search-form">
                            <div class="search-wrapper">
                                <input type="text" 
                                       name="search" 
                                       class="search-input" 
                                       placeholder="Search dry fruits..."
                                       value="{{ request('search') }}"
                                       aria-label="Search products">
                                <button type="submit" class="search-btn" aria-label="Search">
                                    <i class="fas fa-search"></i>
                                </button>
                                @if(request('search'))
                                    <a href="{{ route('shop.index') }}" class="search-clear" aria-label="Clear search">
                                        <i class="fas fa-times"></i>
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </nav>

                <!-- Header Actions -->
                <div class="header-actions">
                    <!-- Mobile Search Toggle -->
                    <button class="search-toggle" id="searchToggle">
                        <i class="fas fa-search"></i>
                    </button>

                    <!-- Wishlist -->
                    @auth
                        <a href="{{ route('wishlist') }}" class="action-btn" aria-label="Wishlist">
                            <i class="fas fa-heart"></i>
                            @php
                                $wishlistCount = App\Models\Wishlist::getCount();
                            @endphp
                            @if($wishlistCount > 0)
                                <span class="badge">{{ $wishlistCount }}</span>
                            @endif
                        </a>
                    @endauth

                    <!-- Cart -->
                    <a href="{{ route('cart.index') }}" class="action-btn cart-btn" aria-label="Shopping cart">
                        <i class="fas fa-shopping-cart"></i>
                        @php
                            $cartCount = 0;
                            if(session()->has('cart')) {
                                $cartItems = session()->get('cart', []);
                                foreach($cartItems as $item) {
                                    $cartCount += $item['quantity'] ?? 1;
                                }
                            }
                        @endphp
                        @if($cartCount > 0)
                            <span class="badge">{{ $cartCount }}</span>
                        @endif
                    </a>

                    <!-- User Account -->
                    @auth
                        <div class="user-dropdown">
                            <button class="action-btn dropdown-toggle" type="button">
                                <i class="fas fa-user"></i>
                            </button>
                            <div class="dropdown-menu user-menu">
                                <a href="{{ route('profile.edit') }}" class="dropdown-item">
                                    <i class="fas fa-user-cog"></i>
                                    <span>Profile</span>
                                </a>
                                <a href="{{ route('orders.index') }}" class="dropdown-item">
                                    <i class="fas fa-history"></i>
                                    <span>Orders</span>
                                </a>
                                <a href="{{ route('wishlist') }}" class="dropdown-item">
                                    <i class="fas fa-heart"></i>
                                    <span>Wishlist</span>
                                </a>
                                @if(Auth::user()->isAdmin())
                                    <div class="dropdown-divider"></div>
                                    <a href="{{ route('admin.dashboard') }}" class="dropdown-item">
                                        <i class="fas fa-cog"></i>
                                        <span>Dashboard</span>
                                    </a>
                                @endif
                                <div class="dropdown-divider"></div>
                                <form method="POST" action="{{ route('logout') }}" class="dropdown-item">
                                    @csrf
                                    <button type="submit" class="logout-btn">
                                        <i class="fas fa-sign-out-alt"></i>
                                        <span>Logout</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="action-btn" aria-label="Login">
                            <i class="fas fa-user"></i>
                        </a>
                    @endauth

                    <!-- Theme Toggle -->
                    <button class="theme-toggle" id="themeToggle" aria-label="Toggle theme">
                        <i class="fas fa-sun light-icon"></i>
                        <i class="fas fa-moon dark-icon"></i>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile Search Overlay -->
    <div class="mobile-search-overlay" id="mobileSearchOverlay">
        <div class="search-overlay-container">
            <form action="{{ route('shop.index') }}" method="GET" class="mobile-search-form">
                <input type="text" 
                       name="search" 
                       class="mobile-search-input" 
                       placeholder="Search almonds, cashews, raisins..."
                       autofocus
                       aria-label="Mobile search">
                <button type="submit" class="mobile-search-btn" aria-label="Search">
                    <i class="fas fa-search"></i>
                </button>
                <button type="button" class="search-close" id="mobileSearchClose" aria-label="Close search">
                    <i class="fas fa-times"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <main id="mainContent">
        @yield('hero')
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="main-footer">
        <div class="container">
            <div class="footer-grid">
                <!-- Company Info -->
                <div class="footer-section">
                    <a href="{{ url('/') }}" class="footer-logo">
                        <div class="logo-icon">
                            <i class="fas fa-seedling"></i>
                        </div>
                        <div class="logo-text">
                            <h3>Nuts & Berries</h3>
                            <p>Premium Dry Fruits</p>
                        </div>
                    </a>
                    <p class="footer-description">
                        Premium quality dry fruits, nuts, and berries. 100% natural, organic, 
                        and sourced from the finest orchards worldwide.
                    </p>
                    <div class="social-links">
                        <a href="#" class="social-link" aria-label="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social-link" aria-label="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="social-link" aria-label="Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="social-link" aria-label="Pinterest">
                            <i class="fab fa-pinterest"></i>
                        </a>
                        <a href="#" class="social-link" aria-label="YouTube">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="footer-section">
                    <h4 class="footer-title">Quick Links</h4>
                    <ul class="footer-links">
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><a href="{{ route('shop.index') }}">Shop All</a></li>
                        <li><a href="{{ route('shop.index', ['new_arrival' => true]) }}">New Arrivals</a></li>
                        <li><a href="{{ route('shop.index', ['featured' => true]) }}">Featured</a></li>
                        <li><a href="{{ route('shop.index', ['sale' => true]) }}">On Sale</a></li>
                    </ul>
                </div>

                <!-- Categories -->
                <div class="footer-section">
                    <h4 class="footer-title">Categories</h4>
                    <ul class="footer-links">
                        @php
                            $footerCategories = App\Models\Category::whereNull('parent_id')
                                ->active()
                                ->orderBy('display_order')
                                ->limit(6)
                                ->get();
                        @endphp
                        @foreach($footerCategories as $category)
                            <li>
                                <a href="{{ route('shop.index', ['category' => $category->slug]) }}">
                                    {{ $category->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Contact & Newsletter -->
                <div class="footer-section">
                    <h4 class="footer-title">Stay Connected</h4>
                    <p class="footer-text">Subscribe for exclusive offers and updates</p>
                    
                    <form class="newsletter-form">
                        <div class="newsletter-group">
                            <input type="email" 
                                   class="newsletter-input" 
                                   placeholder="Your email address"
                                   required
                                   aria-label="Email for newsletter">
                            <button type="submit" class="newsletter-btn">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </form>

                    <div class="contact-info">
                        <div class="contact-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>123 Nut Street, Dry Fruits City</span>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-phone"></i>
                            <span>+1 (555) 123-4567</span>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-envelope"></i>
                            <span>info@nutsandberries.com</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <div class="footer-copyright">
                    &copy; {{ date('Y') }} Nuts & Berries. All rights reserved.
                </div>
                
                <div class="payment-methods">
                    <i class="fab fa-cc-visa" aria-label="Visa"></i>
                    <i class="fab fa-cc-mastercard" aria-label="Mastercard"></i>
                    <i class="fab fa-cc-amex" aria-label="American Express"></i>
                    <i class="fab fa-cc-paypal" aria-label="PayPal"></i>
                    <i class="fab fa-cc-apple-pay" aria-label="Apple Pay"></i>
                </div>
                
                <div class="footer-links-bottom">
                    <a href="{{ route('policies.privacy') }}">Privacy Policy</a>
                    <a href="{{ route('policies.terms') }}">Terms of Service</a>
                    <a href="{{ route('policies.shipping') }}">Shipping Policy</a>
                    <a href="{{ route('policies.refund') }}">Refund Policy</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button class="back-to-top" id="backToTop" aria-label="Back to top">
        <i class="fas fa-chevron-up"></i>
    </button>

    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer"></div>

    <!-- JavaScript -->
    <script src="{{ asset('js/main.js') }}"></script>

    @stack('scripts')

    <script>
        // Announcement Bar
        document.addEventListener('DOMContentLoaded', function() {
            const announcementBar = document.getElementById('announcementBar');
            const announcementToggle = document.getElementById('announcementToggle');
            
            if (announcementBar && announcementToggle) {
                const isCollapsed = localStorage.getItem('announcementCollapsed') === 'true';
                
                if (isCollapsed) {
                    announcementBar.classList.add('collapsed');
                    announcementToggle.innerHTML = '<i class="fas fa-chevron-down"></i>';
                }
                
                announcementToggle.addEventListener('click', () => {
                    announcementBar.classList.toggle('collapsed');
                    const isNowCollapsed = announcementBar.classList.contains('collapsed');
                    localStorage.setItem('announcementCollapsed', isNowCollapsed);
                    announcementToggle.innerHTML = isNowCollapsed 
                        ? '<i class="fas fa-chevron-down"></i>' 
                        : '<i class="fas fa-chevron-up"></i>';
                });
                
                // Handle close buttons
                document.querySelectorAll('.announcement-close').forEach(button => {
                    button.addEventListener('click', function() {
                        const id = this.dataset.id;
                        if (id) {
                            const closedAnnouncements = JSON.parse(localStorage.getItem('closedAnnouncements') || '[]');
                            if (!closedAnnouncements.includes(id)) {
                                closedAnnouncements.push(id);
                                localStorage.setItem('closedAnnouncements', JSON.stringify(closedAnnouncements));
                            }
                        }
                        this.closest('.announcement-item').style.display = 'none';
                    });
                });
            }

            // Mobile Navigation
            const mobileToggle = document.getElementById('mobileToggle');
            const mobileClose = document.getElementById('mobileClose');
            const mainNav = document.getElementById('mainNav');
            
            if (mobileToggle && mainNav) {
                mobileToggle.addEventListener('click', () => {
                    mainNav.classList.add('active');
                    document.body.style.overflow = 'hidden';
                });
                
                if (mobileClose) {
                    mobileClose.addEventListener('click', () => {
                        mainNav.classList.remove('active');
                        document.body.style.overflow = '';
                    });
                }
            }

            // Mobile Search
            const searchToggle = document.getElementById('searchToggle');
            const mobileSearchClose = document.getElementById('mobileSearchClose');
            const mobileSearchOverlay = document.getElementById('mobileSearchOverlay');
            
            if (searchToggle && mobileSearchOverlay) {
                searchToggle.addEventListener('click', () => {
                    mobileSearchOverlay.classList.add('active');
                });
                
                if (mobileSearchClose) {
                    mobileSearchClose.addEventListener('click', () => {
                        mobileSearchOverlay.classList.remove('active');
                    });
                }
            }

            // Clear search input
            document.querySelectorAll('.search-clear').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const searchForm = this.closest('.search-form');
                    if (searchForm) {
                        searchForm.querySelector('.search-input').value = '';
                        searchForm.submit();
                    }
                });
            });

            // Back to Top
            const backToTop = document.getElementById('backToTop');
            if (backToTop) {
                window.addEventListener('scroll', () => {
                    if (window.pageYOffset > 300) {
                        backToTop.classList.add('visible');
                    } else {
                        backToTop.classList.remove('visible');
                    }
                });
                
                backToTop.addEventListener('click', () => {
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                });
            }

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

            // User dropdown
            const userDropdown = document.querySelector('.user-dropdown .dropdown-toggle');
            if (userDropdown) {
                userDropdown.addEventListener('click', function(e) {
                    e.preventDefault();
                    this.nextElementSibling.classList.toggle('show');
                });
                
                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!e.target.closest('.user-dropdown')) {
                        document.querySelectorAll('.user-menu').forEach(menu => {
                            menu.classList.remove('show');
                        });
                    }
                });
            }

            // Close mobile menu when clicking outside
            document.addEventListener('click', function(e) {
                if (mainNav && mainNav.classList.contains('active')) {
                    if (!e.target.closest('#mainNav') && !e.target.closest('#mobileToggle')) {
                        mainNav.classList.remove('active');
                        document.body.style.overflow = '';
                    }
                }
                
                if (mobileSearchOverlay && mobileSearchOverlay.classList.contains('active')) {
                    if (!e.target.closest('#mobileSearchOverlay') && !e.target.closest('#searchToggle')) {
                        mobileSearchOverlay.classList.remove('active');
                    }
                }
            });

            // Close on escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    if (mainNav && mainNav.classList.contains('active')) {
                        mainNav.classList.remove('active');
                        document.body.style.overflow = '';
                    }
                    
                    if (mobileSearchOverlay && mobileSearchOverlay.classList.contains('active')) {
                        mobileSearchOverlay.classList.remove('active');
                    }
                    
                    document.querySelectorAll('.user-menu').forEach(menu => {
                        menu.classList.remove('show');
                    });
                }
            });

            // Update active nav link on page load
            function updateActiveNav() {
                const currentPath = window.location.pathname;
                document.querySelectorAll('.nav-link').forEach(link => {
                    link.classList.remove('active');
                    if (link.getAttribute('href') === currentPath) {
                        link.classList.add('active');
                    }
                });
            }
            updateActiveNav();
        });

        // Toast notification function
        function showToast(message, type = 'success') {
            const toastContainer = document.getElementById('toastContainer');
            if (!toastContainer) return;
            
            const toast = document.createElement('div');
            toast.className = `toast toast-${type}`;
            toast.innerHTML = `
                <div class="toast-content">
                    <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
                    <span>${message}</span>
                </div>
                <button class="toast-close">
                    <i class="fas fa-times"></i>
                </button>
            `;
            
            toastContainer.appendChild(toast);
            
            // Show toast
            setTimeout(() => {
                toast.classList.add('show');
            }, 10);
            
            // Auto remove after 5 seconds
            const autoRemove = setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }, 5000);
            
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
</body>
</html>