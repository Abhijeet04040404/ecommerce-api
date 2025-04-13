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
     *
     * This seeder creates 10 products each with 3 product images.
     */
    public function run(): void
    {
        // Create 10 products
        Product::factory()
        ->count(10)
        ->create()
        ->each(function ($product) {
            // Create 3 product images for each product
            $product->images()->createMany(
                ProductImage::factory()->count(3)->make()->toArray()
            );
        });
    }
}
