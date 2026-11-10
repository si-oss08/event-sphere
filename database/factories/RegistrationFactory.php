<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\Registration;
use App\Models\User;
use App\RegistrationStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Registration>
 */
class RegistrationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'event_id' => Event::factory(),
            'user_id' => User::factory()->participant(),
            'status' => RegistrationStatus::Confirmed,
            'notes' => null,
        ];
    }

    /**
     * Indicate that the registration is still pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => RegistrationStatus::Pending,
        ]);
    }

    /**
     * Indicate that the participant has checked in.
     */
    public function attended(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => RegistrationStatus::Attended,
            'checked_in_at' => now(),
        ]);
    }
}
