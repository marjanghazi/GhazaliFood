<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AdminHelper
{
    public static function isAdminRoute()
    {
        return Request::is('admin*') || Request::is('admin/*');
    }
    
    public static function shouldUseAdminLayout()
    {
        if (!Auth::check()) {
            return false;
        }
        
        return Auth::user()->isAdmin() && self::isAdminRoute();
    }
}