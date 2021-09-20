<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->jobTitle();

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->paragraphs(4, true),
            'quantity' => $this->faker->numberBetween(1, 5),
            'price' => $this->faker->randomNumber(5, true),
            'store_id' => $this->faker->numberBetween(1, 2),
            'category_id' => $this->faker->numberBetween(1, 3),
        ];
    }
}
