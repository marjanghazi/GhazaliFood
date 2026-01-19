<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'label',
        'description',
        'options',
        'is_public',
        'sort_order'
    ];

    protected $casts = [
        'options' => 'array',
        'is_public' => 'boolean',
        'sort_order' => 'integer'
    ];

    /**
     * Get setting value by key
     */
    public static function getValue($key, $default = null)
    {
        // Try to get from cache first
        $settings = Cache::remember('settings.all', 3600, function () {
            return self::all()->pluck('value', 'key')->toArray();
        });

        return $settings[$key] ?? $default;
    }

    /**
     * Get setting with type casting
     */
    public static function get($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        
        if (!$setting) {
            return $default;
        }

        return self::castValue($setting->value, $setting->type);
    }

    /**
     * Set setting value
     */
    public static function set($key, $value)
    {
        $setting = self::where('key', $key)->first();
        
        if (!$setting) {
            $setting = new self(['key' => $key]);
        }

        $setting->value = $value;
        $setting->save();

        // Clear settings cache
        Cache::forget('settings.all');

        return $setting;
    }

    /**
     * Get all settings grouped by group
     */
    public static function getAllGrouped()
    {
        return Cache::remember('settings.grouped', 3600, function () {
            return self::orderBy('group')
                ->orderBy('sort_order')
                ->get()
                ->groupBy('group');
        });
    }

    /**
     * Get settings by group
     */
    public static function getByGroup($group)
    {
        return self::where('group', $group)
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * Cast value based on type
     */
    protected static function castValue($value, $type)
    {
        if ($value === null) {
            return null;
        }

        switch ($type) {
            case 'integer':
                return (int) $value;
            case 'float':
                return (float) $value;
            case 'boolean':
                return filter_var($value, FILTER_VALIDATE_BOOLEAN);
            case 'array':
                return json_decode($value, true);
            case 'json':
                return json_decode($value);
            default:
                return $value;
        }
    }

    /**
     * Format currency
     */
    public static function formatCurrency($amount)
    {
        $currencyCode = self::getValue('currency_code', 'PKR');
        $currencySymbol = self::getValue('currency_symbol', 'Rs');
        $currencyPosition = self::getValue('currency_position', 'left');
        $decimalSeparator = self::getValue('decimal_separator', '.');
        $thousandsSeparator = self::getValue('thousands_separator', ',');
        $decimalPlaces = self::getValue('decimal_places', 2);

        $formatted = number_format(
            $amount, 
            $decimalPlaces, 
            $decimalSeparator, 
            $thousandsSeparator
        );

        switch ($currencyPosition) {
            case 'right':
                return $formatted . $currencySymbol;
            case 'right_with_space':
                return $formatted . ' ' . $currencySymbol;
            case 'left_with_space':
                return $currencySymbol . ' ' . $formatted;
            default: // left
                return $currencySymbol . $formatted;
        }
    }

    /**
     * Calculate tax amount
     */
    public static function calculateTax($amount)
    {
        if (!self::getValue('tax_enabled', true)) {
            return 0;
        }

        $taxRate = self::getValue('tax_rate', 16);
        return ($amount * $taxRate) / 100;
    }

    /**
     * Calculate shipping cost
     */
    public static function calculateShipping($orderAmount)
    {
        if (!self::getValue('shipping_enabled', true)) {
            return 0;
        }

        $freeShippingThreshold = self::getValue('free_shipping_threshold', 5000);
        
        if ($orderAmount >= $freeShippingThreshold) {
            return 0;
        }

        return self::getValue('shipping_cost', 200);
    }

    /**
     * Check if in maintenance mode
     */
    public static function isMaintenanceMode()
    {
        return self::getValue('maintenance_mode', false);
    }

    /**
     * Get all public settings (for frontend)
     */
    public static function getPublicSettings()
    {
        return self::where('is_public', true)
            ->get()
            ->pluck('value', 'key')
            ->toArray();
    }
}