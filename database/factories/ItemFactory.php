<?php

namespace Database\Factories;

use App\Models\Type;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */



    public function definition()
    {
        $attachments = [
            'Potatoes',
            'Tomato Sauce',
            'Cheese',
            'Cream',
        ];

        $typeIds = Type::pluck('id')->toArray();
        return [
            'uuid' => Str::uuid(),
            'name' => $this->faker->word,
            'desc' => $this->faker->text,
            'attachment' => $this->faker->randomElement($attachments),
            'type_id' => $this->faker->randomElement($typeIds),
           

        ];
    }
}
