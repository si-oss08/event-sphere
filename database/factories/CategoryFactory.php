<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->randomElement([
            'Konferensi', 'Workshop', 'Seminar', 'Konser', 'Festival',
            'Pameran', 'Kompetisi', 'Bazar', 'Webinar', 'Komunitas',
        ]).' '.fake()->unique()->numerify('##');

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->sentence(12),
            'color' => fake()->randomElement(['#fbbf24', '#f59e0b', '#fcd34d', '#e11d48', '#d4d4d8', '#a1a1aa']),
            'icon' => fake()->randomElement(['calendar', 'music', 'code', 'briefcase', 'sparkles']),
        ];
    }
}
