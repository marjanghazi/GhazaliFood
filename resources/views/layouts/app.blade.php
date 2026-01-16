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
    <div class="header-top">
        <div class="container">
            <div class="header-top-content">
                <div class="announcement-bar">
                    <p><i class="fas fa-gift me-1"></i> Free Shipping on Orders Over $50</p>
                    <span class="badge bg-success">NEW</span>
                </div>
                <div class="header-actions">
                    <div class="currency-selector">
                        <select class="form-select form-select-sm" aria-label="Currency selector">
                            <option value="USD">USD $</option>
                            <option value="EUR">EUR €</option>
                            <option value="GBP">GBP £</option>
                        </select>
                    </div>
                    <button class="theme-switcher" id="themeToggle" aria-label="Toggle theme">
                        <i class="fas fa-sun"></i>
                    </button>
                    @auth
                    <a href="{{ route('profile.edit') }}" class="text-white text-decoration-none">
                        <i class="fas fa-user me-1"></i> {{ Str::limit(Auth::user()->name, 15) }}
                    </a>
                    @else
                    <a href="{{ route('login') }}" class="text-white text-decoration-none">
                        <i class="fas fa-sign-in-alt me-1"></i> Login
                    </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <header class="header" id="mainHeader">
        <div class="container">
            <nav class="navbar">
                <div class="navbar-content">
                    <!-- Logo -->
                    <a href="{{ url('/') }}" class="logo">
                        <div class="logo-icon">
                            <i class="fas fa-seedling"></i>
                        </div>
                        <div>
                            <div class="logo-text">Nuts & Berries</div>
                            <div class="logo-tagline">Premium Dry Fruits</div>
                        </div>
                    </a>

                    <!-- Mobile Toggle -->
                    <button class="mobile-toggle" id="mobileToggle" aria-label="Toggle navigation">
                        <i class="fas fa-bars"></i>
                    </button>

                    <!-- Navigation -->
                    <div class="nav-main" id="navMain">
                        <button class="mobile-close" id="mobileClose" aria-label="Close navigation">
                            <i class="fas fa-times"></i>
                        </button>

                        <ul class="nav-links">
                            <li><a href="{{ url('/') }}" class="nav-link {{ request()->is('/') ? 'active' : '' }}">Home</a></li>
                            <li><a href="{{ route('shop.index') }}" class="nav-link {{ request()->is('shop*') ? 'active' : '' }}">Shop</a></li>

                            <!-- Dynamic Categories Dropdown -->
                            <li class="dropdown">
                                <a href="#" class="nav-link dropdown-toggle {{ request()->is('categories*') ? 'active' : '' }}">
                                    Categories <i class="fas fa-chevron-down ms-1"></i>
                                </a>
                                <div class="dropdown-menu">
                                    @php
                                    $categories = App\Models\Category::with(['children' => function($query) {
                                    $query->active()->orderBy('display_order');
                                    }])->whereNull('parent_id')
                                    ->active()
                                    ->orderBy('display_order')
                                    ->limit(10)
                                    ->get();
                                    @endphp

                                    @foreach($categories as $category)
                                    <div class="dropdown-item-group">
                                        <a href="{{ route('shop.index', ['category' => $category->slug]) }}"
                                            class="dropdown-item dropdown-parent">
                                            {{ $category->name }}
                                            @if($category->children->count() > 0)
                                            <i class="fas fa-chevron-right ms-2"></i>
                                            @endif
                                        </a>
                                        @if($category->children->count() > 0)
                                        <div class="dropdown-submenu">
                                            @foreach($category->children as $child)
                                            <a href="{{ route('shop.index', ['category' => $child->slug]) }}"
                                                class="dropdown-item dropdown-child">
                                                {{ $child->name }}
                                            </a>
                                            @endforeach
                                        </div>
                                        @endif
                                    </div>
                                    @endforeach

                                    @if($categories->count() > 10)
                                    <div class="dropdown-divider"></div>
                                    <a href="{{ route('categories.index') }}" class="dropdown-item text-center">
                                        View All Categories <i class="fas fa-arrow-right ms-2"></i>
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
                        <a href="{{ url('/cart') }}" class="nav-action-btn cart-btn" aria-label="Shopping cart">
                            <i class="fas fa-shopping-cart"></i>
                            @php
                            $cart = session()->get('cart', []);
                            $cartCount = array_sum(array_column($cart, 'quantity'));
                            @endphp
                            @if($cartCount > 0)
                            <span class="cart-count">{{ $cartCount }}</span>
                            @endif
                        </a>

                        <!-- User Menu for Desktop -->
                        @auth
                        <div class="dropdown user-dropdown d-none d-md-block">
                            <button class="nav-action-btn dropdown-toggle"
                                type="button"
                                id="userDropdown"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                                aria-label="User menu">
                                <i class="fas fa-user"></i>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fas fa-user-cog me-2"></i>Profile</a></li>
                                <li><a class="dropdown-item" href="{{ route('orders.index') }}"><i class="fas fa-history me-2"></i>Orders</a></li>
                                <li><a class="dropdown-item" href="{{ route('wishlist') }}"><i class="fas fa-heart me-2"></i>Wishlist</a></li>
                                @if(Auth::user()->isAdmin())
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="fas fa-cog me-2"></i>Dashboard</a></li>
                                @endif
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
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
                        @endauth
                    </div>
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
                    placeholder="Search for almonds, cashews, raisins..."
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
            <div class="footer-grid">
                <!-- Company Info -->
                <div class="footer-logo">
                    <a href="{{ url('/') }}" class="logo">
                        <div class="logo-icon">
                            <i class="fas fa-seedling"></i>
                        </div>
                        <div>
                            <div class="logo-text">Nuts & Berries</div>
                            <div class="logo-tagline">Premium Dry Fruits</div>
                        </div>
                    </a>
                    <p class="text-muted">Premium quality dry fruits, nuts, and berries. 100% natural, organic, and sourced from the finest orchards worldwide.</p>
                    <div class="social-links">
                        <a href="#" class="social-link" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-link" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-link" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-link" aria-label="Pinterest"><i class="fab fa-pinterest"></i></a>
                        <a href="#" class="social-link" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="footer-links">
                    <h5>Quick Links</h5>
                    <ul>
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><a href="{{ route('shop.index') }}">Shop All</a></li>
                        <li><a href="{{ route('shop.index', ['new_arrival' => true]) }}">New Arrivals</a></li>
                        <li><a href="{{ route('shop.index', ['featured' => true]) }}">Featured Products</a></li>
                        <li><a href="{{ route('shop.index', ['sale' => true]) }}">On Sale</a></li>
                    </ul>
                </div>

                <!-- Categories -->
                <div class="footer-links">
                    <h5>Categories</h5>
                    <ul>
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

                <!-- Contact & Newsletter -->
                <div class="footer-contact">
                    <h5>Stay Connected</h5>
                    <p class="text-muted mb-4">Subscribe to our newsletter for exclusive offers and updates</p>

                    <form class="newsletter-form">
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

                    <div class="contact-info mt-4">
                        <p class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> 123 Nut Street, Dry Fruits City</p>
                        <p class="mb-2"><i class="fas fa-phone me-2"></i> +1 (555) 123-4567</p>
                        <p class="mb-0"><i class="fas fa-envelope me-2"></i> info@nutsandberries.com</p>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <p class="mb-0">&copy; {{ date('Y') }} Nuts & Berries. All rights reserved.</p>
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

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-3">Loading...</p>
        </div>
    </div>

    <!-- Toast Container -->
    <div class="toast-container position-fixed top-0 end-0 p-3" id="toastContainer"></div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JavaScript -->
    <script src="{{ asset('js/main.js') }}"></script>

    @stack('scripts')

    <script>
        // Initialize theme from localStorage or system preference
        function initializeTheme() {
            const savedTheme = localStorage.getItem('theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

            if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
                document.documentElement.setAttribute('data-theme', 'dark');
                document.getElementById('themeToggle').innerHTML = '<i class="fas fa-moon"></i>';
            } else {
                document.documentElement.setAttribute('data-theme', 'light');
                document.getElementById('themeToggle').innerHTML = '<i class="fas fa-sun"></i>';
            }
        }

        // Toggle theme
        document.getElementById('themeToggle').addEventListener('click', function() {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);

            this.innerHTML = newTheme === 'dark' ? '<i class="fas fa-moon"></i>' : '<i class="fas fa-sun"></i>';

            // Dispatch theme change event
            document.dispatchEvent(new CustomEvent('themeChanged', {
                detail: {
                    theme: newTheme
                }
            }));
        });

        // Mobile navigation toggle
        document.getElementById('mobileToggle').addEventListener('click', function() {
            document.getElementById('navMain').classList.add('active');
            document.body.style.overflow = 'hidden';
        });

        document.getElementById('mobileClose').addEventListener('click', function() {
            document.getElementById('navMain').classList.remove('active');
            document.body.style.overflow = '';
        });

        // Mobile search toggle
        document.getElementById('searchToggle').addEventListener('click', function() {
            document.getElementById('mobileSearchOverlay').classList.add('active');
        });

        document.getElementById('mobileSearchClose').addEventListener('click', function() {
            document.getElementById('mobileSearchOverlay').classList.remove('active');
        });

        // Back to top button
        const backToTopButton = document.getElementById('backToTop');

        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.add('visible');
            } else {
                backToTopButton.classList.remove('visible');
            }
        });

        backToTopButton.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            initializeTheme();

            // Close mobile menu when clicking outside
            document.addEventListener('click', function(event) {
                const navMain = document.getElementById('navMain');
                const mobileToggle = document.getElementById('mobileToggle');

                if (navMain.classList.contains('active') &&
                    !navMain.contains(event.target) &&
                    !mobileToggle.contains(event.target)) {
                    navMain.classList.remove('active');
                    document.body.style.overflow = '';
                }
            });

            // Handle dropdown clicks on mobile
            document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
                toggle.addEventListener('click', function(e) {
                    if (window.innerWidth < 992) {
                        e.preventDefault();
                        const dropdown = this.closest('.dropdown');
                        dropdown.classList.toggle('open');
                    }
                });
            });

            // Add to cart functionality
            document.querySelectorAll('.add-to-cart-btn').forEach(button => {
                button.addEventListener('click', async function(e) {
                    e.preventDefault();

                    const productId = this.dataset.productId;
                    const quantity = this.dataset.quantity || 1;

                    // Show loading state
                    const originalHtml = this.innerHTML;
                    this.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                    this.disabled = true;

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
                            document.querySelectorAll('.cart-count').forEach(element => {
                                element.textContent = data.cart_count;
                                element.style.display = data.cart_count > 0 ? 'flex' : 'none';
                            });

                            // Show success toast
                            showToast('Product added to cart!', 'success');
                        } else {
                            showToast(data.message || 'Failed to add to cart', 'error');
                        }
                    } catch (error) {
                        console.error('Error adding to cart:', error);
                        showToast('Network error. Please try again.', 'error');
                    } finally {
                        // Reset button state
                        this.innerHTML = originalHtml;
                        this.disabled = false;
                    }
                });
            });

            // Wishlist toggle functionality
            document.querySelectorAll('.wishlist-toggle-btn').forEach(button => {
                button.addEventListener('click', async function(e) {
                    e.preventDefault();

                    const productId = this.dataset.productId;

                    try {
                        const response = await fetch('{{ route("wishlist.toggle") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                product_id: productId
                            })
                        });

                        const data = await response.json();

                        if (data.success) {
                            // Update wishlist count
                            if (data.wishlist_count !== undefined) {
                                document.querySelectorAll('.badge-count').forEach(element => {
                                    element.textContent = data.wishlist_count;
                                    element.style.display = data.wishlist_count > 0 ? 'inline' : 'none';
                                });
                            }

                            // Update button icon
                            const icon = this.querySelector('i');
                            if (data.in_wishlist) {
                                icon.classList.remove('far');
                                icon.classList.add('fas', 'text-danger');
                            } else {
                                icon.classList.remove('fas', 'text-danger');
                                icon.classList.add('far');
                            }

                            showToast(data.message, data.in_wishlist ? 'success' : 'info');
                        }
                    } catch (error) {
                        console.error('Error toggling wishlist:', error);
                        showToast('Network error. Please try again.', 'error');
                    }
                });
            });
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 992) {
                document.getElementById('navMain').classList.remove('active');
                document.body.style.overflow = '';
            }
        });

        // Toast notification function
        function showToast(message, type = 'info') {
            const toast = document.createElement('div');
            toast.className = `toast show align-items-center text-white bg-${type === 'error' ? 'danger' : type} border-0`;
            toast.setAttribute('role', 'alert');
            toast.setAttribute('aria-live', 'assertive');
            toast.setAttribute('aria-atomic', 'true');

            toast.innerHTML = `
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas ${getToastIcon(type)} me-2"></i>
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            `;

            const container = document.getElementById('toastContainer');
            container.appendChild(toast);

            const bsToast = new bootstrap.Toast(toast, {
                delay: 3000
            });
            bsToast.show();

            toast.addEventListener('hidden.bs.toast', () => {
                toast.remove();
            });
        }

        function getToastIcon(type) {
            switch (type) {
                case 'success':
                    return 'fa-check-circle';
                case 'error':
                    return 'fa-exclamation-circle';
                case 'warning':
                    return 'fa-exclamation-triangle';
                default:
                    return 'fa-info-circle';
            }
        }
    </script>
</body>

</html>