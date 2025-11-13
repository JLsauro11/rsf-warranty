<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WarrantyRegistration;
use Illuminate\Support\Facades\Auth;

class CSRSRFController extends Controller
{
    public function index(Request $request)
    {
        // Count where product_code is 'srf'
        $srfCount = WarrantyRegistration::whereHas('product', function($query) {
            $query->where('product_code', 'srf');
        })->count();

        // Load all products with related product names for dropdowns

        if ($request->ajax()) {
            return response()->json([
                'srfCount' => $srfCount,
            ]);
        }

        return view('csr_srf.index', compact('srfCount'));
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
