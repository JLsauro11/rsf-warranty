<?php
// database/seeders/ProductNameSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductName;
use App\Models\Product;

class ProductNameSeeder extends Seeder
{
    public function run()
    {
        // Get product IDs (rs8=1, srf=2 from your ProductSeeder)
        $rs8Product = Product::where('product_code', 'rs8')->first();
        $srfProduct = Product::where('product_code', 'srf')->first();

        $rs8Models = [
            ['product_id' => $rs8Product->id, 'model_code' => 'RS8-001', 'model_label' => 'RS8 Standard'],
            ['product_id' => $rs8Product->id, 'model_code' => 'RS8-002', 'model_label' => 'RS8 Premium'],
            ['product_id' => $rs8Product->id, 'model_code' => 'RS8-003', 'model_label' => 'RS8 Pro'],
        ];

        $srfModels = [
            ['product_id' => $srfProduct->id, 'model_code' => 'SRF-001', 'model_label' => 'SRF Basic'],
            ['product_id' => $srfProduct->id, 'model_code' => 'SRF-002', 'model_label' => 'SRF Advanced'],
            ['product_id' => $srfProduct->id, 'model_code' => 'SRF-003', 'model_label' => 'SRF Elite'],
        ];

        // Insert RS8 models
        foreach ($rs8Models as $model) {
            ProductName::create($model);
        }

        // Insert SRF models
        foreach ($srfModels as $model) {
            ProductName::create($model);
        }

        $this->command->info('6 product_name records created: 3 RS8 + 3 SRF models!');
    }
}
