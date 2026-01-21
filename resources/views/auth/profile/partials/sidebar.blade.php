<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <!-- User Info -->
    <div class="p-6 border-b border-gray-200">
        <div class="flex items-center">
            <div class="relative">
                <div class="w-12 h-12 rounded-full bg-gradient-to-r from-green-400 to-emerald-500 flex items-center justify-center text-white font-bold overflow-hidden">
                    @if(auth()->user()->profile_image_url)
                        <img src="{{ auth()->user()->profile_image_url }}" alt="{{ auth()->user()->name }}" class="w-full h-full object-cover">
                    @else
                        {{ auth()->user()->initials }}
                    @endif
                </div>
            </div>
            <div class="ml-4">
                <h3 class="text-sm font-semibold text-gray-800">{{ auth()->user()->name }}</h3>
                <p class="text-xs text-gray-600">{{ auth()->user()->email }}</p>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="p-4">
        <ul class="space-y-1">
            <li>
                <a href="{{ route('profile.edit') }}" 
                   class="flex items-center px-4 py-3 text-sm rounded-lg {{ request()->routeIs('profile.edit') ? 'bg-green-50 text-green-700 border border-green-200' : 'text-gray-700 hover:bg-gray-50' }}">
                    <i class="fas fa-user-circle w-5 mr-3 {{ request()->routeIs('profile.edit') ? 'text-green-600' : 'text-gray-400' }}"></i>
                    Profile Overview
                </a>
            </li>
            <li>
                <a href="{{ route('profile.edit') }}" 
                   class="flex items-center px-4 py-3 text-sm rounded-lg {{ request()->is('profile/edit') ? 'bg-green-50 text-green-700 border border-green-200' : 'text-gray-700 hover:bg-gray-50' }}">
                    <i class="fas fa-user-edit w-5 mr-3 {{ request()->is('profile/edit') ? 'text-green-600' : 'text-gray-400' }}"></i>
                    Edit Profile
                </a>
            </li>
            <li>
                <a href="{{ route('profile.change-password') }}" 
                   class="flex items-center px-4 py-3 text-sm rounded-lg {{ request()->is('profile/change-password') ? 'bg-green-50 text-green-700 border border-green-200' : 'text-gray-700 hover:bg-gray-50' }}">
                    <i class="fas fa-key w-5 mr-3 {{ request()->is('profile/change-password') ? 'text-green-600' : 'text-gray-400' }}"></i>
                    Change Password
                </a>
            </li>
            <li>
                <a href="{{ route('orders.index') }}" 
                   class="flex items-center px-4 py-3 text-sm rounded-lg {{ request()->is('orders*') ? 'bg-green-50 text-green-700 border border-green-200' : 'text-gray-700 hover:bg-gray-50' }}">
                    <i class="fas fa-shopping-bag w-5 mr-3 {{ request()->is('orders*') ? 'text-green-600' : 'text-gray-400' }}"></i>
                    My Orders
                    @if(auth()->user()->orders()->where('order_status', 'pending')->count() > 0)
                        <span class="ml-auto bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full">
                            {{ auth()->user()->orders()->where('order_status', 'pending')->count() }}
                        </span>
                    @endif
                </a>
            </li>
            <li>
                <a href="{{ route('profile.wishlist') }}" 
                   class="flex items-center px-4 py-3 text-sm rounded-lg {{ request()->is('profile/wishlist') ? 'bg-green-50 text-green-700 border border-green-200' : 'text-gray-700 hover:bg-gray-50' }}">
                    <i class="fas fa-heart w-5 mr-3 {{ request()->is('profile/wishlist') ? 'text-green-600' : 'text-gray-400' }}"></i>
                    Wishlist
                    @if(auth()->user()->wishlistCount() > 0)
                        <span class="ml-auto bg-pink-100 text-pink-800 text-xs px-2 py-1 rounded-full">
                            {{ auth()->user()->wishlistCount() }}
                        </span>
                    @endif
                </a>
            </li>
            <li>
                <a href="{{ route('profile.shipping-addresses') }}" 
                   class="flex items-center px-4 py-3 text-sm rounded-lg {{ request()->is('profile/addresses*') ? 'bg-green-50 text-green-700 border border-green-200' : 'text-gray-700 hover:bg-gray-50' }}">
                    <i class="fas fa-map-marker-alt w-5 mr-3 {{ request()->is('profile/addresses*') ? 'text-green-600' : 'text-gray-400' }}"></i>
                    Shipping Addresses
                </a>
            </li>
            <li>
                <a href="{{ route('reviews') }}" 
                   class="flex items-center px-4 py-3 text-sm rounded-lg {{ request()->is('reviews*') ? 'bg-green-50 text-green-700 border border-green-200' : 'text-gray-700 hover:bg-gray-50' }}">
                    <i class="fas fa-star w-5 mr-3 {{ request()->is('reviews*') ? 'text-green-600' : 'text-gray-400' }}"></i>
                    My Reviews
                </a>
            </li>
            <li class="border-t border-gray-200 mt-4 pt-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-4 py-3 text-sm text-red-600 rounded-lg hover:bg-red-50">
                        <i class="fas fa-sign-out-alt w-5 mr-3"></i>
                        Logout
                    </button>
                </form>
            </li>
        </ul>
    </nav>
</div>