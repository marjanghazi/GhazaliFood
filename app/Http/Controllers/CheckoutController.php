<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CheckoutController extends Controller
{
    // Show checkout page
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to checkout');
        }

        $user = Auth::user();
        
        // Get cart items from session or database
        $cartItems = session()->get('cart', []);
        
        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        // Calculate totals
        $subtotal = 0;
        $items = [];
        
        foreach ($cartItems as $id => $item) {
            $product = Product::find($id);
            if ($product) {
                $itemTotal = $product->best_price * $item['quantity'];
                $subtotal += $itemTotal;
                
                $items[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'price' => $product->best_price,
                    'total' => $itemTotal
                ];
            }
        }

        // Calculate shipping
        $shippingCost = 0;
        $freeShippingThreshold = Setting::getValue('free_shipping_threshold', 5000);
        $shippingEnabled = Setting::getValue('shipping_enabled', true);
        $shippingRate = Setting::getValue('shipping_cost', 200);
        
        if ($shippingEnabled && $subtotal < $freeShippingThreshold) {
            $shippingCost = $shippingRate;
        }

        // Calculate tax
        $taxEnabled = Setting::getValue('tax_enabled', true);
        $taxRate = Setting::getValue('tax_rate', 16);
        $taxAmount = $taxEnabled ? ($subtotal * $taxRate / 100) : 0;

        $total = $subtotal + $shippingCost + $taxAmount;

        return view('checkout.index', [
            'title' => 'Checkout - Ghazali Food',
            'items' => $items,
            'subtotal' => $subtotal,
            'shippingCost' => $shippingCost,
            'taxAmount' => $taxAmount,
            'total' => $total,
            'user' => $user,
            'freeShippingThreshold' => $freeShippingThreshold
        ]);
    }

    // Process checkout
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Please login to checkout'], 401);
        }

        $request->validate([
            'shipping_address' => 'required|string|max:500',
            'shipping_city' => 'required|string|max:100',
            'shipping_state' => 'required|string|max:100',
            'shipping_zip' => 'required|string|max:20',
            'shipping_country' => 'required|string|max:100',
            'billing_same_as_shipping' => 'nullable|boolean',
            'billing_address' => 'required_if:billing_same_as_shipping,false|string|max:500',
            'billing_city' => 'required_if:billing_same_as_shipping,false|string|max:100',
            'billing_state' => 'required_if:billing_same_as_shipping,false|string|max:100',
            'billing_zip' => 'required_if:billing_same_as_shipping,false|string|max:20',
            'billing_country' => 'required_if:billing_same_as_shipping,false|string|max:100',
            'payment_method' => 'required|in:cod,credit_card,debit_card,paypal,bank_transfer',
            'notes' => 'nullable|string|max:1000',
        ]);

        $user = Auth::user();
        $cartItems = session()->get('cart', []);

        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        // Calculate totals
        $subtotal = 0;
        $itemsData = [];
        
        foreach ($cartItems as $id => $item) {
            $product = Product::find($id);
            if ($product && $product->stock_quantity >= $item['quantity']) {
                $itemTotal = $product->best_price * $item['quantity'];
                $subtotal += $itemTotal;
                
                $itemsData[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->best_price,
                    'total_price' => $itemTotal,
                    'product_data' => $product->toArray()
                ];
            } else {
                return back()->with('error', 'Some items are out of stock or insufficient quantity');
            }
        }

        // Check stock before proceeding
        foreach ($itemsData as $item) {
            $product = Product::find($item['product_id']);
            if ($product->stock_quantity < $item['quantity']) {
                return back()->with('error', "Insufficient stock for {$product->name}");
            }
        }

        // Calculate shipping and tax
        $shippingCost = 0;
        $freeShippingThreshold = Setting::getValue('free_shipping_threshold', 5000);
        $shippingEnabled = Setting::getValue('shipping_enabled', true);
        $shippingRate = Setting::getValue('shipping_cost', 200);
        
        if ($shippingEnabled && $subtotal < $freeShippingThreshold) {
            $shippingCost = $shippingRate;
        }

        $taxEnabled = Setting::getValue('tax_enabled', true);
        $taxRate = Setting::getValue('tax_rate', 16);
        $taxAmount = $taxEnabled ? ($subtotal * $taxRate / 100) : 0;

        $total = $subtotal + $shippingCost + $taxAmount;

        // Generate order number
        $orderNumber = 'ORD-' . strtoupper(Str::random(6)) . '-' . time();

        // Create order
        $order = Order::create([
            'order_number' => $orderNumber,
            'user_id' => $user->id,
            'order_status' => 'pending',
            'payment_status' => 'pending',
            'payment_method' => $request->payment_method,
            'subtotal_amount' => $subtotal,
            'shipping_amount' => $shippingCost,
            'tax_amount' => $taxAmount,
            'total_amount' => $total,
            'shipping_address' => $request->shipping_address,
            'shipping_city' => $request->shipping_city,
            'shipping_state' => $request->shipping_state,
            'shipping_zip' => $request->shipping_zip,
            'shipping_country' => $request->shipping_country,
            'billing_address' => $request->billing_same_as_shipping ? $request->shipping_address : $request->billing_address,
            'billing_city' => $request->billing_same_as_shipping ? $request->shipping_city : $request->billing_city,
            'billing_state' => $request->billing_same_as_shipping ? $request->shipping_state : $request->billing_state,
            'billing_zip' => $request->billing_same_as_shipping ? $request->shipping_zip : $request->billing_zip,
            'billing_country' => $request->billing_same_as_shipping ? $request->shipping_country : $request->billing_country,
            'customer_notes' => $request->notes,
            'order_date' => Carbon::now(),
        ]);

        // Create order items and reduce stock
        foreach ($itemsData as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'product_name' => $item['product_name'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'total_price' => $item['total_price'],
            ]);

            // Reduce product stock
            $product = Product::find($item['product_id']);
            $product->decrement('stock_quantity', $item['quantity']);
        }

        // Clear cart
        session()->forget('cart');

        // Send confirmation email (you can implement this)
        // $this->sendOrderConfirmation($order, $user);

        return redirect()->route('checkout.success', $order)
            ->with('success', 'Order placed successfully!');
    }

    // Show success page
    public function success(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('checkout.success', [
            'title' => 'Order Confirmation - Ghazali Food',
            'order' => $order
        ]);
    }

    // Show order tracking
    public function track(Request $request)
    {
        $order = null;
        
        if ($request->has('order_number') || $request->has('tracking_number')) {
            $query = Order::query();
            
            if ($request->order_number) {
                $query->where('order_number', 'like', '%' . $request->order_number . '%');
            }
            
            if ($request->tracking_number) {
                $query->where('tracking_number', 'like', '%' . $request->tracking_number . '%');
            }
            
            $order = $query->first();
        }

        return view('checkout.track', [
            'title' => 'Track Your Order - Ghazali Food',
            'order' => $order,
            'search' => $request->all()
        ]);
    }

    // Show order details (for logged in users)
    public function orderDetails(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('checkout.order-details', [
            'title' => 'Order #' . $order->order_number . ' - Ghazali Food',
            'order' => $order
        ]);
    }

    // Cancel order
    public function cancel(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if (!in_array($order->order_status, ['pending', 'processing'])) {
            return back()->with('error', 'Cannot cancel order in current status');
        }

        $order->update([
            'order_status' => 'cancelled',
            'cancelled_at' => Carbon::now(),
            'cancelled_reason' => 'Cancelled by customer'
        ]);

        // Restore stock
        foreach ($order->items as $item) {
            $product = Product::find($item->product_id);
            if ($product) {
                $product->increment('stock_quantity', $item->quantity);
            }
        }

        return redirect()->route('orders.show', $order)
            ->with('success', 'Order cancelled successfully');
    }
}