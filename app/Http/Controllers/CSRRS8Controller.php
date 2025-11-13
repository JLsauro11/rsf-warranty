<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WarrantyRegistration;
use Illuminate\Support\Facades\Auth;

class CSRRS8Controller extends Controller
{
    public function index(Request $request)
    {
        // Count warranty registrations where related product.product_code = 'rs8'
        $rs8Count = WarrantyRegistration::whereHas('product', function($query) {
            $query->where('product_code', 'rs8');
        })->count();

        // Load all products with related product names for dropdowns

        if ($request->ajax()) {
            return response()->json([
                'rs8Count' => $rs8Count,
            ]);
        }

        return view('csr_rs8.index', compact('rs8Count'));
    }

    public function accountDisplay(Request $request)
    {
        $user = Auth::user();
        if ($request->ajax()) {
            return response()->json([
                'user' => [
                    'username' => $user->username,
                    'email' => $user->email,
                    'role' => $user->role,
                ]
            ]);
        }

        // Optionally handle non-AJAX request, e.g., abort or redirect
        abort(404); // or return view('someview');
    }
}
