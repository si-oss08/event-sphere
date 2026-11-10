<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Category;
use App\Models\Event;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Display the authenticated organizer's events.
     */
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', 'in:draft,published,cancelled,completed'],
        ]);

        $events = $request->user()->organizedEvents()
            ->with('category')
            ->withCount(['registrations as active_registrations_count' => fn ($query) => $query->whereIn('status', ['pending', 'confirmed', 'attended'])])
            ->when($filters['q'] ?? null, fn ($query, string $search) => $query->where('title', 'like', "%{$search}%"))
            ->when($filters['status'] ?? null, fn ($query, string $status) => $query->where('status', $status))
            ->latest()
            ->paginate(9)
            ->withQueryString();

        return view('organizer.events.index', compact('events', 'filters'));
    }

    /**
     * Show the form for creating a new event.
     */
    public function create(): View
    {
        $this->authorize('create', Event::class);

        $categories = Category::query()->orderBy('name')->get();

        return view('organizer.events.create', compact('categories'));
    }

    /**
     * Store a newly created event.
     */
    public function store(StoreEventRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('poster')) {
            $validated['poster_path'] = $request->file('poster')->store('posters', 'public');
        }

        $validated['organizer_id'] = $request->user()->id;
        $validated['featured'] = $request->boolean('featured');
        unset($validated['poster']);

        $event = Event::create($validated);

        return redirect()->route('organizer.events.index')
            ->with('status', "Event \"{$event->title}\" berhasil dibuat.");
    }

    /**
     * Show the form for editing an event.
     */
    public function edit(Event $event): View
    {
        $this->authorize('update', $event);

        $categories = Category::query()->orderBy('name')->get();

        return view('organizer.events.edit', compact('event', 'categories'));
    }

    /**
     * Update an event.
     */
    public function update(UpdateEventRequest $request, Event $event): RedirectResponse
    {
        $validated = $request->validated();

        if ($request->hasFile('poster')) {
            if ($event->poster_path && ! str_starts_with($event->poster_path, 'http')) {
                Storage::disk('public')->delete($event->poster_path);
            }

            $validated['poster_path'] = $request->file('poster')->store('posters', 'public');
        }

        $validated['featured'] = $request->boolean('featured');
        unset($validated['poster']);

        $event->update($validated);

        return redirect()->route('organizer.events.index')
            ->with('status', "Event \"{$event->title}\" berhasil diperbarui.");
    }

    /**
     * Delete an event.
     */
    public function destroy(Event $event): RedirectResponse
    {
        $this->authorize('delete', $event);

        if ($event->poster_path && ! str_starts_with($event->poster_path, 'http')) {
            Storage::disk('public')->delete($event->poster_path);
        }

        $event->delete();

        return redirect()->route('organizer.events.index')
            ->with('status', 'Event berhasil dihapus.');
    }
}
