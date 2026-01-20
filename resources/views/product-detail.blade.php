@extends('layouts.app')

@section('title', $product->name . ' - Ghazali Food')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-emerald-50 to-amber-50">
        <div class="container mx-auto px-4 py-6">
            <nav class="flex items-center space-x-2 text-sm text-gray-600 overflow-x-auto py-1">
                <a href="{{ url('/') }}" class="hover:text-emerald-600 transition-colors whitespace-nowrap">Home</a>
                <span class="text-gray-400">/</span>
                <a href="{{ route('shop.index') }}" class="hover:text-emerald-600 transition-colors whitespace-nowrap">Shop</a>
                @if($product->category)
                <span class="text-gray-400">/</span>
                <a href="{{ route('category.show', $product->category->slug) }}" class="hover:text-emerald-600 transition-colors whitespace-nowrap">{{ $product->category->name }}</a>
                @endif
                <span class="text-gray-400">/</span>
                <span class="text-gray-900 font-medium truncate whitespace-nowrap">{{ Str::limit($product->name, 30) }}</span>
            </nav>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <!-- Social Proof Banner -->
        <div class="bg-white rounded-xl shadow-sm p-4 mb-8 border border-gray-100">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="flex flex-wrap items-center gap-4 md:gap-6">
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-eye text-emerald-600 text-sm"></i>
                        </div>
                        <span class="text-gray-700"><span class="font-bold text-gray-900" id="current-viewers">124</span> viewing now</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-amber-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-shopping-cart text-amber-600 text-sm"></i>
                        </div>
                        <span class="text-gray-700"><span class="font-bold text-gray-900" id="recent-purchases">87</span> bought today</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-fire text-red-600 text-sm"></i>
                        </div>
                        <span class="text-gray-700">Trending <span class="font-bold text-gray-900" id="trending-rank">#3</span> in {{ $product->category->name ?? 'Dry Fruits' }}</span>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <div class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-sm font-medium whitespace-nowrap">
                        <i class="fas fa-check-circle mr-1"></i> 100% Authentic
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Main Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
            <!-- Product Gallery -->
            <div class="space-y-4">
                <!-- Main Image -->
                <div class="relative bg-white rounded-2xl shadow-lg overflow-hidden group">
                    <div class="absolute top-4 left-4 z-10 flex flex-col space-y-2">
                        @if($product->is_new_arrival)
                        <span class="px-3 py-1.5 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white text-xs font-bold rounded-full shadow-md flex items-center space-x-1">
                            <i class="fas fa-star text-xs"></i>
                            <span>NEW</span>
                        </span>
                        @endif
                        @if($product->compare_at_price && $product->compare_at_price > $product->best_price)
                        <span class="px-3 py-1.5 bg-gradient-to-r from-red-500 to-red-600 text-white text-xs font-bold rounded-full shadow-md">
                            -{{ $product->discount_percentage }}% OFF
                        </span>
                        @endif
                    </div>

                    <img src="{{ $product->media->first()->media_url ?? asset('images/placeholder.jpg') }}"
                         id="mainProductImage"
                         alt="{{ $product->name }}"
                         class="w-full h-[400px] md:h-[500px] object-contain transition-transform duration-300 group-hover:scale-105 cursor-zoom-in">

                    <!-- Live Badge -->
                    <div class="absolute bottom-4 right-4 bg-black/70 backdrop-blur-sm text-white px-3 py-1.5 rounded-full text-xs flex items-center space-x-2">
                        <div class="relative">
                            <div class="w-2 h-2 bg-red-500 rounded-full animate-ping absolute"></div>
                            <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                        </div>
                        <span id="product-viewers">12</span> viewing
                    </div>

                    <!-- Purchase Alert -->
                    <div id="recent-purchase-pulse" class="absolute top-4 right-4 bg-gradient-to-r from-amber-500 to-orange-500 text-white px-3 py-1.5 rounded-full text-xs flex items-center space-x-2 animate-pulse hidden">
                        <i class="fas fa-bolt"></i>
                        <span>Just purchased</span>
                    </div>
                </div>

                <!-- Thumbnails -->
                @if($product->media->count() > 1)
                <div class="flex space-x-3 overflow-x-auto pb-2">
                    @foreach($product->media as $index => $media)
                    <div class="thumbnail-item flex-shrink-0 w-20 h-20 rounded-xl overflow-hidden border-2 border-transparent cursor-pointer transition-all duration-300 hover:border-emerald-500 {{ $index === 0 ? 'border-emerald-500 ring-2 ring-emerald-200' : '' }}"
                         data-image="{{ $media->media_url }}"
                         onclick="changeMainImage(this, {{ $index }})">
                        <img src="{{ $media->media_url }}"
                             alt="{{ $product->name }} - {{ $index + 1 }}"
                             class="w-full h-full object-cover">
                    </div>
                    @endforeach
                </div>
                @endif

                <!-- Image Actions -->
                <div class="grid grid-cols-3 gap-3">
                    <button onclick="zoomImage()" class="flex items-center justify-center space-x-2 bg-white border border-gray-200 rounded-xl py-3 hover:bg-gray-50 transition-colors group">
                        <i class="fas fa-search-plus text-gray-600 group-hover:text-emerald-600"></i>
                        <span class="text-sm font-medium text-gray-700 group-hover:text-emerald-700">Zoom</span>
                    </button>
                    <button onclick="shareProduct()" class="flex items-center justify-center space-x-2 bg-white border border-gray-200 rounded-xl py-3 hover:bg-gray-50 transition-colors group">
                        <i class="fas fa-share-alt text-gray-600 group-hover:text-emerald-600"></i>
                        <span class="text-sm font-medium text-gray-700 group-hover:text-emerald-700">Share</span>
                    </button>
                    <button onclick="downloadImage('{{ $product->media->first()->media_url ?? '' }}')" class="flex items-center justify-center space-x-2 bg-white border border-gray-200 rounded-xl py-3 hover:bg-gray-50 transition-colors group">
                        <i class="fas fa-download text-gray-600 group-hover:text-emerald-600"></i>
                        <span class="text-sm font-medium text-gray-700 group-hover:text-emerald-700">Download</span>
                    </button>
                </div>
            </div>

            <!-- Product Info -->
            <div class="space-y-6">
                <!-- Product Header -->
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex flex-wrap items-center gap-2 mb-3">
                            @if($product->category)
                            <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-medium whitespace-nowrap">
                                {{ $product->category->name }}
                            </span>
                            @endif
                            <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-medium whitespace-nowrap">
                                <i class="fas fa-crown text-xs mr-1"></i>Ghazali Premium
                            </span>
                        </div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">{{ $product->name }}</h1>
                        <div class="flex flex-wrap items-center gap-2 md:gap-4">
                            <div class="flex items-center">
                                @php
                                    $avgRating = $product->average_rating ?? 0;
                                @endphp
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($avgRating))
                                    <i class="fas fa-star text-amber-400 text-sm"></i>
                                    @elseif($i - 0.5 <= $avgRating)
                                    <i class="fas fa-star-half-alt text-amber-400 text-sm"></i>
                                    @else
                                    <i class="far fa-star text-amber-400 text-sm"></i>
                                    @endif
                                @endfor
                                <span class="ml-2 text-gray-600 text-sm">({{ $product->total_reviews ?? 0 }} reviews)</span>
                            </div>
                            <span class="text-gray-400 hidden md:inline">•</span>
                            <span class="text-gray-600 text-sm">SKU: {{ $product->sku ?? 'GF-' . str_pad($product->id, 6, '0', STR_PAD_LEFT) }}</span>
                        </div>
                    </div>
                    <button id="wishlistToggleBtn" 
                            data-product-id="{{ $product->id }}"
                            class="w-12 h-12 rounded-full border border-gray-200 flex items-center justify-center hover:bg-red-50 hover:border-red-200 transition-colors group {{ Auth::check() && Auth::user()->wishlist()->where('product_id', $product->id)->exists() ? 'bg-red-50 border-red-200 text-red-600' : 'bg-white text-gray-400' }} ml-4">
                        <i class="{{ Auth::check() && Auth::user()->wishlist()->where('product_id', $product->id)->exists() ? 'fas' : 'far' }} fa-heart text-xl group-hover:text-red-500"></i>
                    </button>
                </div>

                <!-- Short Description -->
                <p class="text-gray-600 md:text-lg leading-relaxed border-b border-gray-100 pb-6">
                    {{ $product->short_description ?? Str::limit($product->description, 200) }}
                </p>

                <!-- Pricing -->
                <div class="space-y-2">
                    <div class="flex flex-wrap items-center gap-3">
                        <span class="text-3xl md:text-4xl font-bold text-gray-900">{{ config('settings.currency_symbol', '₹') }}{{ number_format($product->best_price, 2) }}</span>
                        @if($product->compare_at_price && $product->compare_at_price > $product->best_price)
                        <span class="text-xl md:text-2xl text-gray-400 line-through">{{ config('settings.currency_symbol', '₹') }}{{ number_format($product->compare_at_price, 2) }}</span>
                        <span class="px-3 py-1 bg-red-100 text-red-700 font-bold rounded-lg whitespace-nowrap">
                            Save {{ $product->discount_percentage }}%
                        </span>
                        @endif
                    </div>
                    @if($product->compare_at_price && $product->compare_at_price > $product->best_price)
                    <div class="flex items-center space-x-2 text-emerald-600">
                        <i class="fas fa-bolt"></i>
                        <span class="text-sm font-medium">Save {{ config('settings.currency_symbol', '₹') }}{{ number_format($product->compare_at_price - $product->best_price, 2) }} • Limited time offer</span>
                    </div>
                    @endif
                </div>

                <!-- Stock & Delivery -->
                <div class="bg-gradient-to-r from-gray-50 to-emerald-50 rounded-2xl p-4 md:p-6 space-y-4">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-3 h-3 rounded-full {{ $product->stock_quantity > 0 ? 'bg-emerald-500' : 'bg-red-500' }}"></div>
                            <div>
                                <span class="font-medium text-gray-900">{{ $product->stock_quantity > 0 ? 'In Stock' : 'Out of Stock' }}</span>
                                @if($product->stock_quantity > 0)
                                <span class="text-gray-600 ml-2">• {{ $product->stock_quantity }} units available</span>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center space-x-2 text-emerald-600">
                            <i class="fas fa-shipping-fast"></i>
                            <span class="font-medium">Free delivery tomorrow</span>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2 text-sm text-gray-600">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Deliver to <span class="font-medium">New York 10001</span></span>
                        <button class="text-emerald-600 hover:text-emerald-700 font-medium ml-2">Change</button>
                    </div>
                </div>

                <!-- Variations -->
                @if($product->variants->count() > 0)
                <div class="space-y-3">
                    <label class="block text-sm font-medium text-gray-700">Select Option:</label>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-2 md:gap-3">
                        @foreach($product->variants as $variant)
                        <label class="variant-option cursor-pointer">
                            <input type="radio" name="variant" value="{{ $variant->id }}" 
                                   data-price="{{ $variant->price }}" 
                                   data-stock="{{ $variant->stock_quantity }}"
                                   class="hidden peer" {{ $loop->first ? 'checked' : '' }}>
                            <div class="border-2 border-gray-200 rounded-xl p-3 md:p-4 text-center transition-all duration-300 hover:border-emerald-400 peer-checked:border-emerald-500 peer-checked:bg-emerald-50">
                                <div class="font-medium text-gray-900 text-sm md:text-base">{{ $variant->name }}</div>
                                <div class="text-emerald-600 font-bold mt-1 text-sm md:text-base">{{ config('settings.currency_symbol', '₹') }}{{ number_format($variant->price, 2) }}</div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Quantity -->
                <div class="space-y-3">
                    <label class="block text-sm font-medium text-gray-700">Quantity:</label>
                    <div class="flex flex-col sm:flex-row sm:items-center space-y-3 sm:space-y-0 sm:space-x-4">
                        <div class="flex items-center border border-gray-200 rounded-xl overflow-hidden w-fit">
                            <button id="decreaseQty" class="w-10 h-10 md:w-12 md:h-12 flex items-center justify-center bg-gray-50 hover:bg-gray-100 text-gray-600 disabled:opacity-50 disabled:cursor-not-allowed" {{ $product->stock_quantity < 2 ? 'disabled' : '' }}>
                                <i class="fas fa-minus text-sm"></i>
                            </button>
                            <input type="number" 
                                   id="quantity" 
                                   name="quantity" 
                                   value="1" 
                                   min="1" 
                                   max="{{ $product->stock_quantity }}"
                                   class="w-12 h-10 md:w-16 md:h-12 text-center text-base md:text-lg font-medium border-x border-gray-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                            <button id="increaseQty" class="w-10 h-10 md:w-12 md:h-12 flex items-center justify-center bg-gray-50 hover:bg-gray-100 text-gray-600">
                                <i class="fas fa-plus text-sm"></i>
                            </button>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button class="quick-qty-btn" data-qty="3">+3</button>
                            <button class="quick-qty-btn" data-qty="5">+5</button>
                            <button class="quick-qty-btn" data-qty="10">+10</button>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2 text-sm text-amber-600">
                        <i class="fas fa-percentage"></i>
                        <span>Buy 3+, save 5% • Buy 5+, save 10%</span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-4">
                    <button id="addToCartBtn"
                            data-id="{{ $product->id }}"
                            data-name="{{ $product->name }}"
                            data-price="{{ $product->best_price }}"
                            data-image="{{ $product->media->first()->media_url ?? asset('images/placeholder.jpg') }}"
                            class="h-12 md:h-14 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white font-bold rounded-xl flex items-center justify-center space-x-2 transition-all duration-300 hover:shadow-lg hover:shadow-emerald-100 active:scale-[0.98] disabled:opacity-70 disabled:cursor-not-allowed"
                            {{ $product->stock_quantity < 1 ? 'disabled' : '' }}>
                        <i class="fas fa-shopping-cart"></i>
                        <span>Add to Cart</span>
                        <span class="ml-2 bg-white/20 px-2 py-0.5 rounded-full text-xs">+{{ rand(50, 200) }} today</span>
                    </button>
                    <button id="buyNowBtn"
                            data-id="{{ $product->id }}"
                            class="h-12 md:h-14 bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white font-bold rounded-xl flex items-center justify-center space-x-2 transition-all duration-300 hover:shadow-lg hover:shadow-amber-100 active:scale-[0.98] disabled:opacity-70 disabled:cursor-not-allowed"
                            {{ $product->stock_quantity < 1 ? 'disabled' : '' }}>
                        <i class="fas fa-bolt"></i>
                        <span>Buy Now</span>
                    </button>
                </div>

                <!-- Trust Badges -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-4 pt-6 border-t border-gray-100">
                    <div class="text-center space-y-2">
                        <div class="w-10 h-10 md:w-12 md:h-12 bg-emerald-100 rounded-full flex items-center justify-center mx-auto">
                            <i class="fas fa-shield-alt text-emerald-600 text-lg md:text-xl"></i>
                        </div>
                        <div class="text-xs md:text-sm">
                            <div class="font-medium text-gray-900">Secure</div>
                            <div class="text-gray-600">100% Safe</div>
                        </div>
                    </div>
                    <div class="text-center space-y-2">
                        <div class="w-10 h-10 md:w-12 md:h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto">
                            <i class="fas fa-undo text-purple-600 text-lg md:text-xl"></i>
                        </div>
                        <div class="text-xs md:text-sm">
                            <div class="font-medium text-gray-900">30-Day Returns</div>
                            <div class="text-gray-600">Easy Returns</div>
                        </div>
                    </div>
                    <div class="text-center space-y-2">
                        <div class="w-10 h-10 md:w-12 md:h-12 bg-amber-100 rounded-full flex items-center justify-center mx-auto">
                            <i class="fas fa-award text-amber-600 text-lg md:text-xl"></i>
                        </div>
                        <div class="text-xs md:text-sm">
                            <div class="font-medium text-gray-900">Quality</div>
                            <div class="text-gray-600">Guaranteed</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Details Tabs -->
        <div class="bg-white rounded-2xl shadow-sm mb-8 overflow-hidden">
            <!-- Tab Navigation -->
            <div class="border-b border-gray-200">
                <div class="flex overflow-x-auto scrollbar-hide">
                    <button data-tab="description" class="tab-btn active px-4 md:px-6 py-3 md:py-4 font-medium text-gray-900 border-b-2 border-emerald-500 whitespace-nowrap">
                        Description
                    </button>
                    <button data-tab="specifications" class="tab-btn px-4 md:px-6 py-3 md:py-4 font-medium text-gray-600 hover:text-gray-900 whitespace-nowrap">
                        Specifications
                    </button>
                    <button data-tab="reviews" class="tab-btn px-4 md:px-6 py-3 md:py-4 font-medium text-gray-600 hover:text-gray-900 whitespace-nowrap">
                        Reviews ({{ $product->reviews->count() }})
                    </button>
                    <button data-tab="shipping" class="tab-btn px-4 md:px-6 py-3 md:py-4 font-medium text-gray-600 hover:text-gray-900 whitespace-nowrap">
                        Shipping & Returns
                    </button>
                    <button data-tab="faq" class="tab-btn px-4 md:px-6 py-3 md:py-4 font-medium text-gray-600 hover:text-gray-900 whitespace-nowrap">
                        FAQ
                    </button>
                </div>
            </div>

            <!-- Tab Content -->
            <div class="p-4 md:p-8">
                <!-- Description -->
                <div id="description" class="tab-content active">
                    <div class="prose max-w-none text-sm md:text-base">
                        {!! $product->full_description ?? $product->description !!}
                    </div>
                </div>

                <!-- Specifications -->
                <div id="specifications" class="tab-content hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
                        <div>
                            <h3 class="text-lg md:text-xl font-bold text-gray-900 mb-4 md:mb-6">Product Details</h3>
                            <dl class="space-y-3 md:space-y-4">
                                <div class="flex justify-between border-b border-gray-100 pb-3">
                                    <dt class="text-gray-600 text-sm md:text-base">SKU</dt>
                                    <dd class="font-medium text-sm md:text-base">{{ $product->sku ?? 'GF-' . str_pad($product->id, 6, '0', STR_PAD_LEFT) }}</dd>
                                </div>
                                <div class="flex justify-between border-b border-gray-100 pb-3">
                                    <dt class="text-gray-600 text-sm md:text-base">Weight</dt>
                                    <dd class="font-medium text-sm md:text-base">{{ $product->weight ?? '500g' }}</dd>
                                </div>
                                <div class="flex justify-between border-b border-gray-100 pb-3">
                                    <dt class="text-gray-600 text-sm md:text-base">Dimensions</dt>
                                    <dd class="font-medium text-sm md:text-base">{{ $product->dimensions ?? '20 × 15 × 5 cm' }}</dd>
                                </div>
                                <div class="flex justify-between border-b border-gray-100 pb-3">
                                    <dt class="text-gray-600 text-sm md:text-base">Shelf Life</dt>
                                    <dd class="font-medium text-sm md:text-base">12 Months</dd>
                                </div>
                                <div class="flex justify-between border-b border-gray-100 pb-3">
                                    <dt class="text-gray-600 text-sm md:text-base">Storage</dt>
                                    <dd class="font-medium text-sm md:text-base">Cool, dry place</dd>
                                </div>
                                <div class="flex justify-between pb-3">
                                    <dt class="text-gray-600 text-sm md:text-base">Origin</dt>
                                    <dd class="font-medium text-sm md:text-base">USA</dd>
                                </div>
                            </dl>
                        </div>
                        <div>
                            <h3 class="text-lg md:text-xl font-bold text-gray-900 mb-4 md:mb-6">Nutrition Facts</h3>
                            <div class="bg-gray-50 rounded-xl p-4 md:p-6">
                                <p class="text-gray-600">Nutrition information coming soon...</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reviews -->
                <div id="reviews" class="tab-content hidden">
                    <div class="flex items-center space-x-4 md:space-x-8 mb-6 md:mb-8">
                        <div class="text-center">
                            <div class="text-4xl md:text-5xl font-bold text-gray-900">{{ number_format($product->average_rating ?? 0, 1) }}</div>
                            <div class="flex items-center justify-center space-x-1 mt-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= floor($product->average_rating ?? 0) ? 'text-amber-400' : 'text-gray-300' }} text-sm md:text-base"></i>
                                @endfor
                            </div>
                            <div class="text-gray-600 mt-2 text-sm md:text-base">{{ $product->total_reviews ?? 0 }} reviews</div>
                        </div>
                        <div class="flex-1">
                            <p class="text-gray-600">Be the first to review this product!</p>
                        </div>
                    </div>
                </div>

                <!-- Shipping -->
                <div id="shipping" class="tab-content hidden">
                    <div class="space-y-4 md:space-y-6">
                        <div class="bg-gray-50 rounded-xl p-4 md:p-6">
                            <h4 class="font-bold text-base md:text-lg text-gray-900 mb-2 md:mb-3">Shipping Information</h4>
                            <ul class="space-y-2 md:space-y-3 text-gray-600">
                                <li class="flex items-start">
                                    <i class="fas fa-shipping-fast text-emerald-500 mt-1 mr-3 text-sm md:text-base"></i>
                                    <span class="text-sm md:text-base">Free standard shipping on orders over $50</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-clock text-emerald-500 mt-1 mr-3 text-sm md:text-base"></i>
                                    <span class="text-sm md:text-base">Delivery within 2-5 business days</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-map-marker-alt text-emerald-500 mt-1 mr-3 text-sm md:text-base"></i>
                                    <span class="text-sm md:text-base">Track your order with real-time updates</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- FAQ -->
                <div id="faq" class="tab-content hidden">
                    <div class="space-y-4">
                        <div class="bg-gray-50 rounded-xl p-4 md:p-6">
                            <p class="text-gray-600">FAQ section coming soon...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Zoom Modal -->
<div id="zoomModal" class="fixed inset-0 bg-black/90 z-50 hidden items-center justify-center p-4">
    <div class="relative max-w-6xl max-h-[90vh] w-full">
        <img id="zoomedImage" src="" alt="" class="w-full h-full object-contain">
        <button onclick="closeZoom()" class="absolute top-2 md:top-4 right-2 md:right-4 text-white text-2xl hover:text-gray-300 bg-black/50 rounded-full w-8 h-8 md:w-10 md:h-10 flex items-center justify-center">
            <i class="fas fa-times"></i>
        </button>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Hide scrollbar for tab navigation */
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    
    .thumbnail-item {
        transition: all 0.3s ease;
    }
    
    .thumbnail-item:hover {
        transform: translateY(-2px);
    }
    
    .quick-qty-btn {
        @apply px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-medium transition-colors;
    }
    
    .tab-btn {
        transition: all 0.3s ease;
        position: relative;
        padding-bottom: 12px;
    }
    
    .tab-btn::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        right: 0;
        height: 2px;
        background-color: transparent;
        transition: background-color 0.3s ease;
    }
    
    .tab-btn.active::after {
        background-color: #10b981;
    }
    
    .tab-content {
        animation: fadeIn 0.3s ease;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    /* Toast Notification */
    .toast {
        animation: slideIn 0.3s ease forwards;
    }
    
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    
    /* Loading spinner */
    .loading-spinner {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 3px solid rgba(255,255,255,.3);
        border-radius: 50%;
        border-top-color: #fff;
        animation: spin 1s ease-in-out infinite;
    }
    
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    
    /* Image zoom animation */
    .zoom-image {
        transition: transform 0.3s ease;
    }
    
    .zoom-image:hover {
        transform: scale(1.5);
    }
</style>
@endpush

@push('scripts')
<script>
// Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Initialize product variables
    const product = {
        id: {{ $product->id }},
        name: '{{ addslashes($product->name) }}',
        price: {{ $product->best_price }},
        stock: {{ $product->stock_quantity }},
        currencySymbol: '{{ config("settings.currency_symbol", "₹") }}'
    };

    // Image Gallery with error handling
    const mainImage = document.getElementById('mainProductImage');
    const thumbnails = document.querySelectorAll('.thumbnail-item');
    let currentImageIndex = 0;
    
    // Function to safely change main image
    window.changeMainImage = function(element, index) {
        try {
            const img = element.querySelector('img');
            if (!img || !img.src) {
                throw new Error('Image not found');
            }
            
            // Add loading state
            mainImage.classList.add('opacity-50');
            
            // Preload image
            const newImage = new Image();
            newImage.src = img.src;
            newImage.onload = function() {
                mainImage.src = img.src;
                mainImage.classList.remove('opacity-50');
                currentImageIndex = index;
                
                // Update active thumbnail
                thumbnails.forEach((thumb, i) => {
                    thumb.classList.remove('border-emerald-500', 'ring-2', 'ring-emerald-200');
                    if (i === index) {
                        thumb.classList.add('border-emerald-500', 'ring-2', 'ring-emerald-200');
                    }
                });
            };
            
            newImage.onerror = function() {
                mainImage.src = '{{ asset("images/placeholder.jpg") }}';
                mainImage.classList.remove('opacity-50');
                showToast('Failed to load image', 'error');
            };
        } catch (error) {
            console.error('Error changing image:', error);
            showToast('Error loading image', 'error');
        }
    };
    
    // Zoom Image with fallback
    window.zoomImage = function() {
        try {
            const modal = document.getElementById('zoomModal');
            const zoomedImg = document.getElementById('zoomedImage');
            
            if (!mainImage.src) {
                showToast('Image not available', 'error');
                return;
            }
            
            zoomedImg.src = mainImage.src;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
            
            // Close on ESC key
            document.addEventListener('keydown', function zoomKeyHandler(e) {
                if (e.key === 'Escape') {
                    closeZoom();
                    document.removeEventListener('keydown', zoomKeyHandler);
                }
            });
        } catch (error) {
            console.error('Error zooming image:', error);
            showToast('Failed to zoom image', 'error');
        }
    };
    
    window.closeZoom = function() {
        const modal = document.getElementById('zoomModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = 'auto';
    };
    
    // Quantity Controls with validation
    const quantityInput = document.getElementById('quantity');
    const maxStock = parseInt(quantityInput.max) || product.stock;
    const decreaseBtn = document.getElementById('decreaseQty');
    const increaseBtn = document.getElementById('increaseQty');
    
    // Validate input on change
    quantityInput.addEventListener('change', function() {
        let value = parseInt(this.value) || 1;
        
        if (value < 1) {
            value = 1;
        } else if (value > maxStock) {
            value = maxStock;
            showToast(`Maximum stock available is ${maxStock} units`, 'warning');
        }
        
        this.value = value;
        updateButtonsState();
    });
    
    // Decrease quantity
    if (decreaseBtn) {
        decreaseBtn.addEventListener('click', () => {
            let value = parseInt(quantityInput.value) || 1;
            if (value > 1) {
                quantityInput.value = value - 1;
                updateButtonsState();
            }
        });
    }
    
    // Increase quantity
    if (increaseBtn) {
        increaseBtn.addEventListener('click', () => {
            let value = parseInt(quantityInput.value) || 1;
            if (value < maxStock) {
                quantityInput.value = value + 1;
                updateButtonsState();
            } else {
                showToast(`Maximum stock available is ${maxStock} units`, 'warning');
            }
        });
    }
    
    function updateButtonsState() {
        const value = parseInt(quantityInput.value) || 1;
        if (decreaseBtn) {
            decreaseBtn.disabled = value <= 1;
        }
        if (increaseBtn) {
            increaseBtn.disabled = value >= maxStock;
        }
    }
    
    // Quick quantity buttons
    document.querySelectorAll('.quick-qty-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const qty = parseInt(this.dataset.qty) || 0;
            const current = parseInt(quantityInput.value) || 1;
            const newQty = current + qty;
            
            if (newQty <= maxStock) {
                quantityInput.value = newQty;
                updateButtonsState();
            } else {
                quantityInput.value = maxStock;
                updateButtonsState();
                showToast(`Maximum stock available is ${maxStock} units`, 'warning');
            }
        });
    });
    
    // Tab Navigation
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            try {
                const tabId = this.dataset.tab;
                if (!tabId) return;
                
                // Update active tab button
                tabBtns.forEach(b => {
                    b.classList.remove('active', 'border-emerald-500', 'text-gray-900');
                    b.classList.add('text-gray-600');
                });
                this.classList.add('active', 'border-emerald-500', 'text-gray-900');
                this.classList.remove('text-gray-600');
                
                // Show active tab content
                tabContents.forEach(content => {
                    content.classList.add('hidden');
                    content.classList.remove('active');
                });
                
                const activeContent = document.getElementById(tabId);
                if (activeContent) {
                    activeContent.classList.remove('hidden');
                    activeContent.classList.add('active');
                }
            } catch (error) {
                console.error('Error switching tabs:', error);
            }
        });
    });
    
    // Wishlist Toggle with improved error handling
    const wishlistBtn = document.getElementById('wishlistToggleBtn');
    if (wishlistBtn) {
        wishlistBtn.addEventListener('click', async function() {
            const productId = this.dataset.productId;
            const isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
            
            if (!isLoggedIn) {
                showToast('Please login to use wishlist', 'warning');
                setTimeout(() => {
                    window.location.href = '{{ route("login") }}?redirect=' + encodeURIComponent(window.location.pathname);
                }, 1500);
                return;
            }
            
            // Show loading state
            const originalHTML = this.innerHTML;
            this.innerHTML = '<div class="loading-spinner"></div>';
            this.disabled = true;
            
            try {
                const response = await fetch('{{ route("wishlist.toggle") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        product_id: productId
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Toggle the heart icon
                    const icon = this.querySelector('i');
                    if (data.action === 'added') {
                        icon.className = 'fas fa-heart text-xl';
                        this.classList.add('bg-red-50', 'border-red-200', 'text-red-600');
                        showToast('Added to wishlist!', 'success');
                    } else {
                        icon.className = 'far fa-heart text-xl';
                        this.classList.remove('bg-red-50', 'border-red-200', 'text-red-600');
                        showToast('Removed from wishlist', 'info');
                    }
                } else {
                    showToast(data.message || 'Failed to update wishlist', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('Failed to update wishlist. Please try again.', 'error');
            } finally {
                // Restore button state
                this.innerHTML = originalHTML;
                this.disabled = false;
            }
        });
    }
    
    // Add to Cart with loading state
    const addToCartBtn = document.getElementById('addToCartBtn');
    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', async function() {
            if (product.stock < 1) {
                showToast('Product is out of stock', 'error');
                return;
            }
            
            const productId = this.dataset.id;
            const quantity = parseInt(quantityInput.value) || 1;
            
            // Show loading state
            const originalHTML = this.innerHTML;
            this.innerHTML = '<div class="loading-spinner"></div>';
            this.disabled = true;
            
            try {
                const response = await fetch('{{ route("cart.add") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: quantity,
                        variant_id: getSelectedVariantId()
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showToast('Product added to cart!', 'success');
                    triggerCartAnimation();
                    
                    // Update cart count in header
                    updateCartCount(data.cart_count);
                } else {
                    showToast(data.message || 'Failed to add to cart', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('Failed to add to cart. Please try again.', 'error');
            } finally {
                // Restore button state
                this.innerHTML = originalHTML;
                this.disabled = false;
            }
        });
    }
    
    // Buy Now button
    const buyNowBtn = document.getElementById('buyNowBtn');
    if (buyNowBtn) {
        buyNowBtn.addEventListener('click', async function() {
            if (product.stock < 1) {
                showToast('Product is out of stock', 'error');
                return;
            }
            
            @auth
            // Add to cart first
            await addToCartBtn.click();
            // Redirect to checkout after a short delay
            setTimeout(() => {
                window.location.href = '{{ route("checkout.index") }}';
            }, 800);
            @else
            showToast('Please login to continue with purchase', 'warning');
            setTimeout(() => {
                window.location.href = '{{ route("login") }}?redirect=' + encodeURIComponent(window.location.pathname);
            }, 1500);
            @endauth
        });
    }
    
    // Share Product with modern API
    window.shareProduct = function() {
        if (navigator.share) {
            navigator.share({
                title: product.name,
                text: 'Check out this amazing product from Ghazali Food',
                url: window.location.href
            }).catch(err => {
                console.log('Error sharing:', err);
                copyToClipboard();
            });
        } else {
            copyToClipboard();
        }
    };
    
    function copyToClipboard() {
        navigator.clipboard.writeText(window.location.href).then(() => {
            showToast('Link copied to clipboard!', 'success');
        }).catch(err => {
            console.error('Failed to copy:', err);
            showToast('Failed to copy link', 'error');
        });
    }
    
    // Download Image
    window.downloadImage = function(url) {
        if (!url || url.includes('placeholder.jpg')) {
            showToast('Image not available', 'error');
            return;
        }
        
        try {
            const a = document.createElement('a');
            a.href = url;
            a.download = '{{ Str::slug($product->name) }}-product.jpg';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            showToast('Image download started', 'success');
        } catch (error) {
            console.error('Download error:', error);
            showToast('Failed to download image', 'error');
        }
    };
    
    // Get selected variant ID
    function getSelectedVariantId() {
        const selectedVariant = document.querySelector('input[name="variant"]:checked');
        return selectedVariant ? selectedVariant.value : null;
    }
    
    // Update cart count in header
    function updateCartCount(count) {
        const cartCountElements = document.querySelectorAll('.cart-count');
        cartCountElements.forEach(el => {
            el.textContent = count;
        });
    }
    
    // Toast notification system
    function showToast(message, type = 'info') {
        // Remove existing toasts
        document.querySelectorAll('.toast-notification').forEach(toast => {
            toast.remove();
        });
        
        // Create toast element
        const toast = document.createElement('div');
        toast.className = `toast-notification fixed top-4 right-4 z-50 px-6 py-3 rounded-xl shadow-lg text-white font-medium transform transition-all duration-300 translate-x-full ${getToastClass(type)}`;
        toast.textContent = message;
        toast.style.zIndex = '9999';
        
        // Add icon based on type
        const icon = getToastIcon(type);
        toast.innerHTML = `${icon}<span class="ml-2">${message}</span>`;
        
        document.body.appendChild(toast);
        
        // Animate in
        requestAnimationFrame(() => {
            toast.classList.remove('translate-x-full');
            toast.classList.add('translate-x-0');
        });
        
        // Remove after 3 seconds
        setTimeout(() => {
            toast.classList.remove('translate-x-0');
            toast.classList.add('translate-x-full');
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.remove();
                }
            }, 300);
        }, 3000);
    }
    
    function getToastClass(type) {
        const classes = {
            success: 'bg-emerald-500',
            error: 'bg-red-500',
            warning: 'bg-amber-500',
            info: 'bg-blue-500'
        };
        return classes[type] || classes.info;
    }
    
    function getToastIcon(type) {
        const icons = {
            success: '<i class="fas fa-check-circle"></i>',
            error: '<i class="fas fa-exclamation-circle"></i>',
            warning: '<i class="fas fa-exclamation-triangle"></i>',
            info: '<i class="fas fa-info-circle"></i>'
        };
        return icons[type] || icons.info;
    }
    
    // Trigger cart animation
    function triggerCartAnimation() {
        const cartIcon = document.querySelector('.cart-icon');
        if (cartIcon) {
            cartIcon.classList.add('animate-ping');
            setTimeout(() => {
                cartIcon.classList.remove('animate-ping');
            }, 1000);
        }
    }
    
    // Social proof simulation
    function simulateSocialProof() {
        // Random viewer count updates
        const viewerCount = document.getElementById('product-viewers');
        if (viewerCount) {
            const current = parseInt(viewerCount.textContent) || 12;
            viewerCount.textContent = Math.max(1, current + Math.floor(Math.random() * 5) - 2);
        }
        
        // Random purchase pulse
        if (Math.random() > 0.7) {
            const pulse = document.getElementById('recent-purchase-pulse');
            if (pulse) {
                pulse.classList.remove('hidden');
                setTimeout(() => {
                    pulse.classList.add('hidden');
                }, 3000);
            }
        }
    }
    
    // Start social proof simulation
    setInterval(simulateSocialProof, 8000);
    
    // Initialize buttons state
    updateButtonsState();
    
    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // ESC to close zoom
        if (e.key === 'Escape') {
            closeZoom();
        }
        
        // Left/Right arrow for image navigation
        if (e.key === 'ArrowLeft' || e.key === 'ArrowRight') {
            if (!thumbnails.length) return;
            
            let newIndex = currentImageIndex;
            if (e.key === 'ArrowLeft') {
                newIndex = (currentImageIndex - 1 + thumbnails.length) % thumbnails.length;
            } else if (e.key === 'ArrowRight') {
                newIndex = (currentImageIndex + 1) % thumbnails.length;
            }
            
            const thumbnail = thumbnails[newIndex];
            if (thumbnail) {
                changeMainImage(thumbnail, newIndex);
            }
        }
    });
    
    // Error handling for images
    mainImage.addEventListener('error', function() {
        this.src = '{{ asset("images/placeholder.jpg") }}';
    });
    
    // Lazy load thumbnails
    const observerOptions = {
        root: null,
        rootMargin: '50px',
        threshold: 0.1
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target.querySelector('img');
                if (img && img.dataset.src) {
                    img.src = img.dataset.src;
                    img.removeAttribute('data-src');
                }
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    // Observe thumbnails for lazy loading
    thumbnails.forEach(thumbnail => {
        observer.observe(thumbnail);
    });
});

// Global error handler
window.addEventListener('error', function(e) {
    console.error('Global error:', e.error);
});
</script>
@endpush