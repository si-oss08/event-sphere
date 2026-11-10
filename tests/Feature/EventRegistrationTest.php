<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Registration;
use App\Models\User;
use App\RegistrationStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_participant_can_register_for_a_published_event(): void
    {
        $participant = User::factory()->participant()->create();
        $event = $this->futureEvent();

        $response = $this->actingAs($participant)
            ->post(route('events.register', $event->slug));

        $registration = Registration::query()->where('user_id', $participant->id)->firstOrFail();

        $response->assertRedirect(route('registrations.show', $registration));
        $this->assertSame(RegistrationStatus::Confirmed, $registration->status);
        $this->assertNotNull($registration->ticket_code);
    }

    public function test_participant_cannot_register_twice_for_the_same_event(): void
    {
        $participant = User::factory()->participant()->create();
        $event = $this->futureEvent();
        Registration::factory()->for($event)->for($participant)->create();

        $this->actingAs($participant)
            ->from(route('events.show', $event->slug))
            ->post(route('events.register', $event->slug))
            ->assertRedirect(route('events.show', $event->slug))
            ->assertSessionHas('error');

        $this->assertSame(1, $event->registrations()->count());
    }

    public function test_participant_can_reactivate_a_cancelled_registration(): void
    {
        $participant = User::factory()->participant()->create();
        $event = $this->futureEvent();

        $registration = Registration::factory()
            ->for($event)
            ->for($participant)
            ->create(['status' => RegistrationStatus::Cancelled]);

        $this->actingAs($participant)
            ->post(route('events.register', $event->slug))
            ->assertRedirect(route('registrations.show', $registration));

        $this->assertSame(RegistrationStatus::Confirmed, $registration->fresh()->status);
    }

    public function test_registration_is_rejected_when_event_is_sold_out(): void
    {
        $participant = User::factory()->participant()->create();
        $event = $this->futureEvent(['capacity' => 1]);

        Registration::factory()->for($event)->create();

        $this->actingAs($participant)
            ->from(route('events.show', $event->slug))
            ->post(route('events.register', $event->slug))
            ->assertRedirect(route('events.show', $event->slug))
            ->assertSessionHas('error');

        $this->assertDatabaseMissing('registrations', [
            'event_id' => $event->id,
            'user_id' => $participant->id,
        ]);
    }

    public function test_registration_is_rejected_when_event_has_finished(): void
    {
        $participant = User::factory()->participant()->create();
        $event = Event::factory()->create([
            'starts_at' => now()->subDays(2),
            'ends_at' => now()->subDay(),
        ]);

        $this->actingAs($participant)
            ->from(route('events.show', $event->slug))
            ->post(route('events.register', $event->slug))
            ->assertRedirect(route('events.show', $event->slug))
            ->assertSessionHas('error');
    }

    public function test_only_participants_can_register_for_events(): void
    {
        $organizer = User::factory()->organizer()->create();
        $event = $this->futureEvent();

        $this->actingAs($organizer)
            ->post(route('events.register', $event->slug))
            ->assertForbidden();
    }

    public function test_participant_can_cancel_their_registration(): void
    {
        $participant = User::factory()->participant()->create();
        $event = $this->futureEvent();
        $registration = Registration::factory()->for($event)->for($participant)->create();

        $this->actingAs($participant)
            ->patch(route('registrations.cancel', $registration))
            ->assertRedirect();

        $this->assertSame(RegistrationStatus::Cancelled, $registration->fresh()->status);
    }

    public function test_participant_cannot_view_another_participants_ticket(): void
    {
        $participant = User::factory()->participant()->create();
        $registration = Registration::factory()->create();

        $this->actingAs($participant)
            ->get(route('registrations.show', $registration))
            ->assertForbidden();
    }

    public function test_participant_can_view_their_own_ticket(): void
    {
        $participant = User::factory()->participant()->create();
        $registration = Registration::factory()->for($participant)->create();

        $this->actingAs($participant)
            ->get(route('registrations.show', $registration))
            ->assertOk()
            ->assertSee($registration->ticket_code);
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    private function futureEvent(array $attributes = []): Event
    {
        return Event::factory()->create(array_merge([
            'starts_at' => now()->addWeek(),
            'ends_at' => now()->addWeek()->addHours(3),
        ], $attributes));
    }
}
