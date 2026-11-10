@extends('layouts.dashboard')

@section('title', 'Semua Pendaftaran')
@section('heading', 'Data Pendaftaran')

@section('content')
    <div>
        <h2 class="text-xl font-extrabold tracking-tight text-slate-900">Semua pendaftaran</h2>
        <p class="mt-1 text-sm text-slate-600">Pantau aktivitas pendaftaran peserta di seluruh event.</p>
    </div>

    <form method="GET" class="flex flex-col gap-3 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:flex-row">
        <div class="relative flex-1">
            <div class="pointer-events-none absolute inset-y-0 left-0 z-10 flex items-center pl-3.5">
                <svg class="size-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
            </div>
            <input type="search" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Cari peserta, event, atau kode tiket…" class="w-full rounded-xl border border-slate-200 bg-slate-50 py-2.5 pl-10 pr-3 text-sm outline-none focus:border-brand-400 focus:bg-white focus:ring-2 focus:ring-brand-100">
        </div>
        <select name="status" class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm outline-none focus:border-brand-400 focus:bg-white focus:ring-2 focus:ring-brand-100">
            <option value="">Semua status</option>
            @foreach (\App\RegistrationStatus::cases() as $status)
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
                        <th class="px-5 py-3">Peserta</th>
                        <th class="px-5 py-3">Event</th>
                        <th class="px-5 py-3">Kode Tiket</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3">Tanggal Daftar</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($registrations as $registration)
                        <tr class="hover:bg-slate-50/60">
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $registration->user->avatarUrl() }}" alt="" class="size-9 rounded-full object-cover">
                                    <div class="min-w-0">
                                        <p class="truncate text-sm font-bold text-slate-900">{{ $registration->user->name }}</p>
                                        <p class="truncate text-xs text-slate-500">{{ $registration->user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3">
                                <a href="{{ route('admin.events.show', $registration->event) }}" class="block max-w-60 truncate text-xs font-semibold text-slate-700 hover:text-brand-700">{{ $registration->event->title }}</a>
                            </td>
                            <td class="px-5 py-3 font-mono text-xs font-semibold text-slate-600">{{ $registration->ticket_code }}</td>
                            <td class="px-5 py-3">
                                <span class="rounded-full px-2.5 py-1 text-[11px] font-bold ring-1 ring-inset {{ $registration->status->badgeClasses() }}">{{ $registration->status->label() }}</span>
                            </td>
                            <td class="px-5 py-3 text-xs text-slate-500">{{ $registration->created_at->translatedFormat('d M Y, H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-14 text-center">
                                <p class="text-sm font-bold text-slate-800">Tidak ada pendaftaran</p>
                                <p class="mt-1 text-sm text-slate-500">Belum ada data yang cocok dengan filter Anda.</p>
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
