<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrganizerEventManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_organizer_can_update_their_own_event(): void
    {
        $organizer = User::factory()->organizer()->create();
        $event = Event::factory()->for($organizer, 'organizer')->create();

        $this->actingAs($organizer)
            ->patch(route('organizer.events.update', $event), $this->eventPayload([
                'title' => 'Judul Event Diperbarui',
            ]))
            ->assertRedirect(route('organizer.events.index'));

        $this->assertDatabaseHas('events', [
            'id' => $event->id,
            'title' => 'Judul Event Diperbarui',
            'organizer_id' => $organizer->id,
        ]);
    }

    public function test_event_end_time_must_be_after_start_time(): void
    {
        $organizer = User::factory()->organizer()->create();

        $response = $this->actingAs($organizer)
            ->from(route('organizer.events.create'))
            ->post(route('organizer.events.store'), $this->eventPayload([
                'starts_at' => now()->addMonth()->format('Y-m-d H:i:s'),
                'ends_at' => now()->addMonth()->subHour()->format('Y-m-d H:i:s'),
            ]));

        $response->assertRedirect(route('organizer.events.create'))
            ->assertSessionHasErrors('ends_at');

        $this->assertDatabaseCount('events', 0);
    }

    public function test_organizer_cannot_update_another_organizers_event(): void
    {
        $organizer = User::factory()->organizer()->create();
        $event = Event::factory()->create(['title' => 'Event Milik Orang Lain']);

        $this->actingAs($organizer)
            ->patch(route('organizer.events.update', $event), $this->eventPayload([
                'title' => 'Percobaan Ubah',
            ]))
            ->assertForbidden();

        $this->assertSame('Event Milik Orang Lain', $event->fresh()->title);
    }

    public function test_organizer_can_delete_their_own_event(): void
    {
        $organizer = User::factory()->organizer()->create();
        $event = Event::factory()->for($organizer, 'organizer')->create();

        $this->actingAs($organizer)
            ->delete(route('organizer.events.destroy', $event))
            ->assertRedirect(route('organizer.events.index'));

        $this->assertDatabaseMissing('events', ['id' => $event->id]);
    }

    public function test_organizer_cannot_delete_another_organizers_event(): void
    {
        $organizer = User::factory()->organizer()->create();
        $event = Event::factory()->create();

        $this->actingAs($organizer)
            ->delete(route('organizer.events.destroy', $event))
            ->assertForbidden();

        $this->assertDatabaseHas('events', ['id' => $event->id]);
    }

    public function test_organizer_can_search_registrants_by_ticket_code(): void
    {
        $organizer = User::factory()->organizer()->create();
        $event = Event::factory()->for($organizer, 'organizer')->create();

        $alpha = User::factory()->participant()->create(['name' => 'Peserta Alpha']);
        $beta = User::factory()->participant()->create(['name' => 'Peserta Beta']);

        $registration = Registration::factory()->for($event)->for($alpha)->create();
        Registration::factory()->for($event)->for($beta)->create();

        $this->actingAs($organizer)
            ->get(route('organizer.events.registrants', [
                'event' => $event,
                'q' => $registration->ticket_code,
            ]))
            ->assertOk()
            ->assertSee('Peserta Alpha')
            ->assertDontSee('Peserta Beta');
    }

    /**
     * @param  array<string, mixed>  $overrides
     * @return array<string, mixed>
     */
    private function eventPayload(array $overrides = []): array
    {
        return array_merge([
            'title' => 'Event Pengujian',
            'description' => 'Deskripsi event yang cukup panjang untuk lolos validasi form.',
            'venue' => 'Gedung Pengujian',
            'city' => 'Bandung',
            'address' => 'Jl. Pengujian No. 1',
            'starts_at' => now()->addMonth()->format('Y-m-d H:i:s'),
            'ends_at' => now()->addMonth()->addHours(3)->format('Y-m-d H:i:s'),
            'capacity' => 100,
            'price' => 50000,
            'status' => 'published',
        ], $overrides);
    }
}
