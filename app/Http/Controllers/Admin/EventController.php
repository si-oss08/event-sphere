<?php

namespace App\Http\Controllers\Admin;

use App\EventStatus;
use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EventController extends Controller
{
    /**
     * Display all events.
     */
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', 'in:draft,published,cancelled,completed'],
        ]);

        $events = Event::query()
            ->with(['organizer', 'category'])
            ->withCount(['registrations as active_registrations_count' => fn ($query) => $query->whereIn('status', ['pending', 'confirmed', 'attended'])])
            ->when($filters['q'] ?? null, function ($query, string $search): void {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhereHas('organizer', fn ($query) => $query->where('name', 'like', "%{$search}%"));
            })
            ->when($filters['status'] ?? null, fn ($query, string $status) => $query->where('status', $status))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.events.index', compact('events', 'filters'));
    }

    /**
     * Display the given event.
     */
    public function show(Event $event): View
    {
        $event->load(['organizer', 'category'])
            ->loadCount(['registrations as active_registrations_count' => fn ($query) => $query->whereIn('status', ['pending', 'confirmed', 'attended'])]);

        $registrations = $event->registrations()->with('user')->latest()->take(10)->get();

        return view('admin.events.show', compact('event', 'registrations'));
    }

    /**
     * Update the status of the given event.
     */
    public function updateStatus(Request $request, Event $event): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::enum(EventStatus::class)],
        ]);

        $event->update(['status' => $validated['status']]);

        return back()->with('status', "Status event \"{$event->title}\" berhasil diperbarui.");
    }

    /**
     * Delete the given event.
     */
    public function destroy(Event $event): RedirectResponse
    {
        $event->delete();

        return redirect()->route('admin.events.index')->with('status', 'Event berhasil dihapus.');
    }
}
