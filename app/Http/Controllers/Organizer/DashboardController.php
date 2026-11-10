<?php

namespace App\Http\Controllers\Organizer;

use App\EventStatus;
use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    /**
     * Display the organizer dashboard.
     */
    public function index(): View
    {
        $user = auth()->user();

        $eventQuery = $user->organizedEvents();

        $events = (clone $eventQuery)
            ->with('category')
            ->withCount(['registrations as active_registrations_count' => fn ($query) => $query->whereIn('status', ['pending', 'confirmed', 'attended'])])
            ->orderBy('starts_at')
            ->take(5)
            ->get();

        $registrations = Registration::query()
            ->whereHas('event', fn ($query) => $query->where('organizer_id', $user->id))
            ->with(['user', 'event'])
            ->latest()
            ->take(6)
            ->get();

        $confirmedRevenue = (float) Registration::query()
            ->whereHas('event', fn ($query) => $query->where('organizer_id', $user->id))
            ->whereIn('registrations.status', ['confirmed', 'attended'])
            ->join('events', 'events.id', '=', 'registrations.event_id')
            ->sum('events.price');

        $stats = [
            'events' => (clone $eventQuery)->count(),
            'published' => (clone $eventQuery)->where('status', EventStatus::Published->value)->count(),
            'registrations' => Registration::query()->whereHas('event', fn ($query) => $query->where('organizer_id', $user->id))->count(),
            'revenue' => $confirmedRevenue,
        ];

        return view('organizer.dashboard', compact('events', 'registrations', 'stats'));
    }
}
