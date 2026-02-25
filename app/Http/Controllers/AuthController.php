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
use Carbon\Carbon;



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


    public function forgot_password(Request $request)
    {
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:users,email',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()->first()
                ], 422);
            }

            $user = User::where('email', trim($request->email))->first();
            $verificationCode = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

            $user->verification_code = $verificationCode;
            $user->verification_expires_at = now()->addMinutes(5);
            $user->save();

            // Store with timestamp for double security
            session([
                'reset_email' => $user->email,
                'reset_requested_at' => now()
            ]);

            $data = [
                'subject' => 'Password Reset Verification Code',
                'template' => 'email.confirmation',
                'verification_code' => $verificationCode,
                'expires_at' => $user->verification_expires_at->format('M d, Y g:i A'),
                'user_name' => $user->username ?? $user->name ?? 'User',
            ];

            try {
                Mail::to($user->email)->send(new NotificationMail($data));
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Failed to send email. Please try again.'
                ], 500);
            }

            return response()->json([
                'status' => true,
                'message' => 'Verification code sent to your email.',
                'redirect' => route('change-password')
            ]);
        }

        return view('auth.forgot-password');
    }

    public function change_password()
    {
        $email = session('reset_email');
        $requestedAt = session('reset_requested_at');

        // Check session exists
        if (!$email || !$requestedAt) {
            session()->forget(['reset_email', 'reset_requested_at']);
            return redirect()->route('forgot-password')
                ->with('error', 'Session expired. Please request new code.');
        }

        // Session timeout: 10 minutes max
        if (now()->diffInMinutes($requestedAt) > 10) {
            session()->forget(['reset_email', 'reset_requested_at']);
            return redirect()->route('forgot-password')
                ->with('error', 'Session expired. Please request new code.');
        }

        // Double-check database expiry
        $user = User::where('email', trim($email))
            ->whereNotNull('verification_code')
            ->whereNotNull('verification_expires_at')
            ->where('verification_expires_at', '>', now())
            ->first();

        if (!$user) {
            session()->forget(['reset_email', 'reset_requested_at']);
            return redirect()->route('forgot-password')
                ->with('error', 'Verification code expired. Please request new code.');
        }

        return view('auth.change-password', [
            'email' => $email,
            'expires_at' => $user->verification_expires_at
        ]);
    }

    public function change_password_submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'verification_code' => 'required|string|size:6',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $email = session('reset_email');
        if (!$email) {
            return response()->json([
                'status' => false,
                'message' => 'Session expired. Please request new code.'
            ], 400);
        }

        $user = User::where('email', trim($email))
            ->whereRaw('CAST(verification_code AS CHAR) = ?', [trim($request->verification_code)])
            ->where('verification_expires_at', '>', now())
            ->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid or expired verification code.'
            ], 400);
        }

        $user->update([
            'password' => Hash::make($request->password),
            'verification_code' => null,
            'verification_expires_at' => null,
        ]);

        session()->forget(['reset_email', 'reset_requested_at']);

        return response()->json([
            'status' => true,
            'message' => 'Password updated successfully!',
            'redirect' => route('login'),
        ]);
    }
}

