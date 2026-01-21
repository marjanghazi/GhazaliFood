<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class HeroImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'image_type',
        'image_url',
        'position',
        'product_label',
        'icon',
        'badge_text',
        'link',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];

    protected $appends = ['full_image_url'];

    /**
     * Get the full image URL with storage path
     */
    public function getFullImageUrlAttribute()
    {
        if ($this->image_url && strpos($this->image_url, 'http') === 0) {
            return $this->image_url;
        }
        
        if ($this->image_url) {
            return Storage::url($this->image_url);
        }
        
        return null;
    }

    /**
     * Scope for active images
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for specific image type
     */
    public function scopeType($query, $type)
    {
        return $query->where('image_type', $type);
    }

    /**
     * Scope for specific position
     */
    public function scopePosition($query, $position)
    {
        return $query->where('position', $position);
    }

    /**
     * Scope ordered by sort order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('created_at');
    }

    /**
     * Get main hero image
     */
    public static function getMainImage()
    {
        return self::active()
            ->type('main')
            ->position('main')
            ->first();
    }

    /**
     * Get floating images
     */
    public static function getFloatingImages()
    {
        return self::active()
            ->type('floating')
            ->where('position', 'like', 'floating_%')
            ->ordered()
            ->get();
    }

    /**
     * Get badge images
     */
    public static function getBadges()
    {
        return self::active()
            ->type('badge')
            ->where('position', 'like', 'badge_%')
            ->ordered()
            ->get();
    }

    /**
     * Get all hero images grouped by type
     */
    public static function getAllHeroImages()
    {
        return [
            'main' => self::getMainImage(),
            'floating' => self::getFloatingImages(),
            'badges' => self::getBadges(),
        ];
    }
}