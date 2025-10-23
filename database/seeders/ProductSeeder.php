<?php

// database/seeders/ProductSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        Product::create([
                'product_code' => 'rs8',
                'product_label' => 'RS8'
            ]);

        Product::create([
            'product_code' => 'srf',
            'product_label' => 'SRF'
        ]);
    }
}

