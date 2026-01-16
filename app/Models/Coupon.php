<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'discount_type',
        'discount_value',
        'min_order_amount',
        'max_discount_amount',
        'usage_limit_per_user',
        'total_usage_limit',
        'used_count',
        'start_date',
        'expiry_date',
        'is_active',
        'applicable_to',
        'created_by'
    ];

    protected $casts = [
        'start_date' => 'date',
        'expiry_date' => 'date',
        'is_active' => 'boolean',
        'min_order_amount' => 'decimal:2',
        'discount_value' => 'decimal:2',
        'max_discount_amount' => 'decimal:2'
    ];

    public function restrictions()
    {
        return $this->hasMany(CouponRestriction::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function isActive()
    {
        return $this->is_active && 
               $this->start_date <= now() && 
               $this->expiry_date >= now();
    }
}