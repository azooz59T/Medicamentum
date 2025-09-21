<?php

namespace Database\Factories;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word() . ' ' . $this->faker->unique()->word(),
            'price' => $this->faker->randomFloat(2, 0, 999), // Generates a random price with 2 decimal places, between 1 and 999
            'category' => $this->faker->randomElement([
            'Dressings', 'Strapping', 'Tablets', 'Insoles', 
            'Gloves, masks, aprons', 'Steriliser trays and pouches', 'Wheelchair'
            ]),
            'description' => $this->faker->sentence(10)
        ];
    }
}
