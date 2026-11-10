<?php

namespace Tests\Feature;

use App\EventStatus;
use App\Models\Category;
use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_lists_featured_upcoming_events(): void
    {
        $featured = Event::factory()->create([
            'title' => 'Konferensi Teknologi Nusantara',
            'featured' => true,
            'starts_at' => now()->addWeek(),
            'ends_at' => now()->addWeek()->addHours(3),
        ]);

        $pastFeature = Event::factory()->create([
            'title' => 'Event Masa Lalu',
            'featured' => true,
            'starts_at' => now()->subMonth(),
            'ends_at' => now()->subMonth()->addHours(3),
        ]);

        $response = $this->get('/');

        $response->assertOk()
            ->assertSee('EventSphere')
            ->assertSee($featured->title)
            ->assertDontSee($pastFeature->title);
    }

    public function test_events_index_only_lists_published_events(): void
    {
        $published = $this->upcomingEvent(['title' => 'Workshop Publik']);
        $draft = $this->upcomingEvent(['title' => 'Event Draf Rahasia']);
        $draft->update(['status' => EventStatus::Draft]);
        $cancelled = $this->upcomingEvent(['title' => 'Event Dibatalkan']);
        $cancelled->update(['status' => EventStatus::Cancelled]);

        $response = $this->get(route('events.index'));

        $response->assertOk()
            ->assertSee($published->title)
            ->assertDontSee($draft->title)
            ->assertDontSee($cancelled->title);
    }

    public function test_events_can_be_searched_and_filtered_by_city(): void
    {
        $this->upcomingEvent([
            'title' => 'Festival Budaya Bali',
            'city' => 'Bali',
        ]);

        $this->upcomingEvent([
            'title' => 'Seminar Bisnis Jakarta',
            'city' => 'Jakarta',
        ]);

        $this->get(route('events.index', ['q' => 'Bali']))
            ->assertOk()
            ->assertSee('Festival Budaya Bali')
            ->assertDontSee('Seminar Bisnis Jakarta');

        $this->get(route('events.index', ['city' => 'Jakarta']))
            ->assertOk()
            ->assertSee('Seminar Bisnis Jakarta')
            ->assertDontSee('Festival Budaya Bali');
    }

    public function test_event_detail_page_shows_published_event(): void
    {
        $event = Event::factory()->create([
            'title' => 'Pameran Seni Rupa',
            'status' => EventStatus::Published,
        ]);

        $this->get(route('events.show', $event->slug))
            ->assertOk()
            ->assertSee('Pameran Seni Rupa');
    }

    public function test_unpublished_event_detail_returns_not_found_for_guests(): void
    {
        $event = Event::factory()->draft()->create();

        $this->get(route('events.show', $event->slug))->assertNotFound();
    }

    public function test_category_page_filter_lists_matching_events(): void
    {
        $category = Category::factory()->create(['name' => 'Workshop Kreatif']);

        $this->upcomingEvent([
            'title' => 'Kelas Fotografi',
            'category_id' => $category->id,
        ]);

        $this->get(route('events.index', ['category' => $category->slug]))
            ->assertOk()
            ->assertSee('Kelas Fotografi');
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    private function upcomingEvent(array $attributes = []): Event
    {
        return Event::factory()->create(array_merge([
            'starts_at' => now()->addWeek(),
            'ends_at' => now()->addWeek()->addHours(3),
        ], $attributes));
    }
}
