@extends('layouts.admin')

@section('title', 'Orders')
@section('page_title', 'Order Management')
@section('breadcrumb', 'All Orders')

@section('page_actions')
    <a href="" class="btn btn-outline-success">
        <i class="fas fa-download me-2"></i> Export CSV
    </a>
@endsection

@section('content')
<div class="card shadow">
    <div class="card-body">
        <!-- Filters -->
        <div class="row mb-4">
            <div class="col-md-3 mb-2">
                <select class="form-select form-select-sm" id="statusFilter">
                    <option value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="processing">Processing</option>
                    <option value="shipped">Shipped</option>
                    <option value="delivered">Delivered</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
            <div class="col-md-3 mb-2">
                <select class="form-select form-select-sm" id="paymentFilter">
                    <option value="">All Payment Status</option>
                    <option value="pending">Pending</option>
                    <option value="paid">Paid</option>
                    <option value="failed">Failed</option>
                </select>
            </div>
            <div class="col-md-3 mb-2">
                <input type="date" class="form-control form-control-sm" id="dateFrom" placeholder="From Date">
            </div>
            <div class="col-md-3 mb-2">
                <input type="date" class="form-control form-control-sm" id="dateTo" placeholder="To Date">
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover data-table">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Payment</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr class="order-row" 
                        data-status="{{ $order->order_status }}"
                        data-payment="{{ $order->payment_status }}"
                        data-date="{{ $order->created_at->format('Y-m-d') }}">
                        <td>
                            <strong>#{{ $order->order_number }}</strong>
                        </td>
                        <td>
                            <div>{{ $order->customer_name }}</div>
                            <small class="text-muted">{{ $order->customer_email }}</small>
                        </td>
                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                        <td>{{ $order->items->sum('quantity') }}</td>
                        <td>
                            <strong class="text-success">${{ number_format($order->total_amount, 2) }}</strong>
                        </td>
                        <td>
                            <span class="badge bg-{{ $order->status_color }}">
                                {{ ucfirst($order->order_status) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-{{ $order->payment_status_color }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.orders.show', $order) }}" 
                                   class="btn btn-sm btn-outline-primary" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.orders.edit', $order) }}" 
                                   class="btn btn-sm btn-outline-info" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('admin.orders.print', $order) }}" 
                                   class="btn btn-sm btn-outline-secondary" title="Print Invoice">
                                    <i class="fas fa-print"></i>
                                </a>
                                <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger confirm-delete" 
                                            data-item-name="Order #{{ $order->order_number }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div>
                Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of {{ $orders->total() }} entries
            </div>
            <div>
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Filter orders
    $(document).ready(function() {
        $('#statusFilter, #paymentFilter, #dateFrom, #dateTo').change(function() {
            filterOrders();
        });
        
        function filterOrders() {
            const status = $('#statusFilter').val();
            const payment = $('#paymentFilter').val();
            const dateFrom = $('#dateFrom').val();
            const dateTo = $('#dateTo').val();
            
            $('.order-row').each(function() {
                const rowStatus = $(this).data('status');
                const rowPayment = $(this).data('payment');
                const rowDate = $(this).data('date');
                
                let show = true;
                
                if (status && rowStatus !== status) show = false;
                if (payment && rowPayment !== payment) show = false;
                if (dateFrom && rowDate < dateFrom) show = false;
                if (dateTo && rowDate > dateTo) show = false;
                
                $(this).toggle(show);
            });
        }
    });
</script>
@endpush