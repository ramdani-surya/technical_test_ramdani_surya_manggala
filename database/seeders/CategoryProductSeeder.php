<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CategoryProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $categories = [['name'    => 'furnitur']];

        for ($i=0; $i < 4; $i++) {
            $categories[] = [ 'name' => $faker->word()];
        }

        DB::table('category_products')->insert(
            $categories
        );
    }
}
