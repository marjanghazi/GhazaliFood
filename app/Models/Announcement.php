<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
        'link_url',
        'background_color',
        'text_color',
        'display_order',
        'start_date',
        'end_date',
        'is_closable',
        'status',
        'created_by'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_closable' => 'boolean'
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'active')
                    ->where('start_date', '<=', now())
                    ->where('end_date', '>=', now());
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}