<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Restaurant>
 */
class RestaurantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

            return [
                'uuid' => Str::uuid(),
                'name' => $this->faker->unique()->company,
                'cuisine_type' => $this->faker->word,
                'address' => $this->faker->address,
                'contact' => json_encode(['email' => $this->faker->unique()->safeEmail, 'phone' => $this->faker->phoneNumber]),
            ];

    }
}
