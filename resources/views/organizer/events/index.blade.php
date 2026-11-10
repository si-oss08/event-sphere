@extends('layouts.dashboard')

@section('title', 'Event Saya')
@section('heading', 'Event Saya')

@section('content')
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <h2 class="text-xl font-extrabold tracking-tight text-slate-900">Daftar event Anda</h2>
            <p class="mt-1 text-sm text-slate-600">Kelola publikasi, peserta, dan detail setiap event.</p>
        </div>
        <a href="{{ route('organizer.events.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-brand-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-brand-700">
            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
            Buat Event Baru
        </a>
    </div>

    <form method="GET" class="flex flex-col gap-3 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:flex-row">
        <div class="relative flex-1">
            <div class="pointer-events-none absolute inset-y-0 left-0 z-10 flex items-center pl-3.5">
                <svg class="size-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
            </div>
            <input type="search" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Cari judul event…" class="w-full rounded-xl border border-slate-200 bg-slate-50 py-2.5 pl-10 pr-3 text-sm outline-none focus:border-brand-400 focus:bg-white focus:ring-2 focus:ring-brand-100">
        </div>
        <select name="status" class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm outline-none focus:border-brand-400 focus:bg-white focus:ring-2 focus:ring-brand-100">
            <option value="">Semua status</option>
            @foreach (\App\EventStatus::cases() as $status)
                <option value="{{ $status->value }}" @selected(($filters['status'] ?? '') === $status->value)>{{ $status->label() }}</option>
            @endforeach
        </select>
        <button type="submit" class="rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-bold text-white transition hover:bg-slate-800">Terapkan</button>
    </form>

    @if ($events->isEmpty())
        <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-14 text-center">
            <span class="mx-auto flex size-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                <svg class="size-7" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" /></svg>
            </span>
            <h3 class="mt-4 text-lg font-bold text-slate-900">Belum ada event</h3>
            <p class="mt-1 text-sm text-slate-500">Buat event pertama Anda dan mulai menerima pendaftaran.</p>
            <a href="{{ route('organizer.events.create') }}" class="mt-5 inline-flex rounded-xl bg-brand-600 px-5 py-2.5 text-sm font-bold text-white hover:bg-brand-700">Buat Event</a>
        </div>
    @else
        <div class="space-y-4">
            @foreach ($events as $event)
                <div class="flex flex-col gap-4 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:flex-row sm:items-center">
                    <img src="{{ $event->posterUrl() }}" alt="" class="h-24 w-full shrink-0 rounded-xl object-cover sm:w-36">
                    <div class="min-w-0 flex-1">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="rounded-full px-2 py-0.5 text-[11px] font-bold ring-1 ring-inset {{ $event->status->badgeClasses() }}">{{ $event->status->label() }}</span>
                            @if ($event->featured)
                                <span class="rounded-full bg-amber-100 px-2 py-0.5 text-[11px] font-bold text-amber-700">★ Unggulan</span>
                            @endif
                            <span class="text-[11px] font-medium text-slate-500">{{ $event->category?->name ?? 'Tanpa kategori' }}</span>
                        </div>
                        <h3 class="mt-1.5 truncate text-base font-bold text-slate-900">{{ $event->title }}</h3>
                        <p class="mt-0.5 text-xs text-slate-500">{{ $event->starts_at->translatedFormat('l, d M Y • H:i') }} · {{ $event->venue }}, {{ $event->city }}</p>
                        <div class="mt-2 flex flex-wrap items-center gap-4 text-xs text-slate-500">
                            <span class="font-semibold text-slate-700">{{ $event->seatsTaken() }}/{{ $event->capacity }} peserta</span>
                            <span>{{ $event->formattedPrice() }}</span>
                            <span>{{ $event->occupancyPercentage() }}% terisi</span>
                        </div>
                    </div>

                    <div class="flex shrink-0 flex-wrap items-center gap-2">
                        <a href="{{ route('organizer.events.registrants', $event) }}" class="rounded-lg bg-brand-600 px-3 py-2 text-xs font-bold text-white transition hover:bg-brand-700">Peserta</a>
                        <a href="{{ route('organizer.events.edit', $event) }}" class="rounded-lg border border-slate-200 px-3 py-2 text-xs font-bold text-slate-700 transition hover:bg-slate-50">Edit</a>
                        <a href="{{ route('events.show', $event) }}" class="rounded-lg border border-slate-200 px-3 py-2 text-xs font-bold text-slate-700 transition hover:bg-slate-50">Lihat</a>
                        <form method="POST" action="{{ route('organizer.events.destroy', $event) }}" onsubmit="return confirm('Hapus event ini beserta seluruh pendaftarannya?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rounded-lg border border-rose-200 px-3 py-2 text-xs font-bold text-rose-600 transition hover:bg-rose-50">Hapus</button>
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
