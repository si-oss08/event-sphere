<?php

namespace Database\Factories;

use App\EventStatus;
use App\Models\Category;
use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = Str::title(fake()->unique()->words(4, true));
        $startsAt = fake()->dateTimeBetween('-1 month', '+3 months');

        return [
            'organizer_id' => User::factory()->organizer(),
            'category_id' => Category::factory(),
            'title' => $title,
            'slug' => Str::slug($title).'-'.fake()->unique()->numerify('####'),
            'description' => fake()->paragraphs(3, true),
            'venue' => fake()->randomElement(['Balai Kartini', 'Jakarta Convention Center', 'Gedung Sate', 'ICE BSD', 'Sabuga', 'Harris Hotel']),
            'city' => fake()->randomElement(['Jakarta', 'Bandung', 'Surabaya', 'Yogyakarta', 'Bali', 'Medan']),
            'address' => fake()->address(),
            'starts_at' => $startsAt,
            'ends_at' => (clone $startsAt)->modify('+3 hours'),
            'capacity' => fake()->randomElement([50, 100, 150, 250, 500]),
            'price' => fake()->randomElement([0, 0, 50000, 75000, 150000, 250000]),
            'poster_path' => 'https://picsum.photos/seed/'.fake()->unique()->numerify('########').'/800/500',
            'status' => EventStatus::Published,
            'featured' => fake()->boolean(25),
        ];
    }

    /**
     * Indicate that the event is a draft.
     */
    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => EventStatus::Draft,
            'featured' => false,
        ]);
    }

    /**
     * Indicate that the event is cancelled.
     */
    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => EventStatus::Cancelled,
            'featured' => false,
        ]);
    }
}
