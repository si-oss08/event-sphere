@extends('layouts.app')

@section('title', 'EventSphere — Temukan & Kelola Event Terbaik')

@section('content')
    <section class="relative overflow-hidden bg-slate-950">
        <div class="absolute inset-0 bg-gradient-to-br from-brand-800 via-slate-950 to-slate-950"></div>
        <div class="bg-grid absolute inset-0 opacity-50"></div>
        <div class="absolute -left-24 top-0 size-96 rounded-full bg-brand-500/25 blur-3xl"></div>
        <div class="absolute -right-20 bottom-0 size-96 rounded-full bg-violet-500/20 blur-3xl"></div>

        <div class="relative mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8 lg:py-28">
            <div class="mx-auto max-w-3xl text-center">
                <span class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-1.5 text-xs font-bold uppercase tracking-wider text-brand-200 ring-1 ring-inset ring-white/15 backdrop-blur">
                    <span class="size-1.5 animate-pulse rounded-full bg-emerald-400"></span>
                    Sistem Informasi Penyelenggaraan Event
                </span>

                <h1 class="mt-6 text-balance text-4xl font-extrabold leading-[1.1] tracking-tight text-white sm:text-5xl lg:text-6xl">
                    Temukan event yang menginspirasi.<br>
                    <span class="text-brand-300">Kelola acara tanpa ribet.</span>
                </h1>

                <p class="mx-auto mt-5 max-w-2xl text-pretty text-base leading-relaxed text-slate-300 sm:text-lg">
                    EventSphere menghubungkan peserta dengan penyelenggara event terbaik — mulai dari konferensi
                    teknologi, workshop, hingga festival budaya. Daftar dalam hitungan detik, kelola dalam satu dasbor.
                </p>

                <form method="GET" action="{{ route('events.index') }}" class="mx-auto mt-9 flex max-w-2xl flex-col gap-2 rounded-2xl bg-white/10 p-2 ring-1 ring-inset ring-white/15 backdrop-blur sm:flex-row">
                    <label for="hero-search" class="sr-only">Cari event</label>
                    <div class="relative flex-1">
                        <div class="pointer-events-none absolute inset-y-0 left-0 z-10 flex items-center pl-4">
                            <svg class="size-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
                        </div>
                        <input id="hero-search" type="search" name="q" value="{{ request('q') }}" placeholder="Cari nama event, kota, atau lokasi…" class="w-full rounded-xl border-0 bg-white py-3 pl-12 pr-4 text-sm text-slate-900 shadow-sm outline-none ring-0 placeholder:text-slate-400 focus:ring-2 focus:ring-brand-500">
                    </div>
                    <button type="submit" class="rounded-xl bg-brand-600 px-6 py-3 text-sm font-bold text-white shadow-lg shadow-brand-900/30 transition hover:bg-brand-500">
                        Cari Event
                    </button>
                </form>

                <div class="mt-6 flex flex-wrap items-center justify-center gap-x-6 gap-y-2 text-xs font-medium text-slate-400">
                    <span class="flex items-center gap-1.5"><svg class="size-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg> Pendaftaran instan</span>
                    <span class="flex items-center gap-1.5"><svg class="size-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg> Tiket digital</span>
                    <span class="flex items-center gap-1.5"><svg class="size-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" /></svg> Dasbor penyelenggara</span>
                </div>
            </div>

            <div class="mx-auto mt-14 grid max-w-4xl grid-cols-2 gap-3 sm:grid-cols-4">
                @foreach ([
                    ['value' => $stats['events'], 'label' => 'Event aktif'],
                    ['value' => $stats['organizers'], 'label' => 'Penyelenggara'],
                    ['value' => $stats['participants'], 'label' => 'Peserta terdaftar'],
                    ['value' => $stats['registrations'], 'label' => 'Pendaftaran'],
                ] as $stat)
                    <div class="rounded-2xl bg-white/5 p-4 text-center ring-1 ring-inset ring-white/10 backdrop-blur">
                        <p class="text-2xl font-extrabold tracking-tight text-white sm:text-3xl">{{ number_format($stat['value'], 0, ',', '.') }}</p>
                        <p class="mt-1 text-xs font-medium text-slate-400">{{ $stat['label'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    @if ($featuredEvents->isNotEmpty())
        <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
            <div class="flex flex-wrap items-end justify-between gap-4">
                <div>
                    <p class="text-sm font-bold uppercase tracking-[0.18em] text-brand-600">Pilihan Editor</p>
                    <h2 class="mt-2 text-3xl font-extrabold tracking-tight text-slate-900">Event unggulan minggu ini</h2>
                    <p class="mt-2 max-w-2xl text-sm text-slate-600">Acara pilihan yang paling dinanti — dari teknologi, bisnis, hingga seni dan budaya.</p>
                </div>
                <a href="{{ route('events.index', ['sort' => 'popular']) }}" class="group inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-bold text-slate-700 shadow-sm transition hover:border-brand-200 hover:text-brand-700">
                    Lihat semua
                    <svg class="size-4 transition group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
                </a>
            </div>

            <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($featuredEvents as $event)
                    <x-event-card :event="$event" />
                @endforeach
            </div>
        </section>
    @endif

    @if ($categories->isNotEmpty())
        <section class="border-y border-slate-200 bg-white py-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex flex-wrap items-end justify-between gap-4">
                    <div>
                        <p class="text-sm font-bold uppercase tracking-[0.18em] text-brand-600">Kategori</p>
                        <h2 class="mt-2 text-3xl font-extrabold tracking-tight text-slate-900">Event sesuai minat Anda</h2>
                    </div>
                    <a href="{{ route('events.index') }}" class="text-sm font-bold text-brand-700 hover:text-brand-800">Jelajahi semua event →</a>
                </div>

                <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($categories as $category)
                        <a href="{{ route('events.index', ['category' => $category->slug]) }}" class="group rounded-2xl border border-slate-200 bg-slate-50 p-5 transition hover:-translate-y-1 hover:border-brand-200 hover:bg-white hover:shadow-lg hover:shadow-slate-900/5">
                            <span class="flex size-11 items-center justify-center rounded-xl text-white shadow-sm" style="background-color: {{ $category->color }}">
                                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" /></svg>
                            </span>
                            <h3 class="mt-4 text-base font-bold text-slate-900 group-hover:text-brand-700">{{ $category->name }}</h3>
                            <p class="mt-1 text-sm text-slate-500">{{ $category->events_count }} event mendatang</p>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="text-sm font-bold uppercase tracking-[0.18em] text-brand-600">Segera Hadir</p>
                <h2 class="mt-2 text-3xl font-extrabold tracking-tight text-slate-900">Jangan sampai terlewat</h2>
                <p class="mt-2 max-w-2xl text-sm text-slate-600">Event terdekat yang masih membuka pendaftaran.</p>
            </div>
            <a href="{{ route('events.index') }}" class="text-sm font-bold text-brand-700 hover:text-brand-800">Lihat semua event →</a>
        </div>

        @if ($upcomingEvents->isEmpty())
            <div class="mt-8 rounded-2xl border border-dashed border-slate-300 bg-white p-12 text-center">
                <p class="text-base font-bold text-slate-800">Belum ada event mendatang</p>
                <p class="mt-1 text-sm text-slate-500">Silakan kembali lagi nanti atau jelajahi event yang sudah berlangsung.</p>
            </div>
        @else
            <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($upcomingEvents as $event)
                    <x-event-card :event="$event" />
                @endforeach
            </div>
        @endif
    </section>

    <section class="mx-auto max-w-7xl px-4 pb-16 sm:px-6 lg:px-8">
        <div class="relative overflow-hidden rounded-3xl bg-slate-950 p-8 sm:p-12 lg:p-16">
            <div class="absolute inset-0 bg-gradient-to-br from-brand-700 via-brand-800 to-slate-950"></div>
            <div class="bg-grid absolute inset-0 opacity-40"></div>
            <div class="absolute -right-20 -top-20 size-80 rounded-full bg-violet-500/30 blur-3xl"></div>

            <div class="relative grid items-center gap-8 lg:grid-cols-2">
                <div>
                    <p class="text-sm font-bold uppercase tracking-[0.18em] text-brand-300">Untuk Penyelenggara</p>
                    <h2 class="mt-3 text-balance text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                        Siap menyelenggarakan event berikutnya?
                    </h2>
                    <p class="mt-4 max-w-xl text-sm leading-relaxed text-slate-300 sm:text-base">
                        Buat event, atur kuota dan harga tiket, pantau pendaftar secara real-time, dan kelola kehadiran
                        peserta — semuanya dalam satu platform.
                    </p>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row lg:justify-end">
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-xl bg-white px-6 py-3 text-sm font-bold text-slate-900 shadow-lg transition hover:bg-slate-100">
                        Mulai sebagai Penyelenggara
                    </a>
                    @guest
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-xl bg-white/10 px-6 py-3 text-sm font-bold text-white ring-1 ring-inset ring-white/20 backdrop-blur transition hover:bg-white/15">
                            Daftar sebagai Peserta
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </section>
@endsection
