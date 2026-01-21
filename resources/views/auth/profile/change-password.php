@extends('layouts.app')

@section('title', 'Change Password - Admin Dashboard')

@section('content')
<div class="min-h-screen bg-gray-100 py-6">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="mb-6">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-green-600">
                            <i class="fas fa-tachometer-alt mr-2"></i>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                            <a href="{{ route('admin.profile.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-green-600">Profile</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Change Password</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>

        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-800">Change Password</h1>
                            <p class="text-gray-600 mt-1">Update your administrator password for enhanced security</p>
                        </div>
                        <a href="{{ route('admin.profile.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Back to Profile
                        </a>
                    </div>
                </div>

                <!-- Form -->
                <div class="p-6">
                    <form action="{{ route('admin.profile.update-password') }}" method="POST">
                        @csrf
                        
                        <div class="space-y-6 max-w-2xl">
                            <!-- Current Password -->
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                                    Current Password *
                                </label>
                                <div class="relative">
                                    <input type="password" 
                                           id="current_password" 
                                           name="current_password" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors pr-10"
                                           required>
                                    <button type="button" 
                                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600"
                                            onclick="togglePassword('current_password')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- New Password -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                    New Password *
                                </label>
                                <div class="relative">
                                    <input type="password" 
                                           id="password" 
                                           name="password" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors pr-10"
                                           required>
                                    <button type="button" 
                                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600"
                                            onclick="togglePassword('password')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <div class="mt-2 grid grid-cols-2 gap-2">
                                    <div class="flex items-center">
                                        <i class="fas fa-check text-green-500 mr-2 text-sm"></i>
                                        <span class="text-xs text-gray-600">Minimum 8 characters</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-check text-green-500 mr-2 text-sm"></i>
                                        <span class="text-xs text-gray-600">Letters and numbers</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-check text-green-500 mr-2 text-sm"></i>
                                        <span class="text-xs text-gray-600">One special character</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                    Confirm New Password *
                                </label>
                                <div class="relative">
                                    <input type="password" 
                                           id="password_confirmation" 
                                           name="password_confirmation" 
                                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors pr-10"
                                           required>
                                    <button type="button" 
                                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600"
                                            onclick="togglePassword('password_confirmation')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Password Strength -->
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Password Requirements</h4>
                                <div class="space-y-2">
                                    <div class="flex items-center">
                                        <div id="adminLengthCheck" class="w-4 h-4 rounded-full border border-gray-300 mr-2 flex items-center justify-center">
                                            <i class="fas fa-check text-white text-xs"></i>
                                        </div>
                                        <span class="text-sm text-gray-600">At least 8 characters</span>
                                    </div>
                                    <div class="flex items-center">
                                        <div id="adminMixedCheck" class="w-4 h-4 rounded-full border border-gray-300 mr-2 flex items-center justify-center">
                                            <i class="fas fa-check text-white text-xs"></i>
                                        </div>
                                        <span class="text-sm text-gray-600">Contains letters and numbers</span>
                                    </div>
                                    <div class="flex items-center">
                                        <div id="adminMatchCheck" class="w-4 h-4 rounded-full border border-gray-300 mr-2 flex items-center justify-center">
                                            <i class="fas fa-check text-white text-xs"></i>
                                        </div>
                                        <span class="text-sm text-gray-600">Passwords match</span>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div id="adminPasswordStrength" class="h-2 rounded-full transition-all duration-300"></div>
                                    </div>
                                    <p id="adminStrengthText" class="text-xs text-gray-500 mt-1"></p>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="border-t border-gray-200 pt-6">
                                <div class="flex justify-end space-x-3">
                                    <a href="{{ route('admin.profile.index') }}" class="px-6 py-3 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                                        Cancel
                                    </a>
                                    <button type="submit" 
                                            id="adminSubmitButton"
                                            class="px-6 py-3 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 disabled:opacity-50 disabled:cursor-not-allowed"
                                            disabled>
                                        <i class="fas fa-key mr-2"></i>
                                        Change Password
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
@endsection

@push('scripts')
<script>
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const type = field.getAttribute('type') === 'password' ? 'text' : 'password';
        field.setAttribute('type', type);
    }

    function checkPasswordStrength(password) {
        let strength = 0;
        
        // Check length
        if (password.length >= 8) strength++;
        if (password.length >= 12) strength++;
        
        // Check for mixed case
        if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
        
        // Check for numbers
        if (/\d/.test(password)) strength++;
        
        // Check for special characters
        if (/[^A-Za-z0-9]/.test(password)) strength++;
        
        return strength;
    }

    function updateAdminPasswordRequirements(password, confirmPassword) {
        const lengthCheck = document.getElementById('adminLengthCheck');
        const mixedCheck = document.getElementById('adminMixedCheck');
        const matchCheck = document.getElementById('adminMatchCheck');
        const passwordStrength = document.getElementById('adminPasswordStrength');
        const strengthText = document.getElementById('adminStrengthText');
        const submitButton = document.getElementById('adminSubmitButton');
        
        // Check length
        if (password.length >= 8) {
            lengthCheck.classList.add('bg-green-500', 'border-green-500');
            lengthCheck.classList.remove('border-gray-300');
        } else {
            lengthCheck.classList.remove('bg-green-500', 'border-green-500');
            lengthCheck.classList.add('border-gray-300');
        }
        
        // Check mixed characters
        if (/[a-zA-Z]/.test(password) && /\d/.test(password)) {
            mixedCheck.classList.add('bg-green-500', 'border-green-500');
            mixedCheck.classList.remove('border-gray-300');
        } else {
            mixedCheck.classList.remove('bg-green-500', 'border-green-500');
            mixedCheck.classList.add('border-gray-300');
        }
        
        // Check match
        if (password === confirmPassword && password.length > 0) {
            matchCheck.classList.add('bg-green-500', 'border-green-500');
            matchCheck.classList.remove('border-gray-300');
        } else {
            matchCheck.classList.remove('bg-green-500', 'border-green-500');
            matchCheck.classList.add('border-gray-300');
        }
        
        // Update strength meter
        const strength = checkPasswordStrength(password);
        let strengthColor, width, text;
        
        switch(strength) {
            case 0:
            case 1:
                strengthColor = 'bg-red-500';
                width = '25%';
                text = 'Very Weak';
                break;
            case 2:
                strengthColor = 'bg-orange-500';
                width = '50%';
                text = 'Weak';
                break;
            case 3:
                strengthColor = 'bg-yellow-500';
                width = '75%';
                text = 'Good';
                break;
            case 4:
            case 5:
                strengthColor = 'bg-green-500';
                width = '100%';
                text = 'Strong';
                break;
            default:
                strengthColor = 'bg-gray-300';
                width = '0%';
                text = 'Enter password';
        }
        
        passwordStrength.className = `h-2 rounded-full transition-all duration-300 ${strengthColor}`;
        passwordStrength.style.width = width;
        strengthText.textContent = text;
        
        // Enable/disable submit button
        const isValid = password.length >= 8 && 
                       /[a-zA-Z]/.test(password) && 
                       /\d/.test(password) && 
                       password === confirmPassword;
        
        submitButton.disabled = !isValid;
    }

    document.addEventListener('DOMContentLoaded', function() {
        const passwordInput = document.getElementById('password');
        const confirmInput = document.getElementById('password_confirmation');
        
        function updateChecks() {
            updateAdminPasswordRequirements(passwordInput.value, confirmInput.value);
        }
        
        passwordInput.addEventListener('input', updateChecks);
        confirmInput.addEventListener('input', updateChecks);
        
        // Initial check
        updateChecks();
    });
</script>
@endpush