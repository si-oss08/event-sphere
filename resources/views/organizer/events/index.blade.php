@extends('layouts.dashboard')

@section('title', 'Event Saya')
@section('heading', 'Event Saya')

@section('content')
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <h2 class="section-title">Daftar event Anda</h2>
            <p class="mt-1 text-sm text-zinc-400">Kelola publikasi, peserta, dan detail setiap event.</p>
        </div>
        <a href="{{ route('organizer.events.create') }}" class="btn-primary">
            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
            Buat Event Baru
        </a>
    </div>

    <form method="GET" class="flex flex-col gap-3 rounded-lg border border-line bg-surface p-4 sm:flex-row">
        <div class="relative flex-1">
            <div class="pointer-events-none absolute inset-y-0 left-0 z-10 flex items-center pl-3.5">
                <svg class="size-4 text-zinc-500" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
            </div>
            <input type="search" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Cari judul event…" class="input pl-10">
        </div>
        <select name="status" class="select sm:w-48">
            <option value="">Semua status</option>
            @foreach (\App\EventStatus::cases() as $status)
                <option value="{{ $status->value }}" @selected(($filters['status'] ?? '') === $status->value)>{{ $status->label() }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn-primary">Terapkan</button>
    </form>

    @if ($events->isEmpty())
        <div class="rounded-lg border border-dashed border-line bg-surface p-14 text-center">
            <span class="mx-auto flex size-14 items-center justify-center rounded-lg border border-line bg-surface-2 text-zinc-500">
                <svg class="size-7" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" /></svg>
            </span>
            <h3 class="mt-4 text-lg font-semibold text-ink">Belum ada event</h3>
            <p class="mt-1 text-sm text-zinc-500">Buat event pertama Anda dan mulai menerima pendaftaran.</p>
            <a href="{{ route('organizer.events.create') }}" class="btn-primary mt-5">Buat Event</a>
        </div>
    @else
        <div class="space-y-3">
            @foreach ($events as $event)
                <div class="flex flex-col gap-4 rounded-lg border border-line bg-surface p-4 sm:flex-row sm:items-center">
                    <img src="{{ $event->posterUrl() }}" alt="" class="h-24 w-full shrink-0 rounded-lg object-cover sm:w-36">
                    <div class="min-w-0 flex-1">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="rounded-md px-2 py-0.5 text-[11px] font-semibold ring-1 ring-inset {{ $event->status->badgeClasses() }}">{{ $event->status->label() }}</span>
                            @if ($event->featured)
                                <span class="rounded border border-accent/25 bg-accent/10 px-2 py-0.5 text-[10px] font-bold uppercase tracking-[0.1em] text-accent-soft">★ Unggulan</span>
                            @endif
                            <span class="text-[11px] font-medium text-zinc-500">{{ $event->category?->name ?? 'Tanpa kategori' }}</span>
                        </div>
                        <h3 class="mt-1.5 truncate text-base font-semibold text-ink">{{ $event->title }}</h3>
                        <p class="mt-0.5 text-xs text-zinc-500">{{ $event->starts_at->translatedFormat('l, d M Y • H:i') }} · {{ $event->venue }}, {{ $event->city }}</p>
                        <div class="mt-2 flex flex-wrap items-center gap-4 text-xs text-zinc-500">
                            <span class="font-medium text-zinc-300">{{ $event->seatsTaken() }}/{{ $event->capacity }} peserta</span>
                            <span>{{ $event->formattedPrice() }}</span>
                            <span>{{ $event->occupancyPercentage() }}% terisi</span>
                        </div>
                    </div>

                    <div class="flex shrink-0 flex-wrap items-center gap-2">
                        <a href="{{ route('organizer.events.registrants', $event) }}" class="btn-primary px-3 py-2 text-xs">Peserta</a>
                        <a href="{{ route('organizer.events.edit', $event) }}" class="btn-secondary px-3 py-2 text-xs">Edit</a>
                        <a href="{{ route('events.show', $event) }}" class="btn-secondary px-3 py-2 text-xs">Lihat</a>
                        <form method="POST" action="{{ route('organizer.events.destroy', $event) }}" onsubmit="return confirm('Hapus event ini beserta seluruh pendaftarannya?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-danger px-3 py-2 text-xs">Hapus</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $events->links() }}
        </div>
    @endif
@endsection
