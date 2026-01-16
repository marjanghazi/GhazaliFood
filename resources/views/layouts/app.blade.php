<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Ghazali Food - Premium Quality Food Products')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">

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
    @if(config('announcement.enabled'))
    <div class="announcement-bar bg-warning text-dark py-2">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <p class="mb-0 text-center flex-grow-1">
                    <i class="fas fa-gift me-2"></i>Free shipping on orders over $50! Use code: GHAZALI10
                </p>
                <button class="btn btn-sm btn-outline-dark announcement-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand fw-bold fs-3 text-success" href="{{ url('/') }}">
                <i class="fas fa-utensils me-2"></i>Ghazali Food
            </a>

            <!-- Mobile Toggle -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navigation Links -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">
                            <i class="fas fa-home me-1"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('shop*') ? 'active' : '' }}" href="{{ route('shop.index') }}">
                            <i class="fas fa-store me-1"></i> Shop
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('blog*') ? 'active' : '' }}" href="{{ route('blog.index') }}">
                            <i class="fas fa-blog me-1"></i> Blog
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('about') ? 'active' : '' }}" href="{{ route('about') }}">
                            <i class="fas fa-info-circle me-1"></i> About Us
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('contact*') ? 'active' : '' }}" href="{{ route('contact.index') }}">
                            <i class="fas fa-phone-alt me-1"></i> Contact Us
                        </a>
                    </li>
                </ul>

                <!-- Right Side Actions -->
                <div class="d-flex align-items-center">
                    @auth
                    <!-- User Dropdown -->
                    <div class="dropdown">
                        <button class="btn btn-outline-success dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user me-1"></i> {{ Auth::user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            @if(Auth::user()->isAdmin())
                            <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                    <i class="fas fa-tachometer-alt me-2"></i>Admin Dashboard
                                </a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            @endif
                            <li><a class="dropdown-item" href="{{ route('wishlist') }}">
                                    <i class="fas fa-heart me-2"></i>Wishlist
                                </a></li>
                            <li><a class="dropdown-item" href="{{ route('cart') }}">
                                    <i class="fas fa-shopping-cart me-2"></i>Cart
                                </a></li>
                            <li><a class="dropdown-item" href="#">
                                    <i class="fas fa-history me-2"></i>Order History
                                </a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                    @else
                    <!-- Login/Register Buttons -->
                    <a href="{{ route('login') }}" class="btn btn-outline-success me-2">
                        <i class="fas fa-sign-in-alt me-1"></i> Login
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-success">
                        <i class="fas fa-user-plus me-1"></i> Register
                    </a>
                    @endauth

                    <!-- Cart Icon -->
                    <a href="{{ route('cart') }}" class="btn btn-outline-dark position-relative ms-3">
                        <i class="fas fa-shopping-cart"></i>
                        @php
                        $cartCount = count(Session::get('cart', []));
                        @endphp
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger cart-count">
                            {{ $cartCount }}
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('hero')
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white pt-5 pb-4">
        <div class="container">
            <div class="row">
                <!-- Company Info -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-utensils me-2"></i>Ghazali Food
                    </h5>
                    <p class="text-light">
                        Premium quality food products sourced directly from trusted suppliers.
                        We deliver freshness and quality right to your doorstep.
                    </p>
                    <div class="social-icons">
                        <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5 class="fw-bold mb-3">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ url('/') }}" class="text-light text-decoration-none">Home</a></li>
                        <li class="mb-2"><a href="{{ route('shop.index') }}" class="text-light text-decoration-none">Shop</a></li>
                        <li class="mb-2"><a href="{{ route('blog.index') }}" class="text-light text-decoration-none">Blog</a></li>
                        <li class="mb-2"><a href="{{ route('about') }}" class="text-light text-decoration-none">About Us</a></li>
                        <li class="mb-2"><a href="{{ route('contact.index') }}" class="text-light text-decoration-none">Contact</a></li>
                    </ul>
                </div>

                <!-- Categories -->
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5 class="fw-bold mb-3">Categories</h5>
                    <ul class="list-unstyled">
                        @foreach(App\Models\Category::where('status', 'active')->limit(5)->get() as $category)
                        <li class="mb-2">
                            <a href="{{ route('shop.index', ['category' => $category->slug]) }}"
                                class="text-light text-decoration-none">
                                {{ $category->name }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <h5 class="fw-bold mb-3">Contact Us</h5>
                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            123 Food Street, Culinary City, CC 12345
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-phone me-2"></i>
                            +1 (234) 567-8900
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-envelope me-2"></i>
                            info@ghazalifood.com
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-clock me-2"></i>
                            Mon - Fri: 9:00 AM - 8:00 PM
                        </li>
                    </ul>
                </div>
            </div>

            <hr class="bg-light">

            <!-- Copyright -->
            <div class="row pt-3">
                <div class="col-md-6">
                    <p class="mb-0">
                        &copy; {{ date('Y') }} Ghazali Food. All rights reserved.
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="#" class="text-light me-3 text-decoration-none">Privacy Policy</a>
                    <a href="#" class="text-light me-3 text-decoration-none">Terms of Service</a>
                    <a href="#" class="text-light text-decoration-none">Shipping Policy</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Custom JS -->
    <script src="{{ asset('js/script.js') }}"></script>

    @stack('scripts')

    <script>
        // Announcement bar close functionality
        $(document).ready(function() {
            $('.announcement-close').click(function() {
                $('.announcement-bar').slideUp();
            });

            // Add to cart functionality
            $('.add-to-cart').click(function(e) {
                e.preventDefault();
                const productId = $(this).data('id');
                const productName = $(this).data('name');

                $.ajax({
                    url: '{{ route("cart.add") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        product_id: productId,
                        quantity: 1
                    },
                    success: function(response) {
                        // Update cart count
                        $('.cart-count').text(response.cart_count);

                        // Show success message
                        showToast('Success', productName + ' added to cart!', 'success');
                    },
                    error: function(xhr) {
                        showToast('Error', 'Failed to add item to cart', 'error');
                    }
                });
            });

            // Add to wishlist
            $('.add-to-wishlist').click(function(e) {
                e.preventDefault();
                const productId = $(this).data('id');

                $.ajax({
                    url: '{{ route("wishlist.add") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        product_id: productId
                    },
                    success: function(response) {
                        showToast('Success', 'Added to wishlist!', 'success');
                    }
                });
            });

            function showToast(title, message, type) {
                // Create toast element
                const toast = $(`
                    <div class="toast align-items-center text-white bg-${type} border-0 position-fixed bottom-0 end-0 m-3" role="alert">
                        <div class="d-flex">
                            <div class="toast-body">
                                <strong>${title}:</strong> ${message}
                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                        </div>
                    </div>
                `);

                $('body').append(toast);
                const bsToast = new bootstrap.Toast(toast[0]);
                bsToast.show();

                // Remove toast after hiding
                toast.on('hidden.bs.toast', function() {
                    $(this).remove();
                });
            }
        });
    </script>
</body>

</html>