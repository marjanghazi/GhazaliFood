@extends('layouts.app')

@section('title', 'My Orders - Nuts & Berries')

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
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                            <a href="{{ route('profile.edit') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-green-600">My Profile</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">My Orders</span>
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
                    <!-- Header -->
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-6 border-b border-gray-200">
                        <div class="flex flex-col md:flex-row md:items-center justify-between">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-800">My Orders</h1>
                                <p class="text-gray-600 mt-1">Track and manage your orders</p>
                            </div>
                            <div class="mt-4 md:mt-0">
                                <a href="{{ route('shop.index') }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                    <i class="fas fa-shopping-cart mr-2"></i>
                                    Continue Shopping
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Orders Content -->
                    <div class="p-6">
                        @if($orders->count() > 0)
                            <!-- Order Stats -->
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                                <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                            <i class="fas fa-clock text-blue-600"></i>
                                        </div>
                                        <div>
                                            <h3 class="text-xl font-bold text-gray-800">{{ $orders->where('status', 'pending')->count() }}</h3>
                                            <p class="text-gray-600 text-sm">Pending</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center mr-3">
                                            <i class="fas fa-spinner text-yellow-600"></i>
                                        </div>
                                        <div>
                                            <h3 class="text-xl font-bold text-gray-800">{{ $orders->where('status', 'processing')->count() }}</h3>
                                            <p class="text-gray-600 text-sm">Processing</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                            <i class="fas fa-check-circle text-green-600"></i>
                                        </div>
                                        <div>
                                            <h3 class="text-xl font-bold text-gray-800">{{ $orders->where('status', 'completed')->count() }}</h3>
                                            <p class="text-gray-600 text-sm">Completed</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                                            <i class="fas fa-times-circle text-red-600"></i>
                                        </div>
                                        <div>
                                            <h3 class="text-xl font-bold text-gray-800">{{ $orders->where('status', 'cancelled')->count() }}</h3>
                                            <p class="text-gray-600 text-sm">Cancelled</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Orders Table -->
                            <div class="overflow-hidden border border-gray-200 rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order #</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Items</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($orders as $order)
                                            <tr class="hover:bg-gray-50 transition-colors">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-900">#{{ $order->order_number }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">{{ $order->created_at->format('M d, Y') }}</div>
                                                    <div class="text-xs text-gray-500">{{ $order->created_at->format('h:i A') }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">{{ $order->items_count }} items</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-900">${{ number_format($order->total_amount, 2) }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                        {{ $order->status == 'completed' ? 'bg-green-100 text-green-800' : 
                                                           ($order->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                                           ($order->status == 'processing' ? 'bg-blue-100 text-blue-800' : 
                                                           ($order->status == 'shipped' ? 'bg-indigo-100 text-indigo-800' : 
                                                           'bg-red-100 text-red-800'))) }}">
                                                        {{ ucfirst($order->status) }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    <a href="{{ route('orders.show', $order->id) }}" 
                                                       class="text-green-600 hover:text-green-900 mr-3"
                                                       title="View Details">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @if(in_array($order->status, ['pending', 'processing']))
                                                        <a href="{{ route('checkout.order.details', $order->id) }}" 
                                                           class="text-blue-600 hover:text-blue-900 mr-3"
                                                           title="Track Order">
                                                            <i class="fas fa-truck"></i>
                                                        </a>
                                                    @endif
                                                    @if($order->status == 'completed')
                                                        <a href="{{ route('checkout.download.invoice', $order->id) }}" 
                                                           class="text-purple-600 hover:text-purple-900"
                                                           title="Download Invoice">
                                                            <i class="fas fa-download"></i>
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            @if($orders->hasPages())
                                <div class="mt-6">
                                    {{ $orders->links() }}
                                </div>
                            @endif
                        @else
                            <div class="text-center py-12">
                                <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                                    <i class="fas fa-shopping-bag text-gray-400 text-3xl"></i>
                                </div>
                                <h3 class="text-xl font-medium text-gray-600 mb-2">No orders yet</h3>
                                <p class="text-gray-500 mb-6 max-w-md mx-auto">You haven't placed any orders yet. Start shopping to see your orders here.</p>
                                <div class="space-x-4">
                                    <a href="{{ route('shop.index') }}" class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                        <i class="fas fa-shopping-cart mr-2"></i>
                                        Start Shopping
                                    </a>
                                    <a href="{{ route('shop.index', ['featured' => true]) }}" class="inline-flex items-center px-6 py-3 border border-green-600 text-green-600 rounded-lg hover:bg-green-50 transition-colors">
                                        <i class="fas fa-star mr-2"></i>
                                        View Featured
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection