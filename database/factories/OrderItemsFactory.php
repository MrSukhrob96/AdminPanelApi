<?php

namespace Database\Factories;

use App\Models\OrderItems;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderItems::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "product_title" => $this->faker->text(30),
			"price" => $this->faker->numberBetween(10, 100),
			"quantity" => $this->faker->numberBetween(1, 5)
        ];
    }
}
