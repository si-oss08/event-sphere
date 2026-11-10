<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Registration;
use App\RegistrationStatus;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    /**
     * Display the registrants for an event.
     */
    public function index(Request $request, Event $event): View
    {
        $this->authorize('view', $event);

        $filters = $request->validate([
            'status' => ['nullable', 'in:pending,confirmed,cancelled,attended'],
            'q' => ['nullable', 'string', 'max:100'],
        ]);

        $registrations = $event->registrations()
            ->with('user')
            ->when($filters['status'] ?? null, fn ($query, string $status) => $query->where('status', $status))
            ->when($filters['q'] ?? null, function ($query, string $search): void {
                $query->where(function ($query) use ($search): void {
                    $query->where('ticket_code', 'like', "%{$search}%")
                        ->orWhereHas('user', fn ($query) => $query->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%"));
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $summary = [
            'total' => $event->registrations()->count(),
            'confirmed' => $event->registrations()->where('status', RegistrationStatus::Confirmed->value)->count(),
            'attended' => $event->registrations()->where('status', RegistrationStatus::Attended->value)->count(),
            'pending' => $event->registrations()->where('status', RegistrationStatus::Pending->value)->count(),
        ];

        return view('organizer.registrations.index', compact('event', 'registrations', 'summary', 'filters'));
    }

    /**
     * Update the status of a registration.
     */
    public function updateStatus(Request $request, Registration $registration): RedirectResponse
    {
        $this->authorize('view', $registration->event);

        $validated = $request->validate([
            'status' => ['required', 'in:pending,confirmed,cancelled,attended'],
        ]);

        $registration->update([
            'status' => $validated['status'],
            'checked_in_at' => $validated['status'] === RegistrationStatus::Attended->value ? now() : null,
        ]);

        return back()->with('status', 'Status pendaftaran berhasil diperbarui.');
    }
}
