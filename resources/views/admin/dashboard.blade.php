@extends('layouts.dashboard')

@section('title', 'Dasbor Admin')
@section('heading', 'Ringkasan Sistem')

@section('content')
    <div class="rounded-lg border border-line border-l-2 border-l-accent bg-surface p-6 sm:p-8">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="eyebrow">Panel Administrator</p>
                <h2 class="mt-2 text-2xl font-bold tracking-tight text-ink sm:text-3xl">Selamat datang, {{ auth()->user()->name }}</h2>
                <p class="mt-2 max-w-xl text-sm leading-relaxed text-zinc-400">Pantau seluruh aktivitas platform: pengguna, event, kategori, dan pendaftaran.</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.events.index') }}" class="btn-primary">Kelola Event</a>
                <a href="{{ route('admin.users.index') }}" class="btn-secondary">Kelola Pengguna</a>
            </div>
        </div>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <x-stat-card label="Total pengguna" :value="$stats['users']" :hint="$stats['organizers'].' penyelenggara · '.$stats['participants'].' peserta'" icon="users" tone="brand" />
        <x-stat-card label="Total event" :value="$stats['events']" :hint="$stats['published'].' event terbit'" icon="calendar" tone="neutral" />
        <x-stat-card label="Total pendaftaran" :value="$stats['registrations']" hint="Seluruh platform" icon="ticket" tone="neutral" />
        <x-stat-card label="Estimasi pendapatan" value="Rp {{ number_format($stats['revenue'], 0, ',', '.') }}" hint="Tiket terkonfirmasi" icon="money" tone="amber" value-class="text-xl" />
    </div>

    <div class="grid gap-6 xl:grid-cols-5">
        <div class="xl:col-span-3">
            <div class="table-wrap">
                <div class="flex items-center justify-between border-b border-line px-5 py-4">
                    <h2 class="text-base font-semibold text-ink">Event terbaru</h2>
                    <a href="{{ route('admin.events.index') }}" class="text-xs font-semibold text-accent hover:text-accent-soft">Lihat semua →</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Event</th>
                                <th>Status</th>
                                <th>Peserta</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentEvents as $event)
                                <tr>
                                    <td>
                                        <div class="flex items-center gap-3">
                                            <img src="{{ $event->posterUrl() }}" alt="" class="size-10 rounded-md object-cover">
                                            <div class="min-w-0">
                                                <a href="{{ route('admin.events.show', $event) }}" class="block max-w-56 truncate text-sm font-semibold text-ink hover:text-accent-soft">{{ $event->title }}</a>
                                                <p class="max-w-56 truncate text-xs text-zinc-500">{{ $event->organizer->name }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="rounded-md px-2 py-0.5 text-[11px] font-semibold ring-1 ring-inset {{ $event->status->badgeClasses() }}">{{ $event->status->label() }}</span>
                                    </td>
                                    <td class="text-xs font-medium text-zinc-300">{{ $event->seatsTaken() }}/{{ $event->capacity }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="space-y-6 xl:col-span-2">
            <div class="table-wrap">
                <div class="flex items-center justify-between border-b border-line px-5 py-4">
                    <h2 class="text-base font-semibold text-ink">Pendaftaran terbaru</h2>
                    <a href="{{ route('admin.registrations.index') }}" class="text-xs font-semibold text-accent hover:text-accent-soft">Semua</a>
                </div>
                <ul class="divide-y divide-line">
                    @foreach ($recentRegistrations as $registration)
                        <li class="flex items-center gap-3 px-5 py-3">
                            <img src="{{ $registration->user->avatarUrl() }}" alt="" class="size-8 rounded-md object-cover">
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-medium text-zinc-200">{{ $registration->user->name }}</p>
                                <p class="truncate text-xs text-zinc-500">{{ $registration->event->title }}</p>
                            </div>
                            <span class="shrink-0 rounded-md px-2 py-0.5 text-[10px] font-semibold ring-1 ring-inset {{ $registration->status->badgeClasses() }}">{{ $registration->status->label() }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="rounded-lg border border-line bg-surface p-5">
                <div class="flex items-center justify-between">
                    <h2 class="text-base font-semibold text-ink">Kategori teratas</h2>
                    <a href="{{ route('admin.categories.index') }}" class="text-xs font-semibold text-accent hover:text-accent-soft">Kelola</a>
                </div>
                <ul class="mt-4 space-y-3">
                    @foreach ($topCategories as $category)
                        <li>
                            <div class="flex items-center justify-between text-xs">
                                <span class="font-medium text-zinc-300">{{ $category->name }}</span>
                                <span class="text-zinc-500">{{ $category->events_count }} event</span>
                            </div>
                            <div class="mt-1.5 h-1.5 overflow-hidden rounded-full bg-surface-2">
                                <div class="h-full rounded-full bg-accent" style="width: {{ $stats['events'] > 0 ? max(6, round($category->events_count / $stats['events'] * 100)) : 0 }}%"></div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
