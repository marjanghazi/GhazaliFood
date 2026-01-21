<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'phone',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'profile_image',
        'date_of_birth',
        'gender',
        'newsletter_subscribed',
        'avatar_url',
        'status',
        'email_verified_at',
        'last_login_at',
        'last_login_ip',
        'login_count',
        'remember_token'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'date_of_birth' => 'date',
        'newsletter_subscribed' => 'boolean',
        'login_count' => 'integer'
    ];

    // Relationships
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

    // Helper methods
    public function getProfileImageUrlAttribute()
    {
        if ($this->profile_image) {
            return Storage::url($this->profile_image);
        }

        if ($this->avatar_url) {
            return $this->avatar_url;
        }

        // Generate initials avatar
        $name = urlencode($this->name);
        return "https://ui-avatars.com/api/?name={$name}&background=random&color=fff&size=200";
    }

    public function getInitialsAttribute()
    {
        $names = explode(' ', $this->name);
        $initials = '';

        foreach ($names as $name) {
            $initials .= strtoupper(substr($name, 0, 1));
            if (strlen($initials) >= 2) break;
        }

        return $initials;
    }

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

    public function hasInWishlist($productId)
    {
        return $this->wishlists()->where('product_id', $productId)->exists();
    }

    public function wishlistItems()
    {
        return $this->hasMany(Wishlist::class)->with('product');
    }

    public function wishlistCount()
    {
        return $this->wishlists()->count();
    }

    public function wishlistProducts()
    {
        return $this->belongsToMany(Product::class, 'wishlists', 'user_id', 'product_id')
            ->withTimestamps();
    }

    // Scope methods
    public function scopeCustomers($query)
    {
        return $query->where('role_id', 3);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    public function scopeSuspended($query)
    {
        return $query->where('status', 'suspended');
    }

    // Activity logging
    public function recordLogin($ip)
    {
        $this->update([
            'last_login_at' => now(),
            'last_login_ip' => $ip,
            'login_count' => $this->login_count + 1
        ]);
    }
}
