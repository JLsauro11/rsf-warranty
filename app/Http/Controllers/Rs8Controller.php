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
            $query = WarrantyRegistration::whereHas('product', function ($q) {
                $q->where('product_code', 'rs8');
            })->with(['product', 'productName' => function ($q) { $q->withTrashed(); }])
                ->orderBy('created_at', 'desc');

            if ($request->filled('from_date')) {
                $query->whereDate('purchase_date', '>=', $request->from_date);
            }
            if ($request->filled('to_date')) {
                $query->whereDate('purchase_date', '<=', $request->to_date);
            }

            $registrations = $query->get();

            $data = $registrations->map(function ($registration) {
                return [
                    'id' => $registration->id,
                    'first_name' => $registration->first_name,
                    'last_name' => $registration->last_name,
                    'contact_no' => $registration->contact_no,
                    'product' => $registration->product?->product_label,
                'product_name' => $registration->productName?->model_label,
                'serial_no' => $registration->serial_no,
                'purchase_date' => $registration->purchase_date?->format('Y-m-d'),
                'receipt_no' => $registration->receipt_no,
                'store_name' => $registration->store_name,
                'facebook_account_link' => $registration->facebook_account_link,
                'status' => $registration->status,
                'created_at' => $registration->created_at?->format('Y-m-d H:i:s'),
                // ONLY URLS - NO BASE64
                'receipt_image_path' => $registration->receipt_image_path ? url(ltrim($registration->receipt_image_path, '/')) : null,
                'product_image_path' => $registration->product_image_path ? url(ltrim($registration->product_image_path, '/')) : null,
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



    public function bulkDelete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ids' => ['required', 'array', 'min:1', 'max:5000'],
            'ids.*' => ['required', 'integer', 'distinct', 'exists:warranty_registrations,id'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $records = WarrantyRegistration::whereIn('id', $request->ids)
            ->whereHas('product', function ($query) {
                $query->where('product_code', 'rs8');
            })
            ->get();
        $deleted = 0;

        foreach ($records as $record) {
            if ($record->receipt_image_path && File::exists(public_path($record->receipt_image_path))) {
                File::delete(public_path($record->receipt_image_path));
            }
            if ($record->product_image_path && File::exists(public_path($record->product_image_path))) {
                File::delete(public_path($record->product_image_path));
            }
            $record->delete();
            $deleted++;
        }

        return response()->json([
            'status' => true,
            'message' => $deleted . ' warranty record' . ($deleted === 1 ? '' : 's') . ' deleted successfully.',
            'deleted_count' => $deleted,
        ]);
    }

}
