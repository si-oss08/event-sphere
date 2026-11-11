@extends('layouts.app')

@section('title', 'EventSphere — Temukan & Kelola Event Terbaik')

@section('content')
    <section class="relative isolate overflow-hidden border-b border-line bg-canvas">
        <div class="bg-grid absolute inset-0 opacity-50"></div>
        <div aria-hidden="true" class="pointer-events-none absolute -left-40 -top-40 size-[600px] rounded-full bg-amber-500/10 blur-[150px]"></div>
        <div class="absolute inset-y-0 left-0 w-px bg-accent/40"></div>

        <div class="relative z-10 mx-auto grid max-w-7xl gap-14 px-4 py-16 sm:px-6 lg:grid-cols-12 lg:gap-16 lg:px-8 lg:py-24">
            <div class="lg:col-span-7">
                <p class="eyebrow">Sistem Informasi Penyelenggaraan Event</p>

                <h1 class="mt-6 text-balance font-display text-4xl font-extrabold leading-[1.03] tracking-tight text-ink sm:text-5xl lg:text-6xl">
                    Temukan event yang
                    <span class="block text-accent">menginspirasi.</span>
                </h1>

                <p class="mt-6 max-w-xl text-pretty text-base leading-relaxed text-zinc-400">
                    Dari konferensi teknologi hingga festival budaya — daftar dalam hitungan detik,
                    kelola seluruh acara dalam satu dasbor yang rapi dan profesional.
                </p>

                <form method="GET" action="{{ route('events.index') }}" class="mt-9 flex max-w-2xl flex-col gap-2 rounded-lg border border-line bg-surface p-2 sm:flex-row">
                    <label for="hero-search" class="sr-only">Cari event</label>
                    <div class="relative flex-1">
                        <div class="pointer-events-none absolute inset-y-0 left-0 z-10 flex items-center pl-4">
                            <svg class="size-5 text-zinc-500" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
                        </div>
                        <input id="hero-search" type="search" name="q" value="{{ request('q') }}" placeholder="Cari nama event, kota, atau lokasi…" class="w-full rounded-md border border-line bg-canvas py-3 pl-12 pr-4 text-sm text-ink outline-none transition placeholder:text-zinc-600 focus:border-accent focus:ring-2 focus:ring-accent/20">
                    </div>
                    <button type="submit" class="btn-primary px-6 py-3">
                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
                        Cari Event
                    </button>
                </form>

                <div class="mt-6 flex flex-wrap items-center gap-x-6 gap-y-2 text-[11px] font-semibold uppercase tracking-[0.1em] text-zinc-500">
                    <span class="flex items-center gap-2"><span class="size-1 rounded-full bg-accent"></span> Pendaftaran instan</span>
                    <span class="flex items-center gap-2"><span class="size-1 rounded-full bg-accent"></span> Tiket digital</span>
                    <span class="flex items-center gap-2"><span class="size-1 rounded-full bg-accent"></span> Dasbor penyelenggara</span>
                </div>
            </div>

            <div class="lg:col-span-5">
                <div class="overflow-hidden rounded-lg border border-line bg-surface">
                    <div class="h-0.5 bg-accent"></div>

                    <div class="flex items-center justify-between border-b border-line px-5 py-4">
                        <div>
                            <p class="text-sm font-semibold text-ink">Ringkasan platform</p>
                            <p class="mt-0.5 text-xs text-zinc-500">Data terkini EventSphere</p>
                        </div>
                        <span class="flex items-center gap-1.5 rounded border border-accent/25 bg-accent/[0.06] px-2 py-1 text-[10px] font-bold uppercase tracking-[0.12em] text-accent">
                            <span class="size-1.5 rounded-full bg-accent"></span>
                            Live
                        </span>
                    </div>

                    <div class="grid grid-cols-2 divide-x divide-y divide-line">
                        @foreach ([
                            ['value' => $stats['events'], 'label' => 'Event aktif'],
                            ['value' => $stats['organizers'], 'label' => 'Penyelenggara'],
                            ['value' => $stats['participants'], 'label' => 'Peserta terdaftar'],
                            ['value' => $stats['registrations'], 'label' => 'Pendaftaran'],
                        ] as $stat)
                            <div class="p-5">
                                <p class="font-display text-3xl font-extrabold tracking-tight text-ink">{{ number_format($stat['value'], 0, ',', '.') }}</p>
                                <p class="mt-1.5 text-[10px] font-semibold uppercase tracking-[0.14em] text-zinc-500">{{ $stat['label'] }}</p>
                            </div>
                        @endforeach
                    </div>

                    <div class="flex items-center justify-between border-t border-line bg-surface-2 px-5 py-3.5">
                        <p class="text-xs text-zinc-500">Siap memulai event Anda?</p>
                        <a href="{{ route('register') }}" class="text-xs font-bold text-accent transition hover:text-accent-soft">Daftar sekarang →</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if ($featuredEvents->isNotEmpty())
        <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
            <div class="flex flex-wrap items-end justify-between gap-4">
                <div>
                    <p class="eyebrow">Pilihan Editor</p>
                    <h2 class="mt-3 text-3xl font-extrabold tracking-tight text-ink">Event unggulan minggu ini</h2>
                    <p class="mt-3 max-w-2xl text-sm leading-relaxed text-zinc-400">Acara pilihan yang paling dinanti — dari teknologi, bisnis, hingga seni dan budaya.</p>
                </div>
                <a href="{{ route('events.index', ['sort' => 'popular']) }}" class="btn-secondary group">
                    Lihat semua
                    <svg class="size-4 transition group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
                </a>
            </div>

            <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($featuredEvents as $event)
                    <x-event-card :event="$event" />
                @endforeach
            </div>
        </section>
    @endif

    @if ($categories->isNotEmpty())
        <section class="relative isolate overflow-hidden border-y border-line bg-surface py-16">
            <div aria-hidden="true" class="pointer-events-none absolute right-0 top-1/2 size-[500px] -translate-y-1/2 rounded-full bg-amber-500/10 blur-[150px]"></div>
            <div class="relative z-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex flex-wrap items-end justify-between gap-4">
                    <div>
                        <p class="eyebrow">Kategori</p>
                        <h2 class="mt-3 text-3xl font-extrabold tracking-tight text-ink">Event sesuai minat Anda</h2>
                    </div>
                    <a href="{{ route('events.index') }}" class="text-sm font-semibold text-accent transition hover:text-accent-soft">Jelajahi semua event →</a>
                </div>

                <div class="mt-8 grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($categories as $category)
                        <a href="{{ route('events.index', ['category' => $category->slug]) }}" class="group flex items-start gap-3 rounded-lg border border-line bg-canvas p-4 transition hover:border-accent/40">
                            <span class="flex size-10 shrink-0 items-center justify-center rounded-md border border-line bg-surface-2 text-accent">
                                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" /></svg>
                            </span>
                            <div class="min-w-0">
                                <h3 class="text-sm font-bold text-ink transition group-hover:text-accent">{{ $category->name }}</h3>
                                <p class="mt-0.5 text-xs text-zinc-500">{{ $category->events_count }} event mendatang</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="eyebrow">Segera Hadir</p>
                <h2 class="mt-3 text-3xl font-extrabold tracking-tight text-ink">Jangan sampai terlewat</h2>
                <p class="mt-3 max-w-2xl text-sm leading-relaxed text-zinc-400">Event terdekat yang masih membuka pendaftaran.</p>
            </div>
            <a href="{{ route('events.index') }}" class="text-sm font-semibold text-accent transition hover:text-accent-soft">Lihat semua event →</a>
        </div>

        @if ($upcomingEvents->isEmpty())
            <div class="mt-8 rounded-lg border border-dashed border-line bg-surface p-12 text-center">
                <p class="text-base font-semibold text-ink">Belum ada event mendatang</p>
                <p class="mt-1 text-sm text-zinc-500">Silakan kembali lagi nanti atau jelajahi event yang sudah berlangsung.</p>
            </div>
        @else
            <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($upcomingEvents as $event)
                    <x-event-card :event="$event" />
                @endforeach
            </div>
        @endif
    </section>

    <section class="mx-auto max-w-7xl px-4 pb-16 sm:px-6 lg:px-8">
        <div class="relative isolate overflow-hidden rounded-lg border border-line bg-surface">
            <div aria-hidden="true" class="pointer-events-none absolute -bottom-40 left-1/4 size-[600px] rounded-full bg-amber-500/10 blur-[150px]"></div>
            <div class="relative z-10 grid items-center gap-8 border-l-2 border-accent p-8 sm:p-10 lg:grid-cols-2 lg:p-12">
                <div>
                    <p class="eyebrow">Untuk Penyelenggara</p>
                    <h2 class="mt-3 text-balance text-3xl font-extrabold tracking-tight text-ink sm:text-4xl">
                        Siap menyelenggarakan event berikutnya?
                    </h2>
                    <p class="mt-4 max-w-xl text-sm leading-relaxed text-zinc-400 sm:text-base">
                        Buat event, atur kuota dan harga tiket, pantau pendaftar secara real-time, dan kelola kehadiran
                        peserta — semuanya dalam satu platform.
                    </p>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row lg:justify-end">
                    <a href="{{ route('register') }}" class="btn-primary px-6 py-3">
                        Mulai sebagai Penyelenggara
                    </a>
                    @guest
                        <a href="{{ route('register') }}" class="btn-secondary px-6 py-3">
                            Daftar sebagai Peserta
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </section>
@endsection
