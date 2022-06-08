<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;



class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'name' => $this->faker->name,
            'description' => $this->faker->paragraph,
            'price' => $this->faker->numberBetween(100, 1000),
            'image' => $this->faker->imageUrl($width = 200, $height = 200)
            // 'image' => $this->faker->image(storage_path('app/public/products'), 200, 200, null, false)
        ];
    }
}
