<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->order_number }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #ddd;
            padding: 30px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            border-bottom: 2px solid #4a5568;
            padding-bottom: 20px;
        }
        .company-info h1 {
            margin: 0;
            color: #2d3748;
        }
        .invoice-info h2 {
            margin: 0;
            color: #4a5568;
        }
        .details {
            margin-bottom: 30px;
        }
        .details-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
        .detail-section h4 {
            margin: 0 0 10px 0;
            color: #4a5568;
        }
        .detail-section p {
            margin: 0;
            color: #718096;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .items-table th {
            background-color: #f7fafc;
            padding: 12px;
            text-align: left;
            border-bottom: 2px solid #e2e8f0;
            color: #4a5568;
        }
        .items-table td {
            padding: 12px;
            border-bottom: 1px solid #e2e8f0;
        }
        .items-table tr:hover {
            background-color: #f7fafc;
        }
        .totals {
            float: right;
            width: 300px;
        }
        .totals-table {
            width: 100%;
            border-collapse: collapse;
        }
        .totals-table td {
            padding: 8px 0;
            border-bottom: 1px solid #e2e8f0;
        }
        .totals-table tr:last-child td {
            border-bottom: 2px solid #4a5568;
            font-weight: bold;
            font-size: 1.1em;
        }
        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            color: #718096;
            font-size: 0.9em;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.9em;
            font-weight: 600;
        }
        .badge-success {
            background-color: #c6f6d5;
            color: #22543d;
        }
        .badge-warning {
            background-color: #feebc8;
            color: #744210;
        }
        .badge-info {
            background-color: #bee3f8;
            color: #2c5282;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="header">
            <div class="company-info">
                <h1>{{ config('app.name', 'Ghazali Food') }}</h1>
                <p>{{ config('app.address', '123 Food Street, Culinary City') }}</p>
                <p>Phone: {{ config('app.phone', '+1 (234) 567-8900') }}</p>
                <p>Email: {{ config('mail.from.address', 'info@ghazalifood.com') }}</p>
            </div>
            <div class="invoice-info">
                <h2>INVOICE</h2>
                <p><strong>Invoice #:</strong> {{ $order->order_number }}</p>
                <p><strong>Date:</strong> {{ $order->created_at->format('M d, Y') }}</p>
                <p><strong>Status:</strong> 
                    <span class="status-badge badge-{{ $order->order_status }}">
                        {{ ucfirst($order->order_status) }}
                    </span>
                </p>
            </div>
        </div>

        <div class="details">
            <div class="details-grid">
                <div class="detail-section">
                    <h4>Bill To</h4>
                    <p><strong>{{ $order->customer_name }}</strong></p>
                    <p>{{ $order->customer_email }}</p>
                    <p>{{ $order->customer_phone ?? 'N/A' }}</p>
                    @php
                        $billing = json_decode($order->billing_address, true);
                    @endphp
                    @if($billing)
                        <p>{{ $billing['address_line_1'] ?? '' }}</p>
                        @if(isset($billing['address_line_2']))
                            <p>{{ $billing['address_line_2'] }}</p>
                        @endif
                        <p>{{ $billing['city'] ?? '' }}, {{ $billing['state'] ?? '' }} {{ $billing['postal_code'] ?? '' }}</p>
                        <p>{{ $billing['country'] ?? '' }}</p>
                    @endif
                </div>
                <div class="detail-section">
                    <h4>Ship To</h4>
                    @php
                        $shipping = json_decode($order->shipping_address, true);
                    @endphp
                    @if($shipping)
                        <p><strong>{{ $shipping['full_name'] ?? $order->customer_name }}</strong></p>
                        <p>{{ $shipping['phone'] ?? $order->customer_phone ?? 'N/A' }}</p>
                        <p>{{ $shipping['address_line_1'] ?? '' }}</p>
                        @if(isset($shipping['address_line_2']))
                            <p>{{ $shipping['address_line_2'] }}</p>
                        @endif
                        <p>{{ $shipping['city'] ?? '' }}, {{ $shipping['state'] ?? '' }} {{ $shipping['postal_code'] ?? '' }}</p>
                        <p>{{ $shipping['country'] ?? '' }}</p>
                    @endif
                </div>
            </div>
        </div>

        <table class="items-table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>
                        <strong>{{ $item->product_name }}</strong>
                        @if($item->variant_name)
                            <br><small>Variant: {{ $item->variant_name }}</small>
                        @endif
                        @if($item->sku)
                            <br><small>SKU: {{ $item->sku }}</small>
                        @endif
                    </td>
                    <td>${{ number_format($item->price, 2) }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>${{ number_format($item->total, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totals">
            <table class="totals-table">
                <tr>
                    <td>Subtotal:</td>
                    <td align="right">${{ number_format($order->subtotal, 2) }}</td>
                </tr>
                <tr>
                    <td>Shipping:</td>
                    <td align="right">${{ number_format($order->shipping_cost, 2) }}</td>
                </tr>
                <tr>
                    <td>Tax:</td>
                    <td align="right">${{ number_format($order->tax_amount, 2) }}</td>
                </tr>
                @if($order->discount_amount > 0)
                <tr>
                    <td>Discount:</td>
                    <td align="right">-${{ number_format($order->discount_amount, 2) }}</td>
                </tr>
                @endif
                <tr>
                    <td><strong>Total:</strong></td>
                    <td align="right"><strong>${{ number_format($order->total_amount, 2) }}</strong></td>
                </tr>
            </table>
        </div>
        <div style="clear: both;"></div>

        <div class="footer">
            <p><strong>Payment Method:</strong> {{ strtoupper($order->payment_method) }}</p>
            <p><strong>Payment Status:</strong> {{ ucfirst($order->payment_status) }}</p>
            @if($order->tracking_number)
                <p><strong>Tracking Number:</strong> {{ $order->tracking_number }}</p>
            @endif
            @if($order->notes)
                <p><strong>Notes:</strong> {{ $order->notes }}</p>
            @endif
            <p style="margin-top: 20px;">Thank you for your business!</p>
        </div>
    </div>
</body>
</html>