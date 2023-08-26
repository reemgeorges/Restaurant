<?php

namespace Database\Factories;

use App\Models\Menu;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MenuOrder>
 */
class MenuOrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $menuIds = Menu::pluck('id')->toArray();
        $orderIds = Order::pluck('id')->toArray();

        return [
            'menu_id' => $this->faker->randomElement($menuIds),
            'order_id' => $this->faker->randomElement($orderIds),
            'quantity' => $this->faker->numberBetween(1, 10),
        ];
    }
}
