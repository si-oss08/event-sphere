@extends('layouts.dashboard')

@section('title', 'Semua Pendaftaran')
@section('heading', 'Data Pendaftaran')

@section('content')
    <div>
        <h2 class="section-title">Semua pendaftaran</h2>
        <p class="mt-1 text-sm text-zinc-400">Pantau aktivitas pendaftaran peserta di seluruh event.</p>
    </div>

    <form method="GET" class="flex flex-col gap-3 rounded-lg border border-line bg-surface p-4 sm:flex-row">
        <div class="relative flex-1">
            <div class="pointer-events-none absolute inset-y-0 left-0 z-10 flex items-center pl-3.5">
                <svg class="size-4 text-zinc-500" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
            </div>
            <input type="search" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Cari peserta, event, atau kode tiket…" class="input pl-10">
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
                        <th>Event</th>
                        <th>Kode Tiket</th>
                        <th>Status</th>
                        <th>Tanggal Daftar</th>
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
                            <td>
                                <a href="{{ route('admin.events.show', $registration->event) }}" class="block max-w-60 truncate text-xs font-medium text-zinc-300 hover:text-accent-soft">{{ $registration->event->title }}</a>
                            </td>
                            <td class="whitespace-nowrap font-mono text-xs font-medium text-zinc-400">{{ $registration->ticket_code }}</td>
                            <td>
                                <span class="whitespace-nowrap rounded-md px-2.5 py-1 text-[11px] font-semibold ring-1 ring-inset {{ $registration->status->badgeClasses() }}">{{ $registration->status->label() }}</span>
                            </td>
                            <td class="text-xs text-zinc-500">{{ $registration->created_at->translatedFormat('d M Y, H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-14 text-center">
                                <p class="text-sm font-semibold text-zinc-200">Tidak ada pendaftaran</p>
                                <p class="mt-1 text-sm text-zinc-500">Belum ada data yang cocok dengan filter Anda.</p>
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
