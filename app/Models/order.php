<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'shipping_address',
        'shipping_city',
        'shipping_state',
        'shipping_zip',
        'shipping_country',
        'billing_address',
        'billing_city',
        'billing_state',
        'billing_zip',
        'billing_country',
        'order_status',
        'payment_status',
        'payment_method',
        'subtotal_amount',
        'shipping_amount',
        'tax_amount',
        'discount_amount',
        'total_amount',
        'customer_notes',
        'tracking_number',
        'order_date',
        'delivered_at',
        'cancelled_at',
        'cancelled_reason'
    ];

    protected $casts = [
        'subtotal_amount' => 'decimal:2',
        'shipping_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'order_date' => 'datetime',
        'delivered_at' => 'datetime',
        'cancelled_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getStatusColorAttribute()
    {
        $colors = [
            'pending' => 'warning',
            'processing' => 'info',
            'shipped' => 'primary',
            'delivered' => 'success',
            'cancelled' => 'danger',
            'refunded' => 'secondary'
        ];
        
        return $colors[$this->order_status] ?? 'secondary';
    }

    public function getPaymentStatusColorAttribute()
    {
        $colors = [
            'pending' => 'warning',
            'paid' => 'success',
            'failed' => 'danger',
            'refunded' => 'info'
        ];
        
        return $colors[$this->payment_status] ?? 'secondary';
    }

    // Helper method to get formatted address
    public function getFormattedShippingAddressAttribute()
    {
        return $this->shipping_address . ', ' . $this->shipping_city . ', ' . 
               $this->shipping_state . ' ' . $this->shipping_zip . ', ' . $this->shipping_country;
    }

    // Helper method to get formatted billing address
    public function getFormattedBillingAddressAttribute()
    {
        return $this->billing_address . ', ' . $this->billing_city . ', ' . 
               $this->billing_state . ' ' . $this->billing_zip . ', ' . $this->billing_country;
    }
    
    // Add this method for getting the last item
    public function getLatestItem()
    {
        return $this->items()->latest()->first();
    }

    // Add this to your Order model (app/Models/Order.php)

public function statusHistory()
{
    return $this->hasMany(OrderStatusHistory::class)->latest();
}

public function shippingAddress()
{
    return $this->belongsTo(ShippingAddress::class);
}
}