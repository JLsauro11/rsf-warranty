<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Mail\NotificationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;



class AuthController extends Controller
{
    public function login(Request $request)
    {
        if ($request->ajax()) {
            $credentials = $request->only('username', 'password');
            $username = $credentials['username'];

            // Case-sensitive lookup for binary charset columns
            $user = User::whereRaw('username = BINARY ?', [$username])->first();
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found.'
                ], 401);
            }

            // Manual case-sensitive password check + login
            if (Hash::check($credentials['password'], $user->password)) {
                Auth::login($user);

                $redirectUrl = match ($user->role) {
                'admin' => route('admin.index'),
                'csr_rs8' => route('csr_rs8.index'),
                'csr_srf' => route('csr_srf.index'),
                default => route('login'),
            };

            $request->session()->regenerate();

            return response()->json([
                'success' => true,
                'message' => 'Logged in successfully.',
                'redirect_url' => $redirectUrl,
            ]);
        }

            return response()->json([
                'success' => false,
                'message' => 'Invalid password.'
            ], 401);
        }

        return view('auth.login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Check if request expects JSON (AJAX)
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Logged out successfully.',
                'redirect_url' => route('login')
            ]);
        }

        // Non-AJAX: redirect directly
        return redirect()->route('login');
    }


    public function forgot_password()
    {
        return view('auth.forgot-password');
    }

    public function verify_submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'validation' => true, 'errors' => $validator->errors()->first()]);
        }

        $user = User::where('email', $request->email)->first();
        $verificationCode = Str::random(6);
        $user->verification_code = $verificationCode;
        $user->verification_expires_at = now()->addMinutes(5);
        $user->save();

        // Store verification data in session
        $request->session()->put([
            'password_reset_email' => $user->email,
            'verification_code_sent_at' => now(),
        ]);

        $data = [
            'subject' => 'Password Reset Verification Code',
            'template' => 'email.confirmation',
            'verification_code' => $verificationCode,
            'expires_at' => $user->verification_expires_at->format('Y-m-d H:i A'),
            'user_name' => $user->username,
        ];

        Mail::to($user->email)->send(new NotificationMail($data));

        return response()->json([
            'message' => 'Verification code sent to your email.',
            'redirect' => route('change-password-submit')
        ]);
    }


    public function change_password_submit(Request $request)
    {
        // Check if user has valid verification session first
        if (!$request->session()->has('password_reset_email')) {
            return redirect()->route('forgot-password')
                ->with('error', 'Please request a verification code first.');
        }

        $email = $request->session()->get('password_reset_email');
        $user = User::where('email', $email)->first();

        // FIXED: Proper null/expiration check
        if (!$user ||
            !$user->verification_code ||
            !$user->verification_expires_at ||
            now()->gte($user->verification_expires_at)) {  // Use gte() instead of greaterThan()

            $request->session()->forget(['password_reset_email', 'verification_code_sent_at']);
            return redirect()->route('forgot-password')
                ->with('error', 'Verification code has expired or was already used. Please request a new one.');
        }

        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'verification_code' => 'required|string',
                'password' => 'required|string|min:8|confirmed',
            ]);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'validation' => true, 'errors' => $validator->errors()->first()]);
            }

            // Check submitted code matches database
            if ($request->verification_code !== $user->verification_code) {
                return response()->json([
                    'status' => false,
                    'validation' => true,
                    'errors' => 'Invalid verification code.',
                ]);
            }

            // Final expiration check
            if (now()->gte($user->verification_expires_at)) {
                $request->session()->forget(['password_reset_email', 'verification_code_sent_at']);
                return response()->json([
                    'status' => false,
                    'validation' => true,
                    'errors' => 'Verification code has expired. Please request a new one.',
                ]);
            }

            $user->password = Hash::make($request->password);
            $user->verification_code = null;
            $user->verification_expires_at = null;
            $user->save();

            $request->session()->forget(['password_reset_email', 'verification_code_sent_at']);

            return response()->json([
                'status' => true,
                'validation' => false,
                'message' => 'Password updated successfully!',
                'redirect' => route('login'),
            ]);
        }

        return view('auth.change-password');
    }




}

