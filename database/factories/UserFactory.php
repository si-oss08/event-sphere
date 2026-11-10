<?php

namespace Database\Factories;

use App\Models\User;
use App\UserRole;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'role' => UserRole::Participant,
            'phone' => fake()->phoneNumber(),
            'organization_name' => null,
            'bio' => null,
            'avatar_path' => null,
        ];
    }

    /**
     * Indicate that the user is an administrator.
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => UserRole::Admin,
        ]);
    }

    /**
     * Indicate that the user is an event organizer.
     */
    public function organizer(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => UserRole::Organizer,
            'organization_name' => fake()->company(),
            'bio' => fake()->sentence(14),
        ]);
    }

    /**
     * Indicate that the user is a participant.
     */
    public function participant(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => UserRole::Participant,
        ]);
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
