<?php

namespace App\Http\Controllers\Admin;

use App\EventStatus;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Event;
use App\Models\Registration;
use App\Models\User;
use App\UserRole;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    /**
     * Display the administrator dashboard.
     */
    public function index(): View
    {
        $stats = [
            'users' => User::query()->count(),
            'organizers' => User::query()->where('role', UserRole::Organizer->value)->count(),
            'participants' => User::query()->where('role', UserRole::Participant->value)->count(),
            'events' => Event::query()->count(),
            'published' => Event::query()->where('status', EventStatus::Published->value)->count(),
            'registrations' => Registration::query()->count(),
            'revenue' => (float) Registration::query()
                ->whereIn('registrations.status', ['confirmed', 'attended'])
                ->join('events', 'events.id', '=', 'registrations.event_id')
                ->sum('events.price'),
        ];

        $recentEvents = Event::query()
            ->with(['organizer', 'category'])
            ->withCount(['registrations as active_registrations_count' => fn ($query) => $query->whereIn('status', ['pending', 'confirmed', 'attended'])])
            ->latest()
            ->take(5)
            ->get();

        $recentRegistrations = Registration::query()
            ->with(['user', 'event'])
            ->latest()
            ->take(6)
            ->get();

        $topCategories = Category::query()
            ->withCount('events')
            ->orderByDesc('events_count')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentEvents', 'recentRegistrations', 'topCategories'));
    }
}
