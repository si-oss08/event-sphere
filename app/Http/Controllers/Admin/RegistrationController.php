<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    /**
     * Display all registrations.
     */
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', 'in:pending,confirmed,cancelled,attended'],
        ]);

        $registrations = Registration::query()
            ->with(['user', 'event'])
            ->when($filters['status'] ?? null, fn ($query, string $status) => $query->where('status', $status))
            ->when($filters['q'] ?? null, function ($query, string $search): void {
                $query->where('ticket_code', 'like', "%{$search}%")
                    ->orWhereHas('user', fn ($query) => $query->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%"))
                    ->orWhereHas('event', fn ($query) => $query->where('title', 'like', "%{$search}%"));
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.registrations.index', compact('registrations', 'filters'));
    }
}
