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
                                               value="{{ $settings['site_name'] }}" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="site_email" class="form-label">Site Email *</label>
                                        <input type="email" class="form-control" id="site_email" name="site_email" 
                                               value="{{ $settings['site_email'] }}" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="site_phone" class="form-label">Site Phone *</label>
                                        <input type="text" class="form-control" id="site_phone" name="site_phone" 
                                               value="{{ $settings['site_phone'] }}" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="site_address" class="form-label">Site Address *</label>
                                        <textarea class="form-control" id="site_address" name="site_address" 
                                                  rows="3" required>{{ $settings['site_address'] }}</textarea>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <h5 class="mb-3">Business Settings</h5>
                                    <div class="mb-3">
                                        <label for="currency" class="form-label">Currency *</label>
                                        <input type="text" class="form-control" id="currency" name="currency" 
                                               value="{{ $settings['currency'] }}" required maxlength="3">
                                        <small class="text-muted">3-letter currency code (e.g., USD, EUR)</small>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="currency_symbol" class="form-label">Currency Symbol *</label>
                                        <input type="text" class="form-control" id="currency_symbol" name="currency_symbol" 
                                               value="{{ $settings['currency_symbol'] }}" required maxlength="5">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="tax_rate" class="form-label">Tax Rate (%) *</label>
                                        <input type="number" class="form-control" id="tax_rate" name="tax_rate" 
                                               value="{{ $settings['tax_rate'] }}" min="0" max="100" step="0.01" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="shipping_cost" class="form-label">Shipping Cost *</label>
                                        <input type="number" class="form-control" id="shipping_cost" name="shipping_cost" 
                                               value="{{ $settings['shipping_cost'] }}" min="0" step="0.01" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="free_shipping_threshold" class="form-label">Free Shipping Threshold *</label>
                                        <input type="number" class="form-control" id="free_shipping_threshold" name="free_shipping_threshold" 
                                               value="{{ $settings['free_shipping_threshold'] }}" min="0" step="0.01" required>
                                        <small class="text-muted">Minimum order amount for free shipping</small>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <h5 class="mb-3">Inventory Settings</h5>
                                    <div class="mb-3">
                                        <label for="low_stock_threshold" class="form-label">Low Stock Threshold *</label>
                                        <input type="number" class="form-control" id="low_stock_threshold" name="low_stock_threshold" 
                                               value="{{ $settings['low_stock_threshold'] }}" min="1" required>
                                        <small class="text-muted">Send alerts when stock falls below this number</small>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <h5 class="mb-3">Feature Toggles</h5>
                                    <div class="mb-3 form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="maintenance_mode" 
                                               name="maintenance_mode" value="1" 
                                               {{ $settings['maintenance_mode'] ? 'checked' : '' }}>
                                        <label class="form-check-label" for="maintenance_mode">
                                            Maintenance Mode
                                        </label>
                                        <small class="d-block text-muted">When enabled, only admins can access the site</small>
                                    </div>
                                    
                                    <div class="mb-3 form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="announcement_enabled" 
                                               name="announcement_enabled" value="1" 
                                               {{ $settings['announcement_enabled'] ? 'checked' : '' }}>
                                        <label class="form-check-label" for="announcement_enabled">
                                            Announcements Enabled
                                        </label>
                                    </div>
                                    
                                    <div class="mb-3 form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="review_approval_required" 
                                               name="review_approval_required" value="1" 
                                               {{ $settings['review_approval_required'] ? 'checked' : '' }}>
                                        <label class="form-check-label" for="review_approval_required">
                                            Review Approval Required
                                        </label>
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
                                            <option value="smtp">SMTP</option>
                                            <option value="mailgun">Mailgun</option>
                                            <option value="ses">Amazon SES</option>
                                            <option value="sendmail">Sendmail</option>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="mail_host" class="form-label">SMTP Host *</label>
                                        <input type="text" class="form-control" id="mail_host" name="mail_host" 
                                               value="{{ old('mail_host', 'smtp.mailtrap.io') }}" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="mail_port" class="form-label">SMTP Port *</label>
                                        <input type="number" class="form-control" id="mail_port" name="mail_port" 
                                               value="{{ old('mail_port', '2525') }}" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="mail_encryption" class="form-label">Encryption</label>
                                        <select class="form-select" id="mail_encryption" name="mail_encryption">
                                            <option value="">None</option>
                                            <option value="tls">TLS</option>
                                            <option value="ssl">SSL</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="mail_username" class="form-label">SMTP Username *</label>
                                        <input type="text" class="form-control" id="mail_username" name="mail_username" 
                                               value="{{ old('mail_username') }}" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="mail_password" class="form-label">SMTP Password *</label>
                                        <input type="password" class="form-control" id="mail_password" name="mail_password" 
                                               value="{{ old('mail_password') }}" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="mail_from_address" class="form-label">From Address *</label>
                                        <input type="email" class="form-control" id="mail_from_address" name="mail_from_address" 
                                               value="{{ old('mail_from_address', $settings['site_email']) }}" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="mail_from_name" class="form-label">From Name *</label>
                                        <input type="text" class="form-control" id="mail_from_name" name="mail_from_name" 
                                               value="{{ old('mail_from_name', $settings['site_name']) }}" required>
                                    </div>
                                </div>
                            </div>
                            
                            <h5 class="mt-4 mb-3">Email Addresses</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="order_notification_email" class="form-label">Order Notifications</label>
                                        <input type="email" class="form-control" id="order_notification_email" 
                                               name="order_notification_email" value="{{ old('order_notification_email') }}">
                                        <small class="text-muted">Send order notifications to this email</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="support_email" class="form-label">Support Email</label>
                                        <input type="email" class="form-control" id="support_email" 
                                               name="support_email" value="{{ old('support_email') }}">
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
                                                       name="stripe_key" value="{{ old('stripe_key') }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="stripe_secret" class="form-label">Secret Key</label>
                                                <input type="password" class="form-control" id="stripe_secret" 
                                                       name="stripe_secret" value="{{ old('stripe_secret') }}">
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
                                                       name="paypal_client_id" value="{{ old('paypal_client_id') }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="paypal_secret" class="form-label">Secret</label>
                                                <input type="password" class="form-control" id="paypal_secret" 
                                                       name="paypal_secret" value="{{ old('paypal_secret') }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="paypal_mode" class="form-label">Mode *</label>
                                                <select class="form-select" id="paypal_mode" name="paypal_mode" required>
                                                    <option value="sandbox">Sandbox</option>
                                                    <option value="live">Live</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <h5 class="mb-3">Payment Methods</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3 form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="cod_enabled" 
                                               name="cod_enabled" value="1" {{ old('cod_enabled') ? 'checked' : 'checked' }}>
                                        <label class="form-check-label" for="cod_enabled">
                                            Cash on Delivery (COD)
                                        </label>
                                    </div>
                                    
                                    <div class="mb-3 form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="bank_transfer_enabled" 
                                               name="bank_transfer_enabled" value="1" {{ old('bank_transfer_enabled') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="bank_transfer_enabled">
                                            Bank Transfer
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="bank_details" class="form-label">Bank Details</label>
                                        <textarea class="form-control" id="bank_details" name="bank_details" 
                                                  rows="4">{{ old('bank_details') }}</textarea>
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
                    
                    <!-- Maintenance -->
                    <div class="tab-pane fade" id="maintenance" role="tabpanel">
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
        if (confirm('Send a test email to {{ $settings["site_email"] }}?')) {
            // You would implement AJAX call here
            alert('Test email would be sent. Implement AJAX call.');
        }
    }
</script>
@endpush