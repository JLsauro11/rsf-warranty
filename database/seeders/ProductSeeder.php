<?php

// database/seeders/ProductSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductName;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Example products
        $products = [
            ['product_code' => 'rs8', 'product_label' => 'RS8'],
            ['product_code' => 'srf', 'product_label' => 'SRF'],
        ];

        foreach ($products as $prod) {
            $product = Product::create($prod);

            // Example product names/models per product
            if ($product->product_code == 'rs8') {
                ProductName::insert([
                    ['product_id' => $product->id, 'model_code' => 'rs8-m1', 'model_label' => 'RS8 Model 1'],
                    ['product_id' => $product->id, 'model_code' => 'rs8-m2', 'model_label' => 'RS8 Model 2'],
                ]);
            } elseif ($product->product_code == 'srf') {
                ProductName::insert([
                    ['product_id' => $product->id, 'model_code' => 'srf-a', 'model_label' => 'SRF Model A'],
                    ['product_id' => $product->id, 'model_code' => 'srf-b', 'model_label' => 'SRF Model B'],
                ]);
            }
        }
    }
}

