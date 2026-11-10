<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use App\RegistrationStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    /**
     * Register the authenticated participant for an event.
     */
    public function store(Request $request, Event $event): RedirectResponse
    {
        $user = $request->user();

        abort_unless($user->isParticipant(), 403, 'Hanya peserta yang dapat mendaftar event.');

        abort_unless($event->status->isVisibleToPublic(), 404);

        if ($event->hasFinished()) {
            return back()->with('error', 'Event ini sudah berakhir.');
        }

        if ($event->isSoldOut()) {
            return back()->with('error', 'Maaf, kuota event ini sudah penuh.');
        }

        $existing = $event->registrations()->where('user_id', $user->id)->first();

        if ($existing && $existing->status !== RegistrationStatus::Cancelled) {
            return back()->with('error', 'Anda sudah terdaftar pada event ini.');
        }

        if ($existing) {
            $existing->update([
                'status' => RegistrationStatus::Confirmed,
                'notes' => null,
                'checked_in_at' => null,
            ]);

            return redirect()->route('registrations.show', $existing)
                ->with('status', 'Pendaftaran Anda berhasil diaktifkan kembali.');
        }

        $registration = Registration::create([
            'event_id' => $event->id,
            'user_id' => $user->id,
            'status' => RegistrationStatus::Confirmed,
        ]);

        return redirect()->route('registrations.show', $registration)
            ->with('status', 'Pendaftaran berhasil! Simpan tiket digital Anda.');
    }
}
