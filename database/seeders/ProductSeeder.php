<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productArray = [
            [
                'category_product_id' => 1,
                'name'                => 'kursi',
                'price'               => 100000,
            ],
            [
                'category_product_id' => 1,
                'name'                => 'meja',
                'price'               => 100000,
            ],
        ];

        foreach ($productArray as $product) {
            $createProduct = new Product;
            $createProduct->category_product_id = $product['category_product_id'];
            $createProduct->name                = $product['name'];
            $createProduct->price               = $product['price'];
            $createProduct->save();
        }
    }
}
