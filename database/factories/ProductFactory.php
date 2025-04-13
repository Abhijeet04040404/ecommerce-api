<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

     public function definition(): array
     {
         return [
             'name' => $this->faker->words(2, true),
             'description' => $this->faker->optional()->paragraph,
             'price' => $this->faker->randomFloat(2, 10, 1000),
             'stock' => $this->faker->numberBetween(0, 100),
             'sku' => strtoupper('SKU-' . $this->faker->unique()->bothify('##??##')),
         ];
     }
     
    
}
