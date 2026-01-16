@extends('layouts.admin')

@section('title', 'Banners')
@section('page_title', 'Banner Management')
@section('breadcrumb', 'All Banners')

@section('page_actions')
    <a href="{{ route('admin.banners.create') }}" class="btn btn-success">
        <i class="fas fa-plus me-2"></i> Create Banner
    </a>
@endsection

@section('content')
<div class="card shadow">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover data-table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Position</th>
                        <th>Status</th>
                        <th>Dates</th>
                        <th>Clicks</th>
                        <th>Order</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($banners as $banner)
                    <tr>
                        <td>
                            <img src="{{ Storage::url($banner->banner_image) }}" 
                                 class="rounded" width="80" height="40" 
                                 style="object-fit: cover;" alt="{{ $banner->alt_text }}">
                        </td>
                        <td>
                            <strong>{{ $banner->title }}</strong>
                            @if($banner->description)
                                <div class="text-muted small">{{ Str::limit($banner->description, 50) }}</div>
                            @endif
                            @if($banner->link_url)
                                <div class="small">
                                    <a href="{{ $banner->link_url }}" target="_blank">
                                        <i class="fas fa-link me-1"></i> Link
                                    </a>
                                </div>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-info">
                                {{ ucfirst(str_replace('_', ' ', $banner->position)) }}
                            </span>
                        </td>
                        <td>
                            @php
                                $now = now();
                                $statusClass = 'secondary';
                                $statusText = 'Inactive';
                                
                                if ($banner->status === 'active' && 
                                    $banner->start_date <= $now && 
                                    $banner->end_date >= $now) {
                                    $statusClass = 'success';
                                    $statusText = 'Active';
                                } elseif ($banner->start_date > $now) {
                                    $statusClass = 'warning';
                                    $statusText = 'Scheduled';
                                } elseif ($banner->end_date < $now) {
                                    $statusClass = 'danger';
                                    $statusText = 'Expired';
                                }
                            @endphp
                            <span class="badge bg-{{ $statusClass }}">
                                {{ $statusText }}
                            </span>
                        </td>
                        <td>
                            <div class="small">
                                <div>From: {{ $banner->start_date->format('M d') }}</div>
                                <div>To: {{ $banner->end_date->format('M d, Y') }}</div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-primary">{{ $banner->clicks }}</span>
                        </td>
                        <td>{{ $banner->display_order }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.banners.show', $banner) }}" 
                                   class="btn btn-sm btn-outline-primary" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.banners.edit', $banner) }}" 
                                   class="btn btn-sm btn-outline-info" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger confirm-delete" 
                                            data-item-name="Banner '{{ $banner->title }}'">
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
                Showing {{ $banners->firstItem() }} to {{ $banners->lastItem() }} of {{ $banners->total() }} entries
            </div>
            <div>
                {{ $banners->links() }}
            </div>
        </div>
    </div>
</div>
@endsection