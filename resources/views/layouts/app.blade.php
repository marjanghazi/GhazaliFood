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

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

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
        <div class="announcement-bar-wrapper" id="announcementBar">
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

    <!-- Theme Controls -->
    <div class="theme-controls">
        <button class="theme-switcher" id="themeToggle" aria-label="Toggle theme">
            <span class="theme-icon">
                <i class="fas fa-sun"></i>
                <i class="fas fa-moon"></i>
            </span>
        </button>
    </div>

    <!-- Main Header -->
    <header class="header" id="mainHeader">
        <div class="container">
            <nav class="navbar">
                <!-- Mobile Toggle -->
                <button class="mobile-toggle" id="mobileToggle" aria-label="Toggle navigation">
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
                        <span>Nuts & Berries</span>
                        <small>Premium Dry Fruits</small>
                    </div>
                </a>

                <!-- Navigation -->
                <div class="nav-main" id="navMain">
                    <!-- Mobile Close -->
                    <button class="mobile-close" id="mobileClose" aria-label="Close navigation">
                        <i class="fas fa-times"></i>
                    </button>

                    <ul class="nav-links">
                        <li><a href="{{ url('/') }}" class="nav-link {{ request()->is('/') ? 'active' : '' }}">Home</a></li>
                        <li><a href="{{ route('shop.index') }}" class="nav-link {{ request()->is('shop*') ? 'active' : '' }}">Shop</a></li>
                        
                        <!-- Dynamic Categories Dropdown -->
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown">
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
                                    <div class="dropdown-item-group">
                                        <a href="{{ route('shop.index', ['category' => $category->slug]) }}" 
                                           class="dropdown-item">
                                            {{ $category->name }}
                                            @if($category->children->count() > 0)
                                                <i class="fas fa-chevron-right float-end"></i>
                                            @endif
                                        </a>
                                        @if($category->children->count() > 0)
                                            <div class="dropdown-submenu">
                                                @foreach($category->children as $child)
                                                    <a href="{{ route('shop.index', ['category' => $child->slug]) }}" 
                                                       class="dropdown-item">
                                                        {{ $child->name }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                                
                                @if($categories->count() > 0)
                                    <div class="dropdown-divider"></div>
                                    <a href="{{ route('categories.index') }}" class="dropdown-item text-center">
                                        View All <i class="fas fa-arrow-right ms-2"></i>
                                    </a>
                                @endif
                            </div>
                        </li>
                        
                        <li><a href="{{ route('blog.index') }}" class="nav-link {{ request()->is('blog*') ? 'active' : '' }}">Blog</a></li>
                        <li><a href="{{ route('about') }}" class="nav-link {{ request()->is('about') ? 'active' : '' }}">About</a></li>
                        <li><a href="{{ route('contact.index') }}" class="nav-link {{ request()->is('contact*') ? 'active' : '' }}">Contact</a></li>
                    </ul>

                    <!-- Search Box -->
                    <div class="search-box">
                        <form action="{{ route('shop.index') }}" method="GET" class="search-form">
                            <input type="text" 
                                   name="search" 
                                   class="search-input" 
                                   placeholder="Search dry fruits..."
                                   value="{{ request('search') }}"
                                   aria-label="Search products">
                            <button type="submit" class="search-btn" aria-label="Search">
                                <i class="fas fa-search"></i>
                            </button>
                            <button type="button" class="search-clear" aria-label="Clear search">
                                <i class="fas fa-times"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="nav-actions">
                    <!-- Search Toggle for Mobile -->
                    <button class="search-toggle d-md-none" id="searchToggle" aria-label="Toggle search">
                        <i class="fas fa-search"></i>
                    </button>

                    <!-- Wishlist -->
                    @auth
                        <a href="{{ route('wishlist') }}" class="nav-action-btn" aria-label="Wishlist">
                            <i class="fas fa-heart"></i>
                            @php
                                $wishlistCount = App\Models\Wishlist::getCount();
                            @endphp
                            @if($wishlistCount > 0)
                                <span class="badge-count">{{ $wishlistCount }}</span>
                            @endif
                        </a>
                    @endauth

                    <!-- Cart -->
                    <a href="{{ route('cart.index') }}" class="nav-action-btn cart-btn" aria-label="Shopping cart">
                        <i class="fas fa-shopping-cart"></i>
                        @php
                            $cartCount = \App\Helpers\CartHelper::getCount();
                        @endphp
                        @if($cartCount > 0)
                            <span class="badge-count">{{ $cartCount }}</span>
                        @endif
                    </a>

                    <!-- User Menu -->
                    @auth
                        <div class="dropdown user-dropdown">
                            <button class="nav-action-btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fas fa-user-cog me-2"></i>Profile</a></li>
                                <li><a class="dropdown-item" href="{{ route('orders.index') }}"><i class="fas fa-history me-2"></i>Orders</a></li>
                                <li><a class="dropdown-item" href="{{ route('wishlist') }}"><i class="fas fa-heart me-2"></i>Wishlist</a></li>
                                @if(Auth::user()->isAdmin())
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="fas fa-cog me-2"></i>Dashboard</a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="nav-action-btn" aria-label="Login">
                            <i class="fas fa-user"></i>
                        </a>
                    @endauth
                </div>
            </nav>
        </div>
    </header>

    <!-- Mobile Search Overlay -->
    <div class="mobile-search-overlay" id="mobileSearchOverlay">
        <div class="container">
            <form action="{{ route('shop.index') }}" method="GET" class="mobile-search-form">
                <input type="text" 
                       name="search" 
                       class="form-control" 
                       placeholder="Search almonds, cashews, raisins..."
                       autofocus
                       aria-label="Mobile search">
                <button type="submit" class="search-submit" aria-label="Search">
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
    <footer class="footer">
        <div class="container">
            <div class="row g-4">
                <!-- Company Info -->
                <div class="col-lg-4 col-md-6">
                    <div class="footer-section">
                        <a href="{{ url('/') }}" class="logo mb-3">
                            <div class="logo-icon">
                                <i class="fas fa-seedling"></i>
                            </div>
                            <div class="logo-text">
                                <span>Nuts & Berries</span>
                                <small>Premium Dry Fruits</small>
                            </div>
                        </a>
                        <p class="text-muted">Premium quality dry fruits, nuts, and berries. 100% natural, organic, and sourced from the finest orchards worldwide.</p>
                        <div class="social-links mt-3">
                            <a href="#" class="social-link" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="social-link" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="social-link" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="social-link" aria-label="Pinterest"><i class="fab fa-pinterest"></i></a>
                            <a href="#" class="social-link" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-lg-2 col-md-6">
                    <div class="footer-section">
                        <h5>Quick Links</h5>
                        <ul class="footer-links">
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <li><a href="{{ route('shop.index') }}">Shop All</a></li>
                            <li><a href="{{ route('shop.index', ['new_arrival' => true]) }}">New Arrivals</a></li>
                            <li><a href="{{ route('shop.index', ['featured' => true]) }}">Featured</a></li>
                            <li><a href="{{ route('shop.index', ['sale' => true]) }}">On Sale</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Categories -->
                <div class="col-lg-2 col-md-6">
                    <div class="footer-section">
                        <h5>Categories</h5>
                        <ul class="footer-links">
                            @php
                                $footerCategories = App\Models\Category::whereNull('parent_id')
                                    ->active()
                                    ->orderBy('display_order')
                                    ->limit(6)
                                    ->get();
                            @endphp
                            @foreach($footerCategories as $category)
                                <li><a href="{{ route('shop.index', ['category' => $category->slug]) }}">{{ $category->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Contact & Newsletter -->
                <div class="col-lg-4 col-md-6">
                    <div class="footer-section">
                        <h5>Stay Connected</h5>
                        <p class="text-muted mb-3">Subscribe for exclusive offers and updates</p>
                        
                        <form class="newsletter-form mb-4">
                            <div class="input-group">
                                <input type="email" 
                                       class="form-control" 
                                       placeholder="Your email address"
                                       required
                                       aria-label="Email for newsletter">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </div>
                        </form>

                        <div class="contact-info">
                            <p class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> 123 Nut Street, Dry Fruits City</p>
                            <p class="mb-2"><i class="fas fa-phone me-2"></i> +1 (555) 123-4567</p>
                            <p class="mb-0"><i class="fas fa-envelope me-2"></i> info@nutsandberries.com</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer-bottom mt-5 pt-4 border-top">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <p class="mb-0 text-muted">&copy; {{ date('Y') }} Nuts & Berries. All rights reserved.</p>
                    </div>
                    <div class="col-md-6">
                        <div class="payment-methods text-md-end">
                            <i class="fab fa-cc-visa me-2" aria-label="Visa"></i>
                            <i class="fab fa-cc-mastercard me-2" aria-label="Mastercard"></i>
                            <i class="fab fa-cc-amex me-2" aria-label="American Express"></i>
                            <i class="fab fa-cc-paypal me-2" aria-label="PayPal"></i>
                            <i class="fab fa-cc-apple-pay" aria-label="Apple Pay"></i>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="footer-links-bottom">
                            <a href="{{ route('policies.privacy') }}" class="text-muted me-3">Privacy Policy</a>
                            <a href="{{ route('policies.terms') }}" class="text-muted me-3">Terms of Service</a>
                            <a href="{{ route('policies.shipping') }}" class="text-muted me-3">Shipping Policy</a>
                            <a href="{{ route('policies.refund') }}" class="text-muted">Refund Policy</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button class="back-to-top" id="backToTop" aria-label="Back to top">
        <i class="fas fa-chevron-up"></i>
    </button>

    <!-- Toast Container -->
    <div class="toast-container position-fixed top-0 end-0 p-3" id="toastContainer"></div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JS -->
    <script src="{{ asset('js/main.js') }}"></script>

    @stack('scripts')

    <script>
        // Announcement Bar
        const announcementBar = document.getElementById('announcementBar');
        const announcementToggle = document.getElementById('announcementToggle');
        
        if (announcementBar && announcementToggle) {
            // Check localStorage for collapsed state
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
            
            // Handle close buttons for individual announcements
            document.querySelectorAll('.announcement-close').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.dataset.id;
                    if (id) {
                        // Store in localStorage that this announcement is closed
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
        document.getElementById('mobileToggle').addEventListener('click', function() {
            document.getElementById('navMain').classList.add('active');
            document.body.style.overflow = 'hidden';
        });

        document.getElementById('mobileClose').addEventListener('click', function() {
            document.getElementById('navMain').classList.remove('active');
            document.body.style.overflow = '';
        });

        // Mobile Search
        document.getElementById('searchToggle')?.addEventListener('click', function() {
            document.getElementById('mobileSearchOverlay').classList.add('active');
        });

        document.getElementById('mobileSearchClose')?.addEventListener('click', function() {
            document.getElementById('mobileSearchOverlay').classList.remove('active');
        });

        // Clear search input
        document.querySelectorAll('.search-clear').forEach(button => {
            button.addEventListener('click', function() {
                const searchInput = this.closest('.search-form').querySelector('.search-input');
                searchInput.value = '';
                searchInput.focus();
            });
        });

        // Back to Top
        const backToTop = document.getElementById('backToTop');
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTop.classList.add('visible');
            } else {
                backToTop.classList.remove('visible');
            }
        });

        backToTop.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            if (!event.target.matches('.dropdown-toggle')) {
                document.querySelectorAll('.dropdown-menu').forEach(menu => {
                    menu.classList.remove('show');
                });
            }
        });

        // Theme Toggle
        const themeToggle = document.getElementById('themeToggle');
        const currentTheme = localStorage.getItem('theme') || 'light';
        
        document.documentElement.setAttribute('data-theme', currentTheme);
        
        themeToggle.addEventListener('click', function() {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
        });
    </script>
</body>
</html>