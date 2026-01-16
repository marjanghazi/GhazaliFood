<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'product_id',
        'quantity',
        'attributes'
    ];

    protected $casts = [
        'attributes' => 'array'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Scopes
    public function scopeForUser($query, $userId = null)
    {
        if ($userId) {
            return $query->where('user_id', $userId);
        }
        
        return $query->where('session_id', session()->getId());
    }

    public function scopeActive($query)
    {
        return $query->whereHas('product', function($q) {
            $q->where('status', 'published');
        });
    }

    // Static Methods
    public static function getCount($userId = null)
    {
        $query = self::active();
        
        if (auth()->check()) {
            $query->where('user_id', auth()->id());
        } else {
            $query->where('session_id', session()->getId());
        }
        
        return $query->sum('quantity');
    }

    public static function getTotal($userId = null)
    {
        $query = self::active()->with('product');
        
        if (auth()->check()) {
            $query->where('user_id', auth()->id());
        } else {
            $query->where('session_id', session()->getId());
        }
        
        $cartItems = $query->get();
        
        return $cartItems->sum(function($item) {
            return $item->quantity * $item->product->best_price;
        });
    }

    public static function getItems($userId = null)
    {
        $query = self::active()->with('product');
        
        if (auth()->check()) {
            $query->where('user_id', auth()->id());
        } else {
            $query->where('session_id', session()->getId());
        }
        
        return $query->get();
    }

    public static function mergeGuestCart($userId)
    {
        $sessionId = session()->getId();
        $guestCart = self::where('session_id', $sessionId)->get();
        
        foreach ($guestCart as $item) {
            $existingItem = self::where('user_id', $userId)
                ->where('product_id', $item->product_id)
                ->first();
            
            if ($existingItem) {
                $existingItem->quantity += $item->quantity;
                $existingItem->save();
                $item->delete();
            } else {
                $item->user_id = $userId;
                $item->session_id = null;
                $item->save();
            }
        }
    }
}