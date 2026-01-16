<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Validation\Rules;

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
            
            // Redirect based on user role
            if (Auth::user()->role_id == 1) { // Admin
                return redirect()->intended(route('admin.dashboard'));
            }
            
            return redirect()->intended(route('home'))->with('success', 'Welcome back!');
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
            'status' => 'active'
        ]);

        event(new Registered($user));

        Auth::login($user);

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
        return view('auth.profile', [
            'title' => 'My Profile - Nuts & Berries',
            'user' => Auth::user()
        ]);
    }

    // Update User Profile
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500'
        ]);

        $user->update($request->only('name', 'email', 'phone', 'address'));

        return back()->with('success', 'Profile updated successfully!');
    }

    // Show User Orders
    public function orders()
    {
        $orders = Auth::user()->orders()->latest()->paginate(10);
        
        return view('auth.orders', [
            'title' => 'My Orders - Nuts & Berries',
            'orders' => $orders
        ]);
    }

    // Show Order Details
    public function orderDetails($id)
    {
        $order = Auth::user()->orders()->with('items.product')->findOrFail($id);
        
        return view('auth.order-details', [
            'title' => 'Order #' . $order->order_number . ' - Nuts & Berries',
            'order' => $order
        ]);
    }
}