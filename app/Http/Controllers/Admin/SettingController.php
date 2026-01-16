<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;

class SettingController extends Controller
{
    public function index()
    {
        $settings = [
            'site_name' => config('app.name', 'Ghazali Food'),
            'site_email' => config('mail.from.address', 'info@ghazalifood.com'),
            'site_phone' => config('app.phone', '+1 (234) 567-8900'),
            'site_address' => config('app.address', '123 Food Street, Culinary City'),
            'currency' => config('app.currency', 'USD'),
            'currency_symbol' => config('app.currency_symbol', '$'),
            'tax_rate' => config('app.tax_rate', 8),
            'shipping_cost' => config('app.shipping_cost', 5.99),
            'free_shipping_threshold' => config('app.free_shipping_threshold', 50),
            'maintenance_mode' => config('app.maintenance_mode', false),
            'announcement_enabled' => config('announcement.enabled', true),
            'review_approval_required' => config('app.review_approval_required', true),
            'low_stock_threshold' => config('app.low_stock_threshold', 10),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function updateGeneral(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:100',
            'site_email' => 'required|email',
            'site_phone' => 'required|string|max:20',
            'site_address' => 'required|string|max:255',
            'currency' => 'required|string|max:3',
            'currency_symbol' => 'required|string|max:5',
            'tax_rate' => 'required|numeric|min:0|max:100',
            'shipping_cost' => 'required|numeric|min:0',
            'free_shipping_threshold' => 'required|numeric|min:0',
            'maintenance_mode' => 'boolean',
            'announcement_enabled' => 'boolean',
            'review_approval_required' => 'boolean',
            'low_stock_threshold' => 'required|integer|min:1'
        ]);

        foreach ($validated as $key => $value) {
            if (is_bool($value)) {
                $value = $value ? 'true' : 'false';
            }
            Cache::forever('setting_' . $key, $value);
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'General settings updated successfully!');
    }

    public function updateEmail(Request $request)
    {
        $validated = $request->validate([
            'mail_mailer' => 'required|string|in:smtp,sendmail,mailgun,ses',
            'mail_host' => 'required|string|max:255',
            'mail_port' => 'required|integer',
            'mail_username' => 'required|string|max:255',
            'mail_password' => 'required|string|max:255',
            'mail_encryption' => 'nullable|string|in:tls,ssl',
            'mail_from_address' => 'required|email',
            'mail_from_name' => 'required|string|max:255',
            'order_notification_email' => 'nullable|email',
            'support_email' => 'nullable|email'
        ]);

        foreach ($validated as $key => $value) {
            Cache::forever('email_' . $key, $value);
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Email settings updated successfully!');
    }

    public function updatePayment(Request $request)
    {
        $validated = $request->validate([
            'stripe_key' => 'nullable|string|max:255',
            'stripe_secret' => 'nullable|string|max:255',
            'paypal_client_id' => 'nullable|string|max:255',
            'paypal_secret' => 'nullable|string|max:255',
            'paypal_mode' => 'required|in:sandbox,live',
            'cod_enabled' => 'boolean',
            'bank_transfer_enabled' => 'boolean',
            'bank_details' => 'nullable|string'
        ]);

        foreach ($validated as $key => $value) {
            Cache::forever('payment_' . $key, $value);
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Payment settings updated successfully!');
    }

    public function backupDatabase()
    {
        // Ensure backup directory exists
        $backupDir = storage_path('app/backups');
        if (!file_exists($backupDir)) {
            mkdir($backupDir, 0755, true);
        }

        $backupFile = 'backup-' . date('Y-m-d-H-i-s') . '.sql';
        $fullPath = $backupDir . '/' . $backupFile;
        
        $command = sprintf(
            'mysqldump -u%s -p%s %s > %s 2>&1',
            config('database.connections.mysql.username'),
            config('database.connections.mysql.password'),
            config('database.connections.mysql.database'),
            $fullPath
        );

        exec($command, $output, $returnVar);

        if ($returnVar === 0 && file_exists($fullPath)) {
            return response()->download($fullPath)->deleteFileAfterSend(true);
        }

        return redirect()->route('admin.settings.index')
            ->with('error', 'Database backup failed. Please check your MySQL configuration.');
    }

    public function clearCache()
    {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');

        return redirect()->route('admin.settings.index')
            ->with('success', 'Cache cleared successfully!');
    }
}