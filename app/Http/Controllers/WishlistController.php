<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlistItems = Wishlist::with(['product' => function($query) {
            $query->with('primaryImage');
        }])
        ->where('user_id', Auth::id())
        ->latest()
        ->get();

        return view('wishlist.index', compact('wishlistItems'));
    }

    public function toggle(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to add to wishlist',
                'login_required' => true
            ], 401);
        }

        $productId = $request->product_id;
        $userId = Auth::id();
        
        $existing = Wishlist::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($existing) {
            // Remove from wishlist
            $existing->delete();
            $inWishlist = false;
            $message = 'Product removed from wishlist';
        } else {
            // Add to wishlist
            Wishlist::create([
                'user_id' => $userId,
                'product_id' => $productId
            ]);
            $inWishlist = true;
            $message = 'Product added to wishlist';
        }

        $wishlistCount = Wishlist::where('user_id', $userId)->count();

        return response()->json([
            'success' => true,
            'message' => $message,
            'in_wishlist' => $inWishlist,
            'wishlist_count' => $wishlistCount
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $userId = Auth::id();
        $productId = $request->product_id;

        // Check if already in wishlist
        $exists = Wishlist::where('user_id', $userId)
            ->where('product_id', $productId)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Product already in wishlist'
            ], 400);
        }

        Wishlist::create([
            'user_id' => $userId,
            'product_id' => $productId
        ]);

        $wishlistCount = Wishlist::where('user_id', $userId)->count();

        return response()->json([
            'success' => true,
            'message' => 'Product added to wishlist',
            'wishlist_count' => $wishlistCount
        ]);
    }

    public function destroy($id)
    {
        $wishlistItem = Wishlist::findOrFail($id);
        
        // Check ownership
        if ($wishlistItem->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $wishlistItem->delete();

        $wishlistCount = Wishlist::where('user_id', Auth::id())->count();

        return response()->json([
            'success' => true,
            'message' => 'Product removed from wishlist',
            'wishlist_count' => $wishlistCount
        ]);
    }

    public function count()
    {
        $count = Auth::check() ? Wishlist::where('user_id', Auth::id())->count() : 0;
        
        return response()->json([
            'count' => $count
        ]);
    }
}