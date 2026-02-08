<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'category_id',
        'short_description',
        'full_description',
        'best_price',
        'compare_at_price',
        'cost_price',
        'stock_quantity',
        'barcode',
        'sku',
        'weight',
        'dimensions',
        'type',
        'is_featured',
        'is_best_seller',
        'is_new_arrival',
        'average_rating',
        'total_reviews',
        'status',
        'meta_title',
        'meta_description',
        'created_by',
        'seo_keywords'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_best_seller' => 'boolean',
        'is_new_arrival' => 'boolean',
        'best_price' => 'decimal:2',
        'compare_at_price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'average_rating' => 'decimal:2',
        'weight' => 'decimal:2',
        'stock_quantity' => 'integer'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductMedia::class)->orderBy('display_order');
    }

    public function media()
    {
        return $this->hasMany(ProductMedia::class)->orderBy('display_order');
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)->where('status', 'approved');
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductMedia::class)->where('is_primary', true);
    }

    public function getDiscountPercentageAttribute()
    {
        if ($this->compare_at_price && $this->compare_at_price > $this->best_price) {
            return round((($this->compare_at_price - $this->best_price) / $this->compare_at_price) * 100);
        }
        return 0;
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_items')
            ->withPivot('quantity', 'price', 'total')
            ->withTimestamps();
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
