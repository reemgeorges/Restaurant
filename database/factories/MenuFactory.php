<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Menu>
 */
class MenuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        $restaurantIds = Restaurant::pluck('id')->toArray();
        $itemIds = Item::pluck('id')->toArray();
        return [
            'uuid' => Str::uuid(),
            'restaurant_id' => $this->faker->randomElement($restaurantIds),
            'item_id' => $this->faker->randomElement($itemIds),
            'price' => $this->faker->randomFloat(2, 5, 50),
            
        ];
    }
}
