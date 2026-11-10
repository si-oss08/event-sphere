@extends('layouts.dashboard')

@section('title', 'Dasbor Admin')
@section('heading', 'Ringkasan Sistem')

@section('content')
    <div class="relative overflow-hidden rounded-3xl bg-slate-950 p-6 sm:p-8">
        <div class="absolute inset-0 bg-gradient-to-br from-rose-700 via-brand-800 to-slate-950"></div>
        <div class="bg-grid absolute inset-0 opacity-40"></div>
        <div class="relative flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="text-sm font-bold uppercase tracking-[0.18em] text-rose-200">Panel Administrator</p>
                <h2 class="mt-2 text-2xl font-extrabold tracking-tight text-white sm:text-3xl">Selamat datang, {{ auth()->user()->name }}</h2>
                <p class="mt-2 max-w-xl text-sm text-slate-300">Pantau seluruh aktivitas platform: pengguna, event, kategori, dan pendaftaran.</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.events.index') }}" class="rounded-xl bg-white px-4 py-2.5 text-sm font-bold text-slate-900 shadow-lg transition hover:bg-slate-100">Kelola Event</a>
                <a href="{{ route('admin.users.index') }}" class="rounded-xl bg-white/10 px-4 py-2.5 text-sm font-bold text-white ring-1 ring-inset ring-white/20 transition hover:bg-white/15">Kelola Pengguna</a>
            </div>
        </div>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <x-stat-card label="Total pengguna" :value="$stats['users']" :hint="$stats['organizers'].' penyelenggara · '.$stats['participants'].' peserta'" icon="users" tone="brand" />
        <x-stat-card label="Total event" :value="$stats['events']" :hint="$stats['published'].' event terbit'" icon="calendar" tone="violet" />
        <x-stat-card label="Total pendaftaran" :value="$stats['registrations']" hint="Seluruh platform" icon="ticket" tone="sky" />
        <x-stat-card label="Estimasi pendapatan" value="Rp {{ number_format($stats['revenue'], 0, ',', '.') }}" hint="Tiket terkonfirmasi" icon="money" tone="emerald" />
    </div>

    <div class="grid gap-6 xl:grid-cols-5">
        <div class="xl:col-span-3">
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
                    <h2 class="text-base font-bold text-slate-900">Event terbaru</h2>
                    <a href="{{ route('admin.events.index') }}" class="text-xs font-bold text-brand-700 hover:text-brand-800">Lihat semua →</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 text-left text-sm">
                        <thead class="bg-slate-50 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                            <tr>
                                <th class="px-5 py-3">Event</th>
                                <th class="px-5 py-3">Status</th>
                                <th class="px-5 py-3">Peserta</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($recentEvents as $event)
                                <tr class="hover:bg-slate-50/60">
                                    <td class="px-5 py-3">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ $event->posterUrl() }}" alt="" class="size-10 rounded-lg object-cover">
                                            <div class="min-w-0">
                                                <a href="{{ route('admin.events.show', $event) }}" class="block max-w-56 truncate text-sm font-bold text-slate-900 hover:text-brand-700">{{ $event->title }}</a>
                                                <p class="max-w-56 truncate text-xs text-slate-500">{{ $event->organizer->name }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-3">
                                        <span class="rounded-full px-2 py-0.5 text-[11px] font-bold ring-1 ring-inset {{ $event->status->badgeClasses() }}">{{ $event->status->label() }}</span>
                                    </td>
                                    <td class="px-5 py-3 text-xs font-semibold text-slate-700">{{ $event->seatsTaken() }}/{{ $event->capacity }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="space-y-6 xl:col-span-2">
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
                    <h2 class="text-base font-bold text-slate-900">Pendaftaran terbaru</h2>
                    <a href="{{ route('admin.registrations.index') }}" class="text-xs font-bold text-brand-700">Semua</a>
                </div>
                <ul class="divide-y divide-slate-100">
                    @foreach ($recentRegistrations as $registration)
                        <li class="flex items-center gap-3 px-5 py-3">
                            <img src="{{ $registration->user->avatarUrl() }}" alt="" class="size-8 rounded-full object-cover">
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-sm font-semibold text-slate-900">{{ $registration->user->name }}</p>
                                <p class="truncate text-xs text-slate-500">{{ $registration->event->title }}</p>
                            </div>
                            <span class="shrink-0 rounded-full px-2 py-0.5 text-[10px] font-bold ring-1 ring-inset {{ $registration->status->badgeClasses() }}">{{ $registration->status->label() }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <h2 class="text-base font-bold text-slate-900">Kategori teratas</h2>
                    <a href="{{ route('admin.categories.index') }}" class="text-xs font-bold text-brand-700">Kelola</a>
                </div>
                <ul class="mt-4 space-y-3">
                    @foreach ($topCategories as $category)
                        <li>
                            <div class="flex items-center justify-between text-xs">
                                <span class="font-semibold text-slate-700">{{ $category->name }}</span>
                                <span class="text-slate-500">{{ $category->events_count }} event</span>
                            </div>
                            <div class="mt-1.5 h-1.5 overflow-hidden rounded-full bg-slate-100">
                                <div class="h-full rounded-full" style="width: {{ $stats['events'] > 0 ? max(6, round($category->events_count / $stats['events'] * 100)) : 0 }}%; background-color: {{ $category->color }}"></div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
