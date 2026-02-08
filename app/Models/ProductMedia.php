<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductMedia extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'image_path',
        'is_primary',
        'display_order',
        'alt_text'
    ];

    protected $casts = [
        'is_primary' => 'boolean'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Add accessor for full image URL
    public function getImageUrlAttribute()
    {
        if ($this->image_path) {
            return asset('storage/' . $this->image_path);
        }
        return asset('images/default-product.png');
    }
}