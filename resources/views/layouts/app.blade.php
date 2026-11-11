<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'EventSphere — Platform Penyelenggaraan Event')</title>
    <meta name="description" content="@yield('description', 'EventSphere adalah sistem informasi penyelenggaraan event berbasis web. Temukan, kelola, dan hadiri event terbaik di seluruh Indonesia.')">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Montserrat:wght@600;700;800;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="min-h-screen bg-canvas font-sans text-ink antialiased">
    @php
        $user = auth()->user();
    @endphp

    <div class="h-px w-full bg-accent/60"></div>

    <header class="sticky top-0 z-40 border-b border-line bg-canvas">
        <div class="mx-auto flex h-16 max-w-7xl items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                <span class="flex size-9 items-center justify-center rounded-lg bg-accent text-zinc-950">
                    <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                    </svg>
                </span>
                <span class="font-display text-lg font-extrabold tracking-tight text-ink">Event<span class="text-accent">Sphere</span></span>
            </a>

            <nav class="hidden items-center gap-1 md:flex">
                <a href="{{ route('home') }}" class="rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('home') ? 'text-accent' : 'text-zinc-400 hover:text-ink' }}">Beranda</a>
                <a href="{{ route('events.index') }}" class="rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('events.*') ? 'text-accent' : 'text-zinc-400 hover:text-ink' }}">Jelajahi Event</a>

                @auth
                    <a href="{{ route('dashboard') }}" class="rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('*.dashboard') ? 'text-accent' : 'text-zinc-400 hover:text-ink' }}">Dashboard</a>
                @endauth
            </nav>

            <div class="flex items-center gap-2">
                @guest
                    <a href="{{ route('login') }}" class="hidden rounded-md px-3 py-2 text-sm font-medium text-zinc-300 transition hover:text-ink sm:block">Masuk</a>
                    <a href="{{ route('register') }}" class="btn-primary px-3 sm:px-4"><span class="sm:hidden">Daftar</span><span class="hidden sm:inline">Daftar Sekarang</span></a>
                @else
                    <details class="group relative" data-user-menu>
                        <summary class="flex cursor-pointer list-none items-center gap-2 rounded-lg border border-line bg-surface py-1 pl-1 pr-3 transition hover:border-line-strong">
                            <img src="{{ $user->avatarUrl() }}" alt="{{ $user->name }}" class="size-8 rounded-md object-cover">
                            <span class="hidden max-w-28 truncate text-sm font-medium text-zinc-200 sm:block">{{ $user->name }}</span>
                            <svg class="size-4 text-zinc-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" /></svg>
                        </summary>

                        <div class="absolute right-0 mt-2 w-60 overflow-hidden rounded-lg border border-line bg-surface">
                            <div class="border-b border-line bg-surface-2 px-4 py-3">
                                <p class="truncate text-sm font-semibold text-ink">{{ $user->name }}</p>
                                <p class="truncate text-xs text-zinc-500">{{ $user->email }}</p>
                                <span class="mt-2 inline-flex rounded-md px-2 py-0.5 text-[11px] font-semibold ring-1 ring-inset {{ $user->role->badgeClasses() }}">{{ $user->role->label() }}</span>
                            </div>
                            <div class="p-2">
                                <a href="{{ route('dashboard') }}" class="block rounded-md px-3 py-2 text-sm font-medium text-zinc-300 hover:bg-surface-2 hover:text-ink">Dashboard</a>
                                <a href="{{ route('profile.edit') }}" class="block rounded-md px-3 py-2 text-sm font-medium text-zinc-300 hover:bg-surface-2 hover:text-ink">Profil Saya</a>
                                @if ($user->isParticipant())
                                    <a href="{{ route('registrations.index') }}" class="block rounded-md px-3 py-2 text-sm font-medium text-zinc-300 hover:bg-surface-2 hover:text-ink">Tiket Saya</a>
                                @endif
                            </div>
                            <form method="POST" action="{{ route('logout') }}" class="border-t border-line p-2">
                                @csrf
                                <button type="submit" class="w-full rounded-md px-3 py-2 text-left text-sm font-medium text-rose-400 hover:bg-danger/10">Keluar</button>
                            </form>
                        </div>
                    </details>
                @endguest

                <button type="button" data-mobile-toggle="#mobile-menu" class="inline-flex size-10 items-center justify-center rounded-lg border border-line text-zinc-300 md:hidden">
                    <span class="sr-only">Buka menu</span>
                    <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>
                </button>
            </div>
        </div>

        <div id="mobile-menu" class="hidden border-t border-line bg-canvas px-4 py-3 md:hidden">
            <nav class="flex flex-col gap-1">
                <a href="{{ route('home') }}" class="rounded-md px-3 py-2 text-sm font-medium text-zinc-300 hover:bg-surface-2 hover:text-ink">Beranda</a>
                <a href="{{ route('events.index') }}" class="rounded-md px-3 py-2 text-sm font-medium text-zinc-300 hover:bg-surface-2 hover:text-ink">Jelajahi Event</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="rounded-md px-3 py-2 text-sm font-medium text-zinc-300 hover:bg-surface-2 hover:text-ink">Dashboard</a>
                    <a href="{{ route('profile.edit') }}" class="rounded-md px-3 py-2 text-sm font-medium text-zinc-300 hover:bg-surface-2 hover:text-ink">Profil Saya</a>
                @endauth
                @guest
                    <a href="{{ route('login') }}" class="rounded-md px-3 py-2 text-sm font-medium text-zinc-300 hover:bg-surface-2 hover:text-ink">Masuk</a>
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

    <footer class="mt-20 border-t border-line bg-surface">
        <div class="mx-auto grid max-w-7xl gap-10 px-4 py-12 sm:px-6 md:grid-cols-2 lg:grid-cols-4 lg:px-8">
            <div class="lg:col-span-2">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                    <span class="flex size-9 items-center justify-center rounded-lg bg-accent text-zinc-950">
                        <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" /></svg>
                    </span>
                    <span class="font-display text-lg font-extrabold tracking-tight text-ink">Event<span class="text-accent">Sphere</span></span>
                </a>
                <p class="mt-4 max-w-md text-sm leading-relaxed text-zinc-400">
                    Sistem informasi penyelenggaraan event berbasis web. Satu platform untuk menemukan event,
                    mendaftar sebagai peserta, dan mengelola acara Anda secara profesional.
                </p>
            </div>

            <div>
                <h3 class="text-sm font-semibold text-ink">Jelajahi</h3>
                <ul class="mt-3 space-y-2 text-sm text-zinc-400">
                    <li><a href="{{ route('events.index') }}" class="transition hover:text-accent-soft">Semua Event</a></li>
                    <li><a href="{{ route('events.index', ['sort' => 'popular']) }}" class="transition hover:text-accent-soft">Event Populer</a></li>
                    <li><a href="{{ route('register') }}" class="transition hover:text-accent-soft">Menjadi Penyelenggara</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-sm font-semibold text-ink">Akun</h3>
                <ul class="mt-3 space-y-2 text-sm text-zinc-400">
                    @auth
                        <li><a href="{{ route('dashboard') }}" class="transition hover:text-accent-soft">Dashboard</a></li>
                        <li><a href="{{ route('profile.edit') }}" class="transition hover:text-accent-soft">Profil</a></li>
                        <li><a href="{{ route('registrations.index') }}" class="transition hover:text-accent-soft">Tiket Saya</a></li>
                    @else
                        <li><a href="{{ route('login') }}" class="transition hover:text-accent-soft">Masuk</a></li>
                        <li><a href="{{ route('register') }}" class="transition hover:text-accent-soft">Daftar</a></li>
                    @endauth
                </ul>
            </div>
        </div>

        <div class="border-t border-line py-5">
            <p class="text-center text-xs text-zinc-500">&copy; {{ date('Y') }} EventSphere. Dibuat dengan Laravel &amp; Tailwind CSS.</p>
        </div>
    </footer>
</body>
</html>
