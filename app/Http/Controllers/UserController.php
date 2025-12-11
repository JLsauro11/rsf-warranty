<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::select('id', 'username', 'email', 'role', 'created_at', 'updated_at')
                ->where('role', '!=', 'admin') // Exclude admin users
                ->get();
            return response()->json(['data' => $users]);
        }
        return view('user.index');
    }




    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'role_id' => ['required', 'in:admin,csr_rs8,csr_srf'], // Keep form field name
            'user_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'validation' => true,
                'errors' => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();
        $user = User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'role' => $validated['role_id'], // ✅ Map form field to model column
            'password' => Hash::make($validated['user_password']),
        ]);

        return response()->json([
            'status' => true,
            'validation' => false,
            'message' => 'User added successfully.',
            'data' => $user
        ]);
    }


    public function edit($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'string', 'max:255', 'unique:users,username,' . $id],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $id],
            'role' => ['required', 'in:admin,csr_rs8,csr_srf'],
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'validation' => true, 'errors' => $validator->errors()], 422);
        }

        $user = User::findOrFail($id);
        $user->update($validator->validated());

        return response()->json(['status' => true, 'message' => 'User updated successfully.']);
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'exists:users,id'],
        ], [
            'id.required' => 'User ID is required.',
            'id.exists' => 'User not found.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'validation' => true,
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::findOrFail($request->id);

        // Use soft delete if you have it enabled
        $user->delete();

        // Or permanent delete:
        // $user->forceDelete();

        return response()->json([
            'status' => true,
            'validation' => false,
            'message' => 'User deleted successfully.'
        ]);
    }


}
