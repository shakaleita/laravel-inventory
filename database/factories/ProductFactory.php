<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return ['sku' => strtoupper($this->faker->unique()->bothify('PR-###')), 'name' => $this->faker->words(2, true), 'category' => $this->faker->word(), 'supplier' => $this->faker->company(), 'unit_price' => $this->faker->randomFloat(2, 1, 500), 'quantity' => $this->faker->numberBetween(0, 100), 'reorder_level' => $this->faker->numberBetween(1, 10)];
    }
}
