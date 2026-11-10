@extends('layouts.dashboard')

@section('title', 'Peserta '.$event->title)
@section('heading', 'Kelola Peserta')

@section('content')
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <a href="{{ route('organizer.events.index') }}" class="text-xs font-semibold text-accent hover:text-accent-soft">← Kembali ke event saya</a>
            <h2 class="mt-1 section-title">{{ $event->title }}</h2>
            <p class="mt-1 text-sm text-zinc-400">
                {{ $event->starts_at->translatedFormat('l, d M Y • H:i') }} · {{ $event->venue }}, {{ $event->city }}
            </p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('organizer.events.edit', $event) }}" class="btn-secondary">Edit Event</a>
            <a href="{{ route('events.show', $event) }}" class="btn-primary">Lihat Event</a>
        </div>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <x-stat-card label="Total pendaftar" :value="$summary['total']" hint="Semua status" icon="users" tone="brand" />
        <x-stat-card label="Terkonfirmasi" :value="$summary['confirmed']" hint="Siap hadir" icon="ticket" tone="emerald" />
        <x-stat-card label="Sudah check-in" :value="$summary['attended']" hint="Hadir di lokasi" icon="calendar" tone="neutral" />
        <x-stat-card label="Menunggu" :value="$summary['pending']" hint="Perlu konfirmasi" icon="chart" tone="amber" />
    </div>

    <form method="GET" class="flex flex-col gap-3 rounded-xl border border-line bg-surface p-4 sm:flex-row">
        <div class="relative flex-1">
            <div class="pointer-events-none absolute inset-y-0 left-0 z-10 flex items-center pl-3.5">
                <svg class="size-4 text-zinc-500" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
            </div>
            <input type="search" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Cari nama, email, atau kode tiket…" class="input pl-10">
        </div>
        <select name="status" class="select sm:w-56">
            <option value="">Semua status</option>
            @foreach (\App\RegistrationStatus::cases() as $status)
                <option value="{{ $status->value }}" @selected(($filters['status'] ?? '') === $status->value)>{{ $status->label() }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn-primary">Terapkan</button>
    </form>

    <div class="table-wrap">
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Peserta</th>
                        <th>Kode Tiket</th>
                        <th>Status</th>
                        <th>Terdaftar</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($registrations as $registration)
                        <tr>
                            <td>
                                <div class="flex items-center gap-3">
                                    <img src="{{ $registration->user->avatarUrl() }}" alt="" class="size-9 rounded-md object-cover">
                                    <div class="min-w-0">
                                        <p class="truncate text-sm font-semibold text-ink">{{ $registration->user->name }}</p>
                                        <p class="truncate text-xs text-zinc-500">{{ $registration->user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="font-mono text-xs font-medium text-zinc-400">{{ $registration->ticket_code }}</td>
                            <td>
                                <span class="rounded-md px-2.5 py-1 text-[11px] font-semibold ring-1 ring-inset {{ $registration->status->badgeClasses() }}">{{ $registration->status->label() }}</span>
                                @if ($registration->checked_in_at)
                                    <p class="mt-1 text-[11px] text-zinc-500">{{ $registration->checked_in_at->format('d M H:i') }}</p>
                                @endif
                            </td>
                            <td class="text-xs text-zinc-500">{{ $registration->created_at->translatedFormat('d M Y') }}</td>
                            <td>
                                <form method="POST" action="{{ route('organizer.registrations.status', $registration) }}" class="flex items-center justify-end gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="select w-52 px-2 py-1.5 text-xs">
                                        @foreach (\App\RegistrationStatus::cases() as $status)
                                            <option value="{{ $status->value }}" @selected($registration->status === $status)>{{ $status->label() }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="rounded-md border border-line bg-surface-2 px-3 py-1.5 text-xs font-semibold text-zinc-200 transition hover:border-line-strong">Simpan</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-14 text-center">
                                <p class="text-sm font-semibold text-zinc-200">Belum ada pendaftar</p>
                                <p class="mt-1 text-sm text-zinc-500">Bagikan halaman event Anda agar peserta mulai mendaftar.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div>
        {{ $registrations->links() }}
    </div>
@endsection
