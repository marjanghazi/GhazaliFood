<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'brief_description',
        'content',
        'author_id',
        'category',
        'tags',
        'featured_image',
        'seo_meta_title',
        'seo_meta_description',
        'view_count',
        'is_published',
        'published_at',
        'status'
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'tags' => 'array'
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                    ->where('published_at', '<=', now());
    }

    public function incrementViewCount()
    {
        $this->increment('view_count');
    }
}