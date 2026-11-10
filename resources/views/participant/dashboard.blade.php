@extends('layouts.dashboard')

@section('title', 'Dasbor Peserta')
@section('heading', 'Ringkasan Peserta')

@section('content')
    <div class="relative overflow-hidden rounded-3xl bg-slate-950 p-6 sm:p-8">
        <div class="absolute inset-0 bg-gradient-to-br from-brand-700 via-brand-800 to-slate-950"></div>
        <div class="bg-grid absolute inset-0 opacity-40"></div>
        <div class="relative flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="text-sm font-bold uppercase tracking-[0.18em] text-brand-300">Halo, {{ auth()->user()->name }}</p>
                <h2 class="mt-2 text-2xl font-extrabold tracking-tight text-white sm:text-3xl">Siap menghadiri event berikutnya?</h2>
                <p class="mt-2 max-w-xl text-sm text-slate-300">Pantau tiket Anda dan temukan event baru yang sesuai minat.</p>
            </div>
            <a href="{{ route('events.index') }}" class="inline-flex items-center gap-2 rounded-xl bg-white px-4 py-2.5 text-sm font-bold text-slate-900 shadow-lg transition hover:bg-slate-100">
                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
                Jelajahi Event
            </a>
        </div>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <x-stat-card label="Total pendaftaran" :value="$stats['total']" hint="Sepanjang waktu" icon="ticket" tone="brand" />
        <x-stat-card label="Event mendatang" :value="$stats['upcoming']" hint="Tiket aktif" icon="calendar" tone="emerald" />
        <x-stat-card label="Sudah hadir" :value="$stats['attended']" hint="Check-in berhasil" icon="users" tone="sky" />
        <x-stat-card label="Dibatalkan" :value="$stats['cancelled']" hint="Tidak aktif" icon="chart" tone="rose" />
    </div>

    <div class="grid gap-6 xl:grid-cols-3">
        <div class="xl:col-span-2">
            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
                    <h2 class="text-base font-bold text-slate-900">Tiket mendatang</h2>
                    <a href="{{ route('registrations.index') }}" class="text-xs font-bold text-brand-700 hover:text-brand-800">Semua tiket →</a>
                </div>

                @if ($upcoming->isEmpty())
                    <div class="p-10 text-center">
                        <span class="mx-auto flex size-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                            <svg class="size-7" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 0 1 0 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 0 1 0-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375Z" /></svg>
                        </span>
                        <p class="mt-4 text-sm font-bold text-slate-800">Belum ada tiket aktif</p>
                        <p class="mt-1 text-sm text-slate-500">Daftar event favorit Anda dan tiket akan muncul di sini.</p>
                        <a href="{{ route('events.index') }}" class="mt-4 inline-flex rounded-xl bg-brand-600 px-4 py-2.5 text-sm font-bold text-white hover:bg-brand-700">Cari event</a>
                    </div>
                @else
                    <ul class="divide-y divide-slate-100">
                        @foreach ($upcoming as $registration)
                            <li>
                                <a href="{{ route('registrations.show', $registration) }}" class="flex items-center gap-4 px-5 py-4 transition hover:bg-slate-50">
                                    <img src="{{ $registration->event->posterUrl() }}" alt="" class="size-16 shrink-0 rounded-xl object-cover">
                                    <div class="min-w-0 flex-1">
                                        <p class="truncate text-sm font-bold text-slate-900">{{ $registration->event->title }}</p>
                                        <p class="mt-0.5 text-xs text-slate-500">{{ $registration->event->starts_at->translatedFormat('d M Y, H:i') }} · {{ $registration->event->city }}</p>
                                        <div class="mt-2 flex items-center gap-2">
                                            <span class="rounded-full px-2 py-0.5 text-[11px] font-bold ring-1 ring-inset {{ $registration->status->badgeClasses() }}">{{ $registration->status->label() }}</span>
                                            <span class="font-mono text-[11px] text-slate-400">{{ $registration->ticket_code }}</span>
                                        </div>
                                    </div>
                                    <svg class="size-5 shrink-0 text-slate-300" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /></svg>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>

        <div class="space-y-4">
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <h2 class="text-base font-bold text-slate-900">Rekomendasi</h2>
                    <a href="{{ route('events.index') }}" class="text-xs font-bold text-brand-700">Semua</a>
                </div>
                <div class="mt-4 space-y-3">
                    @forelse ($recommendations as $event)
                        <a href="{{ route('events.show', $event) }}" class="flex gap-3 rounded-xl p-2 transition hover:bg-slate-50">
                            <img src="{{ $event->posterUrl() }}" alt="" class="size-14 shrink-0 rounded-lg object-cover">
                            <div class="min-w-0">
                                <p class="line-clamp-2 text-sm font-bold leading-snug text-slate-900">{{ $event->title }}</p>
                                <p class="mt-1 text-xs text-slate-500">{{ $event->starts_at->translatedFormat('d M Y') }}</p>
                                <p class="text-xs font-bold text-brand-700">{{ $event->formattedPrice() }}</p>
                            </div>
                        </a>
                    @empty
                        <p class="text-sm text-slate-500">Belum ada rekomendasi event baru.</p>
                    @endforelse
                </div>
            </div>

            <div class="rounded-2xl border border-brand-100 bg-brand-50 p-5">
                <h2 class="text-sm font-bold text-brand-900">Ingin menyelenggarakan event?</h2>
                <p class="mt-1 text-xs leading-relaxed text-brand-800">Hubungi admin untuk mengubah akun Anda menjadi penyelenggara, atau daftar akun baru sebagai penyelenggara.</p>
            </div>
        </div>
    </div>
@endsection
