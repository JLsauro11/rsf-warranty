<?php

namespace App\Http\Controllers;

use App\Models\WarrantyRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class Rs8Controller extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            // 1. Start with a query builder instance
            $query = WarrantyRegistration::whereHas('product', function ($q) {
                $q->where('product_code', 'rs8');
            })->with([
                'product',
                'productName' => function ($q) {
                    $q->withTrashed();  // Includes soft-deleted productName records
                }
            ])->orderBy('created_at', 'desc');

            // 2. Apply date range filtering on the same $query
            if ($request->filled('from_date')) {
                $query->whereDate('created_at', '>=', $request->from_date);
            }

            if ($request->filled('to_date')) {
                $query->whereDate('created_at', '<=', $request->to_date);
            }

            $query->orderBy('created_at', 'desc');

            // 3. Execute the query
            $registrations = $query->get();

            // 4. Your existing map stays the same
            $data = $registrations->map(function ($registration) {
                $receiptImagePath = $registration->receipt_image_path ? public_path(ltrim($registration->receipt_image_path, '/')) : null;
                $productImagePath = $registration->product_image_path ? public_path(ltrim($registration->product_image_path, '/')) : null;

                $receiptImageBase64 = '';
                $productImageBase64 = '';

                if ($receiptImagePath && file_exists($receiptImagePath)) {
                    $type = pathinfo($receiptImagePath, PATHINFO_EXTENSION);
                    $data = file_get_contents($receiptImagePath);
                    $receiptImageBase64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                }

                if ($productImagePath && file_exists($productImagePath)) {
                    $type = pathinfo($productImagePath, PATHINFO_EXTENSION);
                    $data = file_get_contents($productImagePath);
                    $productImageBase64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                }

                return [
                    'id' => $registration->id,
                    'first_name' => $registration->first_name,
                    'last_name' => $registration->last_name,
                    'contact_no' => $registration->contact_no,
                    'product' => $registration->product ? $registration->product->product_label : null,
                    'product_name' => $registration->productName ? $registration->productName->model_label : null,
                    'serial_no' => $registration->serial_no,
                    'purchase_date' => $registration->purchase_date ? $registration->purchase_date->format('Y-m-d') : '',
                    'receipt_no' => $registration->receipt_no,
                    'receipt_image_path' => $registration->receipt_image_path ? url(ltrim($registration->receipt_image_path, '/')) : null,
                    'product_image_path' => $registration->product_image_path ? url(ltrim($registration->product_image_path, '/')) : null,
                    'receipt_image_base64' => $receiptImageBase64,
                    'product_image_base64' => $productImageBase64,
                    'store_name' => $registration->store_name,
                    'facebook_account_link' => $registration->facebook_account_link,
                    'status' => $registration->status,
                ];
            });

            return response()->json(['data' => $data]);
        }

        return view('rs8.index');
    }





    public function update_status(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:warranty_registrations,id', // use your table name
            'status' => 'required|string|in:pending,approved,disapproved',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'validation' => true, 'errors' => $validator->errors()], 422);
        }

        $record = WarrantyRegistration::find($request->id);

        if (!$record) {
            return response()->json(['success' => false, 'message' => 'Record not found.'], 404);
        }

        $record->status = $request->status;
        $record->save();

        return response()->json([
            'status' => true,
            'validation' => false,
            'message' => "Status updated successfully!"]);
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:warranty_registrations,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'validation' => true,
                'errors' => $validator->errors(),
            ], 422);
        }

        $record = WarrantyRegistration::find($request->id);

        if (!$record) {
            return response()->json([
                'status' => false,
                'message' => 'Record not found.',
            ], 404);
        }

        // Delete image file if exists
        if ($record->receipt_image_path && File::exists(public_path($record->receipt_image_path))) {
            File::delete(public_path($record->receipt_image_path));
        }
        if ($record->product_image_path && File::exists(public_path($record->product_image_path))) {
            File::delete(public_path($record->product_image_path));
        }

        // Delete video file if exists
//        if ($record->video_path && File::exists(public_path($record->video_path))) {
//            File::delete(public_path($record->video_path));
//        }

        // Delete the database record
        $record->delete();

        return response()->json([
            'status' => true,
            'validation' => false,
            'message' => 'Record deleted successfully.',
        ]);
    }


}
