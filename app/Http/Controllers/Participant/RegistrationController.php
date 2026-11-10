<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\RegistrationStatus;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    /**
     * Display the authenticated participant's registrations.
     */
    public function index(Request $request): View
    {
        $registrations = Registration::query()
            ->where('user_id', $request->user()->id)
            ->with(['event.category', 'event.organizer'])
            ->latest()
            ->paginate(9);

        return view('participant.registrations.index', compact('registrations'));
    }

    /**
     * Display a single ticket.
     */
    public function show(Request $request, Registration $registration): View
    {
        abort_unless($registration->user_id === $request->user()->id, 403);

        $registration->load(['event.category', 'event.organizer']);

        return view('participant.registrations.show', compact('registration'));
    }

    /**
     * Cancel the participant's registration.
     */
    public function cancel(Request $request, Registration $registration): RedirectResponse
    {
        abort_unless($registration->user_id === $request->user()->id, 403);

        if ($registration->event->starts_at->isPast()) {
            return back()->with('error', 'Pendaftaran tidak dapat dibatalkan karena event sudah dimulai.');
        }

        if ($registration->status === RegistrationStatus::Cancelled) {
            return back()->with('error', 'Pendaftaran ini sudah dibatalkan.');
        }

        $registration->update(['status' => RegistrationStatus::Cancelled]);

        return back()->with('status', 'Pendaftaran berhasil dibatalkan.');
    }
}
