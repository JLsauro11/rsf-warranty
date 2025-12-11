<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductName;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class ProductNameController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Get all product names not soft deleted with eager loaded product
            $productNames = ProductName::whereNull('deleted_at')
                ->with('product') // eager load related product
                ->get();

            // Return entire collection as JSON data
            return response()->json(['data' => $productNames]);
        }

        // Get products for select dropdown in the modal form
        $products = Product::whereNull('deleted_at')->get();

        // Return view with products passed for select options
        return view('product-name.index', compact('products'));
    }

    public function edit($id)
    {
        $productName = ProductName::findOrFail($id);
        return response()->json($productName);
    }

    public function update(Request $request, $id) // Add $id parameter
    {
        $validator = Validator::make($request->all(), [
            'model_code' => ['required', 'string', 'max:255'],
            'product_id' => ['required', 'exists:products,id'], // Fixed table name
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'validation' => true,
                'errors' => $validator->errors(),
            ], 422);
        }

        $productName = ProductName::findOrFail($id); // Use route $id
        $productName->update([
            'model_code' => $request->model_code,
            'model_label' => strtoupper($request->model_code),
            'product_id' => $request->product_id,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Product name updated successfully!',
        ]);
    }



    public function trash(Request $request)
    {
        if ($request->ajax()) {
            // Get all soft deleted product names with their related products
            $productNames = ProductName::onlyTrashed()
                ->with('product')
                ->get();

            // Return JSON data for datatable or frontend
            return response()->json(['data' => $productNames]);
        }

        // Return view for trash page; you can pass additional data if needed
        return view('trash.trash');
    }

    public function add(Request $request)
    {
        // Validate incoming request data
        $validator = Validator::make($request->all(), [
            'model_code' => 'required|unique:product_name,model_code|max:100', // changed product_code to model_code
            'product_id' => 'required|exists:product,id',
        ], [
            // Custom messages with correct keys
            'model_code.required' => 'The product name field is required.',
            'product_id.required' => 'Please select a product.',
        ]);

        if ($validator->fails()) {
            return response()->json(['validation' => true, 'errors' => $validator->errors()], 422);
        }

        $productName = ProductName::create([
            'product_id' => $request->input('product_id'),
            'model_code' => $request->input('model_code'),
            'model_label' => strtoupper($request->input('model_code')),
        ]);

        return response()->json(['validation' => false, 'message' => 'Product name added successfully', 'product' => $productName]);
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:product_name,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'validation' => true,
                'errors' => $validator->errors(),
            ], 422);
        }

        $record = ProductName::find($request->id);

        if (!$record) {
            return response()->json([
                'status' => false,
                'message' => 'Record not found.',
            ], 404);
        }

        $record->delete();

        return response()->json([
            'status' => true,
            'validation' => false,
            'message' => 'Record deleted successfully.',
        ]);
    }

    public function restore(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:product_name,id',
        ]);

        $productName = ProductName::withTrashed()->find($request->id);

        if (!$productName) {
            return response()->json([
                'validation' => true,
                'errors' => ['Product name not found.']
            ], 422);
        }

        try {
            $productName->restore(); // Restore soft deleted record
            return response()->json([
                'validation' => false,
                'message' => 'Product name restored successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'validation' => true,
                'errors' => ['Failed to restore product name.']
            ], 500);
        }
    }

}
