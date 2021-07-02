<?php

namespace Database\Factories;

use App\Models\Amount;
use Illuminate\Database\Eloquent\Factories\Factory;

class AmountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Amount::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'subscription_plan_id' => $this->faker->numberBetween(1, 12),
            'digital' => $this->faker->numberBetween(1000, 10000),
            'combined' => $this->faker->numberBetween(1000, 10000),
        ];
    }
}
