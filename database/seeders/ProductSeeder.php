<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductImage;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::factory()
        ->count(10)
        ->create()
        ->each(function ($product) {
            $product->images()->createMany(
                ProductImage::factory()->count(3)->make()->toArray()
            );
        });
    }
}
