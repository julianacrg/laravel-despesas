<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DespesaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'description' => $this->faker->sentence,
            'date' => $this->faker->date,
            'value' => $this->faker->randomFloat(2, 10, 300)
        ];
    }
}
