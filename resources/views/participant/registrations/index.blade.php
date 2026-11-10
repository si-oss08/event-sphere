@extends('layouts.dashboard')

@section('title', 'Tiket Saya')
@section('heading', 'Tiket Saya')

@section('content')
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <h2 class="text-xl font-extrabold tracking-tight text-slate-900">Semua pendaftaran event</h2>
            <p class="mt-1 text-sm text-slate-600">Unduh atau tunjukkan tiket digital Anda saat menghadiri event.</p>
        </div>
        <a href="{{ route('events.index') }}" class="inline-flex items-center gap-2 rounded-xl bg-brand-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-brand-700">
            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
            Cari Event Baru
        </a>
    </div>

    @if ($registrations->isEmpty())
        <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-14 text-center">
            <span class="mx-auto flex size-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                <svg class="size-7" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 0 1 0 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 0 1 0-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375Z" /></svg>
            </span>
            <h3 class="mt-4 text-lg font-bold text-slate-900">Anda belum memiliki tiket</h3>
            <p class="mt-1 text-sm text-slate-500">Jelajahi event dan daftar untuk mendapatkan tiket digital pertama Anda.</p>
            <a href="{{ route('events.index') }}" class="mt-5 inline-flex rounded-xl bg-brand-600 px-5 py-2.5 text-sm font-bold text-white hover:bg-brand-700">Jelajahi Event</a>
        </div>
    @else
        <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($registrations as $registration)
                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                    <div class="relative h-28 bg-slate-100">
                        <img src="{{ $registration->event->posterUrl() }}" alt="" class="h-full w-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 to-transparent"></div>
                        <span class="absolute left-3 top-3 rounded-full bg-white/95 px-2.5 py-1 text-[11px] font-bold text-slate-800">{{ $registration->event->category?->name ?? 'Event' }}</span>
                        <span class="absolute bottom-3 left-3 rounded-full px-2.5 py-1 text-[11px] font-bold ring-1 ring-inset {{ $registration->status->badgeClasses() }}">{{ $registration->status->label() }}</span>
                    </div>

                    <div class="p-5">
                        <h3 class="line-clamp-2 text-base font-bold leading-snug text-slate-900">{{ $registration->event->title }}</h3>
                        <p class="mt-2 text-xs text-slate-500">{{ $registration->event->starts_at->translatedFormat('l, d M Y • H:i') }} WIB</p>
                        <p class="mt-0.5 truncate text-xs text-slate-500">{{ $registration->event->venue }}, {{ $registration->event->city }}</p>

                        <p class="mt-4 font-mono text-sm font-bold tracking-wider text-slate-800">{{ $registration->ticket_code }}</p>

                        <div class="mt-4 flex gap-2">
                            <a href="{{ route('registrations.show', $registration) }}" class="flex-1 rounded-lg bg-brand-600 px-3 py-2 text-center text-xs font-bold text-white transition hover:bg-brand-700">Lihat Tiket</a>
                            <a href="{{ route('events.show', $registration->event) }}" class="rounded-lg border border-slate-200 px-3 py-2 text-center text-xs font-bold text-slate-700 transition hover:bg-slate-50">Event</a>
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
