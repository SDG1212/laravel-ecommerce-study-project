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

        $products = [];

        for ($i = 0; $i < 240; $i++) {
            $products[] = [
                'name' => $faker->words(5, true),
                'image' => $faker->imageUrl(640, 480),
                'price' => $faker->randomFloat(2, 1, 1000000),
                'quantity' => $faker->randomNumber(2, false),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('products')->insert($products);

        $categories = [];

        for ($i = 0; $i < 12; $i++) {
            $categories[] = [
                'name' => $faker->words(5, true),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('categories')->insert($categories);
    }
}
