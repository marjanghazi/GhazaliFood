<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PolicyController extends Controller
{
    public function privacy()
    {
        return view('policies.privacy', [
            'title' => 'Privacy Policy - Nuts & Berries',
            'description' => 'Learn how we collect, use, and protect your personal information at Nuts & Berries.'
        ]);
    }

    public function terms()
    {
        return view('policies.terms', [
            'title' => 'Terms of Service - Nuts & Berries',
            'description' => 'Terms and conditions governing the use of Nuts & Berries website and services.'
        ]);
    }

    public function shipping()
    {
        return view('policies.shipping', [
            'title' => 'Shipping Policy - Nuts & Berries',
            'description' => 'Information about our shipping methods, delivery times, and shipping charges.'
        ]);
    }

    public function refund()
    {
        return view('policies.refund', [
            'title' => 'Refund & Return Policy - Nuts & Berries',
            'description' => 'Our policy on returns, refunds, and exchanges for products purchased from Nuts & Berries.'
        ]);
    }

    public function cookies()
    {
        return view('policies.cookies', [
            'title' => 'Cookie Policy - Nuts & Berries',
            'description' => 'Information about how we use cookies and similar technologies on our website.'
        ]);
    }
}