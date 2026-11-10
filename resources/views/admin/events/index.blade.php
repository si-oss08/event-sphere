@extends('layouts.dashboard')

@section('title', 'Kelola Event')
@section('heading', 'Kelola Event')

@section('content')
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <h2 class="text-xl font-extrabold tracking-tight text-slate-900">Semua event</h2>
            <p class="mt-1 text-sm text-slate-600">Tinjau, ubah status, atau hapus event dari seluruh penyelenggara.</p>
        </div>
        <a href="{{ route('admin.categories.index') }}" class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-bold text-slate-700 shadow-sm transition hover:bg-slate-50">Kelola Kategori</a>
    </div>

    <form method="GET" class="flex flex-col gap-3 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:flex-row">
        <div class="relative flex-1">
            <div class="pointer-events-none absolute inset-y-0 left-0 z-10 flex items-center pl-3.5">
                <svg class="size-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
            </div>
            <input type="search" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Cari event atau penyelenggara…" class="w-full rounded-xl border border-slate-200 bg-slate-50 py-2.5 pl-10 pr-3 text-sm outline-none focus:border-brand-400 focus:bg-white focus:ring-2 focus:ring-brand-100">
        </div>
        <select name="status" class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm outline-none focus:border-brand-400 focus:bg-white focus:ring-2 focus:ring-brand-100">
            <option value="">Semua status</option>
            @foreach (\App\EventStatus::cases() as $status)
                <option value="{{ $status->value }}" @selected(($filters['status'] ?? '') === $status->value)>{{ $status->label() }}</option>
            @endforeach
        </select>
        <button type="submit" class="rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-bold text-white transition hover:bg-slate-800">Terapkan</button>
    </form>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100 text-left text-sm">
                <thead class="bg-slate-50 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-5 py-3">Event</th>
                        <th class="px-5 py-3">Penyelenggara</th>
                        <th class="px-5 py-3">Jadwal</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3">Peserta</th>
                        <th class="px-5 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($events as $event)
                        <tr class="hover:bg-slate-50/60">
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $event->posterUrl() }}" alt="" class="size-11 rounded-lg object-cover">
                                    <div class="min-w-0">
                                        <a href="{{ route('admin.events.show', $event) }}" class="block max-w-64 truncate text-sm font-bold text-slate-900 hover:text-brand-700">{{ $event->title }}</a>
                                        <p class="max-w-64 truncate text-xs text-slate-500">{{ $event->category?->name ?? 'Tanpa kategori' }} · {{ $event->city }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3 text-xs">
                                <p class="font-semibold text-slate-800">{{ $event->organizer->name }}</p>
                                <p class="text-slate-500">{{ $event->organizer->organization_name ?: '—' }}</p>
                            </td>
                            <td class="px-5 py-3 text-xs text-slate-600">{{ $event->starts_at->translatedFormat('d M Y') }}</td>
                            <td class="px-5 py-3">
                                <span class="rounded-full px-2.5 py-1 text-[11px] font-bold ring-1 ring-inset {{ $event->status->badgeClasses() }}">{{ $event->status->label() }}</span>
                            </td>
                            <td class="px-5 py-3 text-xs font-semibold text-slate-700">{{ $event->seatsTaken() }}/{{ $event->capacity }}</td>
                            <td class="px-5 py-3">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.events.show', $event) }}" class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-bold text-slate-700 hover:bg-slate-50">Detail</a>
                                    <form method="POST" action="{{ route('admin.events.destroy', $event) }}" onsubmit="return confirm('Hapus event ini secara permanen?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-lg border border-rose-200 px-3 py-1.5 text-xs font-bold text-rose-600 hover:bg-rose-50">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-14 text-center">
                                <p class="text-sm font-bold text-slate-800">Tidak ada event yang cocok</p>
                                <p class="mt-1 text-sm text-slate-500">Coba ubah kata kunci atau filter status.</p>
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
