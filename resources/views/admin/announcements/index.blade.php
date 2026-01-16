@extends('layouts.admin')

@section('title', 'Announcements')
@section('page_title', 'Announcement Management')
@section('breadcrumb', 'All Announcements')

@section('page_actions')
    <a href="{{ route('admin.announcements.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i> Create Announcement
    </a>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="announcementsTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Text</th>
                                <th>Status</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Created By</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($announcements as $announcement)
                            <tr>
                                <td>{{ $announcement->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="color-indicator me-2" 
                                             style="background-color: {{ $announcement->background_color }}; 
                                                    color: {{ $announcement->text_color }};
                                                    width: 20px; height: 20px; border-radius: 4px;">
                                        </div>
                                        <span title="{{ $announcement->text }}">
                                            {{ Str::limit($announcement->text, 50) }}
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $now = now();
                                        if ($announcement->status == 'scheduled') {
                                            $statusColor = 'info';
                                        } elseif ($announcement->status == 'active' && 
                                                 $now->between($announcement->start_date, $announcement->end_date)) {
                                            $statusColor = 'success';
                                        } else {
                                            $statusColor = 'secondary';
                                        }
                                    @endphp
                                    <span class="badge bg-{{ $statusColor }}">
                                        {{ ucfirst($announcement->status) }}
                                    </span>
                                </td>
                                <td>{{ $announcement->start_date->format('M d, Y') }}</td>
                                <td>{{ $announcement->end_date->format('M d, Y') }}</td>
                                <td>{{ $announcement->creator->name ?? 'System' }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.announcements.show', $announcement) }}"
                                           class="btn btn-sm btn-outline-primary" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.announcements.edit', $announcement) }}"
                                           class="btn btn-sm btn-outline-info" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.announcements.destroy', $announcement) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                    title="Delete"
                                                    onclick="return confirm('Are you sure you want to delete this announcement?');">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-bullhorn fa-2x mb-3"></i>
                                        <p>No announcements found. Create your first announcement!</p>
                                        <a href="{{ route('admin.announcements.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i> Create Announcement
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($announcements->hasPages())
                    <div class="d-flex justify-content-center mt-3">
                        {{ $announcements->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .color-indicator {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: bold;
    }
</style>
@endpush