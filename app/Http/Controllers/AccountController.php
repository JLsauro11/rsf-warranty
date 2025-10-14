<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class AccountController extends Controller
{
    public function update_account(Request $request)
    {
        if ($request->isMethod('post')) {
            // Custom validation rules
            $rules = [
                'username' => 'required|string|max:255|unique:users,username,' . $request->user()->id,
            ];

            // Only validate password fields if current_password is provided (user wants to change password)
            if ($request->filled('current_password')) {
                $rules['current_password'] = ['required'];
                $rules['new_password'] = ['required', 'string', 'min:8', 'confirmed'];
            }

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'validation' => true,
                    'errors' => $validator->errors(),
                ], 422);
            }

            $user = $request->user();

            // Update username
            $user->username = $request->username;

            // If changing password, verify current password before updating
            if ($request->filled('current_password')) {
                if (!Hash::check($request->current_password, $user->password)) {
                    return response()->json([
                        'validation' => true,
                        'errors' => ['current_password' => ['Current password is incorrect.']],
                    ], 422);
                }

                // Update to new password (hashed)
                $user->password = Hash::make($request->new_password);
            }

            $user->save();

            return response()->json([
                'validation' => false,
                'username' => $user->username,
                'message' => 'Account updated successfully.',
            ]);
        }

        $user = auth()->user();

        return response()->json([
            'username' => $user->username,
        ]);

    }
}
