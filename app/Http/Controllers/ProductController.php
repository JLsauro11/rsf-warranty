<?php
//
//namespace App\Http\Controllers;
//
//use Illuminate\Http\Request;
//use App\Models\Product;
//use Illuminate\Support\Facades\Validator;
//
//class ProductController extends Controller
//{
//    public function index(Request $request)
//    {
//        if ($request->ajax()) {
//            // Get all products not soft deleted
//            $products = Product::whereNull('deleted_at')->get();
//
//            // Return entire collection as JSON data
//            return response()->json(['data' => $products]);
//        }
//
//        return view('product.index');
//    }
//
//    public function add(Request $request)
//    {
//        // Validate incoming request data
//        $validator = Validator::make($request->all(), [
//            'product_code' => 'required|unique:product,product_code|max:20',
//            // Add other validations if needed
//        ],[
//            'product_code.required' => 'The product field is required.'
//            ]
//        );
//
//        if ($validator->fails()) {
//            return response()->json(['validation' => true, 'errors' => $validator->errors()], 422);
//        }
//
//        // Create the product with label as uppercase version of product_code
//        $product = Product::create([
//            'product_code' => $request->input('product_code'),
//            'product_label' => strtoupper($request->input('product_code')), // convert to uppercase
//        ]);
//
//        return response()->json(['validation' => false, 'message' => 'Product added successfully', 'product' => $product]);
//    }
//
//}
