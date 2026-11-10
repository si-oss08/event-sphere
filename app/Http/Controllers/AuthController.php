<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\UserRole;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLogin(): View
    {
        return view('auth.login');
    }

    /**
     * Authenticate the user.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => 'Email atau kata sandi yang Anda masukkan salah.',
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    /**
     * Show the registration form.
     */
    public function showRegister(): View
    {
        return view('auth.register');
    }

    /**
     * Register a new user.
     */
    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique(User::class)],
            'role' => ['required', Rule::in([UserRole::Participant->value, UserRole::Organizer->value])],
            'organization_name' => ['required_if:role,'.UserRole::Organizer->value, 'nullable', 'string', 'max:120'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [], [
            'name' => 'nama lengkap',
            'organization_name' => 'nama organisasi',
            'password' => 'kata sandi',
        ]);

        $user = User::create($validated);

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->route('dashboard')->with('status', 'Selamat datang di EventSphere, '.$user->name.'!');
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
