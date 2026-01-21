@extends('layouts.app')

@section('title', 'Order #' . $order->order_number . ' - Ghazali Food')

@section('content')
<div class="order-details-page">
    <div class="container mx-auto px-4 py-8">
        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Order #{{ $order->order_number }}</h1>
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-600">Placed on {{ $order->created_at->format('F d, Y') }}</span>
                        @php
                            $statusColors = [
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'processing' => 'bg-blue-100 text-blue-800',
                                'shipped' => 'bg-purple-100 text-purple-800',
                                'delivered' => 'bg-green-100 text-green-800',
                                'completed' => 'bg-green-100 text-green-800',
                                'cancelled' => 'bg-red-100 text-red-800',
                                'refunded' => 'bg-gray-100 text-gray-800',
                            ];
                            $color = $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800';
                        @endphp
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ $color }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('checkout.download.invoice', $order->id) }}"
                       class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        <i class="fas fa-download mr-2"></i>Invoice
                    </a>
                    @if(in_array($order->status, ['pending', 'processing']))
                        <button onclick="cancelOrder({{ $order->id }})"
                                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                            <i class="fas fa-times mr-2"></i>Cancel Order
                        </button>
                    @endif
                    <a href="{{ route('orders.index') }}"
                       class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Orders
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Order Items -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Order Items</h2>
                    
                    <div class="space-y-6">
                        @foreach($order->items as $item)
                            <div class="flex items-start space-x-4 p-4 border border-gray-200 rounded-lg">
                                @if($item->product && $item->product->image_url)
                                    <img src="{{ asset('storage/' . $item->product->image_url) }}"
                                         alt="{{ $item->product_name }}"
                                         class="w-20 h-20 object-cover rounded-lg">
                                @else
                                    <div class="w-20 h-20 bg-gray-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-image text-gray-400 text-2xl"></i>
                                    </div>
                                @endif
                                
                                <div class="flex-grow">
                                    <h3 class="font-medium text-gray-900">{{ $item->product_name }}</h3>
                                    @if($item->variant_name)
                                        <p class="text-sm text-gray-600">{{ $item->variant_name }}</p>
                                    @endif
                                    <div class="flex items-center justify-between mt-2">
                                        <div class="text-gray-900">
                                            ${{ number_format($item->price, 2) }} × {{ $item->quantity }}
                                        </div>
                                        <div class="font-medium text-gray-900">
                                            ${{ number_format($item->price * $item->quantity, 2) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Order Status Timeline -->
                <div class="mt-8 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Order Status</h2>
                    
                    <div class="relative">
                        <!-- Timeline -->
                        <div class="flex items-center justify-between mb-8">
                            @php
                                $statuses = [
                                    'pending' => ['icon' => 'fas fa-clock', 'title' => 'Order Placed'],
                                    'processing' => ['icon' => 'fas fa-cog', 'title' => 'Processing'],
                                    'shipped' => ['icon' => 'fas fa-shipping-fast', 'title' => 'Shipped'],
                                    'delivered' => ['icon' => 'fas fa-check-circle', 'title' => 'Delivered'],
                                ];
                                
                                $currentStatusIndex = array_search($order->status, array_keys($statuses));
                            @endphp
                            
                            @foreach($statuses as $status => $data)
                                @php
                                    $isActive = $currentStatusIndex >= array_search($status, array_keys($statuses));
                                    $isCurrent = $order->status === $status;
                                @endphp
                                
                                <div class="flex flex-col items-center">
                                    <div class="w-12 h-12 rounded-full border-2 flex items-center justify-center mb-2
                                        @if($isActive) 
                                            @if($isCurrent) border-blue-500 bg-blue-50 text-blue-600
                                            @else border-green-500 bg-green-50 text-green-600 @endif
                                        @else border-gray-300 bg-gray-50 text-gray-400 @endif">
                                        <i class="{{ $data['icon'] }}"></i>
                                    </div>
                                    <span class="text-sm font-medium @if($isActive) text-gray-900 @else text-gray-500 @endif">
                                        {{ $data['title'] }}
                                    </span>
                                </div>
                                
                                @if(!$loop->last)
                                    <div class="flex-grow h-1 @if($isActive) bg-green-500 @else bg-gray-300 @endif"></div>
                                @endif
                            @endforeach
                        </div>
                        
                        <!-- Status History -->
                        @if($order->statusHistory && $order->statusHistory->count() > 0)
                            <div class="mt-8 space-y-4">
                                <h3 class="font-medium text-gray-900 mb-4">Status Updates</h3>
                                @foreach($order->statusHistory->sortByDesc('created_at') as $history)
                                    <div class="flex items-start space-x-3">
                                        <div class="mt-1">
                                            <i class="fas fa-circle text-xs 
                                                @if($history->status == 'cancelled') text-red-500
                                                @elseif($history->status == 'completed') text-green-500
                                                @else text-blue-500 @endif"></i>
                                        </div>
                                        <div class="flex-grow">
                                            <p class="text-gray-900">
                                                Order marked as <span class="font-medium">{{ $history->status }}</span>
                                            </p>
                                            <p class="text-sm text-gray-500">
                                                {{ $history->created_at->format('M d, Y h:i A') }}
                                            </p>
                                            @if($history->notes)
                                                <p class="text-sm text-gray-600 mt-1">{{ $history->notes }}</p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Order Summary</h2>
                    
                    <div class="space-y-4">
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
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tax</span>
                            <span class="font-medium">${{ number_format($order->tax_amount, 2) }}</span>
                        </div>
                        
                        @if($order->coupon_code)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Coupon</span>
                                <span class="font-medium text-blue-600">{{ $order->coupon_code }}</span>
                            </div>
                        @endif
                        
                        <div class="border-t border-gray-200 pt-4">
                            <div class="flex justify-between">
                                <span class="text-lg font-bold text-gray-900">Total</span>
                                <span class="text-lg font-bold text-gray-900">${{ number_format($order->total_amount, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Information -->
                <div class="mt-8 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Payment Information</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-600">Payment Method</p>
                            <p class="font-medium text-gray-900">{{ ucfirst($order->payment_method) }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-600">Payment Status</p>
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                                @if($order->payment_status == 'paid') bg-green-100 text-green-800
                                @elseif($order->payment_status == 'pending') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </div>
                        
                        @if($order->payment_transaction_id)
                            <div>
                                <p class="text-sm text-gray-600">Transaction ID</p>
                                <p class="font-medium text-gray-900">{{ $order->payment_transaction_id }}</p>
                            </div>
                        @endif
                        
                        <div>
                            <p class="text-sm text-gray-600">Payment Date</p>
                            <p class="font-medium text-gray-900">
                                {{ $order->payment_date ? $order->payment_date->format('M d, Y') : 'Not paid yet' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Shipping Information -->
                <div class="mt-8 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Shipping Information</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-600">Shipping Method</p>
                            <p class="font-medium text-gray-900">{{ $order->shipping_method ?? 'Standard Shipping' }}</p>
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-600">Tracking Number</p>
                            <p class="font-medium text-gray-900">
                                @if($order->tracking_number)
                                    {{ $order->tracking_number }}
                                    @if($order->tracking_url)
                                        <a href="{{ $order->tracking_url }}" 
                                           target="_blank"
                                           class="ml-2 text-blue-600 hover:text-blue-800">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                    @endif
                                @else
                                    Not available yet
                                @endif
                            </p>
                        </div>
                        
                        @if($order->estimated_delivery)
                            <div>
                                <p class="text-sm text-gray-600">Estimated Delivery</p>
                                <p class="font-medium text-gray-900">
                                    {{ $order->estimated_delivery->format('M d, Y') }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Customer Support -->
                <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
                    <h3 class="font-medium text-blue-900 mb-3">Need Help?</h3>
                    <p class="text-blue-700 text-sm mb-4">
                        If you have any questions about your order, please contact our customer support.
                    </p>
                    <a href="{{ route('contact.index') }}"
                       class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                        <i class="fas fa-headset mr-2"></i>Contact Support
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function cancelOrder(orderId) {
        if (confirm('Are you sure you want to cancel this order? This action cannot be undone.')) {
            fetch("{{ route('checkout.cancel', '') }}/" + orderId, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('Order cancelled successfully', 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showToast(data.message || 'Failed to cancel order', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Network error. Please try again.', 'error');
            });
        }
    }
</script>

<style>
    .order-details-page {
        min-height: calc(100vh - 200px);
    }
</style>
@endsection