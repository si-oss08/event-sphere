@extends('layouts.dashboard')

@section('title', 'Detail Event')
@section('heading', 'Detail Event')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <a href="{{ route('admin.events.index') }}" class="text-xs font-bold text-brand-700 hover:text-brand-800">← Kembali ke daftar event</a>
            <h2 class="mt-1 text-xl font-extrabold tracking-tight text-slate-900">{{ $event->title }}</h2>
        </div>
        <a href="{{ route('events.show', $event) }}" class="rounded-xl bg-brand-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-brand-700">Lihat Halaman Publik</a>
    </div>

    <div class="grid gap-6 xl:grid-cols-3">
        <div class="space-y-6 xl:col-span-2">
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <img src="{{ $event->posterUrl() }}" alt="" class="aspect-[16/7] w-full object-cover">
                <div class="p-6">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="rounded-full px-2.5 py-1 text-[11px] font-bold ring-1 ring-inset {{ $event->status->badgeClasses() }}">{{ $event->status->label() }}</span>
                        <span class="rounded-full bg-slate-100 px-2.5 py-1 text-[11px] font-bold text-slate-700">{{ $event->category?->name ?? 'Tanpa kategori' }}</span>
                        @if ($event->featured)
                            <span class="rounded-full bg-amber-100 px-2.5 py-1 text-[11px] font-bold text-amber-700">★ Unggulan</span>
                        @endif
                    </div>

                    <div class="mt-5 grid gap-4 sm:grid-cols-2">
                        <div>
                            <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Jadwal</p>
                            <p class="mt-1 text-sm font-semibold text-slate-900">{{ $event->starts_at->translatedFormat('l, d M Y') }}</p>
                            <p class="text-sm text-slate-600">{{ $event->starts_at->format('H:i') }}–{{ $event->ends_at->format('H:i') }} WIB</p>
                        </div>
                        <div>
                            <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Lokasi</p>
                            <p class="mt-1 text-sm font-semibold text-slate-900">{{ $event->venue }}</p>
                            <p class="text-sm text-slate-600">{{ $event->address ?: $event->city }}</p>
                        </div>
                        <div>
                            <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Harga</p>
                            <p class="mt-1 text-sm font-semibold text-slate-900">{{ $event->formattedPrice() }}</p>
                        </div>
                        <div>
                            <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Kapasitas</p>
                            <p class="mt-1 text-sm font-semibold text-slate-900">{{ $event->seatsTaken() }} / {{ $event->capacity }} peserta</p>
                        </div>
                    </div>

                    <div class="mt-5 border-t border-slate-100 pt-4">
                        <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Deskripsi</p>
                        <p class="mt-1 whitespace-pre-line text-sm leading-relaxed text-slate-600">{{ $event->description }}</p>
                    </div>
                </div>
            </div>

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-100 px-5 py-4">
                    <h3 class="text-base font-bold text-slate-900">Pendaftar terbaru</h3>
                </div>
                <ul class="divide-y divide-slate-100">
                    @forelse ($registrations as $registration)
                        <li class="flex items-center gap-3 px-5 py-3">
                            <img src="{{ $registration->user->avatarUrl() }}" alt="" class="size-8 rounded-full object-cover">
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-semibold text-slate-900">{{ $registration->user->name }}</p>
                                <p class="truncate text-xs text-slate-500">{{ $registration->user->email }}</p>
                            </div>
                            <span class="rounded-full px-2 py-0.5 text-[10px] font-bold ring-1 ring-inset {{ $registration->status->badgeClasses() }}">{{ $registration->status->label() }}</span>
                        </li>
                    @empty
                        <li class="px-5 py-8 text-center text-sm text-slate-500">Belum ada pendaftar.</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <aside class="space-y-4">
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <h3 class="text-sm font-bold text-slate-900">Penyelenggara</h3>
                <div class="mt-3 flex items-center gap-3">
                    <img src="{{ $event->organizer->avatarUrl() }}" alt="" class="size-11 rounded-full object-cover">
                    <div class="min-w-0">
                        <p class="truncate text-sm font-bold text-slate-900">{{ $event->organizer->name }}</p>
                        <p class="truncate text-xs text-slate-500">{{ $event->organizer->email }}</p>
                    </div>
                </div>
                @if ($event->organizer->organization_name)
                    <p class="mt-3 rounded-lg bg-slate-50 px-3 py-2 text-xs font-semibold text-slate-700">{{ $event->organizer->organization_name }}</p>
                @endif
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <h3 class="text-sm font-bold text-slate-900">Ubah status event</h3>
                <p class="mt-1 text-xs text-slate-500">Status menentukan visibilitas event di halaman publik.</p>
                <form method="POST" action="{{ route('admin.events.status', $event) }}" class="mt-3 space-y-2">
                    @csrf
                    @method('PATCH')
                    <select name="status" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm outline-none focus:border-brand-500 focus:ring-4 focus:ring-brand-100">
                        @foreach (\App\EventStatus::cases() as $status)
                            <option value="{{ $status->value }}" @selected($event->status === $status)>{{ $status->label() }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="w-full rounded-xl bg-brand-600 px-4 py-2.5 text-sm font-bold text-white transition hover:bg-brand-700">Simpan Status</button>
                </form>
            </div>

            <div class="rounded-2xl border border-rose-200 bg-rose-50 p-5">
                <h3 class="text-sm font-bold text-rose-900">Zona berbahaya</h3>
                <p class="mt-1 text-xs text-rose-700">Menghapus event akan menghapus seluruh pendaftaran terkait secara permanen.</p>
                <form method="POST" action="{{ route('admin.events.destroy', $event) }}" onsubmit="return confirm('Hapus event ini secara permanen?')" class="mt-3">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full rounded-xl bg-rose-600 px-4 py-2.5 text-sm font-bold text-white transition hover:bg-rose-700">Hapus Event</button>
                </form>
            </div>
        </aside>
    </div>
@endsection
