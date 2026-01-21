@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4">
        <!-- Breadcrumb -->
        <div class="mb-6">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('home') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-green-600">
                            <i class="fas fa-home mr-2"></i>
                            Home
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">My Profile</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Sidebar -->
            <div class="lg:col-span-1">
                @include('auth.profile.partials.sidebar')
            </div>

            <!-- Main Content -->
            <div class="lg:col-span-3">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <!-- Profile Header -->
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-8 border-b border-gray-200">
                        <div class="flex flex-col md:flex-row md:items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="relative">
                                    <div class="w-20 h-20 rounded-full bg-gradient-to-r from-green-400 to-emerald-500 flex items-center justify-center text-white text-2xl font-bold">
                                        @if($user->profile_image_url)
                                            <img src="{{ $user->profile_image_url }}" alt="{{ $user->name }}" class="w-full h-full rounded-full object-cover">
                                        @else
                                            {{ $user->initials }}
                                        @endif
                                    </div>
                                    <div class="absolute bottom-0 right-0 w-6 h-6 bg-green-500 rounded-full border-2 border-white flex items-center justify-center">
                                        <i class="fas fa-check text-white text-xs"></i>
                                    </div>
                                </div>
                                <div>
                                    <h1 class="text-2xl font-bold text-gray-800">{{ $user->name }}</h1>
                                    <p class="text-gray-600 flex items-center mt-1">
                                        <i class="fas fa-envelope mr-2 text-green-500"></i>
                                        {{ $user->email }}
                                    </p>
                                    <div class="flex items-center mt-2">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-user-tag mr-1"></i>
                                            {{ $user->role->name ?? 'Customer' }}
                                        </span>
                                        <span class="ml-2 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $user->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            <i class="fas fa-circle mr-1 text-xs"></i>
                                            {{ ucfirst($user->status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 md:mt-0">
                                <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                    <i class="fas fa-edit mr-2"></i>
                                    Edit Profile
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Stats -->
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                            <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                                        <i class="fas fa-shopping-bag text-blue-600 text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-2xl font-bold text-gray-800">{{ $user->orders()->count() }}</h3>
                                        <p class="text-gray-600 text-sm">Total Orders</p>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-pink-100 rounded-lg flex items-center justify-center mr-4">
                                        <i class="fas fa-heart text-pink-600 text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-2xl font-bold text-gray-800">{{ $wishlistCount }}</h3>
                                        <p class="text-gray-600 text-sm">Wishlist Items</p>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mr-4">
                                        <i class="fas fa-star text-purple-600 text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="text-2xl font-bold text-gray-800">{{ $user->reviews()->count() }}</h3>
                                        <p class="text-gray-600 text-sm">Reviews</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Orders -->
                        <div class="mb-8">
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="text-lg font-semibold text-gray-800">Recent Orders</h2>
                                <a href="{{ route('orders.index') }}" class="text-green-600 hover:text-green-700 text-sm font-medium">
                                    View All
                                    <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                            @if($orders->count() > 0)
                                <div class="overflow-hidden border border-gray-200 rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order #</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($orders as $order)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm font-medium text-gray-900">#{{ $order->order_number }}</div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm text-gray-900">{{ $order->created_at->format('M d, Y') }}</div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm font-medium text-gray-900">${{ number_format($order->total_amount, 2) }}</div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                            {{ $order->status == 'completed' ? 'bg-green-100 text-green-800' : 
                                                               ($order->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                                               ($order->status == 'processing' ? 'bg-blue-100 text-blue-800' : 
                                                               'bg-red-100 text-red-800')) }}">
                                                            {{ ucfirst($order->status) }}
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                        <a href="{{ route('orders.show', $order->id) }}" class="text-green-600 hover:text-green-900 mr-3">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-8 border-2 border-dashed border-gray-300 rounded-lg">
                                    <i class="fas fa-shopping-bag text-gray-400 text-4xl mb-3"></i>
                                    <h3 class="text-lg font-medium text-gray-600 mb-2">No orders yet</h3>
                                    <p class="text-gray-500 mb-4">Start shopping to see your orders here</p>
                                    <a href="{{ route('shop.index') }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                        <i class="fas fa-shopping-cart mr-2"></i>
                                        Start Shopping
                                    </a>
                                </div>
                            @endif
                        </div>

                        <!-- Personal Information -->
                        <div>
                            <h2 class="text-lg font-semibold text-gray-800 mb-4">Personal Information</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <h3 class="text-sm font-medium text-gray-500 mb-2">Contact Information</h3>
                                    <div class="space-y-2">
                                        <div class="flex items-center">
                                            <i class="fas fa-phone text-green-500 w-5"></i>
                                            <span class="ml-3 text-gray-700">{{ $user->phone ?: 'Not provided' }}</span>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-envelope text-green-500 w-5"></i>
                                            <span class="ml-3 text-gray-700">{{ $user->email }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    <h3 class="text-sm font-medium text-gray-500 mb-2">Account Details</h3>
                                    <div class="space-y-2">
                                        <div class="flex items-center">
                                            <i class="fas fa-calendar text-green-500 w-5"></i>
                                            <span class="ml-3 text-gray-700">
                                                Joined {{ $user->created_at->format('M d, Y') }}
                                            </span>
                                        </div>
                                        <div class="flex items-center">
                                            <i class="fas fa-sign-in-alt text-green-500 w-5"></i>
                                            <span class="ml-3 text-gray-700">
                                                Last login: {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Add any profile-specific scripts here
</script>
@endpush