@extends('layouts.admin')

@section('title', 'Feedback Details')
@section('page_title', 'Feedback Details')
@section('breadcrumb', 'Feedback')

@section('page_actions')
    <div class="btn-group">
        <a href="{{ route('admin.feedback.edit', $feedback) }}" class="btn btn-outline-info">
            <i class="fas fa-edit me-2"></i> Edit Feedback
        </a>
        @if(!$feedback->response)
            <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#responseModal">
                <i class="fas fa-reply me-2"></i> Respond
            </button>
        @endif
    </div>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-8">
        <!-- Feedback Details -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Feedback Details</h6>
                <div>
                    <span class="badge bg-{{ $feedback->status == 'new' ? 'danger' : 'success' }}">
                        {{ ucfirst(str_replace('_', ' ', $feedback->status)) }}
                    </span>
                    <span class="badge bg-{{ $feedback->priority == 'urgent' ? 'danger' : 'warning' }}">
                        {{ ucfirst($feedback->priority) }}
                    </span>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <strong>From:</strong>
                            <div>{{ $feedback->name }}</div>
                        </div>
                        <div class="mb-3">
                            <strong>Email:</strong>
                            <div>{{ $feedback->email }}</div>
                        </div>
                        <div class="mb-3">
                            <strong>Phone:</strong>
                            <div>{{ $feedback->phone ?? 'N/A' }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <strong>Type:</strong>
                            <div>
                                <span class="badge bg-info">{{ ucfirst($feedback->feedback_type) }}</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <strong>Assigned To:</strong>
                            <div>
                                @if($feedback->assignedTo)
                                    {{ $feedback->assignedTo->name }}
                                @else
                                    <span class="text-muted">Unassigned</span>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3">
                            <strong>Date Submitted:</strong>
                            <div>{{ $feedback->created_at->format('F d, Y h:i A') }}</div>
                        </div>
                    </div>
                </div>
                
                <div class="mb-4">
                    <strong>Subject:</strong>
                    <h5 class="mt-1">{{ $feedback->subject }}</h5>
                </div>
                
                <div class="mb-4">
                    <strong>Message:</strong>
                    <div class="border rounded p-3 mt-2 bg-light">
                        {{ $feedback->message }}
                    </div>
                </div>
                
                @if($feedback->response)
                <div class="mb-4">
                    <strong>Response:</strong>
                    <div class="border rounded p-3 mt-2 bg-success text-white">
                        {{ $feedback->response }}
                    </div>
                    @if($feedback->respondedBy && $feedback->responded_at)
                        <div class="text-muted small mt-2">
                            Responded by {{ $feedback->respondedBy->name }} on 
                            {{ $feedback->responded_at->format('M d, Y h:i A') }}
                        </div>
                    @endif
                </div>
                @endif
                
                <div class="small text-muted">
                    <div>IP Address: {{ $feedback->ip_address }}</div>
                    <div>User Agent: {{ Str::limit($feedback->user_agent, 100) }}</div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Quick Actions -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2 mb-3">
                    <form action="{{ route('admin.feedback.update-status', $feedback) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="in_progress">
                        <button type="submit" class="btn btn-warning w-100">
                            <i class="fas fa-spinner me-2"></i> Mark as In Progress
                        </button>
                    </form>
                    
                    <form action="{{ route('admin.feedback.update-status', $feedback) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="resolved">
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-check me-2"></i> Mark as Resolved
                        </button>
                    </form>
                    
                    <form action="{{ route('admin.feedback.update-status', $feedback) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="closed">
                        <button type="submit" class="btn btn-secondary w-100">
                            <i class="fas fa-times me-2"></i> Close Feedback
                        </button>
                    </form>
                </div>
                
                <hr>
                
                <div class="mb-3">
                    <strong>Update Priority:</strong>
                    <div class="btn-group w-100 mt-2" role="group">
                        @foreach(['low', 'medium', 'high', 'urgent'] as $priority)
                            <form action="{{ route('admin.feedback.update', $feedback) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="priority" value="{{ $priority }}">
                                <button type="submit" class="btn btn-sm btn-{{ $priority == 'urgent' ? 'danger' : ($priority == 'high' ? 'warning' : ($priority == 'medium' ? 'info' : 'success')) }}">
                                    {{ ucfirst($priority) }}
                                </button>
                            </form>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Customer Information -->
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Customer Information</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Name:</strong>
                    <div>{{ $feedback->name }}</div>
                </div>
                <div class="mb-3">
                    <strong>Email:</strong>
                    <div>{{ $feedback->email }}</div>
                </div>
                <div class="mb-3">
                    <strong>Phone:</strong>
                    <div>{{ $feedback->phone ?? 'N/A' }}</div>
                </div>
                <div class="mb-0">
                    <strong>Feedback History:</strong>
                    <div class="small text-muted">
                        @php
                            $customerFeedbacks = \App\Models\Feedback::where('email', $feedback->email)->count();
                        @endphp
                        {{ $customerFeedbacks }} feedback(s) total
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Response Modal -->
<div class="modal fade" id="responseModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Send Response</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.feedback.respond', $feedback) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="response" class="form-label">Response *</label>
                        <textarea class="form-control" id="response" name="response" rows="6" required></textarea>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="send_email" name="send_email" value="1" checked>
                        <label class="form-check-label" for="send_email">
                            Send email to customer
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Send Response</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection