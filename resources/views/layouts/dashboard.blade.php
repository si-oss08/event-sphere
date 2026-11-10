<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') — EventSphere</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="min-h-screen bg-slate-100 font-sans text-slate-900 antialiased">
    @php
        $user = auth()->user();

        $navItems = match (true) {
            $user->isAdmin() => [
                ['label' => 'Ringkasan', 'route' => 'admin.dashboard', 'active' => 'admin.dashboard', 'icon' => 'M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z'],
                ['label' => 'Kelola Event', 'route' => 'admin.events.index', 'active' => 'admin.events.*', 'icon' => 'M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5'],
                ['label' => 'Kategori', 'route' => 'admin.categories.index', 'active' => 'admin.categories.*', 'icon' => 'M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z'],
                ['label' => 'Pengguna', 'route' => 'admin.users.index', 'active' => 'admin.users.*', 'icon' => 'M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z'],
                ['label' => 'Pendaftaran', 'route' => 'admin.registrations.index', 'active' => 'admin.registrations.*', 'icon' => 'M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 0 1 0 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 0 1 0-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375Z'],
            ],
            $user->isOrganizer() => [
                ['label' => 'Ringkasan', 'route' => 'organizer.dashboard', 'active' => 'organizer.dashboard', 'icon' => 'M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z'],
                ['label' => 'Event Saya', 'route' => 'organizer.events.index', 'active' => 'organizer.events.*', 'icon' => 'M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5'],
                ['label' => 'Buat Event', 'route' => 'organizer.events.create', 'active' => 'organizer.events.create', 'icon' => 'M12 4.5v15m7.5-7.5h-15'],
                ['label' => 'Jelajahi Event', 'route' => 'events.index', 'active' => 'events.*', 'icon' => 'M21 21l-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z'],
            ],
            default => [
                ['label' => 'Ringkasan', 'route' => 'participant.dashboard', 'active' => 'participant.dashboard', 'icon' => 'M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z'],
                ['label' => 'Tiket Saya', 'route' => 'registrations.index', 'active' => 'registrations.*', 'icon' => 'M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 0 1 0 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 0 1 0-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375Z'],
                ['label' => 'Jelajahi Event', 'route' => 'events.index', 'active' => 'events.*', 'icon' => 'M21 21l-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z'],
            ],
        };
    @endphp

    <aside class="fixed inset-y-0 left-0 z-40 hidden w-72 flex-col border-r border-slate-200 bg-white lg:flex">
        <div class="flex h-16 items-center gap-2.5 border-b border-slate-100 px-6">
            <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                <span class="flex size-9 items-center justify-center rounded-xl bg-gradient-to-br from-brand-500 to-violet-600 text-white shadow-lg shadow-brand-600/20">
                    <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" /></svg>
                </span>
                <span class="text-lg font-extrabold tracking-tight text-slate-900">Event<span class="text-brand-600">Sphere</span></span>
            </a>
        </div>

        <div class="flex-1 overflow-y-auto px-4 py-6">
            <p class="px-3 text-[11px] font-bold uppercase tracking-[0.16em] text-slate-400">Menu {{ $user->role->label() }}</p>
            <nav class="mt-3 space-y-1">
                @foreach ($navItems as $item)
                    <a href="{{ route($item['route']) }}" class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold transition {{ request()->routeIs($item['active']) ? 'bg-brand-50 text-brand-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <svg class="size-5 shrink-0 {{ request()->routeIs($item['active']) ? 'text-brand-600' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}" /></svg>
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </nav>

            <div class="mt-8 rounded-2xl bg-gradient-to-br from-brand-600 to-violet-700 p-4 text-white">
                <p class="text-xs font-bold uppercase tracking-widest text-brand-200">EventSphere</p>
                <p class="mt-2 text-sm font-semibold leading-snug">Kelola event lebih rapi dan profesional.</p>
                <p class="mt-1 text-xs text-brand-100">Semua data tersaji dalam satu dasbor.</p>
            </div>
        </div>

        <div class="border-t border-slate-100 p-4">
            <div class="flex items-center gap-3 rounded-xl bg-slate-50 p-3">
                <img src="{{ $user->avatarUrl() }}" alt="{{ $user->name }}" class="size-9 rounded-full object-cover">
                <div class="min-w-0 flex-1">
                    <p class="truncate text-sm font-bold text-slate-900">{{ $user->name }}</p>
                    <p class="truncate text-xs text-slate-500">{{ $user->role->label() }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" title="Keluar" class="flex size-8 items-center justify-center rounded-lg text-slate-400 transition hover:bg-white hover:text-rose-600">
                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" /></svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <div class="lg:pl-72">
        <header class="sticky top-0 z-30 border-b border-slate-200 bg-white/90 backdrop-blur">
            <div class="flex h-16 items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
                <div class="flex items-center gap-3">
                    <button type="button" data-mobile-toggle="#dashboard-menu" class="inline-flex size-10 items-center justify-center rounded-lg border border-slate-200 text-slate-700 lg:hidden">
                        <span class="sr-only">Buka menu</span>
                        <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>
                    </button>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">{{ $user->role->label() }}</p>
                        <h1 class="text-base font-bold text-slate-900">@yield('heading', 'Dashboard')</h1>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('events.index') }}" class="hidden items-center gap-2 rounded-lg border border-slate-200 px-3 py-2 text-sm font-semibold text-slate-700 transition hover:border-slate-300 hover:text-slate-900 sm:flex">
                        <svg class="size-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
                        Cari Event
                    </a>
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 rounded-full border border-slate-200 py-1 pl-1 pr-3 transition hover:border-slate-300">
                        <img src="{{ $user->avatarUrl() }}" alt="{{ $user->name }}" class="size-8 rounded-full object-cover">
                        <span class="hidden max-w-28 truncate text-sm font-semibold text-slate-800 sm:block">{{ $user->name }}</span>
                    </a>
                </div>
            </div>

            <div id="dashboard-menu" class="hidden border-t border-slate-200 bg-white px-4 py-3 lg:hidden">
                <nav class="flex flex-col gap-1">
                    @foreach ($navItems as $item)
                        <a href="{{ route($item['route']) }}" class="rounded-lg px-3 py-2 text-sm font-semibold {{ request()->routeIs($item['active']) ? 'bg-brand-50 text-brand-700' : 'text-slate-700 hover:bg-slate-50' }}">{{ $item['label'] }}</a>
                    @endforeach
                    <a href="{{ route('profile.edit') }}" class="rounded-lg px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Profil Saya</a>
                </nav>
            </div>
        </header>

        <main class="px-4 py-6 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-7xl space-y-6">
                <x-flash />
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
