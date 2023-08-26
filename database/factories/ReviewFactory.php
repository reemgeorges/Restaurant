<?php

namespace Database\Factories;

use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $userIds = User::pluck('id')->toArray();
        $restaurantIds = Restaurant::pluck('id')->toArray();

            return [
                'uuid' => Str::uuid(),
                'star' => $this->faker->numberBetween(1, 5), // Random star rating between 1 and 5.
                'comment' => $this->faker->text,
                'restaurant_id' => $this->faker->randomElement($restaurantIds),
                'user_id' => $this->faker->randomElement($userIds),
            ];

    }
}
