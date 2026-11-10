<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Organizer;
use App\Http\Controllers\Participant;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/events', [EventController::class, 'index'])->name('events.index');

Route::get('/events/{event:slug}', [EventController::class, 'show'])->name('events.show');

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::middleware('auth')->group(function (): void {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::post('/events/{event:slug}/register', [RegistrationController::class, 'store'])->name('events.register');

    Route::get('/my-registrations', [Participant\RegistrationController::class, 'index'])->name('registrations.index');
    Route::get('/my-registrations/{registration}', [Participant\RegistrationController::class, 'show'])->name('registrations.show');
    Route::patch('/my-registrations/{registration}/cancel', [Participant\RegistrationController::class, 'cancel'])->name('registrations.cancel');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function (): void {
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/events', [Admin\EventController::class, 'index'])->name('events.index');
    Route::get('/events/{event}', [Admin\EventController::class, 'show'])->name('events.show');
    Route::patch('/events/{event}/status', [Admin\EventController::class, 'updateStatus'])->name('events.status');
    Route::delete('/events/{event}', [Admin\EventController::class, 'destroy'])->name('events.destroy');

    Route::resource('categories', Admin\CategoryController::class)->except(['show']);

    Route::get('/users', [Admin\UserController::class, 'index'])->name('users.index');
    Route::patch('/users/{user}', [Admin\UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [Admin\UserController::class, 'destroy'])->name('users.destroy');

    Route::get('/registrations', [Admin\RegistrationController::class, 'index'])->name('registrations.index');
});

Route::prefix('organizer')->name('organizer.')->middleware(['auth', 'role:organizer'])->group(function (): void {
    Route::get('/', [Organizer\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/events', [Organizer\EventController::class, 'index'])->name('events.index');
    Route::get('/events/create', [Organizer\EventController::class, 'create'])->name('events.create');
    Route::post('/events', [Organizer\EventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}/edit', [Organizer\EventController::class, 'edit'])->name('events.edit');
    Route::patch('/events/{event}', [Organizer\EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [Organizer\EventController::class, 'destroy'])->name('events.destroy');

    Route::get('/events/{event}/registrants', [Organizer\RegistrationController::class, 'index'])->name('events.registrants');
    Route::patch('/registrations/{registration}/status', [Organizer\RegistrationController::class, 'updateStatus'])->name('registrations.status');
});

Route::prefix('peserta')->name('participant.')->middleware(['auth', 'role:participant'])->group(function (): void {
    Route::get('/', [Participant\DashboardController::class, 'index'])->name('dashboard');
});
