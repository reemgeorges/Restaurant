<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $userIds = User::pluck('id')->toArray();
        return [
            'uuid' => Str::uuid(),
            'user_id' => $this->faker->randomElement($userIds),
            'status' => $this->faker->boolean ? 1 : 0, // Random status (0 or 1).
           
        ];
    }
}
