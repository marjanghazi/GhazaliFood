@extends('layouts.app')

@section('title', 'Admin Profile - Ghazali Food')

@section('content')
<div class="admin-profile-page">
    <div class="container mx-auto px-4 py-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Admin Profile</h1>
            <p class="text-gray-600">Manage your administrator account</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <!-- Admin Info -->
                    <div class="text-center mb-6">
                        <img src="{{ $user->profile_image }}" 
                             alt="{{ $user->name }}"
                             class="w-24 h-24 rounded-full object-cover mx-auto mb-4 border-4 border-white shadow-lg">
                        <h3 class="font-semibold text-gray-900">{{ $user->name }}</h3>
                        <p class="text-gray-600 text-sm">{{ $user->email }}</p>
                        <span class="inline-block mt-2 px-3 py-1 bg-purple-100 text-purple-800 text-xs font-medium rounded-full">
                            Administrator
                        </span>
                    </div>

                    <!-- Admin Navigation -->
                    <nav class="space-y-1">
                        <a href="{{ route('admin.dashboard') }}"
                           class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">
                            <i class="fas fa-tachometer-alt mr-3"></i>
                            Dashboard
                        </a>
                        <a href="#admin-info"
                           class="admin-nav-item active"
                           data-tab="admin-info">
                            <i class="fas fa-user-shield mr-3"></i>
                            Admin Information
                        </a>
                        <a href="#admin-settings"
                           class="admin-nav-item"
                           data-tab="admin-settings">
                            <i class="fas fa-cog mr-3"></i>
                            Settings
                        </a>
                        <a href="{{ route('admin.notifications.index') }}"
                           class="flex items-center px-4 py-3 text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">
                            <i class="fas fa-bell mr-3"></i>
                            Notifications
                            @php
                                $unreadCount = Auth::user()->unreadNotifications()->count();
                            @endphp
                            @if($unreadCount > 0)
                                <span class="ml-auto bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                                    {{ $unreadCount }}
                                </span>
                            @endif
                        </a>
                    </nav>

                    <!-- Admin Stats -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h4 class="font-medium text-gray-900 mb-3">Admin Stats</h4>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 text-sm">Last Login</span>
                                <span class="font-medium">
                                    {{ $user->last_login_at ? $user->last_login_at->format('M d, Y') : 'Never' }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 text-sm">Login Count</span>
                                <span class="font-medium">{{ $user->login_count }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 text-sm">Admin Since</span>
                                <span class="font-medium">{{ $user->created_at->format('M Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:col-span-3">
                <!-- Admin Info Tab -->
                <div id="admin-info" class="admin-tab active">
                    @include('auth.profile') {{-- Reuse the regular profile form --}}
                </div>

                <!-- Admin Settings Tab -->
                <div id="admin-settings" class="admin-tab hidden">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-6">Admin Settings</h2>
                        
                        <!-- System Information -->
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">System Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <p class="text-sm text-gray-600">PHP Version</p>
                                    <p class="font-medium">{{ phpversion() }}</p>
                                </div>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <p class="text-sm text-gray-600">Laravel Version</p>
                                    <p class="font-medium">{{ app()->version() }}</p>
                                </div>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <p class="text-sm text-gray-600">Database</p>
                                    <p class="font-medium">{{ config('database.default') }}</p>
                                </div>
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <p class="text-sm text-gray-600">Environment</p>
                                    <p class="font-medium">{{ app()->environment() }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Admin Actions -->
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Admin Actions</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                <a href="{{ route('admin.settings.cache.clear') }}"
                                   class="flex flex-col items-center justify-center p-4 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 transition-colors">
                                    <i class="fas fa-broom text-blue-600 text-xl mb-2"></i>
                                    <span class="font-medium text-blue-900">Clear Cache</span>
                                </a>
                                <a href="{{ route('admin.settings.backup') }}"
                                   class="flex flex-col items-center justify-center p-4 bg-green-50 border border-green-200 rounded-lg hover:bg-green-100 transition-colors">
                                    <i class="fas fa-database text-green-600 text-xl mb-2"></i>
                                    <span class="font-medium text-green-900">Backup Database</span>
                                </a>
                                <a href="{{ route('admin.settings.logs') }}"
                                   class="flex flex-col items-center justify-center p-4 bg-purple-50 border border-purple-200 rounded-lg hover:bg-purple-100 transition-colors">
                                    <i class="fas fa-file-alt text-purple-600 text-xl mb-2"></i>
                                    <span class="font-medium text-purple-900">View Logs</span>
                                </a>
                            </div>
                        </div>

                        <!-- Activity Log -->
                        <div class="border-t border-gray-200 pt-6 mt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Activity</h3>
                            <div class="space-y-3">
                                @php
                                    // In a real app, fetch from audit logs
                                    $activities = [
                                        ['action' => 'Login', 'time' => now()->subMinutes(30)],
                                        ['action' => 'Updated product', 'time' => now()->subHours(2)],
                                        ['action' => 'Processed order', 'time' => now()->subHours(5)],
                                    ];
                                @endphp
                                
                                @foreach($activities as $activity)
                                    <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                            <i class="fas fa-history text-blue-600"></i>
                                        </div>
                                        <div class="flex-grow">
                                            <p class="font-medium text-gray-900">{{ $activity['action'] }}</p>
                                            <p class="text-sm text-gray-600">
                                                {{ $activity['time']->diffForHumans() }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .admin-profile-page {
        min-height: calc(100vh - 200px);
    }

    .admin-nav-item {
        display: flex;
        align-items: center;
        padding: 12px 16px;
        color: #6b7280;
        border-radius: 8px;
        transition: all 0.2s;
        text-decoration: none;
    }

    .admin-nav-item:hover {
        background-color: #f9fafb;
        color: #374151;
    }

    .admin-nav-item.active {
        background-color: #eef2ff;
        color: #4f46e5;
        font-weight: 500;
    }

    .admin-tab {
        display: none;
    }

    .admin-tab.active {
        display: block;
        animation: fadeIn 0.3s ease-in-out;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Admin Tab Navigation
        const adminNavItems = document.querySelectorAll('.admin-nav-item');
        const adminTabs = document.querySelectorAll('.admin-tab');

        adminNavItems.forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                
                adminNavItems.forEach(nav => nav.classList.remove('active'));
                this.classList.add('active');
                
                adminTabs.forEach(tab => tab.classList.remove('active'));
                
                const tabId = this.getAttribute('data-tab');
                document.getElementById(tabId).classList.add('active');
            });
        });
    });
</script>
@endsection