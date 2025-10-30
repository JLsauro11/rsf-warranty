<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\WarrantyRegistration;
use App\Models\Product;
use App\Models\ProductName;

class RegistrationController extends Controller
{
    public function registration(Request $request)
    {
        if ($request->isMethod('post')) {


            if ($request->ajax()) {
                $validator = Validator::make($request->all(), [
                    'first_name' => 'required|string|max:255',
                    'last_name' => 'required|string|max:255',
                    'contact_no' => ['required', 'max:15', 'regex:/^[0-9+\-\s]+$/'],
                    'product' => 'required|exists:product,id',              // Foreign key validation
                    'product_name' => 'required|exists:product_name,id',    // Foreign key validation
                    'serial_no' => 'required|string|max:255',
                    'purchase_date' => 'required|date|before_or_equal:today|after_or_equal:1900-01-01',
                    'receipt_no' => 'required|string|max:255',
                    'store_name' => 'required|string|max:150',
                    'fap_link' => 'required|string|max:255',
                    'receipt_image' => 'required|image|max:5120',       // max 5MB
                    'product_image' => 'required|image|max:5120',       // max 5MB
                ], [
                    'fap_link.required' => 'The Facebook Account/Page Link field is required. Please provide a valid URL.',
                ]);

//                dd($validator);

                if ($validator->fails()) {
                    return response()->json([
                        'status' => false,
                        'validation' => true,
                        'errors' => $validator->errors()
                    ], 422);
                }

                $registration = new WarrantyRegistration();
                $registration->first_name = $request->first_name;
                $registration->last_name = $request->last_name;
                $registration->contact_no = $request->contact_no;
                $registration->product_id = $request->product;
                $registration->product_name_id = $request->product_name;
                $registration->serial_no = $request->serial_no;
                $registration->purchase_date = $request->purchase_date;
                $registration->receipt_no = $request->receipt_no;
                $registration->store_name = $request->store_name;
                $registration->facebook_account_link = $request->fap_link;
                $registration->status = 'pending';

                // Handle receipt image upload
                if ($request->hasFile('receipt_image')) {
                    $image = $request->file('receipt_image');
                    $imageName = time() . '_' . $image->getClientOriginalName();
                    $image->move(public_path('warranty_receipt_images'), $imageName);
                    $registration->receipt_image_path = 'warranty_receipt_images/' . $imageName;
                }

                // Handle product image upload
                if ($request->hasFile('product_image')) {
                    $image = $request->file('product_image');
                    $imageName = time() . '_' . $image->getClientOriginalName();
                    $image->move(public_path('warranty_product_images'), $imageName);
                    $registration->product_image_path = 'warranty_product_images/' . $imageName;
                }

                // Uncomment and adapt video upload if required
                // if ($request->hasFile('video')) {
                //     $video = $request->file('video');
                //     $videoName = time() . '_' . $video->getClientOriginalName();
                //     $video->move(public_path('warranty_videos'), $videoName);
                //     $registration->video_path = 'warranty_videos/' . $videoName;
                // }

                if ((int)$request->product === 1) {
                    $url = 'https://rs8.com.ph/warranty/';
                } else {
                    $url = 'http://localhost/srf/';
                }



                $registration->save();

                return response()->json([
                    'status' => true,
                    'validation' => false,
                    'message' => 'Registration successful!',
                    'redirect' => $url,
                ]);
            }
        }
        $products = Product::all(); // fetch all products
        return view('registration.index', compact('products'));
    }

    public function getProductNames($productId)
    {
//        dd($productId);

        $productNames = ProductName::where('product_id', $productId)
            ->whereNull('deleted_at')
            ->get(['id', 'model_label']);
        return response()->json($productNames);
    }

}
