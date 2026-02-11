<?php
// app/Providers/ViewServiceProvider.php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Setting;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Load settings and share with all views
        $settings = Setting::pluck('value', 'key')->toArray();
        
        // Decode JSON options for specific settings
        foreach ($settings as $key => $value) {
            if (in_array($key, ['site_language', 'currency_code', 'currency_position'])) {
                $decoded = json_decode($value, true);
                $settings[$key] = $decoded ?? $value;
            }
        }
        
        View::share('settings', $settings);
    }
}