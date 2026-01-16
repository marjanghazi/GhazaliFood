@extends('layouts.app')

@section('title', 'About Us - Ghazali Food')

@section('hero')
<!-- About Hero -->
<section class="hero-section" style="background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?ixlib=rb-4.0.3') center/cover no-repeat;">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="animate__animated animate__fadeInUp">About Ghazali Food</h1>
                <p class="lead animate__animated animate__fadeInUp animate__delay-1s">
                    Quality food products since 2010
                </p>
                <nav aria-label="breadcrumb" class="d-flex justify-content-center">
                    <ol class="breadcrumb bg-transparent p-0 animate__animated animate__fadeInUp animate__delay-2s">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">About Us</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
@endsection

@section('content')
<!-- Our Story -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <img src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?ixlib=rb-4.0.3" 
                     class="img-fluid rounded-3" alt="Our Story">
            </div>
            <div class="col-lg-6">
                <h2 class="fw-bold mb-4">Our Story</h2>
                <p class="lead mb-4">
                    Founded in 2010, Ghazali Food began with a simple mission: to provide 
                    fresh, high-quality food products to our community.
                </p>
                <p class="mb-4">
                    What started as a small family business has grown into a trusted 
                    supplier of premium food products. We work directly with local farmers 
                    and producers to ensure the highest quality and freshness in every product.
                </p>
                <p class="mb-0">
                    Our commitment to quality, sustainability, and customer satisfaction 
                    has been the cornerstone of our success for over a decade.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Mission & Vision -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="text-center p-4 h-100">
                    <div class="icon-box mb-4">
                        <i class="fas fa-bullseye fa-3x text-success"></i>
                    </div>
                    <h3 class="fw-bold mb-3">Our Mission</h3>
                    <p>
                        To provide our customers with the highest quality food products 
                        while supporting sustainable farming practices and local communities.
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="text-center p-4 h-100">
                    <div class="icon-box mb-4">
                        <i class="fas fa-eye fa-3x text-success"></i>
                    </div>
                    <h3 class="fw-bold mb-3">Our Vision</h3>
                    <p>
                        To become the leading provider of premium food products, 
                        recognized for our commitment to quality, innovation, and 
                        customer satisfaction.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Values -->
<section class="py-5">
    <div class="container">
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h2 class="fw-bold mb-3">Our Values</h2>
                <p class="text-muted">The principles that guide everything we do</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="text-center p-4">
                    <div class="value-icon mb-3">
                        <i class="fas fa-leaf fa-2x text-success"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Quality</h5>
                    <p class="text-muted">
                        We never compromise on the quality of our products.
                    </p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="text-center p-4">
                    <div class="value-icon mb-3">
                        <i class="fas fa-handshake fa-2x text-success"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Trust</h5>
                    <p class="text-muted">
                        Building lasting relationships based on trust and reliability.
                    </p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="text-center p-4">
                    <div class="value-icon mb-3">
                        <i class="fas fa-recycle fa-2x text-success"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Sustainability</h5>
                    <p class="text-muted">
                        Committed to environmentally friendly practices.
                    </p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="text-center p-4">
                    <div class="value-icon mb-3">
                        <i class="fas fa-heart fa-2x text-success"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Passion</h5>
                    <p class="text-muted">
                        We're passionate about good food and happy customers.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Team -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h2 class="fw-bold mb-3">Meet Our Team</h2>
                <p class="text-muted">The dedicated people behind Ghazali Food</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="team-card text-center">
                    <img src="https://i.pravatar.cc/150?img=1" class="rounded-circle mb-3" alt="Team Member">
                    <h5 class="fw-bold mb-1">Ahmed Ghazali</h5>
                    <p class="text-muted mb-2">Founder & CEO</p>
                    <div class="social-links">
                        <a href="#" class="text-muted me-2"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="text-muted"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="team-card text-center">
                    <img src="https://i.pravatar.cc/150?img=2" class="rounded-circle mb-3" alt="Team Member">
                    <h5 class="fw-bold mb-1">Sarah Johnson</h5>
                    <p class="text-muted mb-2">Head of Operations</p>
                    <div class="social-links">
                        <a href="#" class="text-muted me-2"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="text-muted"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="team-card text-center">
                    <img src="https://i.pravatar.cc/150?img=3" class="rounded-circle mb-3" alt="Team Member">
                    <h5 class="fw-bold mb-1">Michael Chen</h5>
                    <p class="text-muted mb-2">Quality Manager</p>
                    <div class="social-links">
                        <a href="#" class="text-muted me-2"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="text-muted"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="team-card text-center">
                    <img src="https://i.pravatar.cc/150?img=4" class="rounded-circle mb-3" alt="Team Member">
                    <h5 class="fw-bold mb-1">Emma Davis</h5>
                    <p class="text-muted mb-2">Customer Relations</p>
                    <div class="social-links">
                        <a href="#" class="text-muted me-2"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="text-muted"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats -->
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="text-center">
                    <h2 class="fw-bold text-success display-4">1000+</h2>
                    <p class="text-muted mb-0">Happy Customers</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="text-center">
                    <h2 class="fw-bold text-success display-4">500+</h2>
                    <p class="text-muted mb-0">Products</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="text-center">
                    <h2 class="fw-bold text-success display-4">50+</h2>
                    <p class="text-muted mb-0">Suppliers</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="text-center">
                    <h2 class="fw-bold text-success display-4">10+</h2>
                    <p class="text-muted mb-0">Years Experience</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection