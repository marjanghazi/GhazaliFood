@extends('layouts.app')

@section('title', 'Blog | Health Tips & Recipes | Premium Dry Fruits Store | Nuts & Berries')

@section('hero')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-emerald-900 to-emerald-800 dark:from-emerald-950 dark:to-emerald-900 py-16 md:py-24">
    <div class="container mx-auto px-4">
        <div class="flex flex-col lg:flex-row items-center gap-12">
            <div class="lg:w-1/2">
                <div class="animate-slide-up">
                    <div class="inline-flex items-center space-x-2 bg-white/10 backdrop-blur-sm text-white px-4 py-2 rounded-full text-sm font-medium mb-6">
                        <i class="fas fa-newspaper"></i>
                        <span>Latest Insights</span>
                    </div>
                    
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 leading-tight">
                        The Nuts & Berries
                        <span class="text-amber-400">Blog</span>
                    </h1>
                    
                    <p class="text-lg text-emerald-100 mb-8 leading-relaxed max-w-2xl">
                        Discover expert insights, delicious recipes, and health benefits 
                        of premium dry fruits. Your guide to healthy living.
                    </p>
                    
                    <div class="flex flex-wrap gap-4">
                        <a href="#latest-posts" 
                           class="inline-flex items-center justify-center px-8 py-4 bg-white text-emerald-700 hover:bg-emerald-50 font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                            <i class="fas fa-book-open mr-3"></i>
                            Explore Articles
                        </a>
                        
                        <a href="#categories" 
                           class="inline-flex items-center justify-center px-8 py-4 bg-transparent border-2 border-white text-white hover:bg-white/10 font-semibold rounded-xl transition-all duration-300">
                            <i class="fas fa-tags mr-3"></i>
                            Browse Categories
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="lg:w-1/2">
                <div class="relative animate-slide-up delay-1">
                    <div class="bg-gradient-to-br from-amber-500/10 to-emerald-500/10 backdrop-blur-sm rounded-3xl p-1">
                        <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-8">
                            <div class="grid grid-cols-3 gap-4 mb-6">
                                <div class="bg-amber-500/20 rounded-xl p-4 text-center">
                                    <div class="text-2xl font-bold text-amber-400 mb-1">{{ $totalPosts ?? 0 }}</div>
                                    <div class="text-sm text-emerald-100">Articles</div>
                                </div>
                                <div class="bg-emerald-500/20 rounded-xl p-4 text-center">
                                    <div class="text-2xl font-bold text-emerald-300 mb-1">{{ $categories->count() }}</div>
                                    <div class="text-sm text-emerald-100">Categories</div>
                                </div>
                                <div class="bg-rose-500/20 rounded-xl p-4 text-center">
                                    <div class="text-2xl font-bold text-rose-300 mb-1">5+</div>
                                    <div class="text-sm text-emerald-100">Experts</div>
                                </div>
                            </div>
                            
                            <div class="space-y-4">
                                <div class="flex items-center justify-between p-3 bg-white/5 rounded-xl">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-emerald-500/20 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-heart text-emerald-300"></i>
                                        </div>
                                        <span class="text-emerald-100 font-medium">Health Benefits</span>
                                    </div>
                                    <span class="text-emerald-300 font-bold">{{ $categories->where('name', 'Health Benefits')->first()->posts_count ?? '12' }}</span>
                                </div>
                                
                                <div class="flex items-center justify-between p-3 bg-white/5 rounded-xl">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-amber-500/20 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-utensils text-amber-300"></i>
                                        </div>
                                        <span class="text-emerald-100 font-medium">Recipes</span>
                                    </div>
                                    <span class="text-emerald-300 font-bold">{{ $categories->where('name', 'Recipes')->first()->posts_count ?? '18' }}</span>
                                </div>
                                
                                <div class="flex items-center justify-between p-3 bg-white/5 rounded-xl">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-blue-500/20 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-lightbulb text-blue-300"></i>
                                        </div>
                                        <span class="text-emerald-100 font-medium">Nutrition Tips</span>
                                    </div>
                                    <span class="text-emerald-300 font-bold">{{ $categories->where('name', 'Nutrition')->first()->posts_count ?? '15' }}</span>
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
<!-- Blog Content Section -->
<section class="py-16 md:py-20" id="latest-posts">
    <div class="container mx-auto px-4">
        <!-- Page Header -->
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                Latest Articles
            </h2>
            <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                Expert insights, delicious recipes, and health benefits of premium dry fruits
            </p>
        </div>

        <!-- Filter & Sort -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
            <!-- Categories Filter -->
            <div class="flex flex-wrap gap-2" id="categories">
                <a href="{{ route('blog.index') }}" 
                   class="px-4 py-2 rounded-full border {{ !request('category') ? 'bg-emerald-600 text-white border-emerald-600' : 'border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:border-emerald-500 dark:hover:border-emerald-500' }} transition-colors">
                    All Articles
                </a>
                @foreach($categories as $category)
                @php
                    $categoryName = is_array($category) ? $category['name'] : $category;
                    $categorySlug = is_array($category) ? $category['slug'] : strtolower(str_replace(' ', '-', $category));
                @endphp
                <a href="{{ route('blog.index', ['category' => $categorySlug]) }}" 
                   class="px-4 py-2 rounded-full border {{ request('category') == $categorySlug ? 'bg-emerald-600 text-white border-emerald-600' : 'border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:border-emerald-500 dark:hover:border-emerald-500' }} transition-colors">
                    {{ $categoryName }}
                </a>
                @endforeach
            </div>
            
            <!-- Sort Options -->
            <div class="flex items-center space-x-4">
                <span class="text-gray-600 dark:text-gray-400">Sort by:</span>
                <select class="bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 text-gray-700 dark:text-gray-300 focus:outline-none focus:border-emerald-500">
                    <option value="latest">Latest First</option>
                    <option value="popular">Most Popular</option>
                    <option value="trending">Trending</option>
                </select>
            </div>
        </div>

        <!-- Blog Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            @foreach($blogs as $blog)
            <article class="group bg-white dark:bg-gray-800 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 dark:border-gray-700">
                <!-- Image -->
                <div class="relative overflow-hidden h-56">
                    <img src="{{ $blog->featured_image ? asset('storage/' . $blog->featured_image) : 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80' }}"
                         alt="{{ $blog->title }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    
                    <!-- Category Badge -->
                    <div class="absolute top-4 left-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-600 text-white">
                            {{ $blog->category }}
                        </span>
                    </div>
                    
                    <!-- Featured Badge -->
                    @if($blog->is_featured ?? false)
                    <div class="absolute top-4 right-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-amber-500 text-white">
                            <i class="fas fa-star mr-1"></i> Featured
                        </span>
                    </div>
                    @endif
                </div>
                
                <!-- Content -->
                <div class="p-6">
                    <!-- Meta -->
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-4 text-sm text-gray-500 dark:text-gray-400">
                            <span class="flex items-center">
                                <i class="far fa-calendar mr-2"></i>
                                {{ $blog->published_at->format('M d, Y') }}
                            </span>
                            <span class="flex items-center">
                                <i class="far fa-clock mr-2"></i>
                                {{ $blog->read_time ?? '5' }} min read
                            </span>
                        </div>
                        @if($blog->view_count > 0)
                        <span class="text-sm text-gray-500 dark:text-gray-400 flex items-center">
                            <i class="far fa-eye mr-2"></i>
                            {{ $blog->view_count }}
                        </span>
                        @endif
                    </div>
                    
                    <!-- Title -->
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">
                        <a href="{{ route('blog.show', $blog->slug) }}" class="hover:no-underline">
                            {{ Str::limit($blog->title, 60) }}
                        </a>
                    </h3>
                    
                    <!-- Excerpt -->
                    <p class="text-gray-600 dark:text-gray-300 mb-4 line-clamp-2">
                        {{ Str::limit($blog->brief_description, 120) }}
                    </p>
                    
                    <!-- Tags -->
                    @if($blog->tags)
                    <div class="flex flex-wrap gap-2 mb-6">
                        @foreach(array_slice(explode(',', $blog->tags), 0, 3) as $tag)
                        @if(trim($tag))
                        <span class="inline-block px-2 py-1 text-xs bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 rounded">
                            {{ trim($tag) }}
                        </span>
                        @endif
                        @endforeach
                    </div>
                    @endif
                    
                    <!-- Author & Read More -->
                    <div class="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-gray-700">
                        <div class="flex items-center space-x-3">
                            @if($blog->author && $blog->author->avatar_url)
                            <img src="{{ $blog->author->avatar_url }}"
                                 alt="{{ $blog->author->name }}"
                                 class="w-8 h-8 rounded-full object-cover">
                            @else
                            <div class="w-8 h-8 rounded-full bg-emerald-100 dark:bg-emerald-900 flex items-center justify-center">
                                <i class="fas fa-user text-emerald-600 dark:text-emerald-400 text-sm"></i>
                            </div>
                            @endif
                            <div>
                                <div class="text-sm font-semibold text-gray-900 dark:text-white">
                                    {{ $blog->author->name ?? 'Admin' }}
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $blog->author->title ?? 'Nutrition Expert' }}
                                </div>
                            </div>
                        </div>
                        
                        <a href="{{ route('blog.show', $blog->slug) }}"
                           class="inline-flex items-center text-emerald-600 dark:text-emerald-400 font-semibold text-sm hover:text-emerald-700 dark:hover:text-emerald-300 transition-colors">
                            Read More
                            <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </div>
            </article>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($blogs->hasPages())
        <div class="flex flex-col md:flex-row justify-between items-center gap-4 pt-8 border-t border-gray-200 dark:border-gray-700">
            <div class="text-sm text-gray-600 dark:text-gray-400">
                Showing {{ $blogs->firstItem() }}-{{ $blogs->lastItem() }} of {{ $blogs->total() }} articles
            </div>
            <div class="flex items-center space-x-2">
                {{ $blogs->onEachSide(1)->links('vendor.pagination.simple-tailwind') }}
            </div>
        </div>
        @endif
    </div>
</section>

<!-- Featured Article -->
@if($featuredBlog)
<section class="py-16 md:py-20 bg-gradient-to-r from-gray-50 to-emerald-50 dark:from-gray-900 dark:to-emerald-900/20">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">
                Featured Article
            </h2>
            <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                Don't miss our most popular and insightful article
            </p>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2">
                <!-- Image -->
                <div class="relative h-64 lg:h-auto">
                    <img src="{{ $featuredBlog->featured_image ? asset('storage/' . $featuredBlog->featured_image) : 'https://images.unsplash.com/photo-1490818387583-1baba5e638af?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80' }}"
                         alt="{{ $featuredBlog->title }}"
                         class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-r from-emerald-900/50 to-transparent"></div>
                    <div class="absolute top-6 left-6">
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-amber-500 text-white">
                            <i class="fas fa-star mr-2"></i> Featured
                        </span>
                    </div>
                    <div class="absolute bottom-6 left-6">
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-emerald-600 text-white">
                            {{ $featuredBlog->category }}
                        </span>
                    </div>
                </div>
                
                <!-- Content -->
                <div class="p-8 md:p-12 flex flex-col justify-center">
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="flex items-center space-x-2 text-gray-500 dark:text-gray-400">
                            <i class="far fa-calendar"></i>
                            <span>{{ $featuredBlog->published_at->format('F d, Y') }}</span>
                        </div>
                        <div class="flex items-center space-x-2 text-gray-500 dark:text-gray-400">
                            <i class="far fa-clock"></i>
                            <span>{{ $featuredBlog->read_time ?? '5' }} min read</span>
                        </div>
                    </div>
                    
                    <h3 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-4">
                        {{ $featuredBlog->title }}
                    </h3>
                    
                    <p class="text-gray-600 dark:text-gray-300 mb-6 line-clamp-3">
                        {{ $featuredBlog->brief_description }}
                    </p>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            @if($featuredBlog->author && $featuredBlog->author->avatar_url)
                            <img src="{{ $featuredBlog->author->avatar_url }}"
                                 alt="{{ $featuredBlog->author->name }}"
                                 class="w-10 h-10 rounded-full object-cover">
                            @else
                            <div class="w-10 h-10 rounded-full bg-emerald-100 dark:bg-emerald-900 flex items-center justify-center">
                                <i class="fas fa-user text-emerald-600 dark:text-emerald-400"></i>
                            </div>
                            @endif
                            <div>
                                <div class="font-semibold text-gray-900 dark:text-white">
                                    {{ $featuredBlog->author->name ?? 'Admin' }}
                                </div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $featuredBlog->author->title ?? 'Nutrition Expert' }}
                                </div>
                            </div>
                        </div>
                        
                        <a href="{{ route('blog.show', $featuredBlog->slug) }}"
                           class="inline-flex items-center justify-center px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                            Read Full Article
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Sidebar Content (Moved to bottom for mobile-first) -->
<section class="py-16 md:py-20 bg-gray-50 dark:bg-gray-900">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Sidebar Content -->
            <div class="lg:col-span-2">
                <!-- Recent Posts -->
                <div class="mb-12">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
                        <i class="fas fa-history mr-3 text-emerald-600"></i>
                        Recent Articles
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($recentPosts as $recent)
                        <article class="bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-lg transition-shadow duration-300 overflow-hidden">
                            <div class="flex">
                                <div class="w-32 h-32 flex-shrink-0">
                                    <img src="{{ $recent->featured_image ? asset('storage/' . $recent->featured_image) : 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80' }}"
                                         alt="{{ $recent->title }}"
                                         class="w-full h-full object-cover">
                                </div>
                                <div class="p-4 flex-1">
                                    <h4 class="font-bold text-gray-900 dark:text-white mb-2 line-clamp-2">
                                        <a href="{{ route('blog.show', $recent->slug) }}" class="hover:text-emerald-600 dark:hover:text-emerald-400">
                                            {{ Str::limit($recent->title, 50) }}
                                        </a>
                                    </h4>
                                    <div class="flex items-center space-x-3 text-sm text-gray-500 dark:text-gray-400 mb-2">
                                        <span class="flex items-center">
                                            <i class="far fa-calendar mr-1"></i>
                                            {{ $recent->published_at->format('M d') }}
                                        </span>
                                        <span class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded text-xs">
                                            {{ $recent->category }}
                                        </span>
                                    </div>
                                    <a href="{{ route('blog.show', $recent->slug) }}" 
                                       class="text-emerald-600 dark:text-emerald-400 font-semibold text-sm hover:underline inline-flex items-center">
                                        Read More
                                        <i class="fas fa-arrow-right ml-1 text-xs"></i>
                                    </a>
                                </div>
                            </div>
                        </article>
                        @endforeach
                    </div>
                </div>
                
                <!-- Newsletter -->
                <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 rounded-2xl p-8">
                    <div class="text-center mb-6">
                        <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-paper-plane text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-2">Subscribe to Our Blog</h3>
                        <p class="text-emerald-100">Get the latest articles, recipes, and health tips delivered to your inbox.</p>
                    </div>
                    
                    <form class="space-y-4">
                        <div>
                            <input type="email"
                                   placeholder="Your email address"
                                   class="w-full px-4 py-3 rounded-lg bg-white/10 border border-white/20 text-white placeholder-emerald-200 focus:outline-none focus:border-white/40">
                        </div>
                        <button type="submit" 
                                class="w-full px-6 py-3 bg-white text-emerald-600 font-semibold rounded-lg hover:bg-emerald-50 transition-colors duration-300">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Subscribe Now
                        </button>
                        <p class="text-sm text-emerald-200 text-center">
                            <i class="fas fa-lock mr-1"></i>
                            We respect your privacy. Unsubscribe at any time.
                        </p>
                    </form>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="space-y-8">
                <!-- Search -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
                    <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-4">
                        <i class="fas fa-search mr-2 text-emerald-600"></i>
                        Search Articles
                    </h4>
                    <form action="{{ route('blog.index') }}" method="GET" class="space-y-3">
                        <div class="relative">
                            <input type="text"
                                   name="search"
                                   value="{{ request('search') }}"
                                   placeholder="Search for articles..."
                                   class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg focus:outline-none focus:border-emerald-500 dark:focus:border-emerald-500 text-gray-900 dark:text-white">
                            <button type="submit" class="absolute right-3 top-3 text-gray-400 hover:text-emerald-600">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Categories -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
                    <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-4">
                        <i class="fas fa-folder mr-2 text-emerald-600"></i>
                        Categories
                    </h4>
                    <div class="space-y-2">
                        <a href="{{ route('blog.index') }}" 
                           class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 {{ !request('category') ? 'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400' : 'text-gray-700 dark:text-gray-300' }}">
                            <span class="font-medium">All Articles</span>
                            <span class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 px-2 py-1 rounded-full text-xs font-semibold">
                                {{ $totalPosts }}
                            </span>
                        </a>
                        @foreach($categories as $category)
                        @php
                            $categoryName = is_array($category) ? $category['name'] : $category;
                            $categorySlug = is_array($category) ? $category['slug'] : strtolower(str_replace(' ', '-', $category));
                            $categoryCount = is_array($category) ? $category['posts_count'] : 0;
                        @endphp
                        <a href="{{ route('blog.index', ['category' => $categorySlug]) }}" 
                           class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 {{ request('category') == $categorySlug ? 'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400' : 'text-gray-700 dark:text-gray-300' }}">
                            <span class="font-medium">{{ $categoryName }}</span>
                            <span class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 px-2 py-1 rounded-full text-xs font-semibold">
                                {{ $categoryCount }}
                            </span>
                        </a>
                        @endforeach
                    </div>
                </div>
                
                <!-- Popular Tags -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
                    <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-4">
                        <i class="fas fa-tags mr-2 text-emerald-600"></i>
                        Popular Topics
                    </h4>
                    <div class="flex flex-wrap gap-2">
                        @php
                            $tags = ['Recipes', 'Health Benefits', 'Nutrition', 'Cooking Tips', 'Wellness',
                            'Almonds', 'Walnuts', 'Pistachios', 'Dates', 'Apricots', 'Organic',
                            'Healthy Snacks', 'Superfoods', 'Heart Health', 'Weight Management'];
                        @endphp
                        @foreach($tags as $tag)
                        <a href="{{ route('blog.index', ['tag' => $tag]) }}" 
                           class="px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-full text-sm hover:bg-emerald-100 dark:hover:bg-emerald-900/30 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
                            {{ $tag }}
                        </a>
                        @endforeach
                    </div>
                </div>
                
                <!-- Social Follow -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6">
                    <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-4">
                        <i class="fas fa-share-alt mr-2 text-emerald-600"></i>
                        Follow Us
                    </h4>
                    <div class="flex space-x-3">
                        <a href="#" class="w-10 h-10 bg-blue-600 hover:bg-blue-700 text-white rounded-lg flex items-center justify-center transition-colors">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-pink-600 hover:bg-pink-700 text-white rounded-lg flex items-center justify-center transition-colors">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-blue-400 hover:bg-blue-500 text-white rounded-lg flex items-center justify-center transition-colors">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-red-600 hover:bg-red-700 text-white rounded-lg flex items-center justify-center transition-colors">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-blue-700 hover:bg-blue-800 text-white rounded-lg flex items-center justify-center transition-colors">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
/* Animations */
.animate-slide-up {
    animation: slideUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    opacity: 0;
    transform: translateY(30px);
}

.animate-slide-up.delay-1 {
    animation-delay: 0.2s;
}

@keyframes slideUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Line clamp utilities */
.line-clamp-1 {
    overflow: hidden;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 1;
}

.line-clamp-2 {
    overflow: hidden;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 2;
}

.line-clamp-3 {
    overflow: hidden;
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 3;
}

/* Smooth transitions */
.group-hover\:scale-105 {
    transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Custom scrollbar */
::-webkit-scrollbar {
    width: 8px;
}

::-webkit-scrollbar-track {
    background: var(--surface-color);
}

::-webkit-scrollbar-thumb {
    background: var(--primary-color);
    border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
    background: var(--primary-dark);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .grid-cols-2 {
        grid-template-columns: 1fr;
    }
    
    .featured-article .grid-cols-2 {
        grid-template-columns: 1fr;
    }
    
    .sidebar-content {
        margin-top: 2rem;
    }
}

/* Dark mode adjustments */
[data-theme="dark"] .bg-gray-50 {
    background-color: var(--surface-color);
}

[data-theme="dark"] .border-gray-200 {
    border-color: var(--border-color);
}

/* Card hover effects */
.group:hover .group-hover\:shadow-2xl {
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Category filtering
    const categoryLinks = document.querySelectorAll('[href*="category"]');
    categoryLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            if (!this.classList.contains('bg-emerald-600')) {
                // Add loading state
                const blogGrid = document.querySelector('.grid');
                if (blogGrid) {
                    blogGrid.classList.add('opacity-50');
                }
            }
        });
    });

    // Newsletter subscription
    const newsletterForm = document.querySelector('form');
    if (newsletterForm && newsletterForm.querySelector('input[type="email"]')) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const emailInput = this.querySelector('input[type="email"]');
            const button = this.querySelector('button[type="submit"]');
            
            if (!emailInput.value || !isValidEmail(emailInput.value)) {
                showToast('Please enter a valid email address', 'error');
                return;
            }
            
            const originalText = button.innerHTML;
            button.disabled = true;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Subscribing...';
            
            // Simulate API call
            setTimeout(() => {
                showToast('Successfully subscribed to our newsletter!', 'success');
                emailInput.value = '';
                button.disabled = false;
                button.innerHTML = originalText;
            }, 1500);
        });
    }

    // Search functionality
    const searchForm = document.querySelector('form[action*="blog"]');
    if (searchForm) {
        const searchInput = searchForm.querySelector('input[name="search"]');
        searchInput.addEventListener('input', function() {
            if (this.value.length > 2) {
                // You could add debounced search here
            }
        });
    }

    // View count increment on card hover (for analytics)
    const blogCards = document.querySelectorAll('.group');
    blogCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            // Track hover for analytics if needed
        });
    });

    // Email validation helper
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    // Toast notification function
    function showToast(message, type = 'info') {
        // Use existing toast function or create simple one
        if (typeof window.showToast === 'function') {
            window.showToast(message, type);
        } else {
            // Fallback console log
            console.log(`${type}: ${message}`);
        }
    }
});
</script>
@endpush