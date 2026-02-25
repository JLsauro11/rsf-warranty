<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPasswordReset
{
    public function handle(Request $request, Closure $next)
    {
        // Check if password reset session exists
        if (!$request->session()->has('password_reset_email')) {
            return redirect()->route('forgot-password')
                ->with('error', 'Please request a verification code first.');
        }

        return $next($request);
    }
}
