<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Session::get('cart', []);
        $cartTotal = 0;
        $products = [];
        
        // Calculate total and get product details
        foreach ($cartItems as $item) {
            $product = Product::with('primaryImage')->find($item['id']);
            if ($product) {
                $products[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'subtotal' => $product->best_price * $item['quantity']
                ];
                $cartTotal += $product->best_price * $item['quantity'];
            }
        }
        
        return view('cart.index', compact('products', 'cartTotal'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);
        
        $cart = Session::get('cart', []);
        
        // Check if product already in cart
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $request->quantity ?? 1;
        } else {
            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->best_price,
                'quantity' => $request->quantity ?? 1,
                'image' => $product->primaryImage->media_url ?? '/images/default-product.jpg',
                'slug' => $product->slug
            ];
        }
        
        Session::put('cart', $cart);
        
        $cartCount = $this->getCartCount();
        
        return response()->json([
            'success' => true,
            'cart_count' => $cartCount,
            'message' => 'Product added to cart successfully!'
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = Session::get('cart', []);
        
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $request->quantity;
            Session::put('cart', $cart);
        }
        
        $cartCount = $this->getCartCount();
        $cartTotal = $this->getCartTotal();
        
        return response()->json([
            'success' => true,
            'cart_count' => $cartCount,
            'cart_total' => $cartTotal
        ]);
    }

    public function remove($id)
    {
        $cart = Session::get('cart', []);
        
        if (isset($cart[$id])) {
            unset($cart[$id]);
            Session::put('cart', $cart);
        }
        
        $cartCount = $this->getCartCount();
        $cartTotal = $this->getCartTotal();
        
        return response()->json([
            'success' => true,
            'cart_count' => $cartCount,
            'cart_total' => $cartTotal,
            'message' => 'Item removed from cart'
        ]);
    }

    public function clear()
    {
        Session::forget('cart');
        
        return response()->json([
            'success' => true,
            'message' => 'Cart cleared successfully'
        ]);
    }

    public function count()
    {
        $cartCount = $this->getCartCount();
        
        return response()->json([
            'count' => $cartCount
        ]);
    }

    // Helper methods
    private function getCartCount()
    {
        $cart = Session::get('cart', []);
        return array_sum(array_column($cart, 'quantity'));
    }

    private function getCartTotal()
    {
        $cart = Session::get('cart', []);
        $total = 0;
        
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        return $total;
    }
}