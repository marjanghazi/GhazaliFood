<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id'
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
        $userId = $userId ?? auth()->id();
        return $query->where('user_id', $userId);
    }

    // Static Methods
    public static function getCount($userId = null)
    {
        $userId = $userId ?? auth()->id();
        return self::where('user_id', $userId)->count();
    }

    public static function isInWishlist($productId, $userId = null)
    {
        $userId = $userId ?? auth()->id();
        return self::where('user_id', $userId)
            ->where('product_id', $productId)
            ->exists();
    }

    public static function toggle($productId, $userId = null)
    {
        $userId = $userId ?? auth()->id();
        
        $wishlist = self::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();
        
        if ($wishlist) {
            $wishlist->delete();
            return false;
        } else {
            self::create([
                'user_id' => $userId,
                'product_id' => $productId
            ]);
            return true;
        }
    }
}