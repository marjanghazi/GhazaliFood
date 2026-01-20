@extends('layouts.app')

@section('title', $product->name . ' - Ghazali Food')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-emerald-50 to-amber-50">
        <div class="container mx-auto px-4 py-6">
            <nav class="flex items-center space-x-2 text-sm text-gray-600">
                <a href="{{ url('/') }}" class="hover:text-emerald-600 transition-colors">Home</a>
                <span class="text-gray-400">/</span>
                <a href="{{ route('shop.index') }}" class="hover:text-emerald-600 transition-colors">Shop</a>
                @if($product->category)
                <span class="text-gray-400">/</span>
                <a href="{{ route('category.show', $product->category->slug) }}" class="hover:text-emerald-600 transition-colors">{{ $product->category->name }}</a>
                @endif
                <span class="text-gray-400">/</span>
                <span class="text-gray-900 font-medium truncate max-w-xs">{{ Str::limit($product->name, 30) }}</span>
            </nav>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <!-- Social Proof Banner -->
        <div class="bg-white rounded-xl shadow-sm p-4 mb-8 border border-gray-100">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center space-x-6">
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
                <div class="flex items-center space-x-2">
                    <div class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-sm font-medium">
                        <i class="fas fa-check-circle mr-1"></i> 100% Authentic
                    </div>
                    <div class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-medium">
                        <i class="fas fa-shipping-fast mr-1"></i> Free Shipping
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
                         class="w-full h-[500px] object-contain transition-transform duration-500 group-hover:scale-105 cursor-zoom-in"
                         onclick="zoomImage()">

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
                         onclick="changeMainImage(this)">
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
                    <div>
                        <div class="flex items-center space-x-2 mb-3">
                            <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-medium">
                                {{ $product->category->name ?? 'Premium Dry Fruits' }}
                            </span>
                            <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-medium">
                                <i class="fas fa-crown text-xs mr-1"></i>Ghazali Premium
                            </span>
                        </div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $product->name }}</h1>
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($product->average_rating))
                                    <i class="fas fa-star text-amber-400"></i>
                                    @elseif($i - 0.5 <= $product->average_rating)
                                    <i class="fas fa-star-half-alt text-amber-400"></i>
                                    @else
                                    <i class="far fa-star text-amber-400"></i>
                                    @endif
                                    @endfor
                                    <span class="ml-2 text-gray-600">({{ $product->total_reviews }} reviews)</span>
                            </div>
                            <span class="text-gray-400">•</span>
                            <span class="text-gray-600">SKU: {{ $product->sku ?? 'GF-' . str_pad($product->id, 6, '0', STR_PAD_LEFT) }}</span>
                        </div>
                    </div>
                    <button id="wishlistToggleBtn" 
                            data-product-id="{{ $product->id }}"
                            class="w-12 h-12 rounded-full border border-gray-200 flex items-center justify-center hover:bg-red-50 hover:border-red-200 transition-colors group {{ Auth::check() && Auth::user()->wishlist()->where('product_id', $product->id)->exists() ? 'bg-red-50 border-red-200 text-red-600' : 'bg-white text-gray-400' }}">
                        <i class="{{ Auth::check() && Auth::user()->wishlist()->where('product_id', $product->id)->exists() ? 'fas' : 'far' }} fa-heart text-xl group-hover:text-red-500"></i>
                    </button>
                </div>

                <!-- Short Description -->
                <p class="text-gray-600 text-lg leading-relaxed border-b border-gray-100 pb-6">
                    {{ $product->short_description ?? Str::limit($product->description, 200) }}
                </p>

                <!-- Pricing -->
                <div class="space-y-2">
                    <div class="flex items-center space-x-4">
                        <span class="text-4xl font-bold text-gray-900">{{ config('settings.currency_symbol', '₹') }}{{ number_format($product->best_price, 2) }}</span>
                        @if($product->compare_at_price)
                        <span class="text-2xl text-gray-400 line-through">{{ config('settings.currency_symbol', '₹') }}{{ number_format($product->compare_at_price, 2) }}</span>
                        <span class="px-3 py-1 bg-red-100 text-red-700 font-bold rounded-lg">
                            Save {{ $product->discount_percentage }}%
                        </span>
                        @endif
                    </div>
                    @if($product->compare_at_price)
                    <div class="flex items-center space-x-2 text-emerald-600">
                        <i class="fas fa-bolt"></i>
                        <span class="text-sm font-medium">Save {{ config('settings.currency_symbol', '₹') }}{{ number_format($product->compare_at_price - $product->best_price, 2) }} • Limited time offer</span>
                    </div>
                    @endif
                </div>

                <!-- Stock & Delivery -->
                <div class="bg-gradient-to-r from-gray-50 to-emerald-50 rounded-2xl p-6 space-y-4">
                    <div class="flex items-center justify-between">
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
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        @foreach($product->variants as $variant)
                        <label class="variant-option cursor-pointer">
                            <input type="radio" name="variant" value="{{ $variant->id }}" 
                                   data-price="{{ $variant->price }}" 
                                   class="hidden peer" {{ $loop->first ? 'checked' : '' }}>
                            <div class="border-2 border-gray-200 rounded-xl p-4 text-center transition-all duration-300 hover:border-emerald-400 peer-checked:border-emerald-500 peer-checked:bg-emerald-50">
                                <div class="font-medium text-gray-900">{{ $variant->name }}</div>
                                <div class="text-emerald-600 font-bold mt-1">{{ config('settings.currency_symbol', '₹') }}{{ number_format($variant->price, 2) }}</div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Quantity -->
                <div class="space-y-3">
                    <label class="block text-sm font-medium text-gray-700">Quantity:</label>
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center border border-gray-200 rounded-xl overflow-hidden">
                            <button id="decreaseQty" class="w-12 h-12 flex items-center justify-center bg-gray-50 hover:bg-gray-100 text-gray-600">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input type="number" 
                                   id="quantity" 
                                   name="quantity" 
                                   value="1" 
                                   min="1" 
                                   max="{{ $product->stock_quantity }}"
                                   class="w-16 h-12 text-center text-lg font-medium border-x border-gray-200 focus:outline-none">
                            <button id="increaseQty" class="w-12 h-12 flex items-center justify-center bg-gray-50 hover:bg-gray-100 text-gray-600">
                                <i class="fas fa-plus"></i>
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
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <button id="addToCartBtn"
                            data-id="{{ $product->id }}"
                            data-name="{{ $product->name }}"
                            data-price="{{ $product->best_price }}"
                            data-image="{{ $product->media->first()->media_url ?? asset('images/placeholder.jpg') }}"
                            class="h-14 bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white font-bold rounded-xl flex items-center justify-center space-x-2 transition-all duration-300 hover:shadow-lg hover:shadow-emerald-100 active:scale-[0.98]">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Add to Cart</span>
                        <span class="ml-2 bg-white/20 px-2 py-0.5 rounded-full text-xs">+{{ rand(50, 200) }} today</span>
                    </button>
                    <button id="buyNowBtn"
                            data-id="{{ $product->id }}"
                            class="h-14 bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white font-bold rounded-xl flex items-center justify-center space-x-2 transition-all duration-300 hover:shadow-lg hover:shadow-amber-100 active:scale-[0.98]">
                        <i class="fas fa-bolt"></i>
                        <span>Buy Now</span>
                    </button>
                </div>

                <!-- Trust Badges -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 pt-6 border-t border-gray-100">
                    <div class="text-center space-y-2">
                        <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center mx-auto">
                            <i class="fas fa-shield-alt text-emerald-600 text-xl"></i>
                        </div>
                        <div class="text-sm">
                            <div class="font-medium text-gray-900">Secure</div>
                            <div class="text-gray-600">100% Safe</div>
                        </div>
                    </div>
                    <div class="text-center space-y-2">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto">
                            <i class="fas fa-truck text-blue-600 text-xl"></i>
                        </div>
                        <div class="text-sm">
                            <div class="font-medium text-gray-900">Free Shipping</div>
                            <div class="text-gray-600">Over $50</div>
                        </div>
                    </div>
                    <div class="text-center space-y-2">
                        <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto">
                            <i class="fas fa-undo text-purple-600 text-xl"></i>
                        </div>
                        <div class="text-sm">
                            <div class="font-medium text-gray-900">30-Day Returns</div>
                            <div class="text-gray-600">Easy Returns</div>
                        </div>
                    </div>
                    <div class="text-center space-y-2">
                        <div class="w-12 h-12 bg-amber-100 rounded-full flex items-center justify-center mx-auto">
                            <i class="fas fa-award text-amber-600 text-xl"></i>
                        </div>
                        <div class="text-sm">
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
                <div class="flex overflow-x-auto">
                    <button data-tab="description" class="tab-btn active px-6 py-4 font-medium text-gray-900 border-b-2 border-emerald-500 whitespace-nowrap">
                        Description
                    </button>
                    <button data-tab="specifications" class="tab-btn px-6 py-4 font-medium text-gray-600 hover:text-gray-900 whitespace-nowrap">
                        Specifications
                    </button>
                    <button data-tab="reviews" class="tab-btn px-6 py-4 font-medium text-gray-600 hover:text-gray-900 whitespace-nowrap">
                        Reviews ({{ $product->reviews->count() }})
                    </button>
                    <button data-tab="shipping" class="tab-btn px-6 py-4 font-medium text-gray-600 hover:text-gray-900 whitespace-nowrap">
                        Shipping & Returns
                    </button>
                    <button data-tab="faq" class="tab-btn px-6 py-4 font-medium text-gray-600 hover:text-gray-900 whitespace-nowrap">
                        FAQ
                    </button>
                </div>
            </div>

            <!-- Tab Content -->
            <div class="p-8">
                <!-- Description -->
                <div id="description" class="tab-content active">
                    <div class="prose max-w-none">
                        {!! $product->full_description ?? $product->description !!}
                    </div>
                </div>

                <!-- Specifications -->
                <div id="specifications" class="tab-content hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-6">Product Details</h3>
                            <dl class="space-y-4">
                                <div class="flex justify-between border-b border-gray-100 pb-3">
                                    <dt class="text-gray-600">SKU</dt>
                                    <dd class="font-medium">{{ $product->sku ?? 'GF-' . str_pad($product->id, 6, '0', STR_PAD_LEFT) }}</dd>
                                </div>
                                <div class="flex justify-between border-b border-gray-100 pb-3">
                                    <dt class="text-gray-600">Weight</dt>
                                    <dd class="font-medium">{{ $product->weight ?? '500g' }}</dd>
                                </div>
                                <div class="flex justify-between border-b border-gray-100 pb-3">
                                    <dt class="text-gray-600">Dimensions</dt>
                                    <dd class="font-medium">{{ $product->dimensions ?? '20 × 15 × 5 cm' }}</dd>
                                </div>
                                <div class="flex justify-between border-b border-gray-100 pb-3">
                                    <dt class="text-gray-600">Shelf Life</dt>
                                    <dd class="font-medium">12 Months</dd>
                                </div>
                                <div class="flex justify-between border-b border-gray-100 pb-3">
                                    <dt class="text-gray-600">Storage</dt>
                                    <dd class="font-medium">Cool, dry place</dd>
                                </div>
                                <div class="flex justify-between pb-3">
                                    <dt class="text-gray-600">Origin</dt>
                                    <dd class="font-medium">USA</dd>
                                </div>
                            </dl>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-6">Nutrition Facts</h3>
                            <!-- Add nutrition facts here -->
                        </div>
                    </div>
                </div>

                <!-- Reviews -->
                <div id="reviews" class="tab-content hidden">
                    <div class="flex items-center space-x-8 mb-8">
                        <div class="text-center">
                            <div class="text-5xl font-bold text-gray-900">{{ number_format($product->average_rating, 1) }}</div>
                            <div class="flex items-center justify-center space-x-1 mt-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= floor($product->average_rating) ? 'text-amber-400' : 'text-gray-300' }}"></i>
                                    @endfor
                            </div>
                            <div class="text-gray-600 mt-2">{{ $product->total_reviews }} reviews</div>
                        </div>
                    </div>
                </div>

                <!-- Shipping -->
                <div id="shipping" class="tab-content hidden">
                    <div class="space-y-6">
                        <div class="bg-gray-50 rounded-xl p-6">
                            <h4 class="font-bold text-lg text-gray-900 mb-3">Shipping Information</h4>
                            <ul class="space-y-3 text-gray-600">
                                <li class="flex items-start">
                                    <i class="fas fa-shipping-fast text-emerald-500 mt-1 mr-3"></i>
                                    <span>Free standard shipping on orders over $50</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-clock text-emerald-500 mt-1 mr-3"></i>
                                    <span>Delivery within 2-5 business days</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-map-marker-alt text-emerald-500 mt-1 mr-3"></i>
                                    <span>Track your order with real-time updates</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- FAQ -->
                <div id="faq" class="tab-content hidden">
                    <div class="space-y-4">
                        <!-- Add FAQ items here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Zoom Modal -->
<div id="zoomModal" class="fixed inset-0 bg-black/90 z-50 hidden items-center justify-center p-4">
    <div class="relative max-w-6xl max-h-[90vh]">
        <img id="zoomedImage" src="" alt="" class="w-full h-full object-contain">
        <button onclick="closeZoom()" class="absolute top-4 right-4 text-white text-2xl hover:text-gray-300">
            <i class="fas fa-times"></i>
        </button>
    </div>
</div>
@endsection

@push('styles')
<style>
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
    }
    
    .tab-btn.active {
        @apply text-emerald-700;
    }
    
    .tab-btn:not(.active):hover {
        @apply text-gray-900;
    }
    
    .tab-content {
        animation: fadeIn 0.3s ease;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .purchase-pulse {
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.7); }
        70% { box-shadow: 0 0 0 10px rgba(245, 158, 11, 0); }
        100% { box-shadow: 0 0 0 0 rgba(245, 158, 11, 0); }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Image Gallery
    const mainImage = document.getElementById('mainProductImage');
    const thumbnails = document.querySelectorAll('.thumbnail-item');
    
    window.changeMainImage = function(element) {
        const img = element.querySelector('img');
        mainImage.src = img.src;
        
        // Update active thumbnail
        thumbnails.forEach(thumb => thumb.classList.remove('border-emerald-500', 'ring-2', 'ring-emerald-200'));
        element.classList.add('border-emerald-500', 'ring-2', 'ring-emerald-200');
    };
    
    // Zoom Image
    window.zoomImage = function() {
        const modal = document.getElementById('zoomModal');
        const zoomedImg = document.getElementById('zoomedImage');
        zoomedImg.src = mainImage.src;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    };
    
    window.closeZoom = function() {
        const modal = document.getElementById('zoomModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = 'auto';
    };
    
    // Quantity Controls
    const quantityInput = document.getElementById('quantity');
    const maxStock = parseInt(quantityInput.max);
    
    document.getElementById('decreaseQty').addEventListener('click', () => {
        let value = parseInt(quantityInput.value);
        if (value > 1) {
            quantityInput.value = value - 1;
        }
    });
    
    document.getElementById('increaseQty').addEventListener('click', () => {
        let value = parseInt(quantityInput.value);
        if (value < maxStock) {
            quantityInput.value = value + 1;
        } else {
            showToast(`Maximum stock available is ${maxStock} units`, 'warning');
        }
    });
    
    // Quick quantity buttons
    document.querySelectorAll('.quick-qty-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const qty = parseInt(this.dataset.qty);
            const current = parseInt(quantityInput.value);
            const newQty = current + qty;
            
            if (newQty <= maxStock) {
                quantityInput.value = newQty;
            } else {
                quantityInput.value = maxStock;
                showToast(`Maximum stock available is ${maxStock} units`, 'warning');
            }
        });
    });
    
    // Tab Navigation
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const tabId = this.dataset.tab;
            
            // Update active tab button
            tabBtns.forEach(b => b.classList.remove('active', 'border-emerald-500', 'text-gray-900'));
            tabBtns.forEach(b => b.classList.add('text-gray-600'));
            this.classList.add('active', 'border-emerald-500', 'text-gray-900');
            this.classList.remove('text-gray-600');
            
            // Show active tab content
            tabContents.forEach(content => {
                content.classList.add('hidden');
                content.classList.remove('active');
            });
            
            document.getElementById(tabId).classList.remove('hidden');
            document.getElementById(tabId).classList.add('active');
        });
    });
    
    // Wishlist Toggle - FIXED VERSION
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
            }
        });
    }
    
    // Add to Cart
    const addToCartBtn = document.getElementById('addToCartBtn');
    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', async function() {
            const productId = this.dataset.id;
            const quantity = parseInt(quantityInput.value);
            
            try {
                const response = await fetch('{{ route("cart.add") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: quantity
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showToast('Product added to cart!', 'success');
                    // Trigger cart animation
                    triggerCartAnimation();
                } else {
                    showToast(data.message, 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showToast('Failed to add to cart. Please try again.', 'error');
            }
        });
    }
    
    // Buy Now
    const buyNowBtn = document.getElementById('buyNowBtn');
    if (buyNowBtn) {
        buyNowBtn.addEventListener('click', function() {
            @auth
            // Add to cart and redirect to checkout
            addToCartBtn.click();
            setTimeout(() => {
                window.location.href = '{{ route("checkout.index") }}';
            }, 500);
            @else
            showToast('Please login to continue with purchase', 'warning');
            setTimeout(() => {
                window.location.href = '{{ route("login") }}?redirect=' + encodeURIComponent(window.location.pathname);
            }, 1500);
            @endauth
        });
    }
    
    // Share Product
    window.shareProduct = function() {
        if (navigator.share) {
            navigator.share({
                title: '{{ $product->name }}',
                text: 'Check out this amazing product from Ghazali Food',
                url: window.location.href
            });
        } else {
            navigator.clipboard.writeText(window.location.href).then(() => {
                showToast('Link copied to clipboard!', 'success');
            });
        }
    };
    
    // Download Image
    window.downloadImage = function(url) {
        if (!url) {
            showToast('Image not available', 'error');
            return;
        }
        
        const a = document.createElement('a');
        a.href = url;
        a.download = '{{ Str::slug($product->name) }}-product.jpg';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    };
    
    // Purchase Simulation
    setInterval(() => {
        const pulse = document.getElementById('recent-purchase-pulse');
        if (Math.random() > 0.7) {
            pulse.classList.remove('hidden');
            setTimeout(() => {
                pulse.classList.add('hidden');
            }, 3000);
        }
    }, 10000);
    
    // Utility Functions
    function showToast(message, type = 'info') {
        // Create toast element
        const toast = document.createElement('div');
        toast.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-xl shadow-lg text-white font-medium transform transition-all duration-300 translate-x-full ${type === 'success' ? 'bg-emerald-500' : type === 'error' ? 'bg-red-500' : type === 'warning' ? 'bg-amber-500' : 'bg-blue-500'}`;
        toast.textContent = message;
        document.body.appendChild(toast);
        
        // Animate in
        setTimeout(() => {
            toast.classList.remove('translate-x-full');
            toast.classList.add('translate-x-0');
        }, 10);
        
        // Remove after 3 seconds
        setTimeout(() => {
            toast.classList.remove('translate-x-0');
            toast.classList.add('translate-x-full');
            setTimeout(() => {
                document.body.removeChild(toast);
            }, 300);
        }, 3000);
    }
    
    function triggerCartAnimation() {
        // Add cart animation effect
        const cartBtn = document.querySelector('.cart-btn');
        if (cartBtn) {
            cartBtn.classList.add('animate__animated', 'animate__tada');
            setTimeout(() => {
                cartBtn.classList.remove('animate__animated', 'animate__tada');
            }, 1000);
        }
    }
});
</script>
@endpush