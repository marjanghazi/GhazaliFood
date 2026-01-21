@extends('layouts.app')

@section('title', 'Order Details - Nuts & Berries')

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
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                            <a href="{{ route('orders.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-green-600">My Orders</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Order Details</span>
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
                    <!-- Order Header -->
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-6 border-b border-gray-200">
                        <div class="flex flex-col md:flex-row md:items-center justify-between">
                            <div>
                                <div class="flex items-center mb-2">
                                    <h1 class="text-2xl font-bold text-gray-800 mr-4">Order #{{ $order->order_number }}</h1>
                                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                                        {{ $order->status == 'completed' ? 'bg-green-100 text-green-800' : 
                                           ($order->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                           ($order->status == 'processing' ? 'bg-blue-100 text-blue-800' : 
                                           ($order->status == 'shipped' ? 'bg-indigo-100 text-indigo-800' : 
                                           'bg-red-100 text-red-800'))) }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                                <p class="text-gray-600">
                                    Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}
                                </p>
                            </div>
                            <div class="mt-4 md:mt-0 space-x-3">
                                <a href="{{ route('orders.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50">
                                    <i class="fas fa-arrow-left mr-2"></i>
                                    Back to Orders
                                </a>
                                @if($order->status == 'completed')
                                    <a href="{{ route('checkout.download.invoice', $order->id) }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                                        <i class="fas fa-download mr-2"></i>
                                        Download Invoice
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Order Content -->
                    <div class="p-6">
                        <!-- Order Progress -->
                        <div class="mb-8">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-gray-800">Order Status</h3>
                                @if($order->tracking_number)
                                    <div class="text-sm text-gray-600">
                                        <i class="fas fa-truck mr-1"></i>
                                        Tracking: {{ $order->tracking_number }}
                                    </div>
                                @endif
                            </div>
                            
                            <div class="relative">
                                <!-- Progress Bar -->
                                <div class="absolute top-4 left-0 right-0 h-1 bg-gray-200"></div>
                                <div class="absolute top-4 left-0 h-1 bg-green-500 transition-all duration-500"
                                     style="width: 
                                        {{ $order->status == 'pending' ? '25%' : 
                                          ($order->status == 'processing' ? '50%' : 
                                          ($order->status == 'shipped' ? '75%' : 
                                          '100%')) }}">
                                </div>
                                
                                <!-- Steps -->
                                <div class="relative flex justify-between">
                                    @php
                                        $steps = [
                                            'pending' => ['label' => 'Order Placed', 'icon' => 'fa-shopping-cart'],
                                            'processing' => ['label' => 'Processing', 'icon' => 'fa-cog'],
                                            'shipped' => ['label' => 'Shipped', 'icon' => 'fa-truck'],
                                            'completed' => ['label' => 'Delivered', 'icon' => 'fa-check-circle']
                                        ];
                                    @endphp
                                    
                                    @foreach($steps as $status => $step)
                                        @php
                                            $isActive = array_search($order->status, array_keys($steps)) >= array_search($status, array_keys($steps));
                                        @endphp
                                        <div class="flex flex-col items-center">
                                            <div class="w-10 h-10 rounded-full border-2 flex items-center justify-center mb-2
                                                {{ $isActive ? 'bg-green-500 border-green-500 text-white' : 'bg-white border-gray-300 text-gray-400' }}">
                                                <i class="fas {{ $step['icon'] }}"></i>
                                            </div>
                                            <span class="text-sm {{ $isActive ? 'text-green-600 font-medium' : 'text-gray-500' }}">
                                                {{ $step['label'] }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Order Items -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Order Items</h3>
                            <div class="overflow-hidden border border-gray-200 rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($order->items as $item)
                                            <tr>
                                                <td class="px-6 py-4">
                                                    <div class="flex items-center">
                                                        @if($item->product->image_url)
                                                            <img src="{{ $item->product->image_url }}" 
                                                                 alt="{{ $item->product->name }}" 
                                                                 class="w-16 h-16 object-cover rounded-lg mr-4">
                                                        @else
                                                            <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center mr-4">
                                                                <i class="fas fa-box text-gray-400"></i>
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <a href="{{ route('shop.show', $item->product->slug) }}" 
                                                               class="text-sm font-medium text-gray-900 hover:text-green-600">
                                                                {{ $item->product->name }}
                                                            </a>
                                                            @if($item->variant_name)
                                                                <p class="text-sm text-gray-500 mt-1">
                                                                    Variant: {{ $item->variant_name }}
                                                                </p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">${{ number_format($item->unit_price, 2) }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">{{ $item->quantity }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-900">${{ number_format($item->total_price, 2) }}</div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Order Summary -->
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                            <!-- Order Totals -->
                            <div class="lg:col-span-2">
                                <div class="bg-gray-50 rounded-lg p-6">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Order Summary</h3>
                                    <div class="space-y-3">
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Subtotal</span>
                                            <span class="font-medium">${{ number_format($order->subtotal, 2) }}</span>
                                        </div>
                                        @if($order->discount_amount > 0)
                                            <div class="flex justify-between">
                                                <span class="text-gray-600">Discount</span>
                                                <span class="font-medium text-green-600">-${{ number_format($order->discount_amount, 2) }}</span>
                                            </div>
                                        @endif
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Shipping</span>
                                            <span class="font-medium">${{ number_format($order->shipping_amount, 2) }}</span>
                                        </div>
                                        @if($order->tax_amount > 0)
                                            <div class="flex justify-between">
                                                <span class="text-gray-600">Tax</span>
                                                <span class="font-medium">${{ number_format($order->tax_amount, 2) }}</span>
                                            </div>
                                        @endif
                                        <div class="border-t border-gray-200 pt-3 mt-3">
                                            <div class="flex justify-between">
                                                <span class="text-lg font-semibold text-gray-800">Total</span>
                                                <span class="text-lg font-bold text-gray-900">${{ number_format($order->total_amount, 2) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Information -->
                            <div>
                                <div class="bg-gray-50 rounded-lg p-6">
                                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Order Information</h3>
                                    <div class="space-y-4">
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-500 mb-1">Payment Method</h4>
                                            <p class="text-sm text-gray-800">{{ ucfirst($order->payment_method) }}</p>
                                            <p class="text-xs text-gray-500 mt-1">
                                                Status: 
                                                <span class="font-medium {{ $order->payment_status == 'paid' ? 'text-green-600' : 'text-yellow-600' }}">
                                                    {{ ucfirst($order->payment_status) }}
                                                </span>
                                            </p>
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-500 mb-1">Shipping Address</h4>
                                            <p class="text-sm text-gray-800">
                                                {{ $order->shipping_full_name }}<br>
                                                {{ $order->shipping_address }}<br>
                                                {{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_postal_code }}<br>
                                                {{ $order->shipping_country }}
                                            </p>
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-500 mb-1">Contact</h4>
                                            <p class="text-sm text-gray-800">
                                                <i class="fas fa-phone mr-2 text-gray-400"></i> {{ $order->shipping_phone }}<br>
                                                <i class="fas fa-envelope mr-2 text-gray-400"></i> {{ auth()->user()->email }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Order History -->
                        @if($order->statusHistory && $order->statusHistory->count() > 0)
                            <div class="mt-8">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Order History</h3>
                                <div class="bg-gray-50 rounded-lg p-6">
                                    <div class="space-y-4">
                                        @foreach($order->statusHistory->sortByDesc('created_at') as $history)
                                            <div class="flex items-start">
                                                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-green-100 flex items-center justify-center mr-4">
                                                    <i class="fas fa-history text-green-600"></i>
                                                </div>
                                                <div class="flex-1">
                                                    <div class="flex items-center justify-between">
                                                        <h4 class="text-sm font-medium text-gray-800">{{ ucfirst($history->status) }}</h4>
                                                        <span class="text-xs text-gray-500">{{ $history->created_at->format('M d, Y h:i A') }}</span>
                                                    </div>
                                                    @if($history->notes)
                                                        <p class="text-sm text-gray-600 mt-1">{{ $history->notes }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
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