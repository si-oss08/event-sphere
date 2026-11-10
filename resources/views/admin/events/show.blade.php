@extends('layouts.dashboard')

@section('title', 'Detail Event')
@section('heading', 'Detail Event')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <a href="{{ route('admin.events.index') }}" class="text-xs font-semibold text-accent hover:text-accent-soft">← Kembali ke daftar event</a>
            <h2 class="mt-1 section-title">{{ $event->title }}</h2>
        </div>
        <a href="{{ route('events.show', $event) }}" class="btn-primary">Lihat Halaman Publik</a>
    </div>

    <div class="grid gap-6 xl:grid-cols-3">
        <div class="space-y-6 xl:col-span-2">
            <div class="overflow-hidden rounded-xl border border-line bg-surface">
                <img src="{{ $event->posterUrl() }}" alt="" class="aspect-[16/7] w-full object-cover">
                <div class="p-6">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="rounded-md px-2.5 py-1 text-[11px] font-semibold ring-1 ring-inset {{ $event->status->badgeClasses() }}">{{ $event->status->label() }}</span>
                        <span class="rounded-md border border-line bg-surface-2 px-2.5 py-1 text-[11px] font-medium text-zinc-300">{{ $event->category?->name ?? 'Tanpa kategori' }}</span>
                        @if ($event->featured)
                            <span class="rounded-md border border-amber-500/25 bg-amber-500/10 px-2.5 py-1 text-[11px] font-semibold text-amber-300">★ Unggulan</span>
                        @endif
                    </div>

                    <div class="mt-6 grid gap-4 sm:grid-cols-2">
                        <div>
                            <p class="text-[11px] font-semibold uppercase tracking-[0.12em] text-zinc-500">Jadwal</p>
                            <p class="mt-1 text-sm font-semibold text-ink">{{ $event->starts_at->translatedFormat('l, d M Y') }}</p>
                            <p class="text-sm text-zinc-400">{{ $event->starts_at->format('H:i') }}–{{ $event->ends_at->format('H:i') }} WIB</p>
                        </div>
                        <div>
                            <p class="text-[11px] font-semibold uppercase tracking-[0.12em] text-zinc-500">Lokasi</p>
                            <p class="mt-1 text-sm font-semibold text-ink">{{ $event->venue }}</p>
                            <p class="text-sm text-zinc-400">{{ $event->address ?: $event->city }}</p>
                        </div>
                        <div>
                            <p class="text-[11px] font-semibold uppercase tracking-[0.12em] text-zinc-500">Harga</p>
                            <p class="mt-1 text-sm font-semibold text-ink">{{ $event->formattedPrice() }}</p>
                        </div>
                        <div>
                            <p class="text-[11px] font-semibold uppercase tracking-[0.12em] text-zinc-500">Kapasitas</p>
                            <p class="mt-1 text-sm font-semibold text-ink">{{ $event->seatsTaken() }} / {{ $event->capacity }} peserta</p>
                        </div>
                    </div>

                    <div class="mt-6 border-t border-line pt-4">
                        <p class="text-[11px] font-semibold uppercase tracking-[0.12em] text-zinc-500">Deskripsi</p>
                        <p class="mt-1 whitespace-pre-line text-sm leading-relaxed text-zinc-400">{{ $event->description }}</p>
                    </div>
                </div>
            </div>

            <div class="table-wrap">
                <div class="border-b border-line px-5 py-4">
                    <h3 class="text-base font-semibold text-ink">Pendaftar terbaru</h3>
                </div>
                <ul class="divide-y divide-line">
                    @forelse ($registrations as $registration)
                        <li class="flex items-center gap-3 px-5 py-3">
                            <img src="{{ $registration->user->avatarUrl() }}" alt="" class="size-8 rounded-md object-cover">
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-medium text-zinc-200">{{ $registration->user->name }}</p>
                                <p class="truncate text-xs text-zinc-500">{{ $registration->user->email }}</p>
                            </div>
                            <span class="rounded-md px-2 py-0.5 text-[10px] font-semibold ring-1 ring-inset {{ $registration->status->badgeClasses() }}">{{ $registration->status->label() }}</span>
                        </li>
                    @empty
                        <li class="px-5 py-8 text-center text-sm text-zinc-500">Belum ada pendaftar.</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <aside class="space-y-4">
            <div class="rounded-xl border border-line bg-surface p-5">
                <h3 class="text-sm font-semibold text-ink">Penyelenggara</h3>
                <div class="mt-3 flex items-center gap-3">
                    <img src="{{ $event->organizer->avatarUrl() }}" alt="" class="size-11 rounded-lg object-cover">
                    <div class="min-w-0">
                        <p class="truncate text-sm font-semibold text-ink">{{ $event->organizer->name }}</p>
                        <p class="truncate text-xs text-zinc-500">{{ $event->organizer->email }}</p>
                    </div>
                </div>
                @if ($event->organizer->organization_name)
                    <p class="mt-3 rounded-lg border border-line bg-surface-2 px-3 py-2 text-xs font-medium text-zinc-300">{{ $event->organizer->organization_name }}</p>
                @endif
            </div>

            <div class="rounded-xl border border-line bg-surface p-5">
                <h3 class="text-sm font-semibold text-ink">Ubah status event</h3>
                <p class="mt-1 text-xs text-zinc-500">Status menentukan visibilitas event di halaman publik.</p>
                <form method="POST" action="{{ route('admin.events.status', $event) }}" class="mt-3 space-y-2">
                    @csrf
                    @method('PATCH')
                    <select name="status" class="select">
                        @foreach (\App\EventStatus::cases() as $status)
                            <option value="{{ $status->value }}" @selected($event->status === $status)>{{ $status->label() }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn-primary w-full">Simpan Status</button>
                </form>
            </div>

            <div class="rounded-xl border border-rose-500/25 bg-rose-500/[0.04] p-5">
                <h3 class="text-sm font-semibold text-rose-300">Zona berbahaya</h3>
                <p class="mt-1 text-xs leading-relaxed text-rose-400/80">Menghapus event akan menghapus seluruh pendaftaran terkait secara permanen.</p>
                <form method="POST" action="{{ route('admin.events.destroy', $event) }}" onsubmit="return confirm('Hapus event ini secara permanen?')" class="mt-3">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full rounded-lg bg-rose-500 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-rose-600">Hapus Event</button>
                </form>
            </div>
        </aside>
    </div>
@endsection
