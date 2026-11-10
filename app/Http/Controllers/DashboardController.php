<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

class DashboardController extends Controller
{
    /**
     * Redirect the user to the dashboard for their role.
     */
    public function index(): RedirectResponse
    {
        $user = auth()->user();

        return match (true) {
            $user->isAdmin() => redirect()->route('admin.dashboard'),
            $user->isOrganizer() => redirect()->route('organizer.dashboard'),
            default => redirect()->route('participant.dashboard'),
        };
    }
}
