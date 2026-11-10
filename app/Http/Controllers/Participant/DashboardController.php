<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Registration;
use App\RegistrationStatus;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    /**
     * Display the participant dashboard.
     */
    public function index(): View
    {
        $user = auth()->user();

        $registrations = Registration::query()
            ->where('user_id', $user->id)
            ->with(['event.category', 'event.organizer'])
            ->latest()
            ->get();

        $upcoming = $registrations
            ->filter(fn (Registration $registration) => $registration->event->ends_at->isFuture()
                && $registration->status->occupiesSeat())
            ->sortBy(fn (Registration $registration) => $registration->event->starts_at);

        $recommendations = Event::query()
            ->visible()
            ->upcoming()
            ->whereNotIn('id', $registrations->pluck('event_id'))
            ->with('category')
            ->orderBy('starts_at')
            ->take(3)
            ->get();

        $stats = [
            'total' => $registrations->count(),
            'upcoming' => $upcoming->count(),
            'attended' => $registrations->filter(fn (Registration $registration) => $registration->status === RegistrationStatus::Attended)->count(),
            'cancelled' => $registrations->filter(fn (Registration $registration) => $registration->status === RegistrationStatus::Cancelled)->count(),
        ];

        return view('participant.dashboard', compact('registrations', 'upcoming', 'recommendations', 'stats'));
    }
}
