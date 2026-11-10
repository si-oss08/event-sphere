<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'EventSphere — Platform Penyelenggaraan Event')</title>
    <meta name="description" content="@yield('description', 'EventSphere adalah sistem informasi penyelenggaraan event berbasis web. Temukan, kelola, dan hadiri event terbaik di seluruh Indonesia.')">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="min-h-screen bg-slate-50 font-sans text-slate-900 antialiased">
    @php
        $user = auth()->user();
    @endphp

    <header class="sticky top-0 z-40 border-b border-slate-200/80 bg-white/85 backdrop-blur">
        <div class="mx-auto flex h-16 max-w-7xl items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                <span class="flex size-9 items-center justify-center rounded-xl bg-gradient-to-br from-brand-500 to-violet-600 text-white shadow-lg shadow-brand-600/25">
                    <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                    </svg>
                </span>
                <span class="text-lg font-extrabold tracking-tight text-slate-900">Event<span class="text-brand-600">Sphere</span></span>
            </a>

            <nav class="hidden items-center gap-1 md:flex">
                <a href="{{ route('home') }}" class="rounded-lg px-3 py-2 text-sm font-semibold {{ request()->routeIs('home') ? 'text-brand-700' : 'text-slate-600 hover:text-slate-900' }}">Beranda</a>
                <a href="{{ route('events.index') }}" class="rounded-lg px-3 py-2 text-sm font-semibold {{ request()->routeIs('events.*') ? 'text-brand-700' : 'text-slate-600 hover:text-slate-900' }}">Jelajahi Event</a>

                @auth
                    <a href="{{ route('dashboard') }}" class="rounded-lg px-3 py-2 text-sm font-semibold {{ request()->routeIs('*.dashboard') ? 'text-brand-700' : 'text-slate-600 hover:text-slate-900' }}">Dashboard</a>
                @endauth
            </nav>

            <div class="flex items-center gap-2">
                @guest
                    <a href="{{ route('login') }}" class="hidden rounded-lg px-3 py-2 text-sm font-semibold text-slate-700 hover:text-slate-900 sm:block">Masuk</a>
                    <a href="{{ route('register') }}" class="rounded-lg bg-brand-600 px-4 py-2 text-sm font-bold text-white shadow-sm transition hover:bg-brand-700">Daftar Sekarang</a>
                @else
                    <details class="group relative">
                        <summary class="flex cursor-pointer list-none items-center gap-2 rounded-full border border-slate-200 bg-white py-1 pl-1 pr-3 transition hover:border-slate-300">
                            <img src="{{ $user->avatarUrl() }}" alt="{{ $user->name }}" class="size-8 rounded-full object-cover">
                            <span class="hidden max-w-28 truncate text-sm font-semibold text-slate-800 sm:block">{{ $user->name }}</span>
                            <svg class="size-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" /></svg>
                        </summary>

                        <div class="absolute right-0 mt-2 w-60 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-xl">
                            <div class="border-b border-slate-100 bg-slate-50 px-4 py-3">
                                <p class="truncate text-sm font-bold text-slate-900">{{ $user->name }}</p>
                                <p class="truncate text-xs text-slate-500">{{ $user->email }}</p>
                                <span class="mt-2 inline-flex rounded-full px-2 py-0.5 text-[11px] font-bold ring-1 ring-inset {{ $user->role->badgeClasses() }}">{{ $user->role->label() }}</span>
                            </div>
                            <div class="p-2">
                                <a href="{{ route('dashboard') }}" class="block rounded-lg px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Dashboard</a>
                                <a href="{{ route('profile.edit') }}" class="block rounded-lg px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Profil Saya</a>
                                @if ($user->isParticipant())
                                    <a href="{{ route('registrations.index') }}" class="block rounded-lg px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">Tiket Saya</a>
                                @endif
                            </div>
                            <form method="POST" action="{{ route('logout') }}" class="border-t border-slate-100 p-2">
                                @csrf
                                <button type="submit" class="w-full rounded-lg px-3 py-2 text-left text-sm font-semibold text-rose-600 hover:bg-rose-50">Keluar</button>
                            </form>
                        </div>
                    </details>
                @endguest

                <button type="button" data-mobile-toggle="#mobile-menu" class="inline-flex size-10 items-center justify-center rounded-lg border border-slate-200 text-slate-700 md:hidden">
                    <span class="sr-only">Buka menu</span>
                    <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>
                </button>
            </div>
        </div>

        <div id="mobile-menu" class="hidden border-t border-slate-200 bg-white px-4 py-3 md:hidden">
            <nav class="flex flex-col gap-1">
                <a href="{{ route('home') }}" class="rounded-lg px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Beranda</a>
                <a href="{{ route('events.index') }}" class="rounded-lg px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Jelajahi Event</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="rounded-lg px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Dashboard</a>
                    <a href="{{ route('profile.edit') }}" class="rounded-lg px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Profil Saya</a>
                @endauth
                @guest
                    <a href="{{ route('login') }}" class="rounded-lg px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Masuk</a>
                @endguest
            </nav>
        </div>
    </header>

    <main>
        <div class="mx-auto max-w-7xl space-y-4 px-4 pt-6 sm:px-6 lg:px-8">
            <x-flash />
        </div>

        @yield('content')
    </main>

    <footer class="mt-20 border-t border-slate-200 bg-white">
        <div class="mx-auto grid max-w-7xl gap-10 px-4 py-12 sm:px-6 md:grid-cols-2 lg:grid-cols-4 lg:px-8">
            <div class="lg:col-span-2">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                    <span class="flex size-9 items-center justify-center rounded-xl bg-gradient-to-br from-brand-500 to-violet-600 text-white">
                        <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" /></svg>
                    </span>
                    <span class="text-lg font-extrabold tracking-tight text-slate-900">Event<span class="text-brand-600">Sphere</span></span>
                </a>
                <p class="mt-4 max-w-md text-sm leading-relaxed text-slate-600">
                    Sistem informasi penyelenggaraan event berbasis web. Satu platform untuk menemukan event,
                    mendaftar sebagai peserta, dan mengelola acara Anda secara profesional.
                </p>
            </div>

            <div>
                <h3 class="text-sm font-bold text-slate-900">Jelajahi</h3>
                <ul class="mt-3 space-y-2 text-sm text-slate-600">
                    <li><a href="{{ route('events.index') }}" class="hover:text-brand-700">Semua Event</a></li>
                    <li><a href="{{ route('events.index', ['sort' => 'popular']) }}" class="hover:text-brand-700">Event Populer</a></li>
                    <li><a href="{{ route('register') }}" class="hover:text-brand-700">Menjadi Penyelenggara</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-sm font-bold text-slate-900">Akun</h3>
                <ul class="mt-3 space-y-2 text-sm text-slate-600">
                    @auth
                        <li><a href="{{ route('dashboard') }}" class="hover:text-brand-700">Dashboard</a></li>
                        <li><a href="{{ route('profile.edit') }}" class="hover:text-brand-700">Profil</a></li>
                        <li><a href="{{ route('registrations.index') }}" class="hover:text-brand-700">Tiket Saya</a></li>
                    @else
                        <li><a href="{{ route('login') }}" class="hover:text-brand-700">Masuk</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-brand-700">Daftar</a></li>
                    @endauth
                </ul>
            </div>
        </div>

        <div class="border-t border-slate-100 py-5">
            <p class="text-center text-xs text-slate-500">&copy; {{ date('Y') }} EventSphere. Dibuat dengan Laravel &amp; Tailwind CSS.</p>
        </div>
    </footer>
</body>
</html>
