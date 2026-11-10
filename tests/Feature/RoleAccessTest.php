<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Registration;
use App\Models\User;
use App\RegistrationStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_login_from_protected_dashboards(): void
    {
        $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
        $this->get(route('organizer.dashboard'))->assertRedirect(route('login'));
        $this->get(route('participant.dashboard'))->assertRedirect(route('login'));
    }

    public function test_admin_can_access_admin_dashboard(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Panel Administrator');
    }

    public function test_organizer_can_access_organizer_dashboard(): void
    {
        $organizer = User::factory()->organizer()->create();

        $this->actingAs($organizer)
            ->get(route('organizer.dashboard'))
            ->assertOk();
    }

    public function test_participant_can_access_participant_dashboard(): void
    {
        $participant = User::factory()->participant()->create();

        $this->actingAs($participant)
            ->get(route('participant.dashboard'))
            ->assertOk();
    }

    public function test_participant_cannot_access_admin_or_organizer_areas(): void
    {
        $participant = User::factory()->participant()->create();

        $this->actingAs($participant)->get(route('admin.dashboard'))->assertForbidden();
        $this->actingAs($participant)->get(route('organizer.dashboard'))->assertForbidden();
    }

    public function test_organizer_cannot_access_admin_area(): void
    {
        $organizer = User::factory()->organizer()->create();

        $this->actingAs($organizer)
            ->get(route('admin.dashboard'))
            ->assertForbidden();
    }

    public function test_dashboard_route_redirects_users_by_role(): void
    {
        $admin = User::factory()->admin()->create();
        $organizer = User::factory()->organizer()->create();
        $participant = User::factory()->participant()->create();

        $this->actingAs($admin)->get(route('dashboard'))->assertRedirect(route('admin.dashboard'));
        $this->actingAs($organizer)->get(route('dashboard'))->assertRedirect(route('organizer.dashboard'));
        $this->actingAs($participant)->get(route('dashboard'))->assertRedirect(route('participant.dashboard'));
    }

    public function test_organizer_can_update_registration_status_for_own_event(): void
    {
        $organizer = User::factory()->organizer()->create();
        $event = Event::factory()->for($organizer, 'organizer')->create();
        $registration = Registration::factory()->for($event)->create();

        $this->actingAs($organizer)
            ->patch(route('organizer.registrations.status', $registration), [
                'status' => RegistrationStatus::Attended->value,
            ])
            ->assertRedirect();

        $registration->refresh();

        $this->assertSame(RegistrationStatus::Attended, $registration->status);
        $this->assertNotNull($registration->checked_in_at);
    }

    public function test_organizer_cannot_update_registration_status_for_another_organizers_event(): void
    {
        $organizer = User::factory()->organizer()->create();
        $otherEvent = Event::factory()->create();
        $registration = Registration::factory()->for($otherEvent)->create();

        $this->actingAs($organizer)
            ->patch(route('organizer.registrations.status', $registration), [
                'status' => RegistrationStatus::Attended->value,
            ])
            ->assertForbidden();

        $this->assertSame(RegistrationStatus::Confirmed, $registration->fresh()->status);
    }

    public function test_organizer_can_create_an_event(): void
    {
        $organizer = User::factory()->organizer()->create();

        $response = $this->actingAs($organizer)->post(route('organizer.events.store'), [
            'title' => 'Workshop Desain Produk',
            'description' => 'Workshop intensif untuk mempelajari dasar desain produk digital.',
            'venue' => 'Gedung Kreatif',
            'city' => 'Bandung',
            'address' => 'Jl. Merdeka No. 1',
            'starts_at' => now()->addMonth()->format('Y-m-d H:i:s'),
            'ends_at' => now()->addMonth()->addHours(4)->format('Y-m-d H:i:s'),
            'capacity' => 80,
            'price' => 75000,
            'status' => 'published',
        ]);

        $response->assertRedirect(route('organizer.events.index'));

        $this->assertDatabaseHas('events', [
            'title' => 'Workshop Desain Produk',
            'organizer_id' => $organizer->id,
            'city' => 'Bandung',
        ]);
    }
}
