<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function update_account(Request $request)
    {
        if ($request->isMethod('post')) {
            $user = $request->user();

            $passwordChangeRequested = $request->filled('current_password')
                || $request->filled('new_password')
                || $request->filled('new_password_confirmation');

            $rules = [
                'username' => ['required', 'string', 'max:255', 'unique:users,username,' . $user->id],
                'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            ];

            // Password changes are all-or-nothing. If the user touches any password
            // field, require the current password plus a confirmed new password.
            if ($passwordChangeRequested) {
                $rules['current_password'] = ['required', 'string'];
                $rules['new_password'] = ['required', 'string', 'min:8', 'confirmed'];
                $rules['new_password_confirmation'] = ['required', 'string'];
            }

            $messages = [
                'current_password.required' => 'Enter your current password to change your password.',
                'new_password.required' => 'Enter a new password.',
                'new_password.min' => 'New password must be at least 8 characters.',
                'new_password.confirmed' => 'New password and confirmation do not match.',
                'new_password_confirmation.required' => 'Confirm your new password.',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return response()->json([
                    'validation' => true,
                    'errors' => $validator->errors(),
                ], 422);
            }

            if ($passwordChangeRequested && !Hash::check($request->current_password, $user->password)) {
                return response()->json([
                    'validation' => true,
                    'errors' => [
                        'current_password' => ['Current password is incorrect.'],
                    ],
                ], 422);
            }

            $user->username = $request->username;
            $user->email = $request->email;

            if ($passwordChangeRequested) {
                $user->password = Hash::make($request->new_password);
            }

            $user->save();

            return response()->json([
                'validation' => false,
                'username' => $user->username,
                'email' => $user->email,
                'password_changed' => $passwordChangeRequested,
                'message' => $passwordChangeRequested
                    ? 'Account and password updated successfully.'
                    : 'Account updated successfully.',
            ]);
        }

        $user = auth()->user();

        return response()->json([
            'username' => $user->username,
            'email' => $user->email,
        ]);
    }
}
