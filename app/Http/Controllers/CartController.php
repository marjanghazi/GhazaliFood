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
        
        // Calculate total
        foreach ($cartItems as $item) {
            $cartTotal += $item['price'] * $item['quantity'];
        }
        
        return view('cart', compact('cartItems', 'cartTotal'));
    }

    public function add(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        
        $cart = Session::get('cart', []);
        
        // Check if product already in cart
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->best_price,
                'quantity' => $request->quantity ?? 1,
                'image' => $product->primaryImage->media_url ?? null,
                'slug' => $product->slug
            ];
        }
        
        Session::put('cart', $cart);
        
        return response()->json([
            'success' => true,
            'cart_count' => count($cart),
            'message' => 'Product added to cart successfully!'
        ]);
    }

    public function update(Request $request, $id)
    {
        $cart = Session::get('cart', []);
        
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $request->quantity;
            Session::put('cart', $cart);
        }
        
        return response()->json(['success' => true]);
    }

    public function remove($id)
    {
        $cart = Session::get('cart', []);
        
        if (isset($cart[$id])) {
            unset($cart[$id]);
            Session::put('cart', $cart);
        }
        
        return response()->json(['success' => true]);
    }

    public function clear()
    {
        Session::forget('cart');
        return response()->json(['success' => true]);
    }

    public function getCartCount()
    {
        $cart = Session::get('cart', []);
        return response()->json(['count' => count($cart)]);
    }
}