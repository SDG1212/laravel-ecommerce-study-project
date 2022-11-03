<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $faker = Faker::create();

        for ($i = 0; $i < 8; $i++) {
            $category_id = DB::table('categories')->insertGetId([
                'name' => $faker->words(5, true),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            for ($y = 0; $y < 24; $y++) {
                $products = [
                    'name' => $faker->words(5, true),
                    'image' => $faker->imageUrl(640, 480),
                    'price' => $faker->randomFloat(2, 1, 1000000),
                    'quantity' => $faker->randomNumber(2, false),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                $product_id = DB::table('products')->insertGetId($products);

                DB::table('category_has_products')->insert([
                    'category_id' => $category_id,
                    'product_id' => $product_id,
                ]);
            }
        }
    }
}
