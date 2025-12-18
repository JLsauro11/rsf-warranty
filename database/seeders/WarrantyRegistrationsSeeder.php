<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WarrantyRegistrationsSeeder extends Seeder
{
    public function run(): void
    {
        $products = DB::table('product')->pluck('id')->toArray();
        $productNames = DB::table('product_name')->pluck('id')->toArray();

        if (empty($products)) {
            $this->command->error('Product table is empty. Run: php artisan db:seed --class=ProductSeeder');
            return;
        }
        if (empty($productNames)) {
            $this->command->error('Product_name table is empty. Run: php artisan db:seed --class=ProductNameSeeder');
            return;
        }

        $firstNames = ['John', 'Jane', 'Michael', 'Sarah', 'David', 'Emily', 'Robert', 'Lisa', 'William', 'Mary'];
        $lastNames = ['Doe', 'Smith', 'Johnson', 'Brown', 'Davis', 'Wilson', 'Moore', 'Taylor', 'Anderson', 'Thomas'];
        $stores = ['TechMart', 'GadgetZone', 'ElectroHub', 'SmartBuy', 'PowerTech'];

        $data = [];
        for ($i = 1; $i <= 20; $i++) {
            $data[] = [
                'first_name' => $firstNames[array_rand($firstNames)],
                'last_name' => $lastNames[array_rand($lastNames)],
                'contact_no' => '09' . rand(100000000, 999999999),
                'product_id' => $products[array_rand($products)],
                'product_name_id' => $productNames[array_rand($productNames)],
                'serial_no' => 'SN' . strtoupper(substr(md5($i . time()), 0, 10)),
                'purchase_date' => Carbon::now()->subDays(rand(1, 365))->format('Y-m-d'),
                'receipt_no' => 'REC' . str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT),
                'product_image_path' => null,
                'receipt_image_path' => null,
                'store_name' => $stores[array_rand($stores)],
                'facebook_account_link' => null,
                'status' => in_array($i, [1,3,5,7,9]) ? 'approved' : (in_array($i, [2,4,6]) ? 'disapproved' : 'pending'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        DB::table('warranty_registrations')->insert($data);
        $this->command->info('20 warranty registrations seeded successfully!');
    }
}
