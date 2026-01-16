@extends('layouts.app')

@section('title', 'Set New Password - Ghazali Food')

@section('hero')
<section class="hero-section" style="background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?ixlib=rb-4.0.3') center/cover no-repeat;">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="animate__animated animate__fadeInUp">Set New Password</h1>
                <p class="lead animate__animated animate__fadeInUp animate__delay-1s">
                    Create a new password for your account
                </p>
            </div>
        </div>
    </div>
</section>
@endsection

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm border-0">
                <div class="card-body p-5">
                    <h3 class="text-center mb-4">Create New Password</h3>
                    
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ $email ?? old('email') }}" 
                                   placeholder="Your email address" required autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" 
                                   placeholder="Enter new password" required>
                            <div class="form-text">Must be at least 8 characters long.</div>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="password-confirm" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" 
                                   id="password-confirm" name="password_confirmation" 
                                   placeholder="Confirm your new password" required>
                        </div>
                        
                        <button type="submit" class="btn btn-success btn-lg w-100 mb-3">
                            <i class="fas fa-key me-2"></i> Reset Password
                        </button>
                        
                        <div class="text-center">
                            <a href="{{ route('login') }}" class="text-decoration-none text-success">
                                <i class="fas fa-arrow-left me-1"></i> Back to Login
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection