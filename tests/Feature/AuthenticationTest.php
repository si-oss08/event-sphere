<?php

namespace Tests\Feature;

use App\Models\User;
use App\UserRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_can_be_rendered(): void
    {
        $this->get(route('login'))->assertOk()->assertSee('Masuk');
    }

    public function test_user_can_login_with_valid_credentials(): void
    {
        $user = User::factory()->participant()->create([
            'email' => 'peserta@example.com',
            'password' => 'password',
        ]);

        $response = $this->post(route('login.store'), [
            'email' => 'peserta@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_cannot_login_with_invalid_password(): void
    {
        User::factory()->participant()->create([
            'email' => 'peserta@example.com',
            'password' => 'password',
        ]);

        $response = $this->from(route('login'))->post(route('login.store'), [
            'email' => 'peserta@example.com',
            'password' => 'kata-sandi-salah',
        ]);

        $response->assertRedirect(route('login'))
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_participant_can_register(): void
    {
        $response = $this->post(route('register.store'), [
            'name' => 'Peserta Baru',
            'email' => 'pesertabaru@example.com',
            'role' => UserRole::Participant->value,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('users', [
            'email' => 'pesertabaru@example.com',
            'role' => UserRole::Participant->value,
        ]);

        $this->assertAuthenticated();
    }

    public function test_registration_rejects_duplicate_email(): void
    {
        User::factory()->participant()->create(['email' => 'sudah@example.com']);

        $response = $this->from(route('register'))->post(route('register.store'), [
            'name' => 'Peserta Duplikat',
            'email' => 'sudah@example.com',
            'role' => UserRole::Participant->value,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect(route('register'))
            ->assertSessionHasErrors('email');

        $this->assertSame(1, User::query()->where('email', 'sudah@example.com')->count());
    }

    public function test_organizer_registration_requires_organization_name(): void
    {
        $response = $this->from(route('register'))->post(route('register.store'), [
            'name' => 'Penyelenggara Baru',
            'email' => 'penyelenggara@example.com',
            'role' => UserRole::Organizer->value,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect(route('register'))
            ->assertSessionHasErrors('organization_name');

        $this->assertDatabaseMissing('users', [
            'email' => 'penyelenggara@example.com',
        ]);
    }

    public function test_organizer_can_register_with_organization_name(): void
    {
        $response = $this->post(route('register.store'), [
            'name' => 'Penyelenggara Baru',
            'email' => 'penyelenggara@example.com',
            'role' => UserRole::Organizer->value,
            'organization_name' => 'Komunitas Kreatif',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('users', [
            'email' => 'penyelenggara@example.com',
            'role' => UserRole::Organizer->value,
            'organization_name' => 'Komunitas Kreatif',
        ]);
    }

    public function test_authenticated_user_can_logout(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('logout'))
            ->assertRedirect(route('home'));

        $this->assertGuest();
    }
}
