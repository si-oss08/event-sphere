<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\UserRole;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display all users.
     */
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'role' => ['nullable', Rule::enum(UserRole::class)],
        ]);

        $users = User::query()
            ->withCount('registrations')
            ->when($filters['q'] ?? null, function ($query, string $search): void {
                $query->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%");
            })
            ->when($filters['role'] ?? null, fn ($query, string $role) => $query->where('role', $role))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $summary = [
            'total' => User::query()->count(),
            'admin' => User::query()->where('role', UserRole::Admin->value)->count(),
            'organizer' => User::query()->where('role', UserRole::Organizer->value)->count(),
            'participant' => User::query()->where('role', UserRole::Participant->value)->count(),
        ];

        return view('admin.users.index', compact('users', 'filters', 'summary'));
    }

    /**
     * Update the role of the given user.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'role' => ['required', Rule::enum(UserRole::class)],
        ]);

        if ($user->is($request->user()) && $validated['role'] !== UserRole::Admin->value) {
            return back()->with('error', 'Anda tidak dapat mengubah peran akun Anda sendiri.');
        }

        $user->update([
            'role' => $validated['role'],
            'organization_name' => $validated['role'] === UserRole::Organizer->value
                ? ($user->organization_name ?? $user->name)
                : $user->organization_name,
        ]);

        return back()->with('status', "Peran {$user->name} berhasil diperbarui.");
    }

    /**
     * Delete the given user.
     */
    public function destroy(Request $request, User $user): RedirectResponse
    {
        if ($user->is($request->user())) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return back()->with('status', 'Pengguna berhasil dihapus.');
    }
}
