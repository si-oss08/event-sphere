<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of published events.
     */
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'category' => ['nullable', 'string', 'max:120'],
            'city' => ['nullable', 'string', 'max:80'],
            'sort' => ['nullable', 'in:soonest,latest,cheapest,popular'],
        ]);

        $events = Event::query()
            ->visible()
            ->upcoming()
            ->with(['category', 'organizer'])
            ->withCount(['registrations as active_registrations_count' => fn ($query) => $query->whereIn('status', ['pending', 'confirmed', 'attended'])])
            ->when($filters['q'] ?? null, function ($query, string $search): void {
                $query->where(function ($query) use ($search): void {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('venue', 'like', "%{$search}%")
                        ->orWhere('city', 'like', "%{$search}%");
                });
            })
            ->when($filters['category'] ?? null, fn ($query, string $slug) => $query->whereHas('category', fn ($query) => $query->where('slug', $slug)))
            ->when($filters['city'] ?? null, fn ($query, string $city) => $query->where('city', $city))
            ->when(($filters['sort'] ?? 'soonest') === 'latest', fn ($query) => $query->orderByDesc('starts_at'))
            ->when(($filters['sort'] ?? 'soonest') === 'soonest', fn ($query) => $query->orderBy('starts_at'))
            ->when(($filters['sort'] ?? null) === 'cheapest', fn ($query) => $query->orderBy('price'))
            ->when(($filters['sort'] ?? null) === 'popular', fn ($query) => $query->orderByDesc('active_registrations_count'))
            ->paginate(9)
            ->withQueryString();

        $categories = Category::query()->orderBy('name')->get();
        $cities = Event::query()->visible()->distinct()->orderBy('city')->pluck('city');

        return view('events.index', compact('events', 'categories', 'cities', 'filters'));
    }

    /**
     * Display a single published event.
     */
    public function show(Event $event): View
    {
        $event->load(['category', 'organizer'])
            ->loadCount(['registrations as active_registrations_count' => fn ($query) => $query->whereIn('status', ['pending', 'confirmed', 'attended'])]);

        $user = auth()->user();

        abort_unless(
            $event->status->isVisibleToPublic()
            || ($user && ($user->isAdmin() || $event->organizer_id === $user->id)),
            404,
        );

        $registration = $user?->registrations()->where('event_id', $event->id)->first();

        $relatedEvents = Event::query()
            ->visible()
            ->upcoming()
            ->whereKeyNot($event->id)
            ->when($event->category_id, fn ($query) => $query->where('category_id', $event->category_id))
            ->with('category')
            ->orderBy('starts_at')
            ->take(3)
            ->get();

        return view('events.show', compact('event', 'registration', 'relatedEvents'));
    }
}
