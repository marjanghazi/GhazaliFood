<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ShippingAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    // Show Login Form
    public function showLogin()
    {
        return view('auth.login', [
            'title' => 'Login - Nuts & Berries'
        ]);
    }

    // Handle Login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            // Record login activity
            Auth::user()->recordLogin($request->ip());
            
            // Redirect based on user role
            if (Auth::user()->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'))
                    ->with('success', 'Welcome back, ' . Auth::user()->name . '!');
            }
            
            return redirect()->intended(route('home'))
                ->with('success', 'Welcome back, ' . Auth::user()->name . '!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    // Show Registration Form
    public function showRegister()
    {
        return view('auth.register', [
            'title' => 'Register - Nuts & Berries'
        ]);
    }

    // Handle Registration
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone' => 'nullable|string|max:20',
            'agree_terms' => 'required|accepted'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role_id' => 3, // Default customer role
            'status' => 'active',
            'newsletter_subscribed' => $request->has('newsletter')
        ]);

        event(new Registered($user));

        Auth::login($user);
        
        // Record first login
        Auth::user()->recordLogin($request->ip());

        return redirect(route('home'))->with('success', 'Account created successfully! Welcome to Nuts & Berries!');
    }

    // Handle Logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'You have been logged out successfully.');
    }

    // Show Forgot Password Form
    public function showForgotPassword()
    {
        return view('auth.forgot-password', [
            'title' => 'Forgot Password - Nuts & Berries'
        ]);
    }

    // Send Password Reset Link
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    // Show Reset Password Form
    public function showResetPassword(Request $request)
    {
        return view('auth.reset-password', [
            'title' => 'Reset Password - Nuts & Berries',
            'token' => $request->token,
            'email' => $request->email
        ]);
    }

    // Handle Password Reset
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    // Show User Profile
    public function profile()
    {
        $user = Auth::user();
        $shippingAddresses = $user->shippingAddresses()->latest()->get();
        $orders = $user->orders()->latest()->take(5)->get();
        $wishlistCount = $user->wishlistCount();
        
        return view('auth.profile.index', [
            'title' => 'My Profile - Nuts & Berries',
            'user' => $user,
            'shippingAddresses' => $shippingAddresses,
            'orders' => $orders,
            'wishlistCount' => $wishlistCount
        ]);
    }

    // Update User Profile
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', 
                       Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date|before:today',
            'gender' => 'nullable|in:male,female,other',
            'newsletter_subscribed' => 'boolean',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->only([
            'name', 'email', 'phone', 'address', 'city', 
            'state', 'country', 'postal_code', 'date_of_birth',
            'gender', 'newsletter_subscribed'
        ]);

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($user->profile_image && Storage::exists($user->profile_image)) {
                Storage::delete($user->profile_image);
            }
            
            $path = $request->file('profile_image')->store('profile-images', 'public');
            $data['profile_image'] = $path;
        }

        $user->update($data);

        return redirect()->route('profile.edit')
            ->with('success', 'Profile updated successfully!');
    }

    // Show Change Password Form
    public function showChangePasswordForm()
    {
        return view('auth.profile.change-password', [
            'title' => 'Change Password - Nuts & Berries',
            'user' => Auth::user()
        ]);
    }

    // Update Password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = Auth::user();
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('profile.edit')
            ->with('success', 'Password updated successfully!');
    }

    // Show User Orders
    public function orders()
    {
        $orders = Auth::user()->orders()->latest()->paginate(10);
        
        return view('auth.profile.orders', [
            'title' => 'My Orders - Nuts & Berries',
            'orders' => $orders
        ]);
    }

    // Show Order Details
    public function orderDetails($id)
    {
        $order = Auth::user()->orders()->with(['items.product', 'statusHistory'])->findOrFail($id);
        
        return view('auth.profile.order-details', [
            'title' => 'Order #' . $order->order_number . ' - Nuts & Berries',
            'order' => $order
        ]);
    }

    // Shipping Address Management
    public function shippingAddresses()
    {
        $addresses = Auth::user()->shippingAddresses()->latest()->get();
        
        return view('auth.profile.shipping-addresses', [
            'title' => 'Shipping Addresses - Nuts & Berries',
            'addresses' => $addresses
        ]);
    }

    public function createShippingAddress()
    {
        return view('auth.profile.address-form', [
            'title' => 'Add New Address - Nuts & Berries',
            'address' => null
        ]);
    }

    public function storeShippingAddress(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address_line_1' => 'required|string|max:500',
            'address_line_2' => 'nullable|string|max:500',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'is_default' => 'boolean',
            'address_type' => 'nullable|in:home,office,other'
        ]);

        $user = Auth::user();
        
        // If this is set as default, unset other defaults
        if ($request->is_default) {
            $user->shippingAddresses()->update(['is_default' => false]);
        }

        $address = $user->shippingAddresses()->create($request->all());

        return redirect()->route('profile.shipping-addresses')
            ->with('success', 'Shipping address added successfully!');
    }

    public function editShippingAddress($id)
    {
        $address = Auth::user()->shippingAddresses()->findOrFail($id);
        
        return view('auth.profile.address-form', [
            'title' => 'Edit Address - Nuts & Berries',
            'address' => $address
        ]);
    }

    public function updateShippingAddress(Request $request, $id)
    {
        $address = Auth::user()->shippingAddresses()->findOrFail($id);
        
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address_line_1' => 'required|string|max:500',
            'address_line_2' => 'nullable|string|max:500',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'is_default' => 'boolean',
            'address_type' => 'nullable|in:home,office,other'
        ]);

        // If this is set as default, unset other defaults
        if ($request->is_default) {
            Auth::user()->shippingAddresses()
                ->where('id', '!=', $id)
                ->update(['is_default' => false]);
        }

        $address->update($request->all());

        return redirect()->route('profile.shipping-addresses')
            ->with('success', 'Shipping address updated successfully!');
    }

    public function destroyShippingAddress($id)
    {
        $address = Auth::user()->shippingAddresses()->findOrFail($id);
        $address->delete();

        return redirect()->route('profile.shipping-addresses')
            ->with('success', 'Shipping address deleted successfully!');
    }

    // Wishlist
    public function wishlist()
    {
        $wishlistItems = Auth::user()->wishlistItems()->with('product')->paginate(12);
        
        return view('auth.profile.wishlist', [
            'title' => 'My Wishlist - Nuts & Berries',
            'wishlistItems' => $wishlistItems
        ]);
    }
}