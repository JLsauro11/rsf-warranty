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

            if (Auth::attempt($credentials)) {
                $user = Auth::user();

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

            return response()->json(['success' => false, 'message' => 'Invalid credentials.'], 401);
        }

        return view('auth.login');
    }




    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['success' => true, 'message' => 'Logged out successfully.', 'redirect_url' => route('login')]);
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

//        if ($validator->fails()) {
//            return response()->json(['status' => false, 'validation' => true, 'errors' => $validator->errors()]);
//        }
        if ($validator->fails()) {
            return response()->json(['status' => false, 'validation' => true, 'errors' => $validator->errors()->first()]);
        }


        $user = User::where('email', $request->email)->first();
        $verificationCode = Str::random(6);
        $user->verification_code = $verificationCode;
        $user->verification_expires_at = now()->addMinutes(5);
        $user->save();

//        dd($user);

        $data = [
            'subject' => 'Password Reset Verification Code',
            'template' => 'email.confirmation',
            'verification_code' => $verificationCode,
            'expires_at' => $user->verification_expires_at->format('Y-m-d H:i A'),
            'user_name' => $user->username,
        ];

        Mail::to($user->email)->send(new NotificationMail($data));

        return response()->json(['message' => 'Verification code sent to your email.',  'redirect' => route('change-password-submit') ]);
    }

    public function change_password_submit(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'verification_code' => 'required|string',
                'password' => 'required|string|min:8|confirmed',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => false, 'validation' => true, 'errors' => $validator->errors()->first()]);
            }


            $user = User::where('verification_code', $request->verification_code)->first();

            if (!$user || now()->greaterThan($user->verification_expires_at)) {
                $validator->errors()->add('verification_code', __('Invalid or expired verification code.'));
                return response()->json([
                    'status' => false,
                    'validation' => true,
                    'errors' => $validator->errors(),
                ]);
            }

            $user->password = Hash::make($request->password);
            $user->verification_code = null;
            $user->verification_expires_at = null;
            $user->save();

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

