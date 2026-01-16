@extends('layouts.admin')

@section('title', 'Customer Feedback')
@section('page_title', 'Feedback Management')
@section('breadcrumb', 'All Feedback')

@section('page_actions')
    <a href="{{ route('admin.feedback.export') }}" class="btn btn-outline-success">
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
                    <option value="new">New</option>
                    <option value="in_progress">In Progress</option>
                    <option value="resolved">Resolved</option>
                    <option value="closed">Closed</option>
                </select>
            </div>
            <div class="col-md-3 mb-2">
                <select class="form-select form-select-sm" id="typeFilter">
                    <option value="">All Types</option>
                    <option value="general">General</option>
                    <option value="complaint">Complaint</option>
                    <option value="suggestion">Suggestion</option>
                    <option value="support">Support</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="col-md-3 mb-2">
                <select class="form-select form-select-sm" id="priorityFilter">
                    <option value="">All Priorities</option>
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="high">High</option>
                    <option value="urgent">Urgent</option>
                </select>
            </div>
            <div class="col-md-3 mb-2">
                <input type="date" class="form-control form-control-sm" id="dateFilter" placeholder="Filter by date">
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Subject</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Assigned To</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($feedbacks as $feedback)
                    <tr class="feedback-row" 
                        data-status="{{ $feedback->status }}"
                        data-type="{{ $feedback->feedback_type }}"
                        data-priority="{{ $feedback->priority }}"
                        data-date="{{ $feedback->created_at->format('Y-m-d') }}">
                        <td>{{ $feedback->id }}</td>
                        <td>
                            <div>{{ $feedback->name }}</div>
                            <small class="text-muted">{{ $feedback->email }}</small>
                        </td>
                        <td>
                            <strong>{{ Str::limit($feedback->subject, 40) }}</strong>
                            <div class="text-muted small">{{ Str::limit($feedback->message, 50) }}</div>
                        </td>
                        <td>
                            <span class="badge bg-info">{{ ucfirst($feedback->feedback_type) }}</span>
                        </td>
                        <td>
                            @php
                                $statusColors = [
                                    'new' => 'danger',
                                    'in_progress' => 'warning',
                                    'resolved' => 'success',
                                    'closed' => 'secondary'
                                ];
                            @endphp
                            <span class="badge bg-{{ $statusColors[$feedback->status] ?? 'secondary' }}">
                                {{ ucfirst(str_replace('_', ' ', $feedback->status)) }}
                            </span>
                        </td>
                        <td>
                            @php
                                $priorityColors = [
                                    'low' => 'success',
                                    'medium' => 'info',
                                    'high' => 'warning',
                                    'urgent' => 'danger'
                                ];
                            @endphp
                            <span class="badge bg-{{ $priorityColors[$feedback->priority] ?? 'secondary' }}">
                                {{ ucfirst($feedback->priority) }}
                            </span>
                        </td>
                        <td>
                            @if($feedback->assignedTo)
                                {{ $feedback->assignedTo->name }}
                            @else
                                <span class="text-muted">Unassigned</span>
                            @endif
                        </td>
                        <td>{{ $feedback->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.feedback.show', $feedback) }}" 
                                   class="btn btn-sm btn-outline-primary" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.feedback.edit', $feedback) }}" 
                                   class="btn btn-sm btn-outline-info" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.feedback.destroy', $feedback) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger confirm-delete" 
                                            data-item-name="Feedback from {{ $feedback->name }}">
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
                Showing {{ $feedbacks->firstItem() }} to {{ $feedbacks->lastItem() }} of {{ $feedbacks->total() }} entries
            </div>
            <div>
                {{ $feedbacks->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Filter feedback
    $(document).ready(function() {
        $('#statusFilter, #typeFilter, #priorityFilter, #dateFilter').change(function() {
            filterFeedback();
        });
        
        function filterFeedback() {
            const status = $('#statusFilter').val();
            const type = $('#typeFilter').val();
            const priority = $('#priorityFilter').val();
            const date = $('#dateFilter').val();
            
            $('.feedback-row').each(function() {
                const rowStatus = $(this).data('status');
                const rowType = $(this).data('type');
                const rowPriority = $(this).data('priority');
                const rowDate = $(this).data('date');
                
                let show = true;
                
                if (status && rowStatus !== status) show = false;
                if (type && rowType !== type) show = false;
                if (priority && rowPriority !== priority) show = false;
                if (date && rowDate !== date) show = false;
                
                $(this).toggle(show);
            });
        }
    });
</script>
@endpush