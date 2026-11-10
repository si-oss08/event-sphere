<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    /**
     * Display the public landing page.
     */
    public function index(): View
    {
        $featuredEvents = Event::query()
            ->visible()
            ->upcoming()
            ->featured()
            ->with(['category', 'organizer'])
            ->withCount(['registrations as active_registrations_count' => fn ($query) => $query->whereIn('status', ['pending', 'confirmed', 'attended'])])
            ->orderBy('starts_at')
            ->take(3)
            ->get();

        $upcomingEvents = Event::query()
            ->visible()
            ->upcoming()
            ->with(['category', 'organizer'])
            ->withCount(['registrations as active_registrations_count' => fn ($query) => $query->whereIn('status', ['pending', 'confirmed', 'attended'])])
            ->orderBy('starts_at')
            ->take(6)
            ->get();

        $categories = Category::query()
            ->withCount(['events' => fn ($query) => $query->visible()->upcoming()])
            ->orderByDesc('events_count')
            ->get();

        $stats = [
            'events' => Event::query()->visible()->count(),
            'organizers' => User::query()->where('role', 'organizer')->count(),
            'participants' => User::query()->where('role', 'participant')->count(),
            'registrations' => Registration::query()->whereIn('status', ['confirmed', 'attended'])->count(),
        ];

        return view('home', compact('featuredEvents', 'upcomingEvents', 'categories', 'stats'));
    }
}
