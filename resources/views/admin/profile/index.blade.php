@extends('layouts.app')

@section('title', 'Admin Profile - Dashboard')

@section('content')
<div class="min-h-screen bg-gray-100 py-6">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Admin Profile</h1>
            <p class="text-gray-600">Manage your administrator account settings</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <!-- Profile Card -->
                    <div class="text-center mb-6">
                        <div class="relative inline-block mb-4">
                            <div class="w-32 h-32 rounded-full bg-gradient-to-r from-green-400 to-emerald-500 flex items-center justify-center text-white text-3xl font-bold mx-auto overflow-hidden">
                                @if(auth()->user()->profile_image_url)
                                    <img src="{{ auth()->user()->profile_image_url }}" alt="{{ auth()->user()->name }}" class="w-full h-full object-cover">
                                @else
                                    {{ auth()->user()->initials }}
                                @endif
                            </div>
                            <div class="absolute bottom-2 right-6 w-8 h-8 bg-green-500 rounded-full border-2 border-white flex items-center justify-center">
                                <i class="fas fa-crown text-white text-sm"></i>
                            </div>
                        </div>
                        <h2 class="text-xl font-bold text-gray-800">{{ auth()->user()->name }}</h2>
                        <p class="text-gray-600">{{ auth()->user()->email }}</p>
                        <div class="mt-2">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <i class="fas fa-user-shield mr-1"></i>
                                {{ auth()->user()->role->name ?? 'Administrator' }}
                            </span>
                        </div>
                    </div>

                    <!-- Stats -->
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-calendar-day text-green-500 mr-3"></i>
                                <span class="text-sm text-gray-700">Member Since</span>
                            </div>
                            <span class="text-sm font-medium text-gray-800">{{ auth()->user()->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-sign-in-alt text-blue-500 mr-3"></i>
                                <span class="text-sm text-gray-700">Last Login</span>
                            </div>
                            <span class="text-sm font-medium text-gray-800">{{ auth()->user()->last_login_at ? auth()->user()->last_login_at->diffForHumans() : 'Never' }}</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-chart-line text-purple-500 mr-3"></i>
                                <span class="text-sm text-gray-700">Login Count</span>
                            </div>
                            <span class="text-sm font-medium text-gray-800">{{ auth()->user()->login_count }}</span>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h3 class="text-sm font-semibold text-gray-700 mb-3">Quick Actions</h3>
                        <div class="space-y-2">
                            <a href="{{ route('admin.profile.index') }}" 
                               class="flex items-center px-3 py-2 text-sm rounded-lg bg-green-50 text-green-700 border border-green-200">
                                <i class="fas fa-user-edit mr-2"></i>
                                Edit Profile
                            </a>
                            <a href="{{ route('admin.profile.change-password') }}" 
                               class="flex items-center px-3 py-2 text-sm rounded-lg text-gray-700 hover:bg-gray-50">
                                <i class="fas fa-key mr-2"></i>
                                Change Password
                            </a>
                            <a href="{{ route('admin.dashboard') }}" 
                               class="flex items-center px-3 py-2 text-sm rounded-lg text-gray-700 hover:bg-gray-50">
                                <i class="fas fa-tachometer-alt mr-2"></i>
                                Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="lg:col-span-2">
                <!-- Profile Edit Form -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
                    <div class="border-b border-gray-200 px-6 py-4">
                        <h3 class="text-lg font-semibold text-gray-800">Profile Information</h3>
                        <p class="text-sm text-gray-600">Update your account's profile information</p>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="space-y-6">
                                <!-- Profile Image -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Profile Image</label>
                                    <div class="flex items-center space-x-6">
                                        <div class="relative">
                                            <div class="w-20 h-20 rounded-full bg-gradient-to-r from-green-400 to-emerald-500 flex items-center justify-center text-white text-xl font-bold overflow-hidden">
                                                @if(auth()->user()->profile_image_url)
                                                    <img id="adminProfilePreview" src="{{ auth()->user()->profile_image_url }}" alt="{{ auth()->user()->name }}" class="w-full h-full object-cover">
                                                @else
                                                    <span id="adminInitials">{{ auth()->user()->initials }}</span>
                                                @endif
                                            </div>
                                            <label for="admin_profile_image" class="absolute bottom-0 right-0 w-6 h-6 bg-green-500 rounded-full border-2 border-white flex items-center justify-center cursor-pointer hover:bg-green-600">
                                                <i class="fas fa-camera text-white text-xs"></i>
                                            </label>
                                        </div>
                                        <div>
                                            <input type="file" 
                                                   id="admin_profile_image" 
                                                   name="profile_image" 
                                                   class="hidden"
                                                   accept="image/*">
                                            <div>
                                                <p class="text-sm text-gray-600">Click the camera icon to upload</p>
                                                <p class="text-xs text-gray-500">Max 2MB, JPG/PNG/GIF</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Form Fields -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="admin_name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                                        <input type="text" 
                                               id="admin_name" 
                                               name="name" 
                                               value="{{ old('name', auth()->user()->name) }}"
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                               required>
                                    </div>

                                    <div>
                                        <label for="admin_email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                                        <input type="email" 
                                               id="admin_email" 
                                               name="email" 
                                               value="{{ old('email', auth()->user()->email) }}"
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                               required>
                                    </div>

                                    <div>
                                        <label for="admin_phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                                        <input type="tel" 
                                               id="admin_phone" 
                                               name="phone" 
                                               value="{{ old('phone', auth()->user()->phone) }}"
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Account Status</label>
                                        <div class="px-4 py-2 bg-gray-100 rounded-lg">
                                            <span class="inline-flex items-center">
                                                <i class="fas fa-circle text-green-500 mr-2 text-xs"></i>
                                                <span class="text-sm font-medium text-gray-800">{{ ucfirst(auth()->user()->status) }}</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Save Button -->
                                <div class="pt-6 border-t border-gray-200">
                                    <div class="flex justify-end">
                                        <button type="submit" 
                                                class="px-6 py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                            <i class="fas fa-save mr-2"></i>
                                            Save Changes
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Change Password Form -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                    <div class="border-b border-gray-200 px-6 py-4">
                        <h3 class="text-lg font-semibold text-gray-800">Security Settings</h3>
                        <p class="text-sm text-gray-600">Update your password to keep your account secure</p>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('admin.profile.change-password') }}" method="POST">
                            @csrf
                            
                            <div class="space-y-6">
                                <div>
                                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Current Password</label>
                                    <input type="password" 
                                           id="current_password" 
                                           name="current_password" 
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                           required>
                                </div>

                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                                    <input type="password" 
                                           id="password" 
                                           name="password" 
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                           required>
                                    <p class="mt-1 text-xs text-gray-500">Minimum 8 characters with letters and numbers</p>
                                </div>

                                <div>
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
                                    <input type="password" 
                                           id="password_confirmation" 
                                           name="password_confirmation" 
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                           required>
                                </div>

                                <!-- Update Button -->
                                <div class="pt-6 border-t border-gray-200">
                                    <div class="flex justify-end">
                                        <button type="submit" 
                                                class="px-6 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            <i class="fas fa-key mr-2"></i>
                                            Update Password
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Admin profile image preview
        const adminProfileInput = document.getElementById('admin_profile_image');
        const adminProfilePreview = document.getElementById('adminProfilePreview');
        const adminInitials = document.getElementById('adminInitials');
        
        if (adminProfileInput) {
            adminProfileInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        if (adminProfilePreview) {
                            adminProfilePreview.src = e.target.result;
                            adminProfilePreview.style.display = 'block';
                        }
                        if (adminInitials) {
                            adminInitials.style.display = 'none';
                        }
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    });
</script>
@endpush