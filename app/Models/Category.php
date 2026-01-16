<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
        'display_order',
        'category_image',
        'type',
        'status',
        'meta_title',
        'meta_description',
        'created_by'
    ];

    // Relationships
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured($query)
    {
        return $query->where('type', 'featured');
    }

    public function scopePopular($query)
    {
        return $query->where('type', 'popular');
    }

    // Accessors
    public function getImageUrlAttribute()
    {
        if ($this->category_image) {
            return asset('storage/' . $this->category_image);
        }
        return asset('images/default-category.jpg');
    }

    public function getParentNameAttribute()
    {
        return $this->parent ? $this->parent->name : 'None';
    }
    public function activeProducts()
    {
        return $this->products()->where('status', 'published');
    }
}
