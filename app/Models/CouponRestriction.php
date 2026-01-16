<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponRestriction extends Model
{
    use HasFactory;

    protected $fillable = [
        'coupon_id',
        'restriction_type',
        'entity_id'
    ];

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }
}