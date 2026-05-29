<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
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
            'name' => fake()->words(3, true),
            'description' => fake()->paragraph(),
            'price' => fake()->randomFloat(2, 50, 500),
            'stock' => fake()->numberBetween(1, 100),
            'rating' => fake()->randomFloat(2, 1, 5),
            'status' => 'active',
            'category_id' => Category::query()->inRandomOrder()->value('id'),
        ];
    }
}
