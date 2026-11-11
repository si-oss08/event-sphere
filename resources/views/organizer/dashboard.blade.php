@extends('layouts.dashboard')

@section('title', 'Dasbor Penyelenggara')
@section('heading', 'Ringkasan Penyelenggara')

@section('content')
    <div class="rounded-lg border border-line border-l-2 border-l-accent bg-surface p-6 sm:p-8">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="eyebrow">{{ auth()->user()->organization_name ?: 'Penyelenggara' }}</p>
                <h2 class="mt-2 text-2xl font-bold tracking-tight text-ink sm:text-3xl">Kelola event Anda dengan mudah</h2>
                <p class="mt-2 max-w-xl text-sm leading-relaxed text-zinc-400">Pantau pendaftaran, konfirmasi peserta, dan siapkan event berikutnya.</p>
            </div>
            <a href="{{ route('organizer.events.create') }}" class="btn-primary">
                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                Buat Event Baru
            </a>
        </div>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <x-stat-card label="Total event" :value="$stats['events']" hint="Semua status" icon="calendar" tone="brand" />
        <x-stat-card label="Event terbit" :value="$stats['published']" hint="Tampil di publik" icon="chart" tone="gold" />
        <x-stat-card label="Total pendaftar" :value="$stats['registrations']" hint="Seluruh event Anda" icon="users" tone="neutral" />
        <x-stat-card label="Estimasi pendapatan" value="Rp {{ number_format($stats['revenue'], 0, ',', '.') }}" hint="Dari tiket terkonfirmasi" icon="money" tone="amber" value-class="text-xl" />
    </div>

    <div class="grid gap-6 xl:grid-cols-5">
        <div class="xl:col-span-3">
            <div class="table-wrap">
                <div class="flex items-center justify-between border-b border-line px-5 py-4">
                    <h2 class="text-base font-semibold text-ink">Event terdekat</h2>
                    <a href="{{ route('organizer.events.index') }}" class="text-xs font-semibold text-accent hover:text-accent-soft">Semua event →</a>
                </div>

                @if ($events->isEmpty())
                    <div class="p-10 text-center">
                        <p class="text-sm font-semibold text-zinc-200">Belum ada event</p>
                        <p class="mt-1 text-sm text-zinc-500">Mulai dengan membuat event pertama Anda.</p>
                        <a href="{{ route('organizer.events.create') }}" class="btn-primary mt-4">Buat Event</a>
                    </div>
                @else
                    <ul class="divide-y divide-line">
                        @foreach ($events as $event)
                            <li class="flex items-center gap-4 px-5 py-4">
                                <img src="{{ $event->posterUrl() }}" alt="" class="size-14 shrink-0 rounded-lg object-cover">
                                <div class="min-w-0 flex-1">
                                    <p class="truncate text-sm font-semibold text-ink">{{ $event->title }}</p>
                                    <p class="mt-0.5 text-xs text-zinc-500">{{ $event->starts_at->translatedFormat('d M Y, H:i') }} · {{ $event->city }}</p>
                                    <div class="mt-1.5 flex flex-wrap items-center gap-2">
                                        <span class="rounded-md px-2 py-0.5 text-[11px] font-semibold ring-1 ring-inset {{ $event->status->badgeClasses() }}">{{ $event->status->label() }}</span>
                                        <span class="text-[11px] font-medium text-zinc-500">{{ $event->seatsTaken() }}/{{ $event->capacity }} peserta</span>
                                    </div>
                                </div>
                                <a href="{{ route('organizer.events.registrants', $event) }}" class="btn-secondary px-3 py-1.5 text-xs">Peserta</a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>

        <div class="xl:col-span-2">
            <div class="table-wrap">
                <div class="border-b border-line px-5 py-4">
                    <h2 class="text-base font-semibold text-ink">Pendaftaran terbaru</h2>
                </div>

                @if ($registrations->isEmpty())
                    <p class="p-6 text-sm text-zinc-500">Belum ada pendaftaran masuk.</p>
                @else
                    <ul class="divide-y divide-line">
                        @foreach ($registrations as $registration)
                            <li class="flex items-center gap-3 px-5 py-3.5">
                                <img src="{{ $registration->user->avatarUrl() }}" alt="" class="size-9 rounded-md object-cover">
                                <div class="min-w-0 flex-1">
                                    <p class="truncate text-sm font-medium text-zinc-200">{{ $registration->user->name }}</p>
                                    <p class="truncate text-xs text-zinc-500">{{ $registration->event->title }}</p>
                                </div>
                                <span class="shrink-0 rounded-md px-2 py-0.5 text-[10px] font-semibold ring-1 ring-inset {{ $registration->status->badgeClasses() }}">{{ $registration->status->label() }}</span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
@endsection
