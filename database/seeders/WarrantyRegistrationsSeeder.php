<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WarrantyRegistrationsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('warranty_registrations')->insert([
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'contact_no' => '09171234567',
                'product' => 'rs8',
                'product_name' => 'Gizmo Pro',
                'serial_no' => 'GP-1000',
                'purchase_date' => '2024-01-15',
                'receipt_no' => 'R123456',
//                'image_path' => 'images/product1.jpg',
//                'video_path' => 'https://example.com/video1.mp4',
                'status' => 'pending',

            ],
            [
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'contact_no' => '09179876543',
                'product' => 'srf',
                'product_name' => 'Device Ultra',
                'serial_no' => 'DU-2000',
                'purchase_date' => '2024-03-22',
                'receipt_no' => 'R654321',
//                'image_path' => 'images/product2.jpg',
//                'video_path' => 'https://example.com/video2.mp4',
                'status' => 'pending',
            ],
            // Add more sample data as needed
        ]);
    }
}
