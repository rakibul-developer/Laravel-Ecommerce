<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
    public function definition()
    {
        return [
            "user_id" => 1,
            "title" => fake()->unique()->sentence(),
            "sku" => fake()->unique()->numberBetween(1, 9999),
            "short_description" => fake()->paragraph(),
            "description" => fake()->paragraph(5),
            "price" => fake()->numberBetween(1, 9999),
            "sale_price" => fake()->numberBetween(1, 9999),
            "add_info" => fake()->paragraph(10),
            "image" => "product.png",
        ];
    }
}
