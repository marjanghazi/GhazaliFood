@extends('layouts.app')

@section('title', 'Contact Us | Ghazali Food | Premium Dry Fruits Store')

@section('hero')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-emerald-50 to-amber-50 dark:from-emerald-900/20 dark:to-amber-900/20 py-16 md:py-24">
    <div class="container mx-auto px-4">
        <div class="flex flex-col lg:flex-row items-center gap-12">
            <div class="lg:w-1/2">
                <div class="animate-slide-up">
                    <div class="inline-flex items-center space-x-2 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 px-4 py-2 rounded-full text-sm font-medium mb-6">
                        <i class="fas fa-headset"></i>
                        <span>24/7 Customer Support</span>
                    </div>

                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 dark:text-white mb-6 leading-tight">
                        Let's Connect &<br>
                        <span class="text-emerald-600 dark:text-emerald-400">Start a Conversation</span>
                    </h1>

                    <p class="text-lg text-gray-600 dark:text-gray-300 mb-8 leading-relaxed max-w-2xl">
                        Have questions about our premium dry fruits? Need assistance with your order?
                        Our dedicated support team is here to provide exceptional service and ensure
                        your complete satisfaction.
                    </p>

                    <div class="flex flex-wrap gap-4">
                        <a href="#contact-form"
                            class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 dark:from-emerald-600 dark:to-emerald-700 dark:hover:from-emerald-700 dark:hover:to-emerald-800 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                            <i class="fas fa-paper-plane mr-3"></i>
                            Send Message
                        </a>

                        <a href="#faq"
                            class="inline-flex items-center justify-center px-8 py-4 bg-white dark:bg-gray-800 border-2 border-emerald-500 dark:border-emerald-400 text-emerald-600 dark:text-emerald-400 font-semibold rounded-xl hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-all duration-300">
                            <i class="fas fa-question-circle mr-3"></i>
                            View FAQs
                        </a>
                    </div>
                </div>
            </div>

            <div class="lg:w-1/2">
                <div class="relative animate-slide-up delay-1">
                    <div class="relative bg-white dark:bg-gray-800 rounded-3xl shadow-2xl p-8 md:p-12">
                        <div class="absolute -top-6 -right-6 w-20 h-20 bg-gradient-to-br from-amber-400 to-amber-600 rounded-2xl flex items-center justify-center shadow-lg animate-pulse">
                            <i class="fas fa-comments text-white text-3xl"></i>
                        </div>

                        <div class="space-y-6">
                            <div class="flex items-start space-x-4">
                                <div class="w-12 h-12 bg-emerald-100 dark:bg-emerald-900/30 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-clock text-emerald-600 dark:text-emerald-400 text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-1">24/7 Support</h3>
                                    <p class="text-gray-600 dark:text-gray-300">Round-the-clock assistance for all your queries</p>
                                </div>
                            </div>

                            <div class="flex items-start space-x-4">
                                <div class="w-12 h-12 bg-amber-100 dark:bg-amber-900/30 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-bolt text-amber-600 dark:text-amber-400 text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-1">Fast Response</h3>
                                    <p class="text-gray-600 dark:text-gray-300">Average response time: <span class="font-bold text-emerald-600 dark:text-emerald-400">2 minutes</span></p>
                                </div>
                            </div>

                            <div class="flex items-start space-x-4">
                                <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-check-circle text-purple-600 dark:text-purple-400 text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-1">100% Satisfaction</h3>
                                    <p class="text-gray-600 dark:text-gray-300">Guaranteed solutions for all your concerns</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('content')
<!-- Contact Cards -->
<section class="py-16 md:py-20">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                Multiple Ways to Reach Us
            </h2>
            <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                Choose your preferred method of communication. We're always ready to assist you.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8 mb-16">
            <!-- Address Card -->
            <div class="group">
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100 dark:border-gray-700 group-hover:border-emerald-500 dark:group-hover:border-emerald-400">
                    <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg group-hover:shadow-emerald-200 dark:group-hover:shadow-emerald-900/30 transition-shadow duration-300">
                        <i class="fas fa-map-marker-alt text-white text-2xl"></i>
                    </div>

                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Visit Our Store</h3>

                    <div class="space-y-3">
                        <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                            123 Premium Nut Street<br>
                            Suite 101, Dry Fruit Valley<br>
                            California, USA 12345
                        </p>

                        <div class="pt-4 border-t border-gray-100 dark:border-gray-700">
                            <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                <i class="fas fa-car text-emerald-500 mr-2"></i>
                                <span>Free customer parking</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Phone Card -->
            <div class="group">
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100 dark:border-gray-700 group-hover:border-amber-500 dark:group-hover:border-amber-400">
                    <div class="w-16 h-16 bg-gradient-to-br from-amber-500 to-amber-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg group-hover:shadow-amber-200 dark:group-hover:shadow-amber-900/30 transition-shadow duration-300">
                        <i class="fas fa-phone-alt text-white text-2xl"></i>
                    </div>

                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Call Us</h3>

                    <div class="space-y-3">
                        <div>
                            <a href="tel:+12345678900"
                                class="text-lg font-semibold text-gray-900 dark:text-white hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors duration-200 block">
                                +1 (234) 567-8900
                            </a>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Main Line</span>
                        </div>

                        <div>
                            <a href="tel:+12345678901"
                                class="text-lg font-semibold text-gray-900 dark:text-white hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors duration-200 block">
                                +1 (234) 567-8901
                            </a>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Support Line</span>
                        </div>

                        <div class="pt-4 border-t border-gray-100 dark:border-gray-700">
                            <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                <i class="fas fa-clock text-amber-500 mr-2"></i>
                                <span>Mon-Fri: 9AM-8PM | Sat-Sun: 10AM-6PM</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Email Card -->
            <div class="group">
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100 dark:border-gray-700 group-hover:border-blue-500 dark:group-hover:border-blue-400">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg group-hover:shadow-blue-200 dark:group-hover:shadow-blue-900/30 transition-shadow duration-300">
                        <i class="fas fa-envelope text-white text-2xl"></i>
                    </div>

                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Email Us</h3>

                    <div class="space-y-3">
                        <div>
                            <a href="mailto:support@ghazalifood.com"
                                class="text-lg font-semibold text-gray-900 dark:text-white hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors duration-200 block">
                                support@ghazalifood.com
                            </a>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Customer Support</span>
                        </div>

                        <div>
                            <a href="mailto:sales@ghazalifood.com"
                                class="text-lg font-semibold text-gray-900 dark:text-white hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors duration-200 block">
                                sales@ghazalifood.com
                            </a>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Sales & Business</span>
                        </div>

                        <div class="pt-4 border-t border-gray-100 dark:border-gray-700">
                            <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                <i class="fas fa-shield-alt text-blue-500 mr-2"></i>
                                <span>Response within 24 hours</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hours Card -->
            <div class="group">
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100 dark:border-gray-700 group-hover:border-purple-500 dark:group-hover:border-purple-400">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg group-hover:shadow-purple-200 dark:group-hover:shadow-purple-900/30 transition-shadow duration-300">
                        <i class="fas fa-business-time text-white text-2xl"></i>
                    </div>

                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Business Hours</h3>

                    <div class="space-y-4">
                        <div>
                            <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-1">Store Hours</h4>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">
                                Monday - Friday: 9:00 AM - 8:00 PM<br>
                                Saturday - Sunday: 10:00 AM - 6:00 PM
                            </p>
                        </div>

                        <div>
                            <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-1">Online Support</h4>
                            <p class="text-gray-600 dark:text-gray-400 text-sm">
                                Available 24/7 via email & live chat
                            </p>
                        </div>

                        <div class="pt-4 border-t border-gray-100 dark:border-gray-700">
                            <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                <i class="fas fa-globe text-purple-500 mr-2"></i>
                                <span>International support available</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Social Media -->
        <div class="text-center">
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Follow Us on Social Media</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-8 max-w-2xl mx-auto">
                Stay connected for exclusive offers, health tips, recipes, and behind-the-scenes content.
            </p>

            <div class="flex justify-center space-x-4">
                <a href="#" class="social-media-btn facebook group">
                    <i class="fab fa-facebook-f"></i>
                    <span class="social-media-text">Facebook</span>
                </a>

                <a href="#" class="social-media-btn twitter group">
                    <i class="fab fa-twitter"></i>
                    <span class="social-media-text">Twitter</span>
                </a>

                <a href="#" class="social-media-btn instagram group">
                    <i class="fab fa-instagram"></i>
                    <span class="social-media-text">Instagram</span>
                </a>

                <a href="#" class="social-media-btn youtube group">
                    <i class="fab fa-youtube"></i>
                    <span class="social-media-text">YouTube</span>
                </a>

                <a href="#" class="social-media-btn linkedin group">
                    <i class="fab fa-linkedin-in"></i>
                    <span class="social-media-text">LinkedIn</span>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Contact Form -->
<section class="py-16 md:py-20 bg-gradient-to-b from-gray-50 to-white dark:from-gray-900 dark:to-gray-800" id="contact-form">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl shadow-lg mb-6">
                    <i class="fas fa-envelope-open-text text-white text-3xl"></i>
                </div>

                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    Send Us a Message
                </h2>
                <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    Fill out the form below and we'll get back to you within 24 hours. Your satisfaction is our priority.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Form Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 sticky top-8">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Need Help With?</h3>

                        <div class="space-y-4">
                            <div class="flex items-start space-x-3 p-3 rounded-xl bg-gray-50 dark:bg-gray-700/50">
                                <div class="w-10 h-10 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-shopping-cart text-emerald-600 dark:text-emerald-400"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 dark:text-white">Order Support</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Tracking, cancellations, returns</p>
                                </div>
                            </div>

                            <div class="flex items-start space-x-3 p-3 rounded-xl bg-gray-50 dark:bg-gray-700/50">
                                <div class="w-10 h-10 bg-amber-100 dark:bg-amber-900/30 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-box text-amber-600 dark:text-amber-400"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 dark:text-white">Product Questions</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Ingredients, storage, usage</p>
                                </div>
                            </div>

                            <div class="flex items-start space-x-3 p-3 rounded-xl bg-gray-50 dark:bg-gray-700/50">
                                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-handshake text-blue-600 dark:text-blue-400"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 dark:text-white">Business Inquiries</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Wholesale, partnerships</p>
                                </div>
                            </div>

                            <div class="flex items-start space-x-3 p-3 rounded-xl bg-gray-50 dark:bg-gray-700/50">
                                <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-lightbulb text-purple-600 dark:text-purple-400"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 dark:text-white">General Inquiries</h4>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Feedback, suggestions</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700">
                            <h4 class="font-bold text-gray-900 dark:text-white mb-3">What to Expect</h4>
                            <ul class="space-y-2">
                                <li class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                    <i class="fas fa-check-circle text-emerald-500 mr-3"></i>
                                    <span>Response within 24 hours</span>
                                </li>
                                <li class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                    <i class="fas fa-check-circle text-emerald-500 mr-3"></i>
                                    <span>Personalized solutions</span>
                                </li>
                                <li class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                    <i class="fas fa-check-circle text-emerald-500 mr-3"></i>
                                    <span>Follow-up guarantee</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Main Form -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 md:p-10">
                        @if(session('success'))
                        <div class="mb-8 p-4 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white rounded-xl shadow-lg">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-2xl mr-3"></i>
                                <div>
                                    <h4 class="font-bold text-lg">Message Sent Successfully!</h4>
                                    <p class="text-emerald-100">{{ session('success') }}</p>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($errors->any())
                        <div class="mb-8 p-4 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-xl shadow-lg">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-triangle text-2xl mr-3"></i>
                                <div>
                                    <h4 class="font-bold text-lg">Please correct the errors below:</h4>
                                    <ul class="list-disc list-inside mt-2 text-red-100">
                                        @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @endif

                        <form action="{{ route('contact.store') }}" method="POST" class="contact-form" id="mainContactForm">
                            @csrf

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Name Field -->
                                <div class="form-group">
                                    <label for="name" class="form-label">Full Name *</label>
                                    <div class="relative">
                                        <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                                        </div>
                                        <input type="text"
                                            id="name"
                                            name="name"
                                            value="{{ old('name') }}"
                                            class="form-input pl-12 @error('name') error @enderror"
                                            placeholder="Enter your full name"
                                            required>
                                    </div>
                                    @error('name')
                                    <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Email Field -->
                                <div class="form-group">
                                    <label for="email" class="form-label">Email Address *</label>
                                    <div class="relative">
                                        <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                                        </div>
                                        <input type="email"
                                            id="email"
                                            name="email"
                                            value="{{ old('email') }}"
                                            class="form-input pl-12 @error('email') error @enderror"
                                            placeholder="Enter your email address"
                                            required>
                                    </div>
                                    @error('email')
                                    <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                                <!-- Phone Field -->
                                <div class="form-group">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <div class="relative">
                                        <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                                        </div>
                                        <input type="tel"
                                            id="phone"
                                            name="phone"
                                            value="{{ old('phone') }}"
                                            class="form-input pl-12 @error('phone') error @enderror"
                                            placeholder="Optional - for faster response">
                                    </div>
                                    @error('phone')
                                    <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Subject Field -->
                                <div class="form-group">
                                    <label for="subject" class="form-label">Subject *</label>
                                    <div class="relative">
                                        <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                                        </div>
                                        <input type="text"
                                            id="subject"
                                            name="subject"
                                            value="{{ old('subject') }}"
                                            class="form-input pl-12 @error('subject') error @enderror"
                                            placeholder="What is this regarding?"
                                            required>
                                    </div>
                                    @error('subject')
                                    <p class="form-error">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Feedback Type (Updated to match controller) -->
                            <div class="form-group mt-6">
                                <label for="feedback_type" class="form-label">Feedback Type *</label>
                                <div class="relative">
                                    <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                                    </div>
                                    <select id="feedback_type"
                                        name="feedback_type"
                                        class="form-select pl-12 @error('feedback_type') error @enderror"
                                        required>
                                        <option value="">Select feedback type...</option>
                                        <option value="general" {{ old('feedback_type') == 'general' ? 'selected' : '' }}>General Inquiry</option>
                                        <option value="complaint" {{ old('feedback_type') == 'complaint' ? 'selected' : '' }}>Complaint</option>
                                        <option value="suggestion" {{ old('feedback_type') == 'suggestion' ? 'selected' : '' }}>Suggestion</option>
                                        <option value="support" {{ old('feedback_type') == 'support' ? 'selected' : '' }}>Support Request</option>
                                        <option value="other" {{ old('feedback_type') == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                                @error('feedback_type')
                                <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Message Field -->
                            <div class="form-group mt-6">
                                <label for="message" class="form-label">Message *</label>
                                <div class="relative">
                                    <textarea id="message"
                                        name="message"
                                        rows="6"
                                        class="form-textarea @error('message') error @enderror"
                                        placeholder="Please provide details about your inquiry (minimum 10 characters)..."
                                        required>{{ old('message') }}</textarea>
                                    <div class="absolute bottom-3 right-3 text-sm text-gray-400" id="charCounter">
                                        0/1000
                                    </div>
                                </div>
                                @error('message')
                                <p class="form-error">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Privacy Policy Checkbox -->
                            <div class="space-y-4 mt-8">
                                <div class="flex items-start">
                                    <input type="checkbox"
                                        id="privacy"
                                        name="privacy"
                                        class="form-checkbox mt-1 @error('privacy') error @enderror"
                                        required>
                                    <label for="privacy" class="ml-3 text-gray-700 dark:text-gray-300">
                                        I agree to the
                                        <a href="{{ route('policies.privacy') }}" class="text-emerald-600 dark:text-emerald-400 hover:underline font-medium">Privacy Policy</a>
                                        *
                                    </label>
                                </div>
                                @error('privacy')
                                <p class="form-error">{{ $message }}</p>
                                @enderror

                                <!-- Newsletter Checkbox -->
                                <div class="flex items-start">
                                    <input type="checkbox"
                                        id="newsletter"
                                        name="newsletter"
                                        class="form-checkbox mt-1"
                                        {{ old('newsletter') ? 'checked' : '' }}>
                                    <label for="newsletter" class="ml-3 text-gray-700 dark:text-gray-300">
                                        Subscribe to our newsletter for exclusive offers, health tips,
                                        and new product updates
                                    </label>
                                </div>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="flex flex-col sm:flex-row gap-4 mt-10">
                                <button type="submit"
                                    class="btn-submit group">
                                    <i class="fas fa-paper-plane mr-3"></i>
                                    Send Message
                                    <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform duration-200"></i>
                                </button>

                                <button type="reset"
                                    class="btn-reset">
                                    <i class="fas fa-redo mr-3"></i>
                                    Clear Form
                                </button>
                            </div>

                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-6 text-center">
                                <i class="fas fa-lock mr-2"></i>
                                Your information is secure and will never be shared with third parties
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Live Support Section -->
<section class="py-16 md:py-20 bg-gradient-to-r from-emerald-500 to-emerald-600">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-white/20 rounded-2xl backdrop-blur-sm mb-8">
                <i class="fas fa-headset text-white text-3xl"></i>
            </div>

            <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">
                Need Immediate Assistance?
            </h2>

            <p class="text-lg text-emerald-100 mb-10 max-w-2xl mx-auto">
                Our live chat support team is available 24/7 to help with urgent inquiries,
                order tracking, and product questions.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button id="liveChatBtn"
                    class="btn-live-chat group">
                    <i class="fas fa-comment-dots mr-3"></i>
                    Start Live Chat
                    <span class="inline-flex items-center ml-2 px-2 py-1 bg-white/20 rounded-full text-xs">
                        <span class="w-2 h-2 bg-green-400 rounded-full animate-ping mr-1"></span>
                        Online
                    </span>
                </button>

                <a href="tel:+12345678900"
                    class="btn-call">
                    <i class="fas fa-phone-alt mr-3"></i>
                    Call Now: +1 (234) 567-8900
                </a>
            </div>

            <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6 text-left">
                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6">
                    <i class="fas fa-bolt text-amber-300 text-2xl mb-4"></i>
                    <h4 class="text-white font-semibold mb-2">Fast Response</h4>
                    <p class="text-emerald-100 text-sm">Average response time: 2 minutes</p>
                </div>

                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6">
                    <i class="fas fa-clock text-white text-2xl mb-4"></i>
                    <h4 class="text-white font-semibold mb-2">24/7 Availability</h4>
                    <p class="text-emerald-100 text-sm">Round-the-clock support</p>
                </div>

                <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6">
                    <i class="fas fa-user-check text-green-300 text-2xl mb-4"></i>
                    <h4 class="text-white font-semibold mb-2">Expert Support</h4>
                    <p class="text-emerald-100 text-sm">Certified customer service experts</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-16 md:py-20 bg-gray-50 dark:bg-gray-900" id="faq">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-amber-500 to-amber-600 rounded-2xl shadow-lg mb-6">
                    <i class="fas fa-question-circle text-white text-3xl"></i>
                </div>

                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    Frequently Asked Questions
                </h2>
                <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    Quick answers to common questions about our products and services
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- FAQ Column 1 -->
                <div class="space-y-4">
                    <div class="faq-item bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                        <button class="faq-question w-full px-6 py-5 text-left flex items-center justify-between group">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg flex items-center justify-center mr-4">
                                    <i class="fas fa-shipping-fast text-emerald-600 dark:text-emerald-400"></i>
                                </div>
                                <span class="text-lg font-semibold text-gray-900 dark:text-white">What is your shipping policy?</span>
                            </div>
                            <i class="fas fa-chevron-down text-gray-400 group-hover:text-emerald-500 dark:group-hover:text-emerald-400 transition-transform duration-300"></i>
                        </button>
                        <div class="faq-answer px-6 pb-5">
                            <div class="pl-14">
                                <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                                    We offer free shipping on all orders over $50 within the continental US.
                                    Standard shipping takes 3-5 business days, while expedited options (1-2 days)
                                    are available at checkout. International shipping is available to over 50 countries.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="faq-item bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                        <button class="faq-question w-full px-6 py-5 text-left flex items-center justify-between group">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-amber-100 dark:bg-amber-900/30 rounded-lg flex items-center justify-center mr-4">
                                    <i class="fas fa-leaf text-amber-600 dark:text-amber-400"></i>
                                </div>
                                <span class="text-lg font-semibold text-gray-900 dark:text-white">Are your products organic?</span>
                            </div>
                            <i class="fas fa-chevron-down text-gray-400 group-hover:text-amber-500 dark:group-hover:text-amber-400 transition-transform duration-300"></i>
                        </button>
                        <div class="faq-answer px-6 pb-5">
                            <div class="pl-14">
                                <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                                    Yes! All our dry fruits are 100% certified organic, sourced from trusted
                                    organic farms worldwide. We never use preservatives, additives, or artificial
                                    colors in any of our products. Each product comes with certification details.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="faq-item bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                        <button class="faq-question w-full px-6 py-5 text-left flex items-center justify-between group">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center mr-4">
                                    <i class="fas fa-boxes text-blue-600 dark:text-blue-400"></i>
                                </div>
                                <span class="text-lg font-semibold text-gray-900 dark:text-white">Do you offer bulk/wholesale pricing?</span>
                            </div>
                            <i class="fas fa-chevron-down text-gray-400 group-hover:text-blue-500 dark:group-hover:text-blue-400 transition-transform duration-300"></i>
                        </button>
                        <div class="faq-answer px-6 pb-5">
                            <div class="pl-14">
                                <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                                    Absolutely! We offer special wholesale pricing for restaurants, cafes,
                                    hotels, and bulk purchases. Contact our dedicated wholesale team at
                                    <a href="mailto:wholesale@ghazalifood.com" class="text-emerald-600 dark:text-emerald-400 hover:underline">
                                        wholesale@ghazalifood.com
                                    </a>
                                    for custom quotes, volume discounts, and business partnership opportunities.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FAQ Column 2 -->
                <div class="space-y-4">
                    <div class="faq-item bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                        <button class="faq-question w-full px-6 py-5 text-left flex items-center justify-between group">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-lg flex items-center justify-center mr-4">
                                    <i class="fas fa-thermometer-half text-purple-600 dark:text-purple-400"></i>
                                </div>
                                <span class="text-lg font-semibold text-gray-900 dark:text-white">How do I store dry fruits?</span>
                            </div>
                            <i class="fas fa-chevron-down text-gray-400 group-hover:text-purple-500 dark:group-hover:text-purple-400 transition-transform duration-300"></i>
                        </button>
                        <div class="faq-answer px-6 pb-5">
                            <div class="pl-14">
                                <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                                    For maximum freshness, store dry fruits in airtight containers in a cool,
                                    dark place (15-20°C). Most dry fruits last 6-12 months when stored properly.
                                    Nuts are best stored in the refrigerator (0-5°C) to maintain their natural oils.
                                    Always check individual product labels for specific storage instructions.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="faq-item bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                        <button class="faq-question w-full px-6 py-5 text-left flex items-center justify-between group">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center mr-4">
                                    <i class="fas fa-undo text-red-600 dark:text-red-400"></i>
                                </div>
                                <span class="text-lg font-semibold text-gray-900 dark:text-white">What is your return policy?</span>
                            </div>
                            <i class="fas fa-chevron-down text-gray-400 group-hover:text-red-500 dark:group-hover:text-red-400 transition-transform duration-300"></i>
                        </button>
                        <div class="faq-answer px-6 pb-5">
                            <div class="pl-14">
                                <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                                    We offer a 30-day satisfaction guarantee. If you're not completely happy
                                    with your purchase, contact us within 30 days for a full refund or exchange.
                                    Products must be in original, unopened packaging. For damaged or incorrect
                                    items, we provide free return shipping and immediate replacement.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="faq-item bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
                        <button class="faq-question w-full px-6 py-5 text-left flex items-center justify-between group">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center mr-4">
                                    <i class="fas fa-globe text-green-600 dark:text-green-400"></i>
                                </div>
                                <span class="text-lg font-semibold text-gray-900 dark:text-white">Do you ship internationally?</span>
                            </div>
                            <i class="fas fa-chevron-down text-gray-400 group-hover:text-green-500 dark:group-hover:text-green-400 transition-transform duration-300"></i>
                        </button>
                        <div class="faq-answer px-6 pb-5">
                            <div class="pl-14">
                                <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                                    Yes! We ship to over 50 countries worldwide. International shipping costs
                                    and delivery times vary by destination. You'll see available shipping options
                                    and costs during checkout. All international orders include tracking and
                                    customs documentation. Please note that some countries may have restrictions
                                    on imported food products.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-12">
                <p class="text-gray-600 dark:text-gray-400 mb-6">
                    Can't find the answer you're looking for?
                </p>
                <a href="#contact-form"
                    class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 dark:from-emerald-600 dark:to-emerald-700 dark:hover:from-emerald-700 dark:hover:to-emerald-800 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                    <i class="fas fa-question-circle mr-3"></i>
                    Ask Your Question
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Newsletter Section -->
<section class="py-16 md:py-20 bg-gradient-to-r from-amber-500 to-orange-500">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-white/20 rounded-2xl backdrop-blur-sm mb-8">
                <i class="fas fa-newspaper text-white text-3xl"></i>
            </div>

            <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">
                Stay Connected with Us
            </h2>

            <p class="text-lg text-amber-100 mb-10 max-w-2xl mx-auto">
                Subscribe to our newsletter for exclusive offers, health tips,
                delicious recipes, and new product launches delivered to your inbox.
            </p>

            <form class="newsletter-form max-w-md mx-auto">
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1">
                        <input type="email"
                            class="w-full px-6 py-4 rounded-xl bg-white/10 backdrop-blur-sm border-2 border-white/20 text-white placeholder-amber-200 focus:outline-none focus:border-white/40 transition-colors duration-300"
                            placeholder="Enter your email address"
                            required
                            aria-label="Email for newsletter">
                    </div>
                    <button type="submit"
                        class="px-8 py-4 bg-white text-amber-600 font-semibold rounded-xl hover:bg-amber-50 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 whitespace-nowrap">
                        <i class="fas fa-paper-plane mr-3"></i>
                        Subscribe
                    </button>
                </div>

                <p class="text-sm text-amber-200 mt-4">
                    <i class="fas fa-lock mr-2"></i>
                    We respect your privacy. Unsubscribe at any time.
                </p>
            </form>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    /* Contact Page Specific Styles */
    .animate-slide-up {
        animation: slideUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        opacity: 0;
        transform: translateY(30px);
    }

    .animate-slide-up.delay-1 {
        animation-delay: 0.2s;
    }

    .animate-slide-up.delay-2 {
        animation-delay: 0.4s;
    }

    @keyframes slideUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Social Media Buttons */
    .social-media-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 60px;
        height: 60px;
        border-radius: 16px;
        color: white;
        font-size: 20px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .social-media-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.1);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .social-media-btn:hover::before {
        opacity: 1;
    }

    .social-media-btn.facebook {
        background: linear-gradient(135deg, #1877F2, #0D65D9);
    }

    .social-media-btn.twitter {
        background: linear-gradient(135deg, #1DA1F2, #0D8BD9);
    }

    .social-media-btn.instagram {
        background: linear-gradient(135deg, #E4405F, #C13584);
    }

    .social-media-btn.youtube {
        background: linear-gradient(135deg, #FF0000, #CC0000);
    }

    .social-media-btn.linkedin {
        background: linear-gradient(135deg, #0077B5, #005582);
    }

    .social-media-btn:hover {
        transform: translateY(-4px) scale(1.05);
        box-shadow: 0 12px 24px -8px rgba(0, 0, 0, 0.3);
    }

    .social-media-text {
        position: absolute;
        bottom: -30px;
        left: 50%;
        transform: translateX(-50%);
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
        opacity: 0;
        transition: all 0.3s ease;
    }

    .social-media-btn:hover .social-media-text {
        opacity: 1;
        bottom: -25px;
    }

    /* Form Styles */
    .form-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: var(--text-primary);
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-input,
    .form-select,
    .form-textarea {
        width: 100%;
        padding: 16px 20px;
        background: var(--surface-color);
        border: 2px solid var(--border-color);
        border-radius: 12px;
        font-size: 16px;
        color: var(--text-primary);
        transition: all 0.3s ease;
        outline: none;
    }

    .form-input:focus,
    .form-select:focus,
    .form-textarea:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
        background: var(--surface-color);
    }

    .form-input.error,
    .form-select.error,
    .form-textarea.error {
        border-color: var(--danger-color);
        box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1);
    }

    .form-error {
        margin-top: 6px;
        font-size: 14px;
        color: var(--danger-color);
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .form-error::before {
        content: '⚠';
        font-size: 12px;
    }

    .form-checkbox {
        width: 20px;
        height: 20px;
        border: 2px solid var(--border-color);
        border-radius: 6px;
        background: var(--surface-color);
        transition: all 0.2s ease;
        cursor: pointer;
        position: relative;
    }

    .form-checkbox:checked {
        background: var(--primary-color);
        border-color: var(--primary-color);
    }

    .form-checkbox:checked::after {
        content: '✓';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: white;
        font-size: 12px;
        font-weight: bold;
    }

    /* Buttons */
    .btn-submit {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex: 1;
        padding: 18px 32px;
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        color: white;
        font-size: 16px;
        font-weight: 600;
        border: none;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.2);
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 28px rgba(16, 185, 129, 0.3);
    }

    .btn-submit:active {
        transform: translateY(0);
    }

    .btn-reset {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex: 1;
        padding: 18px 32px;
        background: var(--surface-color);
        color: var(--text-secondary);
        font-size: 16px;
        font-weight: 600;
        border: 2px solid var(--border-color);
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-reset:hover {
        background: var(--border-color);
        color: var(--text-primary);
    }

    .btn-live-chat {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 18px 32px;
        background: white;
        color: var(--primary-color);
        font-size: 16px;
        font-weight: 600;
        border: none;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }

    .btn-live-chat:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.2);
        background: var(--surface-color);
    }

    .btn-call {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 18px 32px;
        background: rgba(255, 255, 255, 0.15);
        color: white;
        font-size: 16px;
        font-weight: 600;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
    }

    .btn-call:hover {
        background: rgba(255, 255, 255, 0.25);
        border-color: rgba(255, 255, 255, 0.5);
        transform: translateY(-2px);
    }

    /* FAQ Styles */
    .faq-item {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .faq-item.active {
        box-shadow: 0 16px 40px rgba(0, 0, 0, 0.12);
    }

    .faq-question {
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .faq-question:hover {
        background: rgba(139, 92, 246, 0.05);
    }

    .faq-item.active .faq-question {
        background: rgba(139, 92, 246, 0.08);
    }

    .faq-answer {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .faq-item.active .faq-answer {
        max-height: 500px;
    }

    .faq-item.active .faq-question i {
        transform: rotate(180deg);
    }

    /* Character Counter */
    #charCounter {
        font-size: 12px;
        font-weight: 500;
        transition: color 0.3s ease;
    }

    .form-textarea:focus+#charCounter {
        color: var(--primary-color);
    }

    /* Loading Animation */
    .loading-spinner {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        border-top-color: white;
        animation: spin 0.8s linear infinite;
        margin-left: 10px;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }

    /* Dark Mode Adjustments */
    [data-theme="dark"] .form-input,
    [data-theme="dark"] .form-select,
    [data-theme="dark"] .form-textarea {
        background: rgba(255, 255, 255, 0.05);
        border-color: rgba(255, 255, 255, 0.1);
    }

    [data-theme="dark"] .form-input:focus,
    [data-theme="dark"] .form-select:focus,
    [data-theme="dark"] .form-textarea:focus {
        background: rgba(255, 255, 255, 0.07);
        border-color: var(--primary-light);
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.2);
    }

    [data-theme="dark"] .btn-reset {
        background: rgba(255, 255, 255, 0.05);
        border-color: rgba(255, 255, 255, 0.1);
    }

    [data-theme="dark"] .btn-reset:hover {
        background: rgba(255, 255, 255, 0.1);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .social-media-btn {
            width: 50px;
            height: 50px;
            font-size: 18px;
        }

        .social-media-text {
            display: none;
        }

        .btn-submit,
        .btn-reset,
        .btn-live-chat,
        .btn-call {
            padding: 16px 24px;
            font-size: 15px;
        }

        .form-input,
        .form-select,
        .form-textarea {
            padding: 14px 16px;
            font-size: 15px;
        }

        .faq-question {
            padding: 16px;
        }

        .faq-answer {
            padding: 0 16px 16px;
        }
    }

    @media (max-width: 480px) {
        .grid-cols-2 {
            grid-template-columns: 1fr;
        }

        .social-media-btn {
            width: 44px;
            height: 44px;
            font-size: 16px;
        }

        .btn-submit,
        .btn-reset,
        .btn-live-chat,
        .btn-call {
            padding: 14px 20px;
            font-size: 14px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Character counter for message field
        const messageField = document.getElementById('message');
        const charCounter = document.getElementById('charCounter');

        if (messageField && charCounter) {
            messageField.addEventListener('input', function() {
                const length = this.value.length;
                const maxLength = 1000;
                const remaining = maxLength - length;

                charCounter.textContent = `${length}/${maxLength}`;

                // Update color based on remaining characters
                if (remaining < 100) {
                    charCounter.style.color = '#e74c3c';
                } else if (remaining < 200) {
                    charCounter.style.color = '#f39c12';
                } else {
                    charCounter.style.color = 'var(--text-muted)';
                }

                // Limit text to max length
                if (length > maxLength) {
                    this.value = this.value.substring(0, maxLength);
                }
            });

            // Trigger initial count
            messageField.dispatchEvent(new Event('input'));
        }

        // FAQ Accordion
        const faqQuestions = document.querySelectorAll('.faq-question');

        faqQuestions.forEach(question => {
            question.addEventListener('click', function() {
                const faqItem = this.closest('.faq-item');
                const isActive = faqItem.classList.contains('active');
                const arrowIcon = this.querySelector('.fa-chevron-down');

                // Close all FAQ items
                document.querySelectorAll('.faq-item').forEach(item => {
                    item.classList.remove('active');
                });

                // Close all arrow icons
                document.querySelectorAll('.faq-question .fa-chevron-down').forEach(icon => {
                    icon.style.transform = 'rotate(0deg)';
                });

                // Open clicked item if it wasn't active
                if (!isActive) {
                    faqItem.classList.add('active');
                    if (arrowIcon) {
                        arrowIcon.style.transform = 'rotate(180deg)';
                    }
                }
            });
        });

        // Form Validation and Submission
        // Form Validation and Submission - REMOVE THIS BLOCK and replace with:
        const contactForm = document.getElementById('mainContactForm');
        if (contactForm) {
            // Keep only client-side validation, remove AJAX submission
            contactForm.addEventListener('submit', function(e) {
                // Only validate client-side, let the form submit normally
                const isValid = validateContactForm();

                if (!isValid) {
                    e.preventDefault();
                    return;
                }

                // Show loading state but allow normal form submission
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalContent = submitBtn.innerHTML;

                submitBtn.disabled = true;
                submitBtn.innerHTML = originalContent.replace('Send Message', 'Sending...');
                submitBtn.innerHTML += '<div class="loading-spinner"></div>';
            });
        }
        // Form validation function
        function validateContactForm() {
            let isValid = true;

            // Clear previous errors
            document.querySelectorAll('.form-error').forEach(el => el.remove());
            document.querySelectorAll('.error').forEach(el => el.classList.remove('error'));

            // Check required fields
            const requiredFields = contactForm.querySelectorAll('[required]');
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('error');
                    const errorMsg = field.labels?.[0]?.textContent?.replace('*', '') || 'This field';
                    showFieldError(field, `${errorMsg} is required`);
                    isValid = false;
                }
            });

            // Validate email format
            const emailField = document.getElementById('email');
            if (emailField.value && !isValidEmail(emailField.value)) {
                emailField.classList.add('error');
                showFieldError(emailField, 'Please enter a valid email address');
                isValid = false;
            }

            // Validate phone format if provided
            const phoneField = document.getElementById('phone');
            if (phoneField.value && !isValidPhone(phoneField.value)) {
                phoneField.classList.add('error');
                showFieldError(phoneField, 'Please enter a valid phone number');
                isValid = false;
            }

            // Validate message length
            if (messageField && messageField.value.length > 1000) {
                messageField.classList.add('error');
                showFieldError(messageField, 'Message must be less than 1000 characters');
                isValid = false;
            }

            // Validate minimum message length (10 characters as per controller)
            if (messageField && messageField.value.length < 10) {
                messageField.classList.add('error');
                showFieldError(messageField, 'Message must be at least 10 characters');
                isValid = false;
            }

            return isValid;
        }

        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        function isValidPhone(phone) {
            const phoneRegex = /^[\+]?[1-9][\d]{0,15}$/;
            return phoneRegex.test(phone.replace(/[\s\-\(\)]/g, ''));
        }

        function showFieldError(field, message) {
            const errorDiv = document.createElement('p');
            errorDiv.className = 'form-error';
            errorDiv.textContent = message;

            const parent = field.parentElement.parentElement;
            parent.appendChild(errorDiv);
        }

        // Live Chat Button
        const liveChatBtn = document.getElementById('liveChatBtn');
        if (liveChatBtn) {
            liveChatBtn.addEventListener('click', function(e) {
                e.preventDefault();

                // Show loading state
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin mr-3"></i>Connecting...';
                this.disabled = true;

                // Simulate connection delay
                setTimeout(() => {
                    showToast('Live chat feature will be available soon! For now, please use the contact form or call us.', 'info');

                    // Restore button
                    this.innerHTML = originalText;
                    this.disabled = false;
                }, 1500);
            });
        }

        // Newsletter Form
        const newsletterForm = document.querySelector('.newsletter-form');
        if (newsletterForm) {
            newsletterForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const email = this.querySelector('input[type="email"]');
                if (!email.value || !isValidEmail(email.value)) {
                    showToast('Please enter a valid email address', 'warning');
                    return;
                }

                showToast('Thank you for subscribing! You\'ll receive our first newsletter soon.', 'success');
                this.reset();
            });
        }

        // Form Reset Button
        const resetBtn = contactForm?.querySelector('button[type="reset"]');
        if (resetBtn) {
            resetBtn.addEventListener('click', function() {
                // Clear validation errors
                document.querySelectorAll('.form-error').forEach(el => el.remove());
                document.querySelectorAll('.error').forEach(el => el.classList.remove('error'));

                // Reset character counter
                if (messageField) {
                    messageField.dispatchEvent(new Event('input'));
                }

                showToast('Form cleared', 'info');
            });
        }

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;

                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    e.preventDefault();
                    targetElement.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Intersection Observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '50px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-slide-up');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        // Observe elements for animation
        document.querySelectorAll('.contact-card, .social-media-btn, .form-group, .faq-item')
            .forEach(el => observer.observe(el));
    });

    // Toast notification function
    function showToast(message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = `fixed top-4 right-4 z-50 px-6 py-4 rounded-xl shadow-xl text-white font-semibold transform translate-x-full transition-transform duration-300`;

        switch (type) {
            case 'success':
                toast.style.background = 'linear-gradient(135deg, var(--primary-color), var(--primary-dark))';
                break;
            case 'error':
                toast.style.background = 'linear-gradient(135deg, #ef4444, #dc2626)';
                break;
            case 'warning':
                toast.style.background = 'linear-gradient(135deg, #f59e0b, #d97706)';
                break;
            default:
                toast.style.background = 'linear-gradient(135deg, #3b82f6, #1d4ed8)';
        }

        toast.innerHTML = `
        <div class="flex items-center">
            <i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : type === 'warning' ? 'fa-exclamation-triangle' : 'fa-info-circle'} mr-3"></i>
            <span>${message}</span>
        </div>
    `;

        document.body.appendChild(toast);

        // Animate in
        setTimeout(() => {
            toast.style.transform = 'translateX(0)';
        }, 10);

        // Remove after 5 seconds
        setTimeout(() => {
            toast.style.transform = 'translateX(100%)';
            setTimeout(() => {
                document.body.removeChild(toast);
            }, 300);
        }, 5000);
    }
</script>
@endpush