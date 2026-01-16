@extends('layouts.admin')

@section('title', 'View Banner')
@section('page_title', 'Banners')
@section('breadcrumb', 'View Banner')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Banner Details</h5>
                <div>
                    <a href="{{ route('admin.banners.edit', $banner) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>
                    <a href="{{ route('admin.banners.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Back
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Banner Information</h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <tr>
                                        <th style="width: 30%">Title:</th>
                                        <td>{{ $banner->title }}</td>
                                    </tr>
                                    <tr>
                                        <th>Description:</th>
                                        <td>{{ $banner->description ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Position:</th>
                                        <td>
                                            <span class="badge bg-primary">
                                                {{ ucfirst(str_replace('_', ' ', $banner->position)) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Display Order:</th>
                                        <td>{{ $banner->display_order }}</td>
                                    </tr>
                                    <tr>
                                        <th>Link URL:</th>
                                        <td>
                                            @if($banner->link_url)
                                                <a href="{{ $banner->link_url }}" target="_blank">
                                                    {{ $banner->link_url }}
                                                </a>
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Alt Text:</th>
                                        <td>{{ $banner->alt_text ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Clicks:</th>
                                        <td>{{ $banner->clicks }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- Banner Image -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Banner Image</h6>
                            </div>
                            <div class="card-body text-center">
                                @if($banner->banner_image)
                                    <img src="{{ asset('storage/' . $banner->banner_image) }}" 
                                         class="img-fluid rounded mb-3" alt="{{ $banner->alt_text }}" style="max-height: 300px;">
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <!-- Status Card -->
                        <div class="card mb-3">
                            <div class="card-header">
                                <h6 class="mb-0">Status & Dates</h6>
                            </div>
                            <div class="card-body">
                                <p><strong>Status:</strong><br>
                                    @php
                                        $now = now();
                                        $isActive = $banner->status == 'active' && 
                                                   $now->between($banner->start_date, $banner->end_date);
                                        $isScheduled = $now->lt($banner->start_date);
                                        $isExpired = $now->gt($banner->end_date);
                                    @endphp
                                    <span class="badge bg-{{ $isActive ? 'success' : ($isScheduled ? 'info' : ($isExpired ? 'danger' : 'warning')) }}">
                                        {{ $isActive ? 'Active' : ($isScheduled ? 'Scheduled' : ($isExpired ? 'Expired' : ucfirst($banner->status))) }}
                                    </span>
                                </p>
                                <p><strong>Start Date:</strong><br>
                                   {{ $banner->start_date->format('M d, Y h:i A') }}</p>
                                <p><strong>End Date:</strong><br>
                                   {{ $banner->end_date->format('M d, Y h:i A') }}</p>
                                <p><strong>Days Remaining:</strong><br>
                                   @php
                                       $daysRemaining = $now->diffInDays($banner->end_date, false);
                                   @endphp
                                   @if($daysRemaining > 0)
                                       <span class="text-success">{{ $daysRemaining }} days</span>
                                   @elseif($daysRemaining == 0)
                                       <span class="text-warning">Ends today</span>
                                   @else
                                       <span class="text-danger">Ended {{ abs($daysRemaining) }} days ago</span>
                                   @endif
                                </p>
                            </div>
                        </div>

                        <!-- Mobile Banner Image -->
                        @if($banner->banner_mobile_image)
                        <div class="card mb-3">
                            <div class="card-header">
                                <h6 class="mb-0">Mobile Banner Image</h6>
                            </div>
                            <div class="card-body text-center">
                                <img src="{{ asset('storage/' . $banner->banner_mobile_image) }}" 
                                     class="img-fluid rounded" alt="{{ $banner->alt_text }}" style="max-height: 200px;">
                            </div>
                        </div>
                        @endif

                        <!-- Creation Info -->
                        <div class="card mb-3">
                            <div class="card-header">
                                <h6 class="mb-0">Creation Info</h6>
                            </div>
                            <div class="card-body">
                                <p><strong>Created By:</strong><br>
                                   {{ $banner->creator->name ?? 'System' }}</p>
                                <p><strong>Created At:</strong><br>
                                   {{ $banner->created_at->format('M d, Y h:i A') }}</p>
                                <p><strong>Last Updated:</strong><br>
                                   {{ $banner->updated_at->format('M d, Y h:i A') }}</p>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Quick Actions</h6>
                            </div>
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" 
                                          class="d-grid">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" 
                                                onclick="return confirm('Are you sure you want to delete this banner?');">
                                            <i class="fas fa-trash me-1"></i> Delete Banner
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