@extends('layouts.admin')

@section('title', 'View Announcement')
@section('page_title', 'Announcements')
@section('breadcrumb', 'View Announcement')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Announcement Details</h5>
                <div>
                    <a href="{{ route('admin.announcements.edit', $announcement) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>
                    <a href="{{ route('admin.announcements.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Back
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Announcement Preview</h6>
                            </div>
                            <div class="card-body">
                                <div class="announcement-preview p-4 rounded" 
                                     style="background-color: {{ $announcement->background_color }}; 
                                            color: {{ $announcement->text_color }};">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="mb-0">Announcement</h5>
                                        @if($announcement->is_closable)
                                            <button type="button" class="btn btn-sm btn-light">×</button>
                                        @endif
                                    </div>
                                    <p class="mb-0">{{ $announcement->text }}</p>
                                    @if($announcement->link_url)
                                        <div class="mt-3">
                                            <a href="{{ $announcement->link_url }}" 
                                               class="btn btn-sm btn-outline-light">
                                                Learn More
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Details -->
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Details</h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <tr>
                                        <th style="width: 30%">Text:</th>
                                        <td>{{ $announcement->text }}</td>
                                    </tr>
                                    <tr>
                                        <th>Link URL:</th>
                                        <td>
                                            @if($announcement->link_url)
                                                <a href="{{ $announcement->link_url }}" target="_blank">
                                                    {{ $announcement->link_url }}
                                                </a>
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Closable:</th>
                                        <td>
                                            <span class="badge bg-{{ $announcement->is_closable ? 'success' : 'danger' }}">
                                                {{ $announcement->is_closable ? 'Yes' : 'No' }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Display Order:</th>
                                        <td>{{ $announcement->display_order }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <!-- Colors -->
                        <div class="card mb-3">
                            <div class="card-header">
                                <h6 class="mb-0">Colors</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <label class="form-label">Background</label>
                                        <div class="color-box" 
                                             style="background-color: {{ $announcement->background_color }}; 
                                                    width: 40px; height: 40px; border-radius: 4px;"></div>
                                        <small class="text-muted">{{ $announcement->background_color }}</small>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label">Text</label>
                                        <div class="color-box" 
                                             style="background-color: {{ $announcement->text_color }}; 
                                                    width: 40px; height: 40px; border-radius: 4px;"></div>
                                        <small class="text-muted">{{ $announcement->text_color }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Dates -->
                        <div class="card mb-3">
                            <div class="card-header">
                                <h6 class="mb-0">Dates</h6>
                            </div>
                            <div class="card-body">
                                <p><strong>Start Date:</strong><br>
                                   {{ $announcement->start_date->format('M d, Y h:i A') }}</p>
                                <p><strong>End Date:</strong><br>
                                   {{ $announcement->end_date->format('M d, Y h:i A') }}</p>
                                <p><strong>Status:</strong><br>
                                    @php
                                        $now = now();
                                        $isActive = $announcement->status == 'active' && 
                                                   $now->between($announcement->start_date, $announcement->end_date);
                                        $isScheduled = $now->lt($announcement->start_date);
                                        $isExpired = $now->gt($announcement->end_date);
                                    @endphp
                                    <span class="badge bg-{{ $isActive ? 'success' : ($isScheduled ? 'info' : ($isExpired ? 'danger' : 'warning')) }}">
                                        {{ $isActive ? 'Active' : ($isScheduled ? 'Scheduled' : ($isExpired ? 'Expired' : ucfirst($announcement->status))) }}
                                    </span>
                                </p>
                            </div>
                        </div>

                        <!-- Creation Info -->
                        <div class="card mb-3">
                            <div class="card-header">
                                <h6 class="mb-0">Creation Info</h6>
                            </div>
                            <div class="card-body">
                                <p><strong>Created By:</strong><br>
                                   {{ $announcement->creator->name ?? 'System' }}</p>
                                <p><strong>Created At:</strong><br>
                                   {{ $announcement->created_at->format('M d, Y h:i A') }}</p>
                                <p><strong>Last Updated:</strong><br>
                                   {{ $announcement->updated_at->format('M d, Y h:i A') }}</p>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Quick Actions</h6>
                            </div>
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <form action="{{ route('admin.announcements.destroy', $announcement) }}" method="POST" 
                                          class="d-grid">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" 
                                                onclick="return confirm('Are you sure you want to delete this announcement?');">
                                            <i class="fas fa-trash me-1"></i> Delete Announcement
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .announcement-preview {
        min-height: 150px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .color-box {
        border: 1px solid #dee2e6;
    }
</style>
@endpush