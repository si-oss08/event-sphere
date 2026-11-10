@extends('layouts.app')

@section('title', 'Jelajahi Event — EventSphere')
@section('description', 'Temukan konferensi, workshop, seminar, konser, dan festival terbaik di seluruh Indonesia.')

@section('content')
    <section class="relative overflow-hidden bg-slate-950">
        <div class="absolute inset-0 bg-gradient-to-br from-brand-800 via-slate-950 to-slate-950"></div>
        <div class="bg-grid absolute inset-0 opacity-40"></div>
        <div class="relative mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
            <p class="text-sm font-bold uppercase tracking-[0.18em] text-brand-300">Jelajahi</p>
            <h1 class="mt-2 text-3xl font-extrabold tracking-tight text-white sm:text-4xl">Temukan event berikutnya</h1>
            <p class="mt-3 max-w-2xl text-sm text-slate-300 sm:text-base">
                Saring event berdasarkan kategori, kota, dan harga. Semua pendaftaran dikelola langsung oleh penyelenggara terverifikasi.
            </p>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <form method="GET" action="{{ route('events.index') }}" class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <div class="grid gap-3 md:grid-cols-12">
                <div class="md:col-span-4">
                    <label for="q" class="mb-1 block text-xs font-bold uppercase tracking-wider text-slate-500">Kata kunci</label>
                    <div class="relative">
                        <div class="pointer-events-none absolute inset-y-0 left-0 z-10 flex items-center pl-3.5">
                            <svg class="size-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
                        </div>
                        <input id="q" type="search" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Nama event, lokasi…" class="w-full rounded-xl border border-slate-200 bg-slate-50 py-2.5 pl-10 pr-3 text-sm text-slate-900 outline-none transition focus:border-brand-400 focus:bg-white focus:ring-2 focus:ring-brand-100">
                    </div>
                </div>

                <div class="md:col-span-3">
                    <label for="category" class="mb-1 block text-xs font-bold uppercase tracking-wider text-slate-500">Kategori</label>
                    <select id="category" name="category" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-brand-400 focus:bg-white focus:ring-2 focus:ring-brand-100">
                        <option value="">Semua kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->slug }}" @selected(($filters['category'] ?? '') === $category->slug)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label for="city" class="mb-1 block text-xs font-bold uppercase tracking-wider text-slate-500">Kota</label>
                    <select id="city" name="city" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-brand-400 focus:bg-white focus:ring-2 focus:ring-brand-100">
                        <option value="">Semua kota</option>
                        @foreach ($cities as $city)
                            <option value="{{ $city }}" @selected(($filters['city'] ?? '') === $city)>{{ $city }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label for="sort" class="mb-1 block text-xs font-bold uppercase tracking-wider text-slate-500">Urutkan</label>
                    <select id="sort" name="sort" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-brand-400 focus:bg-white focus:ring-2 focus:ring-brand-100">
                        <option value="soonest" @selected(($filters['sort'] ?? 'soonest') === 'soonest')>Terdekat</option>
                        <option value="latest" @selected(($filters['sort'] ?? '') === 'latest')>Terbaru</option>
                        <option value="cheapest" @selected(($filters['sort'] ?? '') === 'cheapest')>Termurah</option>
                        <option value="popular" @selected(($filters['sort'] ?? '') === 'popular')>Terpopuler</option>
                    </select>
                </div>

                <div class="flex items-end gap-2 md:col-span-1">
                    <button type="submit" class="w-full rounded-xl bg-brand-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-brand-700">
                        Filter
                    </button>
                </div>
            </div>

            @if (($filters['q'] ?? null) || ($filters['category'] ?? null) || ($filters['city'] ?? null))
                <div class="mt-3 flex flex-wrap items-center gap-2 border-t border-slate-100 pt-3">
                    <span class="text-xs font-semibold text-slate-500">Filter aktif:</span>
                    @if ($filters['q'] ?? null)
                        <span class="rounded-full bg-brand-50 px-2.5 py-1 text-xs font-semibold text-brand-700">“{{ $filters['q'] }}”</span>
                    @endif
                    @if ($filters['category'] ?? null)
                        <span class="rounded-full bg-brand-50 px-2.5 py-1 text-xs font-semibold text-brand-700">{{ $categories->firstWhere('slug', $filters['category'])?->name ?? $filters['category'] }}</span>
                    @endif
                    @if ($filters['city'] ?? null)
                        <span class="rounded-full bg-brand-50 px-2.5 py-1 text-xs font-semibold text-brand-700">{{ $filters['city'] }}</span>
                    @endif
                    <a href="{{ route('events.index') }}" class="text-xs font-bold text-rose-600 hover:text-rose-700">Reset</a>
                </div>
            @endif
        </form>

        <div class="mt-6 flex items-center justify-between">
            <p class="text-sm text-slate-600">
                Menampilkan <span class="font-bold text-slate-900">{{ $events->firstItem() ?? 0 }}–{{ $events->lastItem() ?? 0 }}</span>
                dari <span class="font-bold text-slate-900">{{ $events->total() }}</span> event
            </p>
        </div>

        @if ($events->isEmpty())
            <div class="mt-6 rounded-2xl border border-dashed border-slate-300 bg-white p-14 text-center">
                <span class="mx-auto flex size-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                    <svg class="size-7" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" /></svg>
                </span>
                <h2 class="mt-4 text-lg font-bold text-slate-900">Event tidak ditemukan</h2>
                <p class="mt-1 text-sm text-slate-500">Coba ubah kata kunci atau filter pencarian Anda.</p>
                <a href="{{ route('events.index') }}" class="mt-5 inline-flex rounded-xl bg-brand-600 px-4 py-2.5 text-sm font-bold text-white hover:bg-brand-700">Lihat semua event</a>
            </div>
        @else
            <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($events as $event)
                    <x-event-card :event="$event" />
                @endforeach
            </div>

            <div class="mt-10">
                {{ $events->links() }}
            </div>
        @endif
    </section>
@endsection
