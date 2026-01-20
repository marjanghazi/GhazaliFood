<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Ghazali Food | Premium Dry Fruits Store')</title>

    <!-- SEO Meta Tags -->
    <meta name="description" content="@yield('description', 'Premium quality dry fruits, nuts, and berries. 100% natural, organic, and sourced from the finest orchards worldwide.')">
    <meta name="keywords" content="dry fruits, nuts, berries, organic, healthy snacks, premium quality">
    <meta name="author" content="Ghazali Food">
    <meta property="og:title" content="@yield('title', 'Ghazali Food | Premium Dry Fruits')">
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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Animate.css for extra animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

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
    <div class="announcement-bar animate__animated animate__slideInDown" id="announcementBar">
        <div class="announcement-container">
            <div class="announcement-content">
                @if($announcements->count() > 0)
                @foreach($announcements as $announcement)
                <div class="announcement-item" style="
                                @if($announcement->background_color) background-color: {{ $announcement->background_color }}; @endif
                                @if($announcement->text_color) color: {{ $announcement->text_color }}; @endif
                            ">
                    @if($announcement->link_url)
                    <a href="{{ $announcement->link_url }}" class="announcement-link">
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
        <div class="header-container">
            <div class="header-wrapper">
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
                        <span class="logo-main">Ghazali Food</span>
                        <span class="logo-tagline">Premium Dry Fruits</span>
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
                                <i class="fas fa-home me-2"></i>Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('about') }}" class="nav-link {{ request()->is('about') ? 'active' : '' }}">
                                <i class="fas fa-info-circle me-2"></i>About
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('shop.index') }}" class="nav-link {{ request()->is('shop*') ? 'active' : '' }}">
                                <i class="fas fa-shopping-bag me-2"></i>Shop
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('contact.index') }}" class="nav-link {{ request()->is('contact*') ? 'active' : '' }}">
                                <i class="fas fa-envelope me-2"></i>Contact
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('blog.index') }}" class="nav-link {{ request()->is('blog*') ? 'active' : '' }}">
                                <i class="fas fa-blog me-2"></i>Blog
                            </a>
                        </li>
                    </ul>

                    <!-- Search Box -->
                    <div class="search-container">
                        <form action="{{ route('shop.index') }}" method="GET" class="search-form">
                            <div class="search-wrapper">
                                <i class="fas fa-search search-icon"></i>
                                <input type="text"
                                    name="search"
                                    class="search-input"
                                    placeholder="Search products..."
                                    value="{{ request('search') }}"
                                    aria-label="Search products">
                                @if(request('search'))
                                <a href="{{ route('shop.index') }}" class="search-clear" aria-label="Clear search">
                                    <i class="fas fa-times"></i>
                                </a>
                                @endif
                                <button type="submit" class="search-btn" aria-label="Search">
                                    <i class="fas fa-arrow-right"></i>
                                </button>
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
                            <div class="user-menu-header">
                                <div class="user-avatar">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <div class="user-info">
                                    <h6>{{ Auth::user()->name }}</h6>
                                    <small>{{ Auth::user()->email }}</small>
                                </div>
                            </div>
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
                                @if($wishlistCount > 0)
                                <span class="badge-count">{{ $wishlistCount }}</span>
                                @endif
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
                <div class="search-overlay-wrapper">
                    <i class="fas fa-search search-overlay-icon"></i>
                    <input type="text"
                        name="search"
                        class="mobile-search-input"
                        placeholder="Search almonds, cashews, raisins..."
                        autofocus
                        aria-label="Mobile search">
                    <button type="submit" class="mobile-search-btn" aria-label="Search">
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
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
                            <h3>Ghazali Food</h3>
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
                        <a href="#" class="social-link" aria-label="YouTube">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="#" class="social-link" aria-label="Pinterest">
                            <i class="fab fa-pinterest"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="footer-section">
                    <h4 class="footer-title">Quick Links</h4>
                    <ul class="footer-links">
                        <li><a href="{{ url('/') }}"><i class="fas fa-chevron-right me-2"></i>Home</a></li>
                        <li><a href="{{ route('shop.index') }}"><i class="fas fa-chevron-right me-2"></i>Shop All</a></li>
                        <li><a href="{{ route('shop.index', ['new_arrival' => true]) }}"><i class="fas fa-chevron-right me-2"></i>New Arrivals</a></li>
                        <li><a href="{{ route('shop.index', ['featured' => true]) }}"><i class="fas fa-chevron-right me-2"></i>Featured</a></li>
                        <li><a href="{{ route('shop.index', ['sale' => true]) }}"><i class="fas fa-chevron-right me-2"></i>On Sale</a></li>
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
                                <i class="fas fa-leaf me-2"></i>{{ $category->name }}
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
                        <small class="newsletter-note">We respect your privacy. Unsubscribe at any time.</small>
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
                            <span>info@ghazalifood.com</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <div class="footer-copyright">
                    &copy; {{ date('Y') }} Ghazali Food. All rights reserved.
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

    <!-- WhatsApp Floating Button -->
    <a href="https://wa.me/923288179010"
        class="whatsapp-float"
        target="_blank"
        rel="noopener noreferrer"
        aria-label="Chat on WhatsApp">
        <div class="whatsapp-icon">
            <i class="fab fa-whatsapp"></i>
        </div>
        <span class="whatsapp-text">Chat with us</span>
        <div class="whatsapp-notification" id="whatsappNotification">
            <span>Click to chat on WhatsApp!</span>
        </div>
    </a>

    <!-- Back to Top Button -->
    <button class="back-to-top" id="backToTop" aria-label="Back to top">
        <i class="fas fa-chevron-up"></i>
    </button>

    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer"></div>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-content">
            <div class="loading-spinner">
                <div class="spinner"></div>
            </div>
            <p class="loading-text">Loading...</p>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="{{ asset('js/main.js') }}"></script>

    @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // DEBUG: Check if elements exist
            console.log('DOM loaded - checking elements:');
            console.log('Announcement bar exists:', !!document.getElementById('announcementBar'));
            console.log('Announcement toggle exists:', !!document.getElementById('announcementToggle'));
            console.log('Close buttons found:', document.querySelectorAll('.announcement-close').length);

            // Announcement Bar - FIXED VERSION
            const announcementBar = document.getElementById('announcementBar');
            const announcementToggle = document.getElementById('announcementToggle');

            if (announcementBar && announcementToggle) {
                console.log('Announcement bar found, initializing...');

                // Add class to body when announcement is active
                document.body.classList.add('announcement-active');

                // Check if announcement should be collapsed
                const isCollapsed = localStorage.getItem('announcementCollapsed') === 'true';
                const closedAnnouncements = JSON.parse(localStorage.getItem('closedAnnouncements') || '[]');
                console.log('Closed announcements:', closedAnnouncements);

                // Check if any announcement items should be hidden
                document.querySelectorAll('.announcement-item').forEach(item => {
                    const closeButton = item.querySelector('.announcement-close');
                    if (closeButton) {
                        const id = closeButton.dataset.id;
                        if (id && closedAnnouncements.includes(id)) {
                            item.style.display = 'none';
                            console.log('Hiding announcement item with id:', id);
                        }
                    }
                });

                // Hide entire bar if all items are hidden
                const visibleItems = Array.from(document.querySelectorAll('.announcement-item')).filter(
                    item => item.style.display !== 'none' && getComputedStyle(item).display !== 'none'
                );

                console.log('Visible announcement items:', visibleItems.length);

                if (visibleItems.length === 0) {
                    announcementBar.style.display = 'none';
                    document.body.classList.remove('announcement-active');
                    console.log('All announcements hidden, removing bar');
                    return;
                }

                // Set initial collapsed state
                if (isCollapsed) {
                    announcementBar.classList.add('collapsed');
                    announcementToggle.innerHTML = '<i class="fas fa-chevron-down"></i>';
                    document.body.classList.remove('announcement-active');
                    console.log('Announcement initially collapsed');
                } else {
                    console.log('Announcement initially expanded');
                }

                // Toggle button functionality
                announcementToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    console.log('Announcement toggle clicked');

                    announcementBar.classList.toggle('collapsed');
                    const isNowCollapsed = announcementBar.classList.contains('collapsed');
                    localStorage.setItem('announcementCollapsed', isNowCollapsed);

                    if (isNowCollapsed) {
                        announcementToggle.innerHTML = '<i class="fas fa-chevron-down"></i>';
                        document.body.classList.remove('announcement-active');
                        console.log('Announcement collapsed');
                    } else {
                        announcementToggle.innerHTML = '<i class="fas fa-chevron-up"></i>';
                        document.body.classList.add('announcement-active');
                        console.log('Announcement expanded');
                    }
                });

                // Close button functionality - FIXED
                document.querySelectorAll('.announcement-close').forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        console.log('Close button clicked');

                        const id = this.dataset.id;
                        const announcementItem = this.closest('.announcement-item');

                        if (id) {
                            const closedAnnouncements = JSON.parse(localStorage.getItem('closedAnnouncements') || '[]');
                            if (!closedAnnouncements.includes(id)) {
                                closedAnnouncements.push(id);
                                localStorage.setItem('closedAnnouncements', JSON.stringify(closedAnnouncements));
                                console.log('Saved closed announcement id:', id);
                            }
                        }

                        // Hide the specific announcement item
                        announcementItem.style.display = 'none';
                        console.log('Hiding announcement item');

                        // Check if all items are now hidden
                        const remainingItems = Array.from(document.querySelectorAll('.announcement-item')).filter(
                            item => item.style.display !== 'none' && getComputedStyle(item).display !== 'none'
                        );

                        console.log('Remaining items after close:', remainingItems.length);

                        if (remainingItems.length === 0) {
                            announcementBar.style.display = 'none';
                            document.body.classList.remove('announcement-active');
                            console.log('All announcements closed, hiding bar');
                        }
                    });
                });
            }

            // Theme Toggle - COMPLETELY FIXED VERSION
            const themeToggle = document.getElementById('themeToggle');

            if (themeToggle) {
                console.log('Theme toggle button found, initializing...');

                // Initialize theme
                const savedTheme = localStorage.getItem('theme') || 'light';
                document.documentElement.setAttribute('data-theme', savedTheme);
                console.log('Initial theme set to:', savedTheme);

                // Remove all existing event listeners by replacing the button
                const newButton = themeToggle.cloneNode(true);
                themeToggle.parentNode.replaceChild(newButton, themeToggle);

                // Get fresh reference
                const freshToggle = document.getElementById('themeToggle');

                // Add click event listener
                freshToggle.addEventListener('click', function handleThemeClick(e) {
                    console.log('Theme button clicked!');
                    e.preventDefault();
                    e.stopPropagation();

                    const currentTheme = document.documentElement.getAttribute('data-theme');
                    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

                    console.log('Changing theme from', currentTheme, 'to', newTheme);

                    // Apply theme change
                    document.documentElement.setAttribute('data-theme', newTheme);
                    localStorage.setItem('theme', newTheme);

                    // Force a reflow to ensure theme change is applied
                    document.body.offsetHeight;

                    // Update button state for immediate feedback
                    freshToggle.style.transform = 'rotate(180deg)';
                    setTimeout(() => {
                        freshToggle.style.transform = '';
                    }, 300);
                }, {
                    capture: true
                }); // Use capturing phase

                // Also add as direct onclick handler as backup
                freshToggle.onclick = function(e) {
                    console.log('Direct onclick handler triggered');
                    e.preventDefault();
                    e.stopPropagation();

                    const currentTheme = document.documentElement.getAttribute('data-theme');
                    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

                    document.documentElement.setAttribute('data-theme', newTheme);
                    localStorage.setItem('theme', newTheme);

                    return false;
                };
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

            // User dropdown
            const userDropdown = document.querySelector('.user-dropdown .dropdown-toggle');
            if (userDropdown) {
                userDropdown.addEventListener('click', function(e) {
                    e.preventDefault();
                    this.nextElementSibling.classList.toggle('show');
                });

                document.addEventListener('click', function(e) {
                    if (!e.target.closest('.user-dropdown')) {
                        document.querySelectorAll('.user-menu').forEach(menu => {
                            menu.classList.remove('show');
                        });
                    }
                });
            }

            // WhatsApp Notification
            const whatsappFloat = document.querySelector('.whatsapp-float');
            const whatsappNotification = document.getElementById('whatsappNotification');

            if (whatsappFloat && whatsappNotification) {
                let notificationShown = localStorage.getItem('whatsappNotificationShown') === 'true';

                // Show notification bubble on first visit with delay
                if (!notificationShown) {
                    setTimeout(() => {
                        whatsappNotification.classList.add('show');
                        localStorage.setItem('whatsappNotificationShown', 'true');

                        // Auto hide after 5 seconds
                        setTimeout(() => {
                            whatsappNotification.classList.remove('show');
                        }, 5000);
                    }, 3000);
                }

                // Hide notification when clicked
                whatsappFloat.addEventListener('click', () => {
                    whatsappNotification.classList.remove('show');
                });

                // Show/hide text on hover
                whatsappFloat.addEventListener('mouseenter', () => {
                    whatsappFloat.classList.add('hover');
                });

                whatsappFloat.addEventListener('mouseleave', () => {
                    whatsappFloat.classList.remove('hover');
                });

                // Add pulse animation periodically
                setInterval(() => {
                    whatsappFloat.classList.add('pulse');
                    setTimeout(() => {
                        whatsappFloat.classList.remove('pulse');
                    }, 1000);
                }, 10000); // Pulse every 10 seconds
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

            // Sticky header on scroll
            window.addEventListener('scroll', function() {
                const header = document.getElementById('mainHeader');
                if (window.pageYOffset > 50) {
                    header.classList.add('scrolled');
                } else {
                    header.classList.remove('scrolled');
                }
            });

            // Dropdown menus on mobile
            document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
                toggle.addEventListener('click', function(e) {
                    if (window.innerWidth <= 992) {
                        e.preventDefault();
                        const dropdown = this.nextElementSibling;
                        dropdown.classList.toggle('show');
                    }
                });
            });

            // Initialize body padding based on announcement
            setTimeout(() => {
                if (announcementBar && !announcementBar.classList.contains('collapsed') && announcementBar.offsetHeight > 0) {
                    document.body.classList.add('announcement-active');
                    console.log('Body announcement-active class added on init');
                }
            }, 100);
        });

        // Loading overlay functions
        window.showLoading = function() {
            document.getElementById('loadingOverlay').classList.add('active');
        };

        window.hideLoading = function() {
            document.getElementById('loadingOverlay').classList.remove('active');
        };

        // Toast notification function
        window.showToast = function(message, type = 'success') {
            const toastContainer = document.getElementById('toastContainer');
            if (!toastContainer) return;

            const toast = document.createElement('div');
            toast.className = `toast toast-${type} animate__animated animate__fadeInRight`;
            toast.innerHTML = `
            <div class="toast-content">
                <div class="toast-icon">
                    <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
                </div>
                <div class="toast-body">
                    <span class="toast-message">${message}</span>
                </div>
            </div>
            <button class="toast-close">
                <i class="fas fa-times"></i>
            </button>
        `;

            toastContainer.appendChild(toast);

            setTimeout(() => {
                toast.classList.add('show');
            }, 10);

            const autoRemove = setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }, 5000);

            toast.querySelector('.toast-close').addEventListener('click', () => {
                clearTimeout(autoRemove);
                toast.classList.remove('show');
                setTimeout(() => {
                    toast.remove();
                }, 300);
            });
        };

        // Add to cart functionality
        window.addToCart = async function(productId, quantity = 1) {
            showLoading();

            try {
                const response = await fetch('{{ route("cart.add") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: quantity
                    })
                });

                const data = await response.json();

                if (data.success) {
                    // Update cart count
                    document.querySelectorAll('.cart-btn .badge').forEach(element => {
                        element.textContent = data.cart_count;
                        element.style.display = data.cart_count > 0 ? 'flex' : 'none';
                    });

                    showToast('Product added to cart!', 'success');

                    // Add animation to cart icon
                    const cartBtn = document.querySelector('.cart-btn');
                    cartBtn.classList.add('animate__animated', 'animate__tada');
                    setTimeout(() => {
                        cartBtn.classList.remove('animate__animated', 'animate__tada');
                    }, 1000);

                    return true;
                } else {
                    showToast(data.message || 'Failed to add to cart', 'error');
                    return false;
                }
            } catch (error) {
                console.error('Error adding to cart:', error);
                showToast('Network error. Please try again.', 'error');
                return false;
            } finally {
                hideLoading();
            }
        };
    </script>
</body>

</html>