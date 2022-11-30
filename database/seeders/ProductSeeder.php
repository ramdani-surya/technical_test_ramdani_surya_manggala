<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
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
        ]);
    }
}
