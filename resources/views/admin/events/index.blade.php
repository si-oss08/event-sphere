@extends('layouts.dashboard')

@section('title', 'Kelola Event')
@section('heading', 'Kelola Event')

@section('content')
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <h2 class="section-title">Semua event</h2>
            <p class="mt-1 text-sm text-zinc-400">Tinjau, ubah status, atau hapus event dari seluruh penyelenggara.</p>
        </div>
        <a href="{{ route('admin.categories.index') }}" class="btn-secondary">Kelola Kategori</a>
    </div>

    <form method="GET" class="flex flex-col gap-3 rounded-lg border border-line bg-surface p-4 sm:flex-row">
        <div class="relative flex-1">
            <div class="pointer-events-none absolute inset-y-0 left-0 z-10 flex items-center pl-3.5">
                <svg class="size-4 text-zinc-500" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
            </div>
            <input type="search" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Cari event atau penyelenggara…" class="input pl-10">
        </div>
        <select name="status" class="select sm:w-48">
            <option value="">Semua status</option>
            @foreach (\App\EventStatus::cases() as $status)
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
                        <th>Event</th>
                        <th>Penyelenggara</th>
                        <th>Jadwal</th>
                        <th>Status</th>
                        <th>Peserta</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($events as $event)
                        <tr>
                            <td>
                                <div class="flex items-center gap-3">
                                    <img src="{{ $event->posterUrl() }}" alt="" class="size-11 rounded-md object-cover">
                                    <div class="min-w-0">
                                        <a href="{{ route('admin.events.show', $event) }}" class="block max-w-64 truncate text-sm font-semibold text-ink hover:text-accent-soft">{{ $event->title }}</a>
                                        <p class="max-w-64 truncate text-xs text-zinc-500">{{ $event->category?->name ?? 'Tanpa kategori' }} · {{ $event->city }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="text-xs">
                                <p class="font-medium text-zinc-200">{{ $event->organizer->name }}</p>
                                <p class="text-zinc-500">{{ $event->organizer->organization_name ?: '—' }}</p>
                            </td>
                            <td class="text-xs text-zinc-400">{{ $event->starts_at->translatedFormat('d M Y') }}</td>
                            <td>
                                <span class="rounded-md px-2.5 py-1 text-[11px] font-semibold ring-1 ring-inset {{ $event->status->badgeClasses() }}">{{ $event->status->label() }}</span>
                            </td>
                            <td class="text-xs font-medium text-zinc-300">{{ $event->seatsTaken() }}/{{ $event->capacity }}</td>
                            <td>
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.events.show', $event) }}" class="btn-secondary px-3 py-1.5 text-xs">Detail</a>
                                    <form method="POST" action="{{ route('admin.events.destroy', $event) }}" onsubmit="return confirm('Hapus event ini secara permanen?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-danger px-3 py-1.5 text-xs">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-14 text-center">
                                <p class="text-sm font-semibold text-zinc-200">Tidak ada event yang cocok</p>
                                <p class="mt-1 text-sm text-zinc-500">Coba ubah kata kunci atau filter status.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div>
        {{ $events->links() }}
    </div>
@endsection
