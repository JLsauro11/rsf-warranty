<?php

namespace App\Http\Controllers;
use App\Models\WarrantyRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Count warranty registrations where related product.product_code = 'rs8'
        $rs8Count = WarrantyRegistration::whereHas('product', function($query) {
            $query->where('product_code', 'rs8');
        })->count();

        // Count where product_code is 'srf'
        $srfCount = WarrantyRegistration::whereHas('product', function($query) {
            $query->where('product_code', 'srf');
        })->count();

        // Load all products with related product names for dropdowns

        if ($request->ajax()) {
            return response()->json([
                'rs8Count' => $rs8Count,
                'srfCount' => $srfCount,
            ]);
        }

        return view('home.index', compact('rs8Count', 'srfCount'));
    }


    public function accountDisplay(Request $request)
    {
        $user = Auth::user();
        if ($request->ajax()) {
            return response()->json([
                'user' => [
                    'username' => $user->username,
                    'email' => $user->email
                ]
            ]);
        }

        // Optionally handle non-AJAX request, e.g., abort or redirect
        abort(404); // or return view('someview');
    }



}
