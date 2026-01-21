@extends('layouts.app')

@section('title', 'My Profile - Ghazali Food')

@section('content')
<div class="profile-page">
    <div class="container mx-auto px-4 py-8">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">My Profile</h1>
            <p class="text-gray-600">Manage your account information and preferences</p>
        </div>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                    <span class="text-green-700">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                    <span class="text-red-700">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Sidebar Navigation -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <!-- User Info -->
                    <div class="text-center mb-6">
                        <div class="relative inline-block mb-4">
                            <img src="{{ $user->profile_image }}" 
                                 alt="{{ $user->name }}"
                                 class="w-24 h-24 rounded-full object-cover mx-auto border-4 border-white shadow-lg">
                            <button type="button" 
                                    onclick="document.getElementById('avatarInput').click()"
                                    class="absolute bottom-0 right-0 bg-blue-500 text-white p-2 rounded-full hover:bg-blue-600 transition-colors">
                                <i class="fas fa-camera text-sm"></i>
                            </button>
                        </div>
                        <h3 class="font-semibold text-gray-900">{{ $user->name }}</h3>
                        <p class="text-gray-600 text-sm">{{ $user->email }}</p>
                        @if($user->role)
                            <span class="inline-block mt-2 px-3 py-1 text-xs font-medium rounded-full 
                                @if($user->isAdmin()) bg-purple-100 text-purple-800 
                                @else bg-green-100 text-green-800 @endif">
                                {{ $user->role->name }}
                            </span>
                        @endif
                    </div>

                    <!-- Navigation -->
                    <nav class="space-y-1">
                        <a href="#personal-info" 
                           class="profile-nav-item active" 
                           data-tab="personal-info">
                            <i class="fas fa-user-circle mr-3"></i>
                            Personal Information
                        </a>
                        <a href="#shipping-address" 
                           class="profile-nav-item" 
                           data-tab="shipping-address">
                            <i class="fas fa-map-marker-alt mr-3"></i>
                            Shipping Address
                        </a>
                        <a href="#security" 
                           class="profile-nav-item" 
                           data-tab="security">
                            <i class="fas fa-shield-alt mr-3"></i>
                            Security
                        </a>
                        <a href="#notifications" 
                           class="profile-nav-item" 
                           data-tab="notifications">
                            <i class="fas fa-bell mr-3"></i>
                            Notifications
                        </a>
                        <a href="#social-profiles" 
                           class="profile-nav-item" 
                           data-tab="social-profiles">
                            <i class="fas fa-share-alt mr-3"></i>
                            Social Profiles
                        </a>
                    </nav>

                    <!-- Quick Stats -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h4 class="font-medium text-gray-900 mb-3">Quick Stats</h4>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 text-sm">Total Orders</span>
                                <span class="font-semibold">{{ $user->orderStatistics()['total_orders'] }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 text-sm">Wishlist Items</span>
                                <span class="font-semibold">{{ $user->wishlistCount() }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 text-sm">Member Since</span>
                                <span class="font-semibold">{{ $user->created_at->format('M Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="lg:col-span-3">
                <!-- Personal Information Tab -->
                <div id="personal-info" class="profile-tab active">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-xl font-bold text-gray-900">Personal Information</h2>
                            <button type="button" 
                                    onclick="enableEdit('personal-form')"
                                    class="text-blue-600 hover:text-blue-800 font-medium">
                                <i class="fas fa-edit mr-2"></i>Edit
                            </button>
                        </div>

                        <form id="personal-form" 
                              action="{{ route('profile.update') }}" 
                              method="POST"
                              enctype="multipart/form-data"
                              class="space-y-6">
                            @csrf
                            @method('PUT')
                            
                            <!-- Hidden avatar input -->
                            <input type="file" 
                                   id="avatarInput" 
                                   name="avatar" 
                                   accept="image/*"
                                   class="hidden" 
                                   onchange="previewAvatar(this)">
                            
                            <!-- Avatar Preview -->
                            <div id="avatarPreview" class="hidden text-center">
                                <img id="previewImage" 
                                     src="" 
                                     alt="Preview"
                                     class="w-32 h-32 rounded-full object-cover mx-auto mb-4">
                                <p class="text-sm text-gray-600">New profile picture preview</p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Name -->
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                        Full Name *
                                    </label>
                                    <input type="text"
                                           id="name"
                                           name="name"
                                           value="{{ old('name', $user->name) }}"
                                           required
                                           disabled
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 disabled:bg-gray-100">
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                        Email Address *
                                    </label>
                                    <input type="email"
                                           id="email"
                                           name="email"
                                           value="{{ old('email', $user->email) }}"
                                           required
                                           disabled
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 disabled:bg-gray-100">
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Phone -->
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">
                                        Phone Number
                                    </label>
                                    <input type="tel"
                                           id="phone"
                                           name="phone"
                                           value="{{ old('phone', $user->phone) }}"
                                           disabled
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 disabled:bg-gray-100">
                                    @error('phone')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Date of Birth -->
                                <div>
                                    <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-1">
                                        Date of Birth
                                    </label>
                                    <input type="date"
                                           id="date_of_birth"
                                           name="date_of_birth"
                                           value="{{ old('date_of_birth', $user->date_of_birth) }}"
                                           disabled
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 disabled:bg-gray-100">
                                </div>

                                <!-- Gender -->
                                <div>
                                    <label for="gender" class="block text-sm font-medium text-gray-700 mb-1">
                                        Gender
                                    </label>
                                    <select id="gender"
                                            name="gender"
                                            disabled
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 disabled:bg-gray-100">
                                        <option value="">Select Gender</option>
                                        <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                        <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>

                                <!-- Bio -->
                                <div class="md:col-span-2">
                                    <label for="bio" class="block text-sm font-medium text-gray-700 mb-1">
                                        Bio
                                    </label>
                                    <textarea id="bio"
                                              name="bio"
                                              rows="3"
                                              disabled
                                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 disabled:bg-gray-100">{{ old('bio', $user->bio) }}</textarea>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="flex justify-end space-x-3 pt-4 border-t border-gray-200">
                                <button type="button"
                                        onclick="disableEdit('personal-form')"
                                        class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors cancel-btn hidden">
                                    Cancel
                                </button>
                                <button type="submit"
                                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors save-btn hidden">
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Shipping Address Tab -->
                <div id="shipping-address" class="profile-tab hidden">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-xl font-bold text-gray-900">Shipping Address</h2>
                            <button type="button"
                                    onclick="showAddressForm()"
                                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                <i class="fas fa-plus mr-2"></i>Add New Address
                            </button>
                        </div>

                        <!-- Address List -->
                        <div id="addressList" class="space-y-4">
                            @forelse($user->shippingAddresses as $address)
                                <div class="border border-gray-200 rounded-lg p-4 hover:border-blue-300 transition-colors">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <div class="flex items-center mb-2">
                                                <h4 class="font-medium text-gray-900">{{ $address->name }}</h4>
                                                @if($address->is_default)
                                                    <span class="ml-3 px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">
                                                        Default
                                                    </span>
                                                @endif
                                            </div>
                                            <p class="text-gray-600">{{ $address->address_line_1 }}</p>
                                            @if($address->address_line_2)
                                                <p class="text-gray-600">{{ $address->address_line_2 }}</p>
                                            @endif
                                            <p class="text-gray-600">
                                                {{ $address->city }}, {{ $address->state }} {{ $address->postal_code }}
                                            </p>
                                            <p class="text-gray-600">{{ $address->country }}</p>
                                            <p class="text-gray-600 mt-1">
                                                <i class="fas fa-phone mr-2"></i>{{ $address->phone }}
                                            </p>
                                        </div>
                                        <div class="flex space-x-2">
                                            <button type="button"
                                                    onclick="editAddress({{ $address->id }})"
                                                    class="text-blue-600 hover:text-blue-800">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button"
                                                    onclick="deleteAddress({{ $address->id }})"
                                                    class="text-red-600 hover:text-red-800">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <i class="fas fa-map-marker-alt text-gray-300 text-4xl mb-4"></i>
                                    <p class="text-gray-600">No shipping addresses added yet.</p>
                                </div>
                            @endforelse
                        </div>

                        <!-- Address Form (Hidden by default) -->
                        <div id="addressForm" class="hidden mt-6">
                            <div class="border border-gray-200 rounded-lg p-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Add New Address</h3>
                                <form id="address-form" 
                                      action="{{ route('profile.address.store') }}" 
                                      method="POST">
                                    @csrf
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="md:col-span-2">
                                            <label for="address_name" class="block text-sm font-medium text-gray-700 mb-1">
                                                Address Name (e.g., Home, Office) *
                                            </label>
                                            <input type="text"
                                                   id="address_name"
                                                   name="name"
                                                   required
                                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>

                                        <div class="md:col-span-2">
                                            <label for="address_line_1" class="block text-sm font-medium text-gray-700 mb-1">
                                                Address Line 1 *
                                            </label>
                                            <input type="text"
                                                   id="address_line_1"
                                                   name="address_line_1"
                                                   required
                                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>

                                        <div class="md:col-span-2">
                                            <label for="address_line_2" class="block text-sm font-medium text-gray-700 mb-1">
                                                Address Line 2 (Optional)
                                            </label>
                                            <input type="text"
                                                   id="address_line_2"
                                                   name="address_line_2"
                                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>

                                        <div>
                                            <label for="address_city" class="block text-sm font-medium text-gray-700 mb-1">
                                                City *
                                            </label>
                                            <input type="text"
                                                   id="address_city"
                                                   name="city"
                                                   required
                                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>

                                        <div>
                                            <label for="address_state" class="block text-sm font-medium text-gray-700 mb-1">
                                                State/Province *
                                            </label>
                                            <input type="text"
                                                   id="address_state"
                                                   name="state"
                                                   required
                                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>

                                        <div>
                                            <label for="address_postal_code" class="block text-sm font-medium text-gray-700 mb-1">
                                                Postal Code *
                                            </label>
                                            <input type="text"
                                                   id="address_postal_code"
                                                   name="postal_code"
                                                   required
                                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>

                                        <div>
                                            <label for="address_country" class="block text-sm font-medium text-gray-700 mb-1">
                                                Country *
                                            </label>
                                            <select id="address_country"
                                                    name="country"
                                                    required
                                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                                <option value="">Select Country</option>
                                                <option value="Pakistan">Pakistan</option>
                                                <option value="USA">United States</option>
                                                <option value="UK">United Kingdom</option>
                                                <option value="Canada">Canada</option>
                                                <option value="Australia">Australia</option>
                                                <option value="UAE">United Arab Emirates</option>
                                                <option value="Saudi Arabia">Saudi Arabia</option>
                                                <!-- Add more countries as needed -->
                                            </select>
                                        </div>

                                        <div>
                                            <label for="address_phone" class="block text-sm font-medium text-gray-700 mb-1">
                                                Phone Number *
                                            </label>
                                            <input type="tel"
                                                   id="address_phone"
                                                   name="phone"
                                                   required
                                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>

                                        <div class="flex items-center">
                                            <input type="checkbox"
                                                   id="is_default"
                                                   name="is_default"
                                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                            <label for="is_default" class="ml-2 block text-sm text-gray-700">
                                                Set as default shipping address
                                            </label>
                                        </div>
                                    </div>

                                    <div class="flex justify-end space-x-3 mt-6 pt-4 border-t border-gray-200">
                                        <button type="button"
                                                onclick="hideAddressForm()"
                                                class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                                            Cancel
                                        </button>
                                        <button type="submit"
                                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                            Save Address
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Security Tab -->
                <div id="security" class="profile-tab hidden">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-6">Security Settings</h2>

                        <!-- Change Password Form -->
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Change Password</h3>
                            <form id="password-form" 
                                  action="{{ route('profile.password.update') }}" 
                                  method="POST"
                                  class="space-y-4">
                                @csrf
                                @method('PUT')
                                
                                <div>
                                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">
                                        Current Password *
                                    </label>
                                    <div class="relative">
                                        <input type="password"
                                               id="current_password"
                                               name="current_password"
                                               required
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <button type="button"
                                                onclick="togglePassword('current_password')"
                                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('current_password')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="new_password" class="block text-sm font-medium text-gray-700 mb-1">
                                        New Password *
                                    </label>
                                    <div class="relative">
                                        <input type="password"
                                               id="new_password"
                                               name="new_password"
                                               required
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <button type="button"
                                                onclick="togglePassword('new_password')"
                                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">Minimum 8 characters with letters and numbers</p>
                                    @error('new_password')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                                        Confirm New Password *
                                    </label>
                                    <div class="relative">
                                        <input type="password"
                                               id="new_password_confirmation"
                                               name="new_password_confirmation"
                                               required
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <button type="button"
                                                onclick="togglePassword('new_password_confirmation')"
                                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="pt-4">
                                    <button type="submit"
                                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                        Update Password
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Two-Factor Authentication -->
                        <div class="border-t border-gray-200 pt-6">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900">Two-Factor Authentication</h3>
                                    <p class="text-gray-600 text-sm mt-1">
                                        Add an extra layer of security to your account
                                    </p>
                                </div>
                                <div>
                                    @if($user->two_factor_enabled)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-2"></i>Enabled
                                        </span>
                                    @else
                                        <button type="button"
                                                onclick="enableTwoFactor()"
                                                class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                                            Enable 2FA
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Login History -->
                        <div class="border-t border-gray-200 pt-6 mt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Login Activity</h3>
                            <div class="space-y-3">
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div>
                                        <p class="font-medium text-gray-900">Current Session</p>
                                        <p class="text-sm text-gray-600">
                                            {{ request()->ip() }} • {{ now()->format('M d, Y H:i') }}
                                        </p>
                                    </div>
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded">
                                        Active
                                    </span>
                                </div>
                                
                                @if($user->last_login_at)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                        <div>
                                            <p class="font-medium text-gray-900">Previous Login</p>
                                            <p class="text-sm text-gray-600">
                                                {{ $user->last_login_ip }} • {{ $user->last_login_at->format('M d, Y H:i') }}
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notifications Tab -->
                <div id="notifications" class="profile-tab hidden">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-6">Notification Preferences</h2>

                        <form id="notifications-form" 
                              action="{{ route('profile.notifications.update') }}" 
                              method="POST">
                            @csrf
                            @method('PUT')

                            <div class="space-y-6">
                                <!-- Email Notifications -->
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex items-center justify-between mb-4">
                                        <div>
                                            <h3 class="text-lg font-medium text-gray-900">
                                                <i class="fas fa-envelope mr-2 text-blue-500"></i>
                                                Email Notifications
                                            </h3>
                                            <p class="text-gray-600 text-sm mt-1">
                                                Receive important updates via email
                                            </p>
                                        </div>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox"
                                                   name="notification_email"
                                                   value="1"
                                                   class="sr-only peer"
                                                   {{ $user->notification_email ? 'checked' : '' }}>
                                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                        </label>
                                    </div>

                                    <div class="space-y-3 pl-8">
                                        <label class="flex items-center">
                                            <input type="checkbox"
                                                   name="email_orders"
                                                   value="1"
                                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                                   checked>
                                            <span class="ml-3 text-gray-700">Order updates and tracking</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="checkbox"
                                                   name="email_promotions"
                                                   value="1"
                                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                                   {{ $user->newsletter_subscribed ? 'checked' : '' }}>
                                            <span class="ml-3 text-gray-700">Promotions and special offers</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="checkbox"
                                                   name="email_newsletter"
                                                   value="1"
                                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                                   {{ $user->newsletter_subscribed ? 'checked' : '' }}>
                                            <span class="ml-3 text-gray-700">Newsletter subscription</span>
                                        </label>
                                    </div>
                                </div>

                                <!-- SMS Notifications -->
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex items-center justify-between mb-4">
                                        <div>
                                            <h3 class="text-lg font-medium text-gray-900">
                                                <i class="fas fa-sms mr-2 text-green-500"></i>
                                                SMS Notifications
                                            </h3>
                                            <p class="text-gray-600 text-sm mt-1">
                                                Receive delivery updates via SMS
                                            </p>
                                        </div>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox"
                                                   name="notification_sms"
                                                   value="1"
                                                   class="sr-only peer"
                                                   {{ $user->notification_sms ? 'checked' : '' }}>
                                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                                        </label>
                                    </div>
                                </div>

                                <!-- Push Notifications -->
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex items-center justify-between mb-4">
                                        <div>
                                            <h3 class="text-lg font-medium text-gray-900">
                                                <i class="fas fa-bell mr-2 text-yellow-500"></i>
                                                Push Notifications
                                            </h3>
                                            <p class="text-gray-600 text-sm mt-1">
                                                Receive browser notifications
                                            </p>
                                        </div>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox"
                                                   name="notification_push"
                                                   value="1"
                                                   class="sr-only peer"
                                                   {{ $user->notification_push ? 'checked' : '' }}>
                                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-yellow-500"></div>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-end mt-6 pt-4 border-t border-gray-200">
                                <button type="submit"
                                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                    Save Preferences
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Social Profiles Tab -->
                <div id="social-profiles" class="profile-tab hidden">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-6">Social Profiles</h2>
                        <p class="text-gray-600 mb-6">Connect your social media accounts to share activity and make login easier.</p>

                        <form id="social-form" 
                              action="{{ route('profile.social.update') }}" 
                              method="POST"
                              class="space-y-6">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Website -->
                                <div>
                                    <label for="website" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fas fa-globe mr-2 text-blue-500"></i>
                                        Personal Website
                                    </label>
                                    <input type="url"
                                           id="website"
                                           name="website"
                                           value="{{ old('website', $user->website) }}"
                                           placeholder="https://yourwebsite.com"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                <!-- Facebook -->
                                <div>
                                    <label for="facebook_url" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fab fa-facebook mr-2 text-blue-600"></i>
                                        Facebook Profile
                                    </label>
                                    <input type="url"
                                           id="facebook_url"
                                           name="facebook_url"
                                           value="{{ old('facebook_url', $user->facebook_url) }}"
                                           placeholder="https://facebook.com/username"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                <!-- Twitter -->
                                <div>
                                    <label for="twitter_url" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fab fa-twitter mr-2 text-blue-400"></i>
                                        Twitter Profile
                                    </label>
                                    <input type="url"
                                           id="twitter_url"
                                           name="twitter_url"
                                           value="{{ old('twitter_url', $user->twitter_url) }}"
                                           placeholder="https://twitter.com/username"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                <!-- Instagram -->
                                <div>
                                    <label for="instagram_url" class="block text-sm font-medium text-gray-700 mb-1">
                                        <i class="fab fa-instagram mr-2 text-pink-500"></i>
                                        Instagram Profile
                                    </label>
                                    <input type="url"
                                           id="instagram_url"
                                           name="instagram_url"
                                           value="{{ old('instagram_url', $user->instagram_url) }}"
                                           placeholder="https://instagram.com/username"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>

                            <div class="flex justify-end pt-4 border-t border-gray-200">
                                <button type="submit"
                                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                    Save Social Profiles
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .profile-page {
        min-height: calc(100vh - 200px);
    }

    .profile-nav-item {
        display: flex;
        align-items: center;
        padding: 12px 16px;
        color: #6b7280;
        border-radius: 8px;
        transition: all 0.2s;
        text-decoration: none;
    }

    .profile-nav-item:hover {
        background-color: #f9fafb;
        color: #374151;
    }

    .profile-nav-item.active {
        background-color: #eff6ff;
        color: #1d4ed8;
        font-weight: 500;
    }

    .profile-nav-item i {
        width: 20px;
        text-align: center;
    }

    .profile-tab {
        display: none;
    }

    .profile-tab.active {
        display: block;
        animation: fadeIn 0.3s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Toggle switch styling */
    .toggle-checkbox:checked {
        right: 0;
        border-color: #2563eb;
    }
    
    .toggle-checkbox:checked + .toggle-label {
        background-color: #2563eb;
    }

    /* Password visibility toggle */
    .password-toggle {
        cursor: pointer;
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #6b7280;
    }

    .password-toggle:hover {
        color: #374151;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tab Navigation
        const navItems = document.querySelectorAll('.profile-nav-item');
        const tabs = document.querySelectorAll('.profile-tab');

        navItems.forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Remove active class from all nav items
                navItems.forEach(nav => nav.classList.remove('active'));
                
                // Add active class to clicked nav item
                this.classList.add('active');
                
                // Hide all tabs
                tabs.forEach(tab => tab.classList.remove('active'));
                
                // Show selected tab
                const tabId = this.getAttribute('data-tab');
                document.getElementById(tabId).classList.add('active');
                
                // Update URL hash
                window.location.hash = tabId;
            });
        });

        // Handle initial hash
        const hash = window.location.hash.substring(1);
        if (hash) {
            const targetNav = document.querySelector(`.profile-nav-item[data-tab="${hash}"]`);
            if (targetNav) {
                targetNav.click();
            }
        }

        // Form Edit Mode
        window.enableEdit = function(formId) {
            const form = document.getElementById(formId);
            const inputs = form.querySelectorAll('input, select, textarea');
            const cancelBtn = form.querySelector('.cancel-btn');
            const saveBtn = form.querySelector('.save-btn');
            const editBtn = form.closest('.profile-tab').querySelector('button[onclick^="enableEdit"]');

            inputs.forEach(input => {
                if (input.type !== 'file') {
                    input.disabled = false;
                }
            });

            if (cancelBtn) cancelBtn.classList.remove('hidden');
            if (saveBtn) saveBtn.classList.remove('hidden');
            if (editBtn) editBtn.classList.add('hidden');
        };

        window.disableEdit = function(formId) {
            const form = document.getElementById(formId);
            const inputs = form.querySelectorAll('input, select, textarea');
            const cancelBtn = form.querySelector('.cancel-btn');
            const saveBtn = form.querySelector('.save-btn');
            const editBtn = form.closest('.profile-tab').querySelector('button[onclick^="enableEdit"]');

            inputs.forEach(input => {
                if (input.type !== 'file') {
                    input.disabled = true;
                }
            });

            // Reset form
            form.reset();

            if (cancelBtn) cancelBtn.classList.add('hidden');
            if (saveBtn) saveBtn.classList.add('hidden');
            if (editBtn) editBtn.classList.remove('hidden');
        };

        // Avatar Preview
        window.previewAvatar = function(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                const preview = document.getElementById('avatarPreview');
                const previewImage = document.getElementById('previewImage');

                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    preview.classList.remove('hidden');
                };

                reader.readAsDataURL(input.files[0]);
            }
        };

        // Password visibility toggle
        window.togglePassword = function(inputId) {
            const input = document.getElementById(inputId);
            const button = input.parentNode.querySelector('button');
            const icon = button.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        };

        // Address Management
        window.showAddressForm = function() {
            document.getElementById('addressForm').classList.remove('hidden');
            document.getElementById('address-form').reset();
            document.getElementById('address-form').action = "{{ route('profile.address.store') }}";
        };

        window.hideAddressForm = function() {
            document.getElementById('addressForm').classList.add('hidden');
        };

        window.editAddress = function(addressId) {
            // In a real app, you would fetch address data via AJAX
            // For now, we'll just show the form
            showAddressForm();
            // Set form action for update
            document.getElementById('address-form').action = "{{ route('profile.address.update', '') }}/" + addressId;
            document.getElementById('address-form').method = "PUT";
            // You would populate form fields here with AJAX
        };

        window.deleteAddress = function(addressId) {
            if (confirm('Are you sure you want to delete this address?')) {
                fetch("{{ route('profile.address.destroy', '') }}/" + addressId, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast('Address deleted successfully', 'success');
                        // Reload the address list or remove the element
                        location.reload(); // Simple reload for now
                    } else {
                        showToast('Failed to delete address', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('Network error. Please try again.', 'error');
                });
            }
        };

        // Two-Factor Authentication
        window.enableTwoFactor = function() {
            if (confirm('Enable Two-Factor Authentication? You will need to use an authenticator app like Google Authenticator.')) {
                fetch("{{ route('profile.two-factor.enable') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast('2FA setup instructions sent to your email', 'success');
                        setTimeout(() => location.reload(), 2000);
                    } else {
                        showToast(data.message || 'Failed to enable 2FA', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('Network error. Please try again.', 'error');
                });
            }
        };

        // Form Submission with Loading
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function(e) {
                // Show loading state
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn) {
                    const originalText = submitBtn.innerHTML;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Processing...';
                    submitBtn.disabled = true;
                    
                    setTimeout(() => {
                        submitBtn.innerHTML = originalText;
                        submitBtn.disabled = false;
                    }, 3000);
                }
            });
        });
    });
</script>
@endsection