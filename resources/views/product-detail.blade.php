@extends('layouts.app')

@section('title', $product->name . ' - Ghazali Food')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-emerald-50 to-amber-50 dark:from-emerald-900/20 dark:to-amber-900/20">
        <div class="container mx-auto px-4 py-6">
            <nav class="flex items-center space-x-2 text-sm text-gray-600 dark:text-gray-400 overflow-x-auto py-1">
                <a href="{{ url('/') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors whitespace-nowrap">Home</a>
                <span class="text-gray-400 dark:text-gray-600">/</span>
                <a href="{{ route('shop.index') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors whitespace-nowrap">Shop</a>
                @if($product->category)
                <span class="text-gray-400 dark:text-gray-600">/</span>
                <a href="{{ route('category.show', $product->category->slug) }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors whitespace-nowrap">{{ $product->category->name }}</a>
                @endif
                <span class="text-gray-400 dark:text-gray-600">/</span>
                <span class="text-gray-900 dark:text-white font-medium truncate whitespace-nowrap">{{ Str::limit($product->name, 30) }}</span>
            </nav>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <!-- Social Proof Banner -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm dark:shadow-gray-900/20 p-6 mb-8 border border-gray-100 dark:border-gray-700 transition-colors duration-300">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex flex-wrap items-center gap-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-emerald-100 dark:bg-emerald-900/30 rounded-full flex items-center justify-center">
                            <i class="fas fa-eye text-emerald-600 dark:text-emerald-400 text-sm"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">Currently viewing</p>
                            <p class="text-gray-900 dark:text-white font-bold text-lg" id="current-viewers">124</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-amber-100 dark:bg-amber-900/30 rounded-full flex items-center justify-center">
                            <i class="fas fa-shopping-cart text-amber-600 dark:text-amber-400 text-sm"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">Bought today</p>
                            <p class="text-gray-900 dark:text-white font-bold text-lg" id="recent-purchases">87</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center">
                            <i class="fas fa-fire text-red-600 dark:text-red-400 text-sm"></i>
                        </div>
                        <div>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">Trending at</p>
                            <p class="text-gray-900 dark:text-white font-bold text-lg">#3 in {{ $product->category->name ?? 'Dry Fruits' }}</p>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="px-4 py-2 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 rounded-full text-sm font-medium whitespace-nowrap flex items-center gap-2">
                        <i class="fas fa-check-circle"></i>100% Authentic
                    </div>
                    <div class="px-4 py-2 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-full text-sm font-medium whitespace-nowrap flex items-center gap-2">
                        <i class="fas fa-truck"></i>Free Shipping
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Main Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 mb-12">
            <!-- Product Gallery -->
            <div class="space-y-6">
                <!-- Main Image -->
                <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-xl dark:shadow-gray-900/30 overflow-hidden group transition-colors duration-300">
                    <!-- Badges -->
                    <div class="absolute top-4 left-4 z-10 flex flex-col space-y-2">
                        @if($product->is_new_arrival)
                        <span class="px-4 py-2 bg-gradient-to-r from-emerald-500 to-emerald-600 text-white text-xs font-bold rounded-full shadow-lg flex items-center space-x-2">
                            <i class="fas fa-star text-xs"></i>
                            <span>NEW ARRIVAL</span>
                        </span>
                        @endif
                        @if($product->compare_at_price && $product->compare_at_price > $product->best_price)
                        <span class="px-4 py-2 bg-gradient-to-r from-red-500 to-red-600 text-white text-xs font-bold rounded-full shadow-lg">
                            -{{ $product->discount_percentage }}% OFF
                        </span>
                        @endif
                    </div>

                    <!-- Image -->
                    <div class="relative overflow-hidden">
                        <img src="{{ $product->media->first()->media_url ?? asset('images/placeholder.jpg') }}"
                             id="mainProductImage"
                             alt="{{ $product->name }}"
                             class="w-full h-[400px] md:h-[500px] object-contain transition-all duration-500 group-hover:scale-110 cursor-zoom-in">
                        
                        <!-- Loading Overlay -->
                        <div id="imageLoadingOverlay" class="absolute inset-0 bg-white dark:bg-gray-800 bg-opacity-70 dark:bg-opacity-70 flex items-center justify-center hidden">
                            <div class="w-12 h-12 border-4 border-emerald-500 border-t-transparent rounded-full animate-spin"></div>
                        </div>
                    </div>

                    <!-- Live Badge -->
                    <div class="absolute bottom-4 right-4 bg-black/80 backdrop-blur-sm text-white px-4 py-2 rounded-full text-sm flex items-center space-x-2 shadow-lg">
                        <div class="relative">
                            <div class="w-2.5 h-2.5 bg-red-500 rounded-full animate-ping absolute"></div>
                            <div class="w-2.5 h-2.5 bg-red-500 rounded-full"></div>
                        </div>
                        <span id="product-viewers">12</span> viewing live
                    </div>

                    <!-- Purchase Alert -->
                    <div id="recent-purchase-pulse" class="absolute top-4 right-4 bg-gradient-to-r from-amber-500 to-orange-500 text-white px-4 py-2 rounded-full text-sm flex items-center space-x-2 animate-pulse shadow-lg hidden">
                        <i class="fas fa-bolt"></i>
                        <span>Just purchased!</span>
                    </div>
                </div>

                <!-- Thumbnails -->
                @if($product->media->count() > 1)
                <div class="flex space-x-3 overflow-x-auto pb-4 scrollbar-hide">
                    @foreach($product->media as $index => $media)
                    <div class="thumbnail-item flex-shrink-0 w-20 h-20 rounded-xl overflow-hidden border-2 border-transparent cursor-pointer transition-all duration-300 hover:border-emerald-500 dark:hover:border-emerald-400 {{ $index === 0 ? 'border-emerald-500 dark:border-emerald-400 ring-2 ring-emerald-200 dark:ring-emerald-900' : '' }}"
                         data-image="{{ $media->media_url }}"
                         onclick="changeMainImage(this, {{ $index }})">
                        <img src="{{ $media->media_url }}"
                             alt="{{ $product->name }} - {{ $index + 1 }}"
                             class="w-full h-full object-cover hover:scale-110 transition-transform duration-300">
                    </div>
                    @endforeach
                </div>
                @endif

                <!-- Image Actions -->
                <div class="grid grid-cols-3 gap-3">
                    <button onclick="zoomImage()" class="flex items-center justify-center space-x-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl py-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-300 group">
                        <i class="fas fa-search-plus text-gray-600 dark:text-gray-400 group-hover:text-emerald-600 dark:group-hover:text-emerald-400"></i>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-emerald-700 dark:group-hover:text-emerald-300">Zoom</span>
                    </button>
                    <button onclick="shareProduct()" class="flex items-center justify-center space-x-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl py-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-300 group">
                        <i class="fas fa-share-alt text-gray-600 dark:text-gray-400 group-hover:text-emerald-600 dark:group-hover:text-emerald-400"></i>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-emerald-700 dark:group-hover:text-emerald-300">Share</span>
                    </button>
                    <button onclick="downloadImage('{{ $product->media->first()->media_url ?? '' }}')" class="flex items-center justify-center space-x-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl py-3 hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-300 group">
                        <i class="fas fa-download text-gray-600 dark:text-gray-400 group-hover:text-emerald-600 dark:group-hover:text-emerald-400"></i>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-emerald-700 dark:group-hover:text-emerald-300">Download</span>
                    </button>
                </div>
            </div>

            <!-- Product Info -->
            <div class="space-y-6">
                <!-- Product Header -->
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex flex-wrap items-center gap-2 mb-4">
                            @if($product->category)
                            <span class="px-3 py-1.5 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 rounded-full text-xs font-medium whitespace-nowrap">
                                {{ $product->category->name }}
                            </span>
                            @endif
                            <span class="px-3 py-1.5 bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 rounded-full text-xs font-medium whitespace-nowrap flex items-center gap-1">
                                <i class="fas fa-crown text-xs"></i>Ghazali Premium
                            </span>
                            @if($product->is_featured)
                            <span class="px-3 py-1.5 bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 rounded-full text-xs font-medium whitespace-nowrap">
                                <i class="fas fa-star text-xs"></i> Featured
                            </span>
                            @endif
                        </div>
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-3">{{ $product->name }}</h1>
                        <div class="flex flex-wrap items-center gap-3 md:gap-4 mb-6">
                            <div class="flex items-center">
                                @php
                                    $avgRating = $product->average_rating ?? 0;
                                @endphp
                                <div class="flex items-center mr-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= floor($avgRating))
                                        <i class="fas fa-star text-amber-400 text-base"></i>
                                        @elseif($i - 0.5 <= $avgRating)
                                        <i class="fas fa-star-half-alt text-amber-400 text-base"></i>
                                        @else
                                        <i class="far fa-star text-amber-400 text-base"></i>
                                        @endif
                                    @endfor
                                </div>
                                <span class="text-gray-600 dark:text-gray-400 text-sm">({{ $product->total_reviews ?? 0 }} reviews)</span>
                            </div>
                            <span class="text-gray-400 dark:text-gray-600 hidden md:inline">•</span>
                            <span class="text-gray-600 dark:text-gray-400 text-sm flex items-center gap-2">
                                <i class="fas fa-hashtag text-xs"></i>
                                {{ $product->sku ?? 'GF-' . str_pad($product->id, 6, '0', STR_PAD_LEFT) }}
                            </span>
                        </div>
                    </div>
                    <button id="wishlistToggleBtn" 
                            data-product-id="{{ $product->id }}"
                            class="w-14 h-14 rounded-full border border-gray-200 dark:border-gray-700 flex items-center justify-center hover:bg-red-50 dark:hover:bg-red-900/20 hover:border-red-200 dark:hover:border-red-800 transition-all duration-300 group {{ Auth::check() && Auth::user()->wishlist()->where('product_id', $product->id)->exists() ? 'bg-red-50 dark:bg-red-900/30 border-red-200 dark:border-red-800 text-red-600 dark:text-red-400' : 'bg-white dark:bg-gray-800 text-gray-400 dark:text-gray-600' }} ml-4">
                        <i class="{{ Auth::check() && Auth::user()->wishlist()->where('product_id', $product->id)->exists() ? 'fas' : 'far' }} fa-heart text-2xl group-hover:text-red-500 dark:group-hover:text-red-400"></i>
                    </button>
                </div>

                <!-- Short Description -->
                <p class="text-gray-600 dark:text-gray-300 text-lg leading-relaxed border-b border-gray-100 dark:border-gray-800 pb-6 mb-6">
                    {{ $product->short_description ?? Str::limit($product->description, 200) }}
                </p>

                <!-- Pricing -->
                <div class="space-y-3 mb-6">
                    <div class="flex flex-wrap items-center gap-4">
                        <span class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white">{{ config('settings.currency_symbol', '₹') }}{{ number_format($product->best_price, 2) }}</span>
                        @if($product->compare_at_price && $product->compare_at_price > $product->best_price)
                        <span class="text-2xl md:text-3xl text-gray-400 dark:text-gray-600 line-through">{{ config('settings.currency_symbol', '₹') }}{{ number_format($product->compare_at_price, 2) }}</span>
                        <span class="px-4 py-2 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 font-bold rounded-xl whitespace-nowrap text-lg">
                            Save {{ $product->discount_percentage }}%
                        </span>
                        @endif
                    </div>
                    @if($product->compare_at_price && $product->compare_at_price > $product->best_price)
                    <div class="flex items-center space-x-3 text-emerald-600 dark:text-emerald-400">
                        <i class="fas fa-bolt"></i>
                        <span class="text-sm font-medium">Save {{ config('settings.currency_symbol', '₹') }}{{ number_format($product->compare_at_price - $product->best_price, 2) }} • Limited time offer</span>
                    </div>
                    @endif
                </div>

                <!-- Stock & Delivery -->
                <div class="bg-gradient-to-r from-gray-50 to-emerald-50 dark:from-gray-800 dark:to-emerald-900/10 rounded-2xl p-6 space-y-4 mb-6 transition-colors duration-300">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="flex items-center space-x-3">
                            <div class="relative">
                                <div class="w-4 h-4 rounded-full {{ $product->stock_quantity > 0 ? 'bg-emerald-500' : 'bg-red-500' }}"></div>
                                @if($product->stock_quantity > 0 && $product->stock_quantity < 10)
                                <div class="absolute -top-1 -right-1 w-2 h-2 bg-amber-500 rounded-full animate-ping"></div>
                                @endif
                            </div>
                            <div>
                                <span class="font-bold text-gray-900 dark:text-white text-lg">{{ $product->stock_quantity > 0 ? 'In Stock' : 'Out of Stock' }}</span>
                                @if($product->stock_quantity > 0)
                                <span class="text-gray-600 dark:text-gray-400 ml-2">• {{ $product->stock_quantity }} units available</span>
                                @endif
                            </div>
                        </div>
                        @if($product->stock_quantity > 0 && $product->stock_quantity < 10)
                        <div class="px-4 py-2 bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 rounded-full text-sm font-medium">
                            <i class="fas fa-exclamation-triangle mr-2"></i>Low stock
                        </div>
                        @endif
                    </div>
                    <div class="flex items-center space-x-3 text-sm text-gray-600 dark:text-gray-400">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Deliver to <span class="font-medium text-gray-900 dark:text-white">New York 10001</span></span>
                        <button class="text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300 font-medium ml-2">Change</button>
                    </div>
                    <div class="flex items-center space-x-2 text-sm text-gray-600 dark:text-gray-400">
                        <i class="fas fa-shipping-fast"></i>
                        <span>Free shipping on orders over $50</span>
                    </div>
                </div>

                <!-- Variations -->
                @if($product->variants->count() > 0)
                <div class="space-y-4 mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Select Option:</label>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        @foreach($product->variants as $variant)
                        <label class="variant-option cursor-pointer">
                            <input type="radio" name="variant" value="{{ $variant->id }}" 
                                   data-price="{{ $variant->price }}" 
                                   data-stock="{{ $variant->stock_quantity }}"
                                   class="hidden peer" {{ $loop->first ? 'checked' : '' }}>
                            <div class="border-2 border-gray-200 dark:border-gray-700 rounded-xl p-4 text-center transition-all duration-300 hover:border-emerald-400 dark:hover:border-emerald-500 peer-checked:border-emerald-500 dark:peer-checked:border-emerald-400 peer-checked:bg-emerald-50 dark:peer-checked:bg-emerald-900/20">
                                <div class="font-medium text-gray-900 dark:text-white text-base mb-2">{{ $variant->name }}</div>
                                <div class="text-emerald-600 dark:text-emerald-400 font-bold text-lg">{{ config('settings.currency_symbol', '₹') }}{{ number_format($variant->price, 2) }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $variant->stock_quantity }} in stock</div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Quantity -->
                <div class="space-y-4 mb-8">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Quantity:</label>
                    <div class="flex flex-col sm:flex-row sm:items-center space-y-3 sm:space-y-0 sm:space-x-6">
                        <div class="flex items-center border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden w-fit bg-white dark:bg-gray-800">
                            <button id="decreaseQty" class="w-12 h-12 flex items-center justify-center bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-400 disabled:opacity-30 disabled:cursor-not-allowed transition-colors" {{ $product->stock_quantity < 2 ? 'disabled' : '' }}>
                                <i class="fas fa-minus text-sm"></i>
                            </button>
                            <input type="number" 
                                   id="quantity" 
                                   name="quantity" 
                                   value="1" 
                                   min="1" 
                                   max="{{ $product->stock_quantity }}"
                                   class="w-16 h-12 text-center text-lg font-medium border-x border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-emerald-500 dark:focus:ring-emerald-400 focus:border-transparent">
                            <button id="increaseQty" class="w-12 h-12 flex items-center justify-center bg-gray-50 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-400 transition-colors">
                                <i class="fas fa-plus text-sm"></i>
                            </button>
                        </div>
                        <div class="flex flex-wrap items-center gap-2">
                            <button class="quick-qty-btn" data-qty="3">+3</button>
                            <button class="quick-qty-btn" data-qty="5">+5</button>
                            <button class="quick-qty-btn" data-qty="10">+10</button>
                            <button class="quick-qty-btn max" onclick="setMaxQuantity()">MAX</button>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2 text-sm text-amber-600 dark:text-amber-400">
                        <i class="fas fa-percentage"></i>
                        <span>Buy 3+, save 5% • Buy 5+, save 10% • Buy 10+, save 15%</span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                    <button id="addToCartBtn"
                            data-id="{{ $product->id }}"
                            data-name="{{ $product->name }}"
                            data-price="{{ $product->best_price }}"
                            data-image="{{ $product->media->first()->media_url ?? asset('images/placeholder.jpg') }}"
                            class="h-14 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 dark:from-emerald-600 dark:to-emerald-700 dark:hover:from-emerald-700 dark:hover:to-emerald-800 text-white font-bold rounded-xl flex items-center justify-center space-x-3 transition-all duration-300 hover:shadow-lg hover:shadow-emerald-100 dark:hover:shadow-emerald-900/30 active:scale-[0.98] disabled:opacity-50 disabled:cursor-not-allowed group"
                            {{ $product->stock_quantity < 1 ? 'disabled' : '' }}>
                        <i class="fas fa-shopping-cart text-lg"></i>
                        <span class="text-base">Add to Cart</span>
                        <span class="ml-2 bg-white/20 px-3 py-1 rounded-full text-xs font-medium">+{{ rand(50, 200) }} today</span>
                    </button>
                    <button id="buyNowBtn"
                            data-id="{{ $product->id }}"
                            class="h-14 bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 dark:from-amber-600 dark:to-orange-600 dark:hover:from-amber-700 dark:hover:to-orange-700 text-white font-bold rounded-xl flex items-center justify-center space-x-3 transition-all duration-300 hover:shadow-lg hover:shadow-amber-100 dark:hover:shadow-amber-900/30 active:scale-[0.98] disabled:opacity-50 disabled:cursor-not-allowed"
                            {{ $product->stock_quantity < 1 ? 'disabled' : '' }}>
                        <i class="fas fa-bolt text-lg"></i>
                        <span class="text-base">Buy Now</span>
                    </button>
                </div>

                <!-- Trust Badges -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 pt-6 border-t border-gray-100 dark:border-gray-800">
                    <div class="text-center space-y-2">
                        <div class="w-12 h-12 bg-emerald-100 dark:bg-emerald-900/30 rounded-full flex items-center justify-center mx-auto transition-colors duration-300">
                            <i class="fas fa-shield-alt text-emerald-600 dark:text-emerald-400 text-xl"></i>
                        </div>
                        <div class="text-sm">
                            <div class="font-bold text-gray-900 dark:text-white">100% Secure</div>
                            <div class="text-gray-600 dark:text-gray-400">SSL Protected</div>
                        </div>
                    </div>
                    <div class="text-center space-y-2">
                        <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 rounded-full flex items-center justify-center mx-auto transition-colors duration-300">
                            <i class="fas fa-undo text-purple-600 dark:text-purple-400 text-xl"></i>
                        </div>
                        <div class="text-sm">
                            <div class="font-bold text-gray-900 dark:text-white">30-Day Returns</div>
                            <div class="text-gray-600 dark:text-gray-400">Easy Returns</div>
                        </div>
                    </div>
                    <div class="text-center space-y-2">
                        <div class="w-12 h-12 bg-amber-100 dark:bg-amber-900/30 rounded-full flex items-center justify-center mx-auto transition-colors duration-300">
                            <i class="fas fa-award text-amber-600 dark:text-amber-400 text-xl"></i>
                        </div>
                        <div class="text-sm">
                            <div class="font-bold text-gray-900 dark:text-white">Quality Guaranteed</div>
                            <div class="text-gray-600 dark:text-gray-400">Premium Grade</div>
                        </div>
                    </div>
                    <div class="text-center space-y-2">
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center mx-auto transition-colors duration-300">
                            <i class="fas fa-headset text-blue-600 dark:text-blue-400 text-xl"></i>
                        </div>
                        <div class="text-sm">
                            <div class="font-bold text-gray-900 dark:text-white">24/7 Support</div>
                            <div class="text-gray-600 dark:text-gray-400">Dedicated Help</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Details Tabs -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm dark:shadow-gray-900/20 mb-8 overflow-hidden transition-colors duration-300">
            <!-- Tab Navigation -->
            <div class="border-b border-gray-100 dark:border-gray-700">
                <div class="flex overflow-x-auto scrollbar-hide px-2">
                    <button data-tab="description" class="tab-btn active px-6 py-4 font-bold text-emerald-600 dark:text-emerald-400 border-b-2 border-emerald-500 dark:border-emerald-400 whitespace-nowrap transition-colors duration-300">
                        <i class="fas fa-file-alt mr-2"></i>Description
                    </button>
                    <button data-tab="specifications" class="tab-btn px-6 py-4 font-medium text-gray-600 dark:text-gray-400 hover:text-emerald-600 dark:hover:text-emerald-400 whitespace-nowrap transition-colors duration-300">
                        <i class="fas fa-list-alt mr-2"></i>Specifications
                    </button>
                    <button data-tab="reviews" class="tab-btn px-6 py-4 font-medium text-gray-600 dark:text-gray-400 hover:text-emerald-600 dark:hover:text-emerald-400 whitespace-nowrap transition-colors duration-300">
                        <i class="fas fa-star mr-2"></i>Reviews ({{ $product->reviews->count() }})
                    </button>
                    <button data-tab="shipping" class="tab-btn px-6 py-4 font-medium text-gray-600 dark:text-gray-400 hover:text-emerald-600 dark:hover:text-emerald-400 whitespace-nowrap transition-colors duration-300">
                        <i class="fas fa-truck mr-2"></i>Shipping & Returns
                    </button>
                    <button data-tab="faq" class="tab-btn px-6 py-4 font-medium text-gray-600 dark:text-gray-400 hover:text-emerald-600 dark:hover:text-emerald-400 whitespace-nowrap transition-colors duration-300">
                        <i class="fas fa-question-circle mr-2"></i>FAQ
                    </button>
                </div>
            </div>

            <!-- Tab Content -->
            <div class="p-6 md:p-8">
                <!-- Description -->
                <div id="description" class="tab-content active">
                    <div class="prose prose-lg dark:prose-invert max-w-none">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Product Description</h3>
                        {!! $product->full_description ?? $product->description !!}
                        
                        @if(!empty($product->benefits))
                        <div class="mt-8 bg-gradient-to-r from-emerald-50 to-amber-50 dark:from-emerald-900/10 dark:to-amber-900/10 rounded-2xl p-6">
                            <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Key Benefits</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach(explode("\n", $product->benefits) as $benefit)
                                    @if(trim($benefit))
                                    <div class="flex items-start space-x-3">
                                        <i class="fas fa-check-circle text-emerald-500 dark:text-emerald-400 mt-1"></i>
                                        <span class="text-gray-700 dark:text-gray-300">{{ trim($benefit) }}</span>
                                    </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Specifications -->
                <div id="specifications" class="tab-content hidden">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Product Details</h3>
                            <dl class="space-y-4">
                                <div class="flex justify-between items-center py-3 border-b border-gray-100 dark:border-gray-700">
                                    <dt class="text-gray-600 dark:text-gray-400 font-medium">SKU</dt>
                                    <dd class="font-bold text-gray-900 dark:text-white">{{ $product->sku ?? 'GF-' . str_pad($product->id, 6, '0', STR_PAD_LEFT) }}</dd>
                                </div>
                                <div class="flex justify-between items-center py-3 border-b border-gray-100 dark:border-gray-700">
                                    <dt class="text-gray-600 dark:text-gray-400 font-medium">Weight</dt>
                                    <dd class="font-bold text-gray-900 dark:text-white">{{ $product->weight ?? '500g' }}</dd>
                                </div>
                                <div class="flex justify-between items-center py-3 border-b border-gray-100 dark:border-gray-700">
                                    <dt class="text-gray-600 dark:text-gray-400 font-medium">Dimensions</dt>
                                    <dd class="font-bold text-gray-900 dark:text-white">{{ $product->dimensions ?? '20 × 15 × 5 cm' }}</dd>
                                </div>
                                <div class="flex justify-between items-center py-3 border-b border-gray-100 dark:border-gray-700">
                                    <dt class="text-gray-600 dark:text-gray-400 font-medium">Shelf Life</dt>
                                    <dd class="font-bold text-gray-900 dark:text-white">12 Months</dd>
                                </div>
                                <div class="flex justify-between items-center py-3 border-b border-gray-100 dark:border-gray-700">
                                    <dt class="text-gray-600 dark:text-gray-400 font-medium">Storage</dt>
                                    <dd class="font-bold text-gray-900 dark:text-white">Cool, dry place away from sunlight</dd>
                                </div>
                                <div class="flex justify-between items-center py-3">
                                    <dt class="text-gray-600 dark:text-gray-400 font-medium">Origin</dt>
                                    <dd class="font-bold text-gray-900 dark:text-white">USA</dd>
                                </div>
                            </dl>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Nutrition Facts</h3>
                            <div class="bg-gray-50 dark:bg-gray-900 rounded-2xl p-6">
                                <div class="space-y-4">
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600 dark:text-gray-400">Calories</span>
                                        <span class="font-bold text-gray-900 dark:text-white">150 kcal</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600 dark:text-gray-400">Protein</span>
                                        <span class="font-bold text-gray-900 dark:text-white">6g</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600 dark:text-gray-400">Carbohydrates</span>
                                        <span class="font-bold text-gray-900 dark:text-white">20g</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600 dark:text-gray-400">Fat</span>
                                        <span class="font-bold text-gray-900 dark:text-white">8g</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-600 dark:text-gray-400">Fiber</span>
                                        <span class="font-bold text-gray-900 dark:text-white">4g</span>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-6">*Nutritional values are approximate and may vary</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reviews -->
                <div id="reviews" class="tab-content hidden">
                    <div class="space-y-8">
                        <!-- Rating Summary -->
                        <div class="bg-gradient-to-r from-gray-50 to-emerald-50 dark:from-gray-900 dark:to-emerald-900/10 rounded-2xl p-8">
                            <div class="flex flex-col md:flex-row items-center justify-between gap-8">
                                <div class="text-center">
                                    <div class="text-5xl font-bold text-gray-900 dark:text-white mb-2">{{ number_format($product->average_rating ?? 0, 1) }}</div>
                                    <div class="flex items-center justify-center space-x-1 mb-3">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= floor($product->average_rating ?? 0) ? 'text-amber-400' : 'text-gray-300 dark:text-gray-600' }} text-xl"></i>
                                        @endfor
                                    </div>
                                    <div class="text-gray-600 dark:text-gray-400">{{ $product->total_reviews ?? 0 }} reviews</div>
                                </div>
                                <div class="flex-1 max-w-md">
                                    <div class="space-y-2">
                                        @for($i = 5; $i >= 1; $i--)
                                        <div class="flex items-center space-x-3">
                                            <span class="text-sm text-gray-600 dark:text-gray-400 w-8">{{ $i }}★</span>
                                            <div class="flex-1 h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                                <div class="h-full bg-amber-400" style="width: {{ ($product->reviews->where('rating', $i)->count() / max(1, $product->reviews->count())) * 100 }}%"></div>
                                            </div>
                                            <span class="text-sm text-gray-600 dark:text-gray-400 w-8 text-right">{{ $product->reviews->where('rating', $i)->count() }}</span>
                                        </div>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Reviews List -->
                        <div>
                            <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Customer Reviews</h4>
                            @if($product->reviews->count() > 0)
                            <div class="space-y-6">
                                @foreach($product->reviews as $review)
                                <div class="bg-gray-50 dark:bg-gray-900 rounded-2xl p-6">
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-12 h-12 bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-full flex items-center justify-center text-white font-bold">
                                                {{ substr($review->user->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <h5 class="font-bold text-gray-900 dark:text-white">{{ $review->user->name }}</h5>
                                                <div class="flex items-center space-x-1">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="fas fa-star {{ $i <= $review->rating ? 'text-amber-400' : 'text-gray-300 dark:text-gray-600' }} text-sm"></i>
                                                    @endfor
                                                </div>
                                            </div>
                                        </div>
                                        <span class="text-sm text-gray-500 dark:text-gray-400">{{ $review->created_at->format('M d, Y') }}</span>
                                    </div>
                                    <p class="text-gray-700 dark:text-gray-300">{{ $review->comment }}</p>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <div class="text-center py-12">
                                <i class="fas fa-comments text-4xl text-gray-300 dark:text-gray-600 mb-4"></i>
                                <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-2">No Reviews Yet</h4>
                                <p class="text-gray-600 dark:text-gray-400">Be the first to review this product!</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Shipping -->
                <div id="shipping" class="tab-content hidden">
                    <div class="space-y-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="bg-gradient-to-r from-emerald-50 to-emerald-100 dark:from-emerald-900/10 dark:to-emerald-900/20 rounded-2xl p-6">
                                <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                                    <i class="fas fa-shipping-fast"></i>Shipping Information
                                </h4>
                                <ul class="space-y-3">
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-emerald-500 dark:text-emerald-400 mt-1 mr-3"></i>
                                        <span class="text-gray-700 dark:text-gray-300">Free standard shipping on orders over $50</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-emerald-500 dark:text-emerald-400 mt-1 mr-3"></i>
                                        <span class="text-gray-700 dark:text-gray-300">Delivery within 2-5 business days</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-emerald-500 dark:text-emerald-400 mt-1 mr-3"></i>
                                        <span class="text-gray-700 dark:text-gray-300">Express shipping available (1-2 days)</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-emerald-500 dark:text-emerald-400 mt-1 mr-3"></i>
                                        <span class="text-gray-700 dark:text-gray-300">Real-time tracking updates</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="bg-gradient-to-r from-amber-50 to-amber-100 dark:from-amber-900/10 dark:to-amber-900/20 rounded-2xl p-6">
                                <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                                    <i class="fas fa-undo"></i>Return Policy
                                </h4>
                                <ul class="space-y-3">
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-amber-500 dark:text-amber-400 mt-1 mr-3"></i>
                                        <span class="text-gray-700 dark:text-gray-300">30-day return policy</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-amber-500 dark:text-amber-400 mt-1 mr-3"></i>
                                        <span class="text-gray-700 dark:text-gray-300">Free returns for damaged items</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-amber-500 dark:text-amber-400 mt-1 mr-3"></i>
                                        <span class="text-gray-700 dark:text-gray-300">Full refund upon return</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check-circle text-amber-500 dark:text-amber-400 mt-1 mr-3"></i>
                                        <span class="text-gray-700 dark:text-gray-300">Easy return process</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FAQ -->
                <div id="faq" class="tab-content hidden">
                    <div class="space-y-6">
                        <div class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 rounded-2xl p-6">
                            <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                                <i class="fas fa-question-circle"></i>Frequently Asked Questions
                            </h4>
                            <div class="space-y-4">
                                <div class="border border-gray-200 dark:border-gray-700 rounded-xl p-4">
                                    <button class="faq-question w-full text-left font-medium text-gray-900 dark:text-white flex items-center justify-between">
                                        <span>How long does shipping take?</span>
                                        <i class="fas fa-chevron-down transition-transform duration-300"></i>
                                    </button>
                                    <div class="faq-answer mt-3 text-gray-600 dark:text-gray-400 hidden">
                                        Standard shipping takes 2-5 business days. Express shipping is available for 1-2 day delivery.
                                    </div>
                                </div>
                                <div class="border border-gray-200 dark:border-gray-700 rounded-xl p-4">
                                    <button class="faq-question w-full text-left font-medium text-gray-900 dark:text-white flex items-center justify-between">
                                        <span>What is your return policy?</span>
                                        <i class="fas fa-chevron-down transition-transform duration-300"></i>
                                    </button>
                                    <div class="faq-answer mt-3 text-gray-600 dark:text-gray-400 hidden">
                                        We offer a 30-day return policy for all products. Items must be in original condition and packaging.
                                    </div>
                                </div>
                                <div class="border border-gray-200 dark:border-gray-700 rounded-xl p-4">
                                    <button class="faq-question w-full text-left font-medium text-gray-900 dark:text-white flex items-center justify-between">
                                        <span>Are your products organic?</span>
                                        <i class="fas fa-chevron-down transition-transform duration-300"></i>
                                    </button>
                                    <div class="faq-answer mt-3 text-gray-600 dark:text-gray-400 hidden">
                                        Yes, all our dry fruits are 100% organic and sourced from certified organic farms.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if(isset($relatedProducts) && $relatedProducts->count() > 0)
        <div class="mb-12">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">You May Also Like</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $related)
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm dark:shadow-gray-900/20 overflow-hidden transition-all duration-300 hover:shadow-xl dark:hover:shadow-gray-900/40 hover:-translate-y-1">
                    <a href="{{ route('shop.show', $related->slug) }}" class="block">
                        <div class="relative h-48 overflow-hidden">
                            <img src="{{ $related->media->first()->media_url ?? asset('images/placeholder.jpg') }}" 
                                 alt="{{ $related->name }}" 
                                 class="w-full h-full object-cover hover:scale-110 transition-transform duration-500">
                            @if($related->compare_at_price && $related->compare_at_price > $related->best_price)
                            <span class="absolute top-2 left-2 px-2 py-1 bg-red-500 text-white text-xs font-bold rounded">
                                -{{ $related->discount_percentage }}%
                            </span>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-gray-900 dark:text-white mb-2 line-clamp-1">{{ $related->name }}</h3>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <span class="text-lg font-bold text-emerald-600 dark:text-emerald-400">{{ config('settings.currency_symbol', '₹') }}{{ number_format($related->best_price, 2) }}</span>
                                    @if($related->compare_at_price && $related->compare_at_price > $related->best_price)
                                    <span class="text-sm text-gray-400 dark:text-gray-600 line-through">{{ config('settings.currency_symbol', '₹') }}{{ number_format($related->compare_at_price, 2) }}</span>
                                    @endif
                                </div>
                                <button class="w-8 h-8 rounded-full bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 flex items-center justify-center hover:bg-emerald-200 dark:hover:bg-emerald-900/50 transition-colors">
                                    <i class="fas fa-plus text-sm"></i>
                                </button>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Zoom Modal -->
<div id="zoomModal" class="fixed inset-0 bg-black/95 z-50 hidden items-center justify-center p-4 transition-opacity duration-300">
    <div class="relative max-w-6xl max-h-[90vh] w-full">
        <img id="zoomedImage" src="" alt="" class="w-full h-full object-contain">
        <button onclick="closeZoom()" class="absolute top-4 right-4 text-white hover:text-gray-300 bg-black/50 hover:bg-black/70 rounded-full w-10 h-10 flex items-center justify-center transition-all duration-300">
            <i class="fas fa-times text-xl"></i>
        </button>
        <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
            <button onclick="previousImage()" class="w-10 h-10 bg-black/50 hover:bg-black/70 text-white rounded-full flex items-center justify-center transition-all duration-300">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button onclick="nextImage()" class="w-10 h-10 bg-black/50 hover:bg-black/70 text-white rounded-full flex items-center justify-center transition-all duration-300">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>
</div>

<!-- Added to Cart Notification -->
<div id="addedToCartModal" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4 transition-opacity duration-300">
    <div class="bg-white dark:bg-gray-800 rounded-2xl max-w-md w-full p-6 transform transition-all duration-300 scale-95 opacity-0">
        <div class="text-center">
            <div class="w-16 h-16 bg-emerald-100 dark:bg-emerald-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-check text-2xl text-emerald-600 dark:text-emerald-400"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Added to Cart!</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-6">Product has been successfully added to your shopping cart.</p>
            <div class="flex space-x-3">
                <button onclick="closeAddedToCartModal()" class="flex-1 px-4 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    Continue Shopping
                </button>
                <a href="{{ route('cart.index') }}" class="flex-1 px-4 py-3 bg-emerald-500 hover:bg-emerald-600 dark:bg-emerald-600 dark:hover:bg-emerald-700 text-white rounded-xl text-center transition-colors">
                    View Cart
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Custom Scrollbar */
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    
    /* Thumbnail hover effect */
    .thumbnail-item {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .thumbnail-item:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
    }
    
    /* Quick quantity buttons */
    .quick-qty-btn {
        @apply px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg font-medium transition-colors duration-200;
    }
    
    .quick-qty-btn.max {
        @apply bg-amber-100 dark:bg-amber-900/30 hover:bg-amber-200 dark:hover:bg-amber-900/50 text-amber-700 dark:text-amber-400;
    }
    
    /* Tab navigation */
    .tab-btn {
        position: relative;
        transition: all 0.3s ease;
    }
    
    .tab-btn:hover {
        background: rgba(16, 185, 129, 0.05);
    }
    
    .tab-btn.active:hover {
        background: transparent;
    }
    
    /* FAQ accordion */
    .faq-answer {
        transition: all 0.3s ease;
    }
    
    .faq-question.active i {
        transform: rotate(180deg);
    }
    
    /* Toast Global */
    .toast-global-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        display: flex;
        flex-direction: column;
        gap: 12px;
        max-width: 400px;
    }
    
    .toast-global {
        transform: translateX(100%);
        opacity: 0;
        transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }
    
    .toast-global.show {
        transform: translateX(0);
        opacity: 1;
    }
    
    .toast-global-content {
        @apply rounded-xl shadow-xl backdrop-blur-sm border border-white/10 p-4 flex items-center justify-between;
    }
    
    .toast-global-icon {
        @apply text-xl mr-3;
    }
    
    .toast-global-body {
        @apply flex-1;
    }
    
    .toast-global-message {
        @apply font-medium;
    }
    
    .toast-global-close {
        @apply ml-3 opacity-70 hover:opacity-100 transition-opacity;
    }
    
    /* Image loading */
    #imageLoadingOverlay {
        transition: opacity 0.3s ease;
    }
    
    /* Related products line clamp */
    .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    /* Modal animations */
    #zoomModal.show {
        display: flex;
        animation: fadeIn 0.3s ease;
    }
    
    #addedToCartModal.show > div {
        transform: scale(1);
        opacity: 1;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    /* Dark mode adjustments */
    .dark .toast-global-content {
        border-color: rgba(255, 255, 255, 0.1);
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
        currencySymbol: '{{ config("settings.currency_symbol", "₹") }}',
        mediaCount: {{ $product->media->count() }}
    };

    // Image Gallery
    const mainImage = document.getElementById('mainProductImage');
    const thumbnails = document.querySelectorAll('.thumbnail-item');
    const imageLoadingOverlay = document.getElementById('imageLoadingOverlay');
    let currentImageIndex = 0;
    
    // Function to change main image with loading state
    window.changeMainImage = function(element, index) {
        try {
            const img = element.querySelector('img');
            if (!img || !img.src) {
                throw new Error('Image not found');
            }
            
            // Show loading overlay
            imageLoadingOverlay.classList.remove('hidden');
            
            // Preload image
            const newImage = new Image();
            newImage.src = img.src;
            newImage.onload = function() {
                mainImage.src = img.src;
                mainImage.alt = element.querySelector('img').alt;
                currentImageIndex = index;
                
                // Update active thumbnail
                thumbnails.forEach((thumb, i) => {
                    thumb.classList.remove('border-emerald-500', 'dark:border-emerald-400', 'ring-2', 'ring-emerald-200', 'dark:ring-emerald-900');
                    if (i === index) {
                        thumb.classList.add('border-emerald-500', 'dark:border-emerald-400', 'ring-2', 'ring-emerald-200', 'dark:ring-emerald-900');
                    }
                });
                
                // Hide loading overlay
                setTimeout(() => {
                    imageLoadingOverlay.classList.add('hidden');
                }, 300);
            };
            
            newImage.onerror = function() {
                mainImage.src = '{{ asset("images/placeholder.jpg") }}';
                mainImage.alt = 'Placeholder image';
                imageLoadingOverlay.classList.add('hidden');
                showToast('Failed to load image', 'error');
            };
        } catch (error) {
            console.error('Error changing image:', error);
            imageLoadingOverlay.classList.add('hidden');
            showToast('Error loading image', 'error');
        }
    };
    
    // Zoom Image functionality
    window.zoomImage = function() {
        try {
            const modal = document.getElementById('zoomModal');
            const zoomedImg = document.getElementById('zoomedImage');
            
            if (!mainImage.src) {
                showToast('Image not available', 'error');
                return;
            }
            
            zoomedImg.src = mainImage.src;
            zoomedImg.alt = mainImage.alt;
            modal.classList.remove('hidden');
            
            // Force reflow
            modal.offsetHeight;
            modal.style.opacity = '1';
            
            document.body.style.overflow = 'hidden';
            
            // Close on ESC key
            const zoomKeyHandler = function(e) {
                if (e.key === 'Escape') {
                    closeZoom();
                }
            };
            document.addEventListener('keydown', zoomKeyHandler);
            
            // Store handler reference for cleanup
            modal._zoomKeyHandler = zoomKeyHandler;
        } catch (error) {
            console.error('Error zooming image:', error);
            showToast('Failed to zoom image', 'error');
        }
    };
    
    window.closeZoom = function() {
        const modal = document.getElementById('zoomModal');
        modal.style.opacity = '0';
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
            // Clean up event listener
            if (modal._zoomKeyHandler) {
                document.removeEventListener('keydown', modal._zoomKeyHandler);
            }
        }, 300);
    };
    
    // Image navigation in zoom modal
    window.previousImage = function() {
        if (!thumbnails.length) return;
        const newIndex = (currentImageIndex - 1 + thumbnails.length) % thumbnails.length;
        const thumbnail = thumbnails[newIndex];
        if (thumbnail) {
            changeMainImage(thumbnail, newIndex);
            const zoomedImg = document.getElementById('zoomedImage');
            zoomedImg.src = thumbnail.querySelector('img').src;
        }
    };
    
    window.nextImage = function() {
        if (!thumbnails.length) return;
        const newIndex = (currentImageIndex + 1) % thumbnails.length;
        const thumbnail = thumbnails[newIndex];
        if (thumbnail) {
            changeMainImage(thumbnail, newIndex);
            const zoomedImg = document.getElementById('zoomedImage');
            zoomedImg.src = thumbnail.querySelector('img').src;
        }
    };
    
    // Quantity Controls
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
            decreaseBtn.classList.toggle('opacity-30', value <= 1);
            decreaseBtn.classList.toggle('cursor-not-allowed', value <= 1);
        }
        if (increaseBtn) {
            increaseBtn.disabled = value >= maxStock;
            increaseBtn.classList.toggle('opacity-30', value >= maxStock);
            increaseBtn.classList.toggle('cursor-not-allowed', value >= maxStock);
        }
    }
    
    // Quick quantity buttons
    document.querySelectorAll('.quick-qty-btn:not(.max)').forEach(btn => {
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
    
    // Max quantity button
    window.setMaxQuantity = function() {
        quantityInput.value = maxStock;
        updateButtonsState();
        showToast(`Set quantity to maximum available: ${maxStock} units`, 'info');
    };
    
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
                    b.classList.remove('active', 'border-emerald-500', 'dark:border-emerald-400', 'text-emerald-600', 'dark:text-emerald-400', 'font-bold');
                    b.classList.add('text-gray-600', 'dark:text-gray-400', 'font-medium');
                });
                this.classList.add('active', 'border-emerald-500', 'dark:border-emerald-400', 'text-emerald-600', 'dark:text-emerald-400', 'font-bold');
                this.classList.remove('text-gray-600', 'dark:text-gray-400', 'font-medium');
                
                // Show active tab content
                tabContents.forEach(content => {
                    content.classList.add('hidden');
                    content.classList.remove('active');
                });
                
                const activeContent = document.getElementById(tabId);
                if (activeContent) {
                    activeContent.classList.remove('hidden');
                    // Force reflow for animation
                    activeContent.offsetHeight;
                    activeContent.classList.add('active');
                }
            } catch (error) {
                console.error('Error switching tabs:', error);
            }
        });
    });
    
    // FAQ Accordion
    document.querySelectorAll('.faq-question').forEach(question => {
        question.addEventListener('click', function() {
            const answer = this.nextElementSibling;
            const icon = this.querySelector('i');
            
            this.classList.toggle('active');
            answer.classList.toggle('hidden');
            
            if (this.classList.contains('active')) {
                answer.style.maxHeight = answer.scrollHeight + 'px';
                icon.style.transform = 'rotate(180deg)';
            } else {
                answer.style.maxHeight = '0';
                icon.style.transform = 'rotate(0deg)';
            }
        });
    });
    
    // Wishlist Toggle
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
            this.innerHTML = '<div class="w-6 h-6 border-2 border-current border-t-transparent rounded-full animate-spin"></div>';
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
                    body: JSON.stringify({ product_id: productId })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Toggle the heart icon
                    const icon = this.querySelector('i');
                    if (data.action === 'added') {
                        icon.className = 'fas fa-heart text-2xl text-red-600 dark:text-red-400';
                        this.classList.add('bg-red-50', 'dark:bg-red-900/30', 'border-red-200', 'dark:border-red-800', 'text-red-600', 'dark:text-red-400');
                        showToast('Added to wishlist!', 'success');
                    } else {
                        icon.className = 'far fa-heart text-2xl text-gray-400 dark:text-gray-600';
                        this.classList.remove('bg-red-50', 'dark:bg-red-900/30', 'border-red-200', 'dark:border-red-800', 'text-red-600', 'dark:text-red-400');
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
    
    // Add to Cart
    const addToCartBtn = document.getElementById('addToCartBtn');
    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', async function() {
            if (product.stock < 1) {
                showToast('Product is out of stock', 'error');
                return;
            }
            
            const productId = this.dataset.id;
            const quantity = parseInt(quantityInput.value) || 1;
            const variantId = getSelectedVariantId();
            
            // Show loading state
            const originalHTML = this.innerHTML;
            this.innerHTML = '<div class="w-5 h-5 border-2 border-white border-t-transparent rounded-full animate-spin"></div>';
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
                        variant_id: variantId
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showToast('Product added to cart!', 'success');
                    
                    // Update cart count
                    updateCartCount(data.cart_count);
                    
                    // Show added to cart modal
                    showAddedToCartModal();
                    
                    // Trigger cart animation
                    triggerCartAnimation();
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
            const addToCartResult = await addToCart();
            if (addToCartResult) {
                // Redirect to checkout after a short delay
                setTimeout(() => {
                    window.location.href = '{{ route("checkout.index") }}';
                }, 800);
            }
            @else
            showToast('Please login to continue with purchase', 'warning');
            setTimeout(() => {
                window.location.href = '{{ route("login") }}?redirect=' + encodeURIComponent(window.location.pathname);
            }, 1500);
            @endauth
        });
    }
    
    // Helper function for add to cart
    async function addToCart() {
        const productId = addToCartBtn.dataset.id;
        const quantity = parseInt(quantityInput.value) || 1;
        const variantId = getSelectedVariantId();
        
        try {
            const response = await fetch('{{ route("cart.add") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: quantity,
                    variant_id: variantId
                })
            });
            
            const data = await response.json();
            
            if (data.success) {
                updateCartCount(data.cart_count);
                return true;
            } else {
                showToast(data.message || 'Failed to add to cart', 'error');
                return false;
            }
        } catch (error) {
            console.error('Error:', error);
            showToast('Network error. Please try again.', 'error');
            return false;
        }
    }
    
    // Share Product
    window.shareProduct = function() {
        if (navigator.share) {
            navigator.share({
                title: product.name,
                text: 'Check out this amazing product from Ghazali Food',
                url: window.location.href
            }).catch(err => {
                console.log('Error sharing:', err);
                copyToClipboard(window.location.href);
            });
        } else {
            copyToClipboard(window.location.href);
        }
    };
    
    // Copy to clipboard
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            showToast('Link copied to clipboard!', 'success');
        }).catch(err => {
            console.error('Failed to copy:', err);
            // Fallback for older browsers
            const textArea = document.createElement('textarea');
            textArea.value = text;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);
            showToast('Link copied to clipboard!', 'success');
        });
    }
    
    // Download Image
    window.downloadImage = function(url) {
        if (!url || url.includes('placeholder.jpg')) {
            showToast('Image not available for download', 'error');
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
            el.style.display = count > 0 ? 'flex' : 'none';
        });
    }
    
    // Show added to cart modal
    function showAddedToCartModal() {
        const modal = document.getElementById('addedToCartModal');
        const modalContent = modal.querySelector('div');
        
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.style.opacity = '1';
            modalContent.style.transform = 'scale(1)';
            modalContent.style.opacity = '1';
        }, 10);
        
        // Auto close after 5 seconds
        setTimeout(() => {
            closeAddedToCartModal();
        }, 5000);
    }
    
    window.closeAddedToCartModal = function() {
        const modal = document.getElementById('addedToCartModal');
        const modalContent = modal.querySelector('div');
        
        modalContent.style.transform = 'scale(0.95)';
        modalContent.style.opacity = '0';
        modal.style.opacity = '0';
        
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    };
    
    // Trigger cart animation
    function triggerCartAnimation() {
        const cartIcon = document.querySelector('.cart-icon');
        if (cartIcon) {
            cartIcon.classList.add('animate__animated', 'animate__tada');
            setTimeout(() => {
                cartIcon.classList.remove('animate__animated', 'animate__tada');
            }, 1000);
        }
    }
    
    // Social proof simulation
    function simulateSocialProof() {
        // Random viewer count updates
        const viewerCount = document.getElementById('product-viewers');
        if (viewerCount) {
            const current = parseInt(viewerCount.textContent) || 12;
            const change = Math.floor(Math.random() * 3) - 1;
            const newCount = Math.max(5, Math.min(50, current + change));
            viewerCount.textContent = newCount;
        }
        
        // Random purchase pulse
        if (Math.random() > 0.8) {
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
    setInterval(simulateSocialProof, 5000);
    
    // Initialize buttons state
    updateButtonsState();
    
    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // ESC to close modals
        if (e.key === 'Escape') {
            closeZoom();
            closeAddedToCartModal();
        }
        
        // Left/Right arrow for image navigation when zoomed
        if (!document.getElementById('zoomModal').classList.contains('hidden')) {
            if (e.key === 'ArrowLeft') {
                previousImage();
            } else if (e.key === 'ArrowRight') {
                nextImage();
            }
        }
    });
    
    // Error handling for images
    mainImage.addEventListener('error', function() {
        this.src = '{{ asset("images/placeholder.jpg") }}';
        this.alt = 'Placeholder image';
    });
    
    // Preload all images
    thumbnails.forEach(thumbnail => {
        const img = thumbnail.querySelector('img');
        if (img) {
            const tempImage = new Image();
            tempImage.src = img.src;
        }
    });
});

// Global error handler
window.addEventListener('error', function(e) {
    console.error('Global error:', e.error);
    if (e.error && e.error.message) {
        showToast('An error occurred. Please refresh the page.', 'error');
    }
});
</script>
@endpush