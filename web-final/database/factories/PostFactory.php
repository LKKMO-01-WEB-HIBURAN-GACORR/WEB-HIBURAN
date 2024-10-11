<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'content' => $this->faker->paragraph(5),
            'image' => 'post_images/' . $this->faker->randomElement(['blank-1.jpg', 'blank-2.jpg', 'blank-3.jpg', 'blank-4.jpg', 'blank-5.jpg']),
            'user_id' => $this->faker->numberBetween(1, 3),
        ];
    }
}
