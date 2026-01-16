@extends('layouts.admin')

@section('title', 'Customers')
@section('page_title', 'Customer Management')
@section('breadcrumb', 'All Customers')

@section('page_actions')
    <a href="{{ route('admin.customers.export') }}" class="btn btn-outline-success">
        <i class="fas fa-download me-2"></i> Export CSV
    </a>
@endsection

@section('content')
<div class="card shadow">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Orders</th>
                        <th>Status</th>
                        <th>Joined</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($customers as $customer)
                    <tr>
                        <td>{{ $customer->id }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar me-3">
                                    <div class="bg-primary rounded-circle text-white d-flex align-items-center justify-content-center" 
                                         style="width: 40px; height: 40px;">
                                        {{ strtoupper(substr($customer->name, 0, 1)) }}
                                    </div>
                                </div>
                                <div>
                                    <strong>{{ $customer->name }}</strong>
                                    <div class="text-muted small">Customer ID: {{ $customer->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $customer->email }}</td>
                        <td>{{ $customer->phone ?? 'N/A' }}</td>
                        <td>
                            <span class="badge bg-primary">{{ $customer->orders_count ?? 0 }}</span>
                        </td>
                        <td>
                            <form action="{{ route('admin.customers.toggle-status', $customer) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-{{ $customer->status === 'active' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($customer->status) }}
                                </button>
                            </form>
                        </td>
                        <td>{{ $customer->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.customers.show', $customer) }}" 
                                   class="btn btn-sm btn-outline-primary" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.customers.edit', $customer) }}" 
                                   class="btn btn-sm btn-outline-info" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.customers.destroy', $customer) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger confirm-delete" 
                                            data-item-name="{{ $customer->name }}">
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
                Showing {{ $customers->firstItem() }} to {{ $customers->lastItem() }} of {{ $customers->total() }} entries
            </div>
            <div>
                {{ $customers->links() }}
            </div>
        </div>
    </div>
</div>
@endsection