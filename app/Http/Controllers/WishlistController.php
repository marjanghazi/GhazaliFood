<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlistItems = Session::get('wishlist', []);
        
        // If user is logged in, you might want to sync with database
        // For now, we'll use session
        
        return view('wishlist', compact('wishlistItems'));
    }

    public function add(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        
        $wishlist = Session::get('wishlist', []);
        
        // Check if product already in wishlist
        if (!isset($wishlist[$product->id])) {
            $wishlist[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->best_price,
                'image' => $product->primaryImage->media_url ?? null,
                'slug' => $product->slug
            ];
            
            Session::put('wishlist', $wishlist);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Product added to wishlist!'
        ]);
    }

    public function remove($id)
    {
        $wishlist = Session::get('wishlist', []);
        
        if (isset($wishlist[$id])) {
            unset($wishlist[$id]);
            Session::put('wishlist', $wishlist);
        }
        
        return response()->json(['success' => true]);
    }

    public function moveToCart($id)
    {
        $wishlist = Session::get('wishlist', []);
        
        if (isset($wishlist[$id])) {
            $cart = Session::get('cart', []);
            
            // Add to cart
            $cart[$id] = [
                'id' => $wishlist[$id]['id'],
                'name' => $wishlist[$id]['name'],
                'price' => $wishlist[$id]['price'],
                'quantity' => 1,
                'image' => $wishlist[$id]['image'],
                'slug' => $wishlist[$id]['slug']
            ];
            
            Session::put('cart', $cart);
            
            // Remove from wishlist
            unset($wishlist[$id]);
            Session::put('wishlist', $wishlist);
        }
        
        return response()->json(['success' => true]);
    }
}