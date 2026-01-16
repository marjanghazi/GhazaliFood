<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();

            // Update last login
            Auth::user()->update(['last_login_at' => now()]);

            // Redirect based on role
            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'phone' => 'nullable|string|max:20'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role_id' => 4, // Customer role
            'status' => 'active',
            'remember_token' => null
        ]);

        Auth::login($user);

        return redirect('/')->with('success', 'Registration successful! Welcome to Ghazali Food.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    // ================ PASSWORD RESET METHODS ================

    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email'
        ], [
            'email.exists' => 'We couldn\'t find an account with that email address.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Find user
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->back()
                ->withErrors(['email' => 'Email address not found.'])
                ->withInput();
        }

        // Generate reset token
        $token = Str::random(60);

        // Save token to user
        $user->remember_token = $token;
        $user->save();

        // Generate reset URL
        $resetUrl = route('password.reset', ['token' => $token, 'email' => $user->email]);

        // For now, we'll return success with demo link
        // In production, you would send an email here
        return back()->with([
            'status' => 'Password reset link has been generated!',
            'demo_info' => '<div class="alert alert-info mt-3">
                <strong>For demo purposes only:</strong> 
                <a href="' . $resetUrl . '" class="alert-link">Click here to reset password</a>
                <br><small>In production, this link would be sent to your email.</small>
            </div>'
        ]);

        // ========== EMAIL SENDING CODE (FOR PRODUCTION) ==========
        // Uncomment this section when you want to send actual emails

        /*
        try {
            Mail::send('emails.password-reset', [
                'user' => $user,
                'resetUrl' => $resetUrl
            ], function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Password Reset Request - Ghazali Food');
            });
            
            return back()->with('status', 'Password reset link sent to your email!');
        } catch (\Exception $e) {
            return back()->withErrors([
                'email' => 'Failed to send email. Please try again later.'
            ]);
        }
        */
    }

    public function showResetForm(Request $request, $token = null)
    {
        // Validate token
        if (!$token) {
            return redirect()->route('password.request')
                ->withErrors(['token' => 'Reset token is required.']);
        }

        // Find user by token
        $user = User::where('remember_token', $token)->first();

        if (!$user) {
            return redirect()->route('password.request')
                ->withErrors(['token' => 'Invalid or expired reset token.']);
        }

        // Check if token is older than 1 hour (optional)
        if ($user->updated_at && $user->updated_at->diffInHours(now()) > 1) {
            $user->remember_token = null;
            $user->save();

            return redirect()->route('password.request')
                ->withErrors(['token' => 'Reset token has expired. Please request a new one.']);
        }

        return view('auth.passwords.reset')->with([
            'token' => $token,
            'email' => $request->email ?? $user->email
        ]);
    }

    public function reset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ], [
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Password confirmation does not match.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Find user by email and token
        $user = User::where('email', $request->email)
            ->where('remember_token', $request->token)
            ->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Invalid token or email address.'
            ])->withInput();
        }

        // Update password
        $user->password = Hash::make($request->password);
        $user->remember_token = null; // Clear the token after use
        $user->save();

        // Optionally login the user automatically
        // Auth::login($user);

        return redirect()->route('login')
            ->with('success', 'Password reset successfully! You can now login with your new password.');
    }

    // ================ ADDITIONAL HELPER METHODS ================

    public function showResetSuccess()
    {
        return view('auth.passwords.reset-success');
    }

    public function validateResetToken(Request $request)
    {
        $user = User::where('remember_token', $request->token)
            ->where('email', $request->email)
            ->first();

        if ($user) {
            return response()->json(['valid' => true]);
        }

        return response()->json(['valid' => false], 404);
    }
}
