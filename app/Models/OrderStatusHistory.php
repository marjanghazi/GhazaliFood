<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatusHistory extends Model
{
    use HasFactory;

    protected $table = 'order_status_history';

    protected $fillable = [
        'order_id',
        'status',
        'notes',
        'changed_by',
        'changed_by_type'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relationships
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function changedByUser()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }

    // Scopes
    public function scopeByOrder($query, $orderId)
    {
        return $query->where('order_id', $orderId);
    }

    public function scopeLatestFirst($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeOldestFirst($query)
    {
        return $query->orderBy('created_at', 'asc');
    }
}