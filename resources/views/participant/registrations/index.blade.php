@extends('layouts.dashboard')

@section('title', 'Tiket Saya')
@section('heading', 'Tiket Saya')

@section('content')
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <h2 class="section-title">Semua pendaftaran event</h2>
            <p class="mt-1 text-sm text-zinc-400">Unduh atau tunjukkan tiket digital Anda saat menghadiri event.</p>
        </div>
        <a href="{{ route('events.index') }}" class="btn-primary">
            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
            Cari Event Baru
        </a>
    </div>

    @if ($registrations->isEmpty())
        <div class="rounded-xl border border-dashed border-line bg-surface p-14 text-center">
            <span class="mx-auto flex size-14 items-center justify-center rounded-lg border border-line bg-surface-2 text-zinc-500">
                <svg class="size-7" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 0 1 0 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 0 1 0-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375Z" /></svg>
            </span>
            <h3 class="mt-4 text-lg font-semibold text-ink">Anda belum memiliki tiket</h3>
            <p class="mt-1 text-sm text-zinc-500">Jelajahi event dan daftar untuk mendapatkan tiket digital pertama Anda.</p>
            <a href="{{ route('events.index') }}" class="btn-primary mt-5">Jelajahi Event</a>
        </div>
    @else
        <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($registrations as $registration)
                <div class="overflow-hidden rounded-xl border border-line bg-surface">
                    <div class="relative h-28 bg-surface-2">
                        <img src="{{ $registration->event->posterUrl() }}" alt="" class="h-full w-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/75 to-transparent"></div>
                        <span class="absolute left-3 top-3 rounded-md border border-white/10 bg-black/70 px-2.5 py-1 text-[11px] font-medium text-zinc-200 backdrop-blur-sm">{{ $registration->event->category?->name ?? 'Event' }}</span>
                        <span class="absolute bottom-3 left-3 rounded-md px-2.5 py-1 text-[11px] font-semibold ring-1 ring-inset {{ $registration->status->badgeClasses() }}">{{ $registration->status->label() }}</span>
                    </div>

                    <div class="p-5">
                        <h3 class="line-clamp-2 text-base font-semibold leading-snug text-ink">{{ $registration->event->title }}</h3>
                        <p class="mt-2 text-xs text-zinc-500">{{ $registration->event->starts_at->translatedFormat('l, d M Y • H:i') }} WIB</p>
                        <p class="mt-0.5 truncate text-xs text-zinc-500">{{ $registration->event->venue }}, {{ $registration->event->city }}</p>

                        <p class="mt-4 rounded-md border border-line bg-surface-2 px-3 py-2 font-mono text-sm font-semibold tracking-wider text-zinc-200">{{ $registration->ticket_code }}</p>

                        <div class="mt-4 flex gap-2">
                            <a href="{{ route('registrations.show', $registration) }}" class="btn-primary flex-1 px-3 py-2 text-xs">Lihat Tiket</a>
                            <a href="{{ route('events.show', $registration->event) }}" class="btn-secondary px-3 py-2 text-xs">Event</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $registrations->links() }}
        </div>
    @endif
@endsection
