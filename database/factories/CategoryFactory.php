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
            'color' => fake()->randomElement(['#10b981', '#f59e0b', '#f43f5e', '#f97316', '#84cc16', '#ef4444']),
            'icon' => fake()->randomElement(['calendar', 'music', 'code', 'briefcase', 'sparkles']),
        ];
    }
}
