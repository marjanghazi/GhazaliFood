<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'phone',
        'avatar_url',
        'status',
        'remember_token',
        'last_login_at',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'date_of_birth',
        'gender',
        'newsletter_subscribed',
        'bio',
        'website',
        'facebook_url',
        'twitter_url',
        'instagram_url',
        'notification_email',
        'notification_sms',
        'notification_push',
        'two_factor_enabled',
        'profile_image'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'date_of_birth' => 'date',
        'newsletter_subscribed' => 'boolean',
        'notification_email' => 'boolean',
        'notification_sms' => 'boolean',
        'notification_push' => 'boolean',
        'two_factor_enabled' => 'boolean',
        'login_count' => 'integer'
    ];

    // Add these accessors
    public function getFullAddressAttribute()
    {
        $parts = [];
        if ($this->address) $parts[] = $this->address;
        if ($this->city) $parts[] = $this->city;
        if ($this->state) $parts[] = $this->state;
        if ($this->country) $parts[] = $this->country;
        if ($this->postal_code) $parts[] = $this->postal_code;
        
        return implode(', ', $parts);
    }

    public function getAvatarUrlAttribute($value)
    {
        if ($value) {
            return $value;
        }
        
        // Generate initials avatar as fallback
        $name = $this->name;
        $initials = '';
        $words = explode(' ', $name);
        
        foreach ($words as $word) {
            if (isset($word[0])) {
                $initials .= strtoupper($word[0]);
            }
        }
        
        if (strlen($initials) > 2) {
            $initials = substr($initials, 0, 2);
        }
        
        // Use UI Avatars service or similar
        return "https://ui-avatars.com/api/?name=" . urlencode($initials) . "&background=random&color=fff&size=200";
    }

    public function getProfileImageAttribute($value)
    {
        if ($value) {
            return asset('storage/' . $value);
        }
        
        return $this->avatar_url;
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function isAdmin()
    {
        return $this->role_id === 1 || $this->role_id === 2;
    }

    public function isSuperAdmin()
    {
        return $this->role_id === 1;
    }

    public function isCustomer()
    {
        return $this->role_id === 3;
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'author_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function shippingAddresses()
    {
        return $this->hasMany(ShippingAddress::class);
    }

    // Helper method to check if product is in wishlist
    public function hasInWishlist($productId)
    {
        return $this->wishlists()->where('product_id', $productId)->exists();
    }

    // Get wishlist items with products
    public function wishlistItems()
    {
        return $this->hasMany(Wishlist::class)->with('product');
    }

    // Count wishlist items
    public function wishlistCount()
    {
        return $this->wishlists()->count();
    }

    // Get wishlist products
    public function wishlistProducts()
    {
        return $this->belongsToMany(Product::class, 'wishlists', 'user_id', 'product_id')
                    ->withTimestamps();
    }

    public function wishlist()
    {
        return $this->hasMany(Wishlist::class);
    }

    // Get default shipping address
    public function defaultShippingAddress()
    {
        return $this->shippingAddresses()->where('is_default', true)->first();
    }

    // Get order statistics
    public function orderStatistics()
    {
        return [
            'total_orders' => $this->orders()->count(),
            'total_spent' => $this->orders()->where('order_status', 'completed')->sum('total_amount'),
            'pending_orders' => $this->orders()->where('order_status', 'pending')->count(),
            'completed_orders' => $this->orders()->where('order_status', 'completed')->count(),
        ];
    }
}