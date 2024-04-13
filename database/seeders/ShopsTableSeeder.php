<?php

namespace Database\Seeders;

use App\Models\Shop;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ShopsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $imageFilePath = 'storage/shop/shop-default-image.jpg';
        // Generate 100 shops with dummy data
        for ($i = 0; $i < 100; $i++) {
            $shop = new Shop();
            $shop->name = $faker->company;
            $shop->image = $imageFilePath;
            $shop->address = $faker->address;
            $shop->email = $faker->unique()->safeEmail;
            $shop->save();
        }
    }
}
