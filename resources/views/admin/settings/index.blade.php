@extends('layouts.admin')

@section('title', 'Settings')
@section('page_title', 'Settings')
@section('breadcrumb', 'System Settings')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs" id="settingsTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="general-tab" data-bs-toggle="tab"
                            data-bs-target="#general" type="button" role="tab">
                            <i class="fas fa-cog me-2"></i> General
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="email-tab" data-bs-toggle="tab"
                            data-bs-target="#email" type="button" role="tab">
                            <i class="fas fa-envelope me-2"></i> Email
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="payment-tab" data-bs-toggle="tab"
                            data-bs-target="#payment" type="button" role="tab">
                            <i class="fas fa-credit-card me-2"></i> Payment
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="maintenance-tab" data-bs-toggle="tab"
                            data-bs-target="#maintenance" type="button" role="tab">
                            <i class="fas fa-tools me-2"></i> Maintenance
                        </button>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="settingsTabContent">
                    <!-- General Settings -->
                    <div class="tab-pane fade show active" id="general" role="tabpanel">
                        <form action="{{ route('admin.settings.general.update') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="mb-3">Site Information</h5>
                                    <div class="mb-3">
                                        <label for="site_name" class="form-label">Site Name *</label>
                                        <input type="text" class="form-control" id="site_name" name="site_name"
                                            value="{{ old('site_name', $settingValues['site_name'] ?? config('app.name', 'Ghazali Food')) }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="site_email" class="form-label">Site Email *</label>
                                        <input type="email" class="form-control" id="site_email" name="site_email"
                                            value="{{ old('site_email', $settingValues['site_email'] ?? config('mail.from.address', 'admin@ghazalifood.com')) }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="site_phone" class="form-label">Site Phone *</label>
                                        <input type="text" class="form-control" id="site_phone" name="site_phone"
                                            value="{{ old('site_phone', $settingValues['site_phone'] ?? '+1 (234) 567-8900') }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="site_address" class="form-label">Site Address *</label>
                                        <textarea class="form-control" id="site_address" name="site_address"
                                            rows="3" required>{{ old('site_address', $settingValues['site_address'] ?? '123 Food Street, Karachi, Pakistan') }}</textarea>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <h5 class="mb-3">Currency Settings</h5>
                                    <div class="mb-3">
                                        <label for="currency_code" class="form-label">Currency Code *</label>
                                        <input type="text" class="form-control" id="currency_code" name="currency_code"
                                            value="{{ old('currency_code', $settingValues['currency_code'] ?? 'PKR') }}" required maxlength="3">
                                        <small class="text-muted">3-letter currency code (e.g., PKR, USD, EUR)</small>
                                    </div>

                                    <div class="mb-3">
                                        <label for="currency_symbol" class="form-label">Currency Symbol *</label>
                                        <input type="text" class="form-control" id="currency_symbol" name="currency_symbol"
                                            value="{{ old('currency_symbol', $settingValues['currency_symbol'] ?? 'Rs') }}" required maxlength="5">
                                    </div>

                                    <div class="mb-3">
                                        <label for="currency_position" class="form-label">Currency Position *</label>
                                        <select class="form-select" id="currency_position" name="currency_position" required>
                                            <option value="left" {{ old('currency_position', $settingValues['currency_position'] ?? 'left') == 'left' ? 'selected' : '' }}>Left (Rs 100)</option>
                                            <option value="right" {{ old('currency_position', $settingValues['currency_position'] ?? 'left') == 'right' ? 'selected' : '' }}>Right (100 Rs)</option>
                                            <option value="left_with_space" {{ old('currency_position', $settingValues['currency_position'] ?? 'left') == 'left_with_space' ? 'selected' : '' }}>Left with Space (Rs 100)</option>
                                            <option value="right_with_space" {{ old('currency_position', $settingValues['currency_position'] ?? 'left') == 'right_with_space' ? 'selected' : '' }}>Right with Space (100 Rs)</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="decimal_places" class="form-label">Decimal Places *</label>
                                        <input type="number" class="form-control" id="decimal_places" name="decimal_places"
                                            value="{{ old('decimal_places', $settingValues['decimal_places'] ?? 2) }}" min="0" max="4" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <h5 class="mb-3">Tax & Shipping</h5>
                                    <div class="mb-3 form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="tax_enabled"
                                            name="tax_enabled" value="1"
                                            {{ old('tax_enabled', $settingValues['tax_enabled'] ?? 1) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tax_enabled">
                                            Enable Tax
                                        </label>
                                    </div>

                                    <div class="mb-3">
                                        <label for="tax_rate" class="form-label">Tax Rate (%) *</label>
                                        <input type="number" class="form-control" id="tax_rate" name="tax_rate"
                                            value="{{ old('tax_rate', $settingValues['tax_rate'] ?? 16) }}" min="0" max="100" step="0.01" required>
                                    </div>

                                    <div class="mb-3 form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="shipping_enabled"
                                            name="shipping_enabled" value="1"
                                            {{ old('shipping_enabled', $settingValues['shipping_enabled'] ?? 1) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="shipping_enabled">
                                            Enable Shipping
                                        </label>
                                    </div>

                                    <div class="mb-3">
                                        <label for="shipping_cost" class="form-label">Shipping Cost *</label>
                                        <input type="number" class="form-control" id="shipping_cost" name="shipping_cost"
                                            value="{{ old('shipping_cost', $settingValues['shipping_cost'] ?? 200) }}" min="0" step="0.01" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="free_shipping_threshold" class="form-label">Free Shipping Threshold</label>
                                        <input type="number" class="form-control" id="free_shipping_threshold" name="free_shipping_threshold"
                                            value="{{ old('free_shipping_threshold', $settingValues['free_shipping_threshold'] ?? 5000) }}" min="0" step="0.01">
                                        <small class="text-muted">Minimum order amount for free shipping (set 0 to disable)</small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <h5 class="mb-3">Inventory & Features</h5>
                                    <div class="mb-3">
                                        <label for="low_stock_threshold" class="form-label">Low Stock Threshold *</label>
                                        <input type="number" class="form-control" id="low_stock_threshold" name="low_stock_threshold"
                                            value="{{ old('low_stock_threshold', $settingValues['low_stock_threshold'] ?? 10) }}" min="1" required>
                                        <small class="text-muted">Send alerts when stock falls below this number</small>
                                    </div>

                                    <div class="mb-3 form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="review_approval_required"
                                            name="review_approval_required" value="1"
                                            {{ old('review_approval_required', $settingValues['review_approval_required'] ?? 1) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="review_approval_required">
                                            Review Approval Required
                                        </label>
                                    </div>

                                    <div class="mb-3">
                                        <label for="date_format" class="form-label">Date Format *</label>
                                        <input type="text" class="form-control" id="date_format" name="date_format"
                                            value="{{ old('date_format', $settingValues['date_format'] ?? 'd/m/Y') }}" required>
                                        <small class="text-muted">e.g., d/m/Y, Y-m-d, m/d/Y</small>
                                    </div>

                                    <div class="mb-3">
                                        <label for="time_format" class="form-label">Time Format *</label>
                                        <input type="text" class="form-control" id="time_format" name="time_format"
                                            value="{{ old('time_format', $settingValues['time_format'] ?? 'H:i:s') }}" required>
                                        <small class="text-muted">e.g., H:i:s, h:i A</small>
                                    </div>

                                    <div class="mb-3">
                                        <label for="timezone" class="form-label">Timezone *</label>
                                        <input type="text" class="form-control" id="timezone" name="timezone"
                                            value="{{ old('timezone', $settingValues['timezone'] ?? 'Asia/Karachi') }}" required>
                                        <small class="text-muted">e.g., Asia/Karachi, UTC, America/New_York</small>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i> Save General Settings
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Email Settings -->
                    <div class="tab-pane fade" id="email" role="tabpanel">
                        <form action="{{ route('admin.settings.email.update') }}" method="POST">
                            @csrf
                            <h5 class="mb-3">SMTP Configuration</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="mail_mailer" class="form-label">Mail Driver *</label>
                                        <select class="form-select" id="mail_mailer" name="mail_mailer" required>
                                            <option value="smtp" {{ old('mail_mailer', $settingValues['mail_mailer'] ?? 'smtp') == 'smtp' ? 'selected' : '' }}>SMTP</option>
                                            <option value="mailgun" {{ old('mail_mailer', $settingValues['mail_mailer'] ?? 'smtp') == 'mailgun' ? 'selected' : '' }}>Mailgun</option>
                                            <option value="ses" {{ old('mail_mailer', $settingValues['mail_mailer'] ?? 'smtp') == 'ses' ? 'selected' : '' }}>Amazon SES</option>
                                            <option value="sendmail" {{ old('mail_mailer', $settingValues['mail_mailer'] ?? 'smtp') == 'sendmail' ? 'selected' : '' }}>Sendmail</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="mail_host" class="form-label">SMTP Host *</label>
                                        <input type="text" class="form-control" id="mail_host" name="mail_host"
                                            value="{{ old('mail_host', $settingValues['mail_host'] ?? 'smtp.mailtrap.io') }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="mail_port" class="form-label">SMTP Port *</label>
                                        <input type="number" class="form-control" id="mail_port" name="mail_port"
                                            value="{{ old('mail_port', $settingValues['mail_port'] ?? 587) }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="mail_encryption" class="form-label">Encryption</label>
                                        <select class="form-select" id="mail_encryption" name="mail_encryption">
                                            <option value="" {{ old('mail_encryption', $settingValues['mail_encryption'] ?? '') == '' ? 'selected' : '' }}>None</option>
                                            <option value="tls" {{ old('mail_encryption', $settingValues['mail_encryption'] ?? '') == 'tls' ? 'selected' : '' }}>TLS</option>
                                            <option value="ssl" {{ old('mail_encryption', $settingValues['mail_encryption'] ?? '') == 'ssl' ? 'selected' : '' }}>SSL</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="mail_username" class="form-label">SMTP Username *</label>
                                        <input type="text" class="form-control" id="mail_username" name="mail_username"
                                            value="{{ old('mail_username', $settingValues['mail_username'] ?? '') }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="mail_password" class="form-label">SMTP Password *</label>
                                        <input type="password" class="form-control" id="mail_password" name="mail_password"
                                            value="{{ old('mail_password', $settingValues['mail_password'] ?? '') }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="mail_from_address" class="form-label">From Address *</label>
                                        <input type="email" class="form-control" id="mail_from_address" name="mail_from_address"
                                            value="{{ old('mail_from_address', $settingValues['mail_from_address'] ?? ($settingValues['site_email'] ?? config('mail.from.address', 'admin@ghazalifood.com'))) }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="mail_from_name" class="form-label">From Name *</label>
                                        <input type="text" class="form-control" id="mail_from_name" name="mail_from_name"
                                            value="{{ old('mail_from_name', $settingValues['mail_from_name'] ?? ($settingValues['site_name'] ?? config('app.name', 'Ghazali Food'))) }}" required>
                                    </div>
                                </div>
                            </div>

                            <h5 class="mt-4 mb-3">Email Addresses</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="order_notification_email" class="form-label">Order Notifications</label>
                                        <input type="email" class="form-control" id="order_notification_email"
                                            name="order_notification_email" value="{{ old('order_notification_email', $settingValues['order_notification_email'] ?? '') }}">
                                        <small class="text-muted">Send order notifications to this email</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="support_email" class="form-label">Support Email</label>
                                        <input type="email" class="form-control" id="support_email"
                                            name="support_email" value="{{ old('support_email', $settingValues['support_email'] ?? '') }}">
                                        <small class="text-muted">Customer support email address</small>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i> Save Email Settings
                                </button>
                                <button type="button" class="btn btn-outline-secondary" onclick="testEmail()">
                                    <i class="fas fa-paper-plane me-2"></i> Test Email
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Payment Settings -->
                    <div class="tab-pane fade" id="payment" role="tabpanel">
                        <form action="{{ route('admin.settings.payment.update') }}" method="POST">
                            @csrf
                            <h5 class="mb-3">Payment Gateways</h5>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h6 class="card-title">
                                                <i class="fab fa-stripe me-2"></i> Stripe
                                            </h6>
                                            <div class="mb-3">
                                                <label for="stripe_key" class="form-label">Publishable Key</label>
                                                <input type="text" class="form-control" id="stripe_key"
                                                    name="stripe_key" value="{{ old('stripe_key', $settingValues['stripe_key'] ?? '') }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="stripe_secret" class="form-label">Secret Key</label>
                                                <input type="password" class="form-control" id="stripe_secret"
                                                    name="stripe_secret" value="{{ old('stripe_secret', $settingValues['stripe_secret'] ?? '') }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="stripe_webhook_secret" class="form-label">Webhook Secret</label>
                                                <input type="password" class="form-control" id="stripe_webhook_secret"
                                                    name="stripe_webhook_secret" value="{{ old('stripe_webhook_secret', $settingValues['stripe_webhook_secret'] ?? '') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h6 class="card-title">
                                                <i class="fab fa-paypal me-2"></i> PayPal
                                            </h6>
                                            <div class="mb-3">
                                                <label for="paypal_client_id" class="form-label">Client ID</label>
                                                <input type="text" class="form-control" id="paypal_client_id"
                                                    name="paypal_client_id" value="{{ old('paypal_client_id', $settingValues['paypal_client_id'] ?? '') }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="paypal_secret" class="form-label">Secret</label>
                                                <input type="password" class="form-control" id="paypal_secret"
                                                    name="paypal_secret" value="{{ old('paypal_secret', $settingValues['paypal_secret'] ?? '') }}">
                                            </div>
                                            <div class="mb-3 form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="paypal_sandbox"
                                                    name="paypal_sandbox" value="1"
                                                    {{ old('paypal_sandbox', $settingValues['paypal_sandbox'] ?? 1) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="paypal_sandbox">
                                                    Sandbox Mode
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <h5 class="mb-3">Payment Methods</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="payment_gateway" class="form-label">Default Payment Gateway *</label>
                                        <select class="form-select" id="payment_gateway" name="payment_gateway" required>
                                            <option value="stripe" {{ old('payment_gateway', $settingValues['payment_gateway'] ?? 'stripe') == 'stripe' ? 'selected' : '' }}>Stripe</option>
                                            <option value="paypal" {{ old('payment_gateway', $settingValues['payment_gateway'] ?? 'stripe') == 'paypal' ? 'selected' : '' }}>PayPal</option>
                                            <option value="cod" {{ old('payment_gateway', $settingValues['payment_gateway'] ?? 'stripe') == 'cod' ? 'selected' : '' }}>Cash on Delivery</option>
                                            <option value="bank_transfer" {{ old('payment_gateway', $settingValues['payment_gateway'] ?? 'stripe') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                        </select>
                                    </div>

                                    <div class="mb-3 form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="cod_enabled"
                                            name="cod_enabled" value="1" 
                                            {{ old('cod_enabled', $settingValues['cod_enabled'] ?? 1) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="cod_enabled">
                                            Cash on Delivery (COD)
                                        </label>
                                    </div>

                                    <div class="mb-3 form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="bank_transfer_enabled"
                                            name="bank_transfer_enabled" value="1" 
                                            {{ old('bank_transfer_enabled', $settingValues['bank_transfer_enabled'] ?? 0) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="bank_transfer_enabled">
                                            Bank Transfer
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="bank_details" class="form-label">Bank Details</label>
                                        <textarea class="form-control" id="bank_details" name="bank_details"
                                            rows="5">{{ old('bank_details', $settingValues['bank_details'] ?? "Bank Name: HBL\nAccount Name: Ghazali Food\nAccount Number: 1234567890\nIBAN: PK00HBL01234567890\nBranch: Main Branch, Karachi") }}</textarea>
                                        <small class="text-muted">Displayed to customers for bank transfer payments</small>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i> Save Payment Settings
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Maintenance Settings -->
                    <div class="tab-pane fade" id="maintenance" role="tabpanel">
                        <form action="{{ route('admin.settings.maintenance.update') }}" method="POST">
                            @csrf
                            <h5 class="mb-3">Maintenance Mode</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3 form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="maintenance_mode"
                                            name="maintenance_mode" value="1"
                                            {{ old('maintenance_mode', $settingValues['maintenance_mode'] ?? 0) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="maintenance_mode">
                                            Enable Maintenance Mode
                                        </label>
                                        <small class="d-block text-muted">When enabled, only admins can access the site</small>
                                    </div>

                                    <div class="mb-3">
                                        <label for="maintenance_message" class="form-label">Maintenance Message</label>
                                        <textarea class="form-control" id="maintenance_message" name="maintenance_message"
                                            rows="3">{{ old('maintenance_message', $settingValues['maintenance_message'] ?? 'Site is currently under maintenance. Please check back later.') }}</textarea>
                                    </div>

                                    <div class="mb-3 form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="allow_admin_access"
                                            name="allow_admin_access" value="1"
                                            {{ old('allow_admin_access', $settingValues['allow_admin_access'] ?? 1) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="allow_admin_access">
                                            Allow Admin Access During Maintenance
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="cache_duration" class="form-label">Cache Duration (minutes) *</label>
                                        <input type="number" class="form-control" id="cache_duration" name="cache_duration"
                                            value="{{ old('cache_duration', $settingValues['cache_duration'] ?? 60) }}" min="1" required>
                                        <small class="text-muted">How long to cache settings and other data</small>
                                    </div>

                                    <div class="mb-3">
                                        <label for="backup_frequency" class="form-label">Backup Frequency *</label>
                                        <select class="form-select" id="backup_frequency" name="backup_frequency" required>
                                            <option value="daily" {{ old('backup_frequency', $settingValues['backup_frequency'] ?? 'daily') == 'daily' ? 'selected' : '' }}>Daily</option>
                                            <option value="weekly" {{ old('backup_frequency', $settingValues['backup_frequency'] ?? 'daily') == 'weekly' ? 'selected' : '' }}>Weekly</option>
                                            <option value="monthly" {{ old('backup_frequency', $settingValues['backup_frequency'] ?? 'daily') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i> Save Maintenance Settings
                                </button>
                            </div>
                        </form>

                        <hr class="my-4">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h6 class="mb-0">Database Backup</h6>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text">Create a backup of your database. This will download an SQL file containing all your data.</p>
                                        <a href="{{ route('admin.settings.backup') }}" class="btn btn-warning"
                                            onclick="return confirm('This will download a database backup. Continue?');">
                                            <i class="fas fa-database me-2"></i> Backup Database
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h6 class="mb-0">Clear Cache</h6>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text">Clear all cached data including views, routes, and configuration.</p>
                                        <a href="{{ route('admin.settings.cache.clear') }}" class="btn btn-info"
                                            onclick="return confirm('This will clear all cache. Continue?');">
                                            <i class="fas fa-broom me-2"></i> Clear Cache
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">System Information</h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <td style="width: 40%"><strong>PHP Version:</strong></td>
                                        <td>{{ phpversion() }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Laravel Version:</strong></td>
                                        <td>{{ app()->version() }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Server Software:</strong></td>
                                        <td>{{ request()->server('SERVER_SOFTWARE') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Database Driver:</strong></td>
                                        <td>{{ config('database.default') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Application Environment:</strong></td>
                                        <td>
                                            <span class="badge bg-{{ app()->environment('production') ? 'success' : 'warning' }}">
                                                {{ app()->environment() }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Debug Mode:</strong></td>
                                        <td>
                                            <span class="badge bg-{{ config('app.debug') ? 'danger' : 'success' }}">
                                                {{ config('app.debug') ? 'Enabled' : 'Disabled' }}
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function testEmail() {
        let email = '{{ $settingValues["site_email"] ?? config("mail.from.address", "admin@ghazalifood.com") }}';
        if (confirm('Send a test email to ' + email + '?')) {
            fetch('{{ route("admin.settings.email.test") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({email: email})
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Test email sent successfully!');
                } else {
                    alert('Failed to send test email: ' + data.message);
                }
            })
            .catch(error => {
                alert('Error: ' + error.message);
            });
        }
    }
</script>
@endpush