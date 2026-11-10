@extends('layouts.dashboard')

@section('title', 'Dasbor Peserta')
@section('heading', 'Ringkasan Peserta')

@section('content')
    <div class="rounded-xl border border-line bg-surface p-6 sm:p-8">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="eyebrow">Halo, {{ auth()->user()->name }}</p>
                <h2 class="mt-2 text-2xl font-bold tracking-tight text-ink sm:text-3xl">Siap menghadiri event berikutnya?</h2>
                <p class="mt-2 max-w-xl text-sm leading-relaxed text-zinc-400">Pantau tiket Anda dan temukan event baru yang sesuai minat.</p>
            </div>
            <a href="{{ route('events.index') }}" class="btn-primary">
                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
                Jelajahi Event
            </a>
        </div>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <x-stat-card label="Total pendaftaran" :value="$stats['total']" hint="Sepanjang waktu" icon="ticket" tone="brand" />
        <x-stat-card label="Event mendatang" :value="$stats['upcoming']" hint="Tiket aktif" icon="calendar" tone="emerald" />
        <x-stat-card label="Sudah hadir" :value="$stats['attended']" hint="Check-in berhasil" icon="users" tone="neutral" />
        <x-stat-card label="Dibatalkan" :value="$stats['cancelled']" hint="Tidak aktif" icon="chart" tone="rose" />
    </div>

    <div class="grid gap-6 xl:grid-cols-3">
        <div class="xl:col-span-2">
            <div class="table-wrap">
                <div class="flex items-center justify-between border-b border-line px-5 py-4">
                    <h2 class="text-base font-semibold text-ink">Tiket mendatang</h2>
                    <a href="{{ route('registrations.index') }}" class="text-xs font-semibold text-accent hover:text-accent-soft">Semua tiket →</a>
                </div>

                @if ($upcoming->isEmpty())
                    <div class="p-10 text-center">
                        <span class="mx-auto flex size-14 items-center justify-center rounded-lg border border-line bg-surface-2 text-zinc-500">
                            <svg class="size-7" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 0 1 0 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 0 1 0-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375Z" /></svg>
                        </span>
                        <p class="mt-4 text-sm font-semibold text-zinc-200">Belum ada tiket aktif</p>
                        <p class="mt-1 text-sm text-zinc-500">Daftar event favorit Anda dan tiket akan muncul di sini.</p>
                        <a href="{{ route('events.index') }}" class="btn-primary mt-4">Cari event</a>
                    </div>
                @else
                    <ul class="divide-y divide-line">
                        @foreach ($upcoming as $registration)
                            <li>
                                <a href="{{ route('registrations.show', $registration) }}" class="flex items-center gap-4 px-5 py-4 transition hover:bg-surface-2/70">
                                    <img src="{{ $registration->event->posterUrl() }}" alt="" class="size-16 shrink-0 rounded-lg object-cover">
                                    <div class="min-w-0 flex-1">
                                        <p class="truncate text-sm font-semibold text-ink">{{ $registration->event->title }}</p>
                                        <p class="mt-0.5 text-xs text-zinc-500">{{ $registration->event->starts_at->translatedFormat('d M Y, H:i') }} · {{ $registration->event->city }}</p>
                                        <div class="mt-2 flex items-center gap-2">
                                            <span class="rounded-md px-2 py-0.5 text-[11px] font-semibold ring-1 ring-inset {{ $registration->status->badgeClasses() }}">{{ $registration->status->label() }}</span>
                                            <span class="font-mono text-[11px] text-zinc-600">{{ $registration->ticket_code }}</span>
                                        </div>
                                    </div>
                                    <svg class="size-5 shrink-0 text-zinc-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /></svg>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>

        <div class="space-y-4">
            <div class="rounded-xl border border-line bg-surface p-5">
                <div class="flex items-center justify-between">
                    <h2 class="text-base font-semibold text-ink">Rekomendasi</h2>
                    <a href="{{ route('events.index') }}" class="text-xs font-semibold text-accent hover:text-accent-soft">Semua</a>
                </div>
                <div class="mt-4 space-y-3">
                    @forelse ($recommendations as $event)
                        <a href="{{ route('events.show', $event) }}" class="flex gap-3 rounded-lg p-2 transition hover:bg-surface-2">
                            <img src="{{ $event->posterUrl() }}" alt="" class="size-14 shrink-0 rounded-md object-cover">
                            <div class="min-w-0">
                                <p class="line-clamp-2 text-sm font-semibold leading-snug text-ink">{{ $event->title }}</p>
                                <p class="mt-1 text-xs text-zinc-500">{{ $event->starts_at->translatedFormat('d M Y') }}</p>
                                <p class="text-xs font-semibold text-accent">{{ $event->formattedPrice() }}</p>
                            </div>
                        </a>
                    @empty
                        <p class="text-sm text-zinc-500">Belum ada rekomendasi event baru.</p>
                    @endforelse
                </div>
            </div>

            <div class="rounded-xl border border-emerald-500/20 bg-emerald-500/[0.04] p-5">
                <h2 class="text-sm font-semibold text-emerald-300">Ingin menyelenggarakan event?</h2>
                <p class="mt-1 text-xs leading-relaxed text-emerald-400/70">Hubungi admin untuk mengubah akun Anda menjadi penyelenggara, atau daftar akun baru sebagai penyelenggara.</p>
            </div>
        </div>
    </div>
@endsection
