<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'value',
        'hex_code',
        'display_order',
        'status'
    ];

    protected $casts = [
        'status' => 'string',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_variants')
            ->withPivot('price', 'stock_quantity', 'sku', 'barcode', 'images', 'status', 'weight')
            ->withTimestamps();
    }
}