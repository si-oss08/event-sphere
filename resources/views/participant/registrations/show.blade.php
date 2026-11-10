@extends('layouts.dashboard')

@section('title', 'Tiket '.$registration->ticket_code)
@section('heading', 'Detail Tiket')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3 print-hidden">
        <div>
            <a href="{{ route('registrations.index') }}" class="text-xs font-bold text-brand-700 hover:text-brand-800">← Kembali ke tiket saya</a>
            <h2 class="mt-1 text-xl font-extrabold tracking-tight text-slate-900">Tiket digital Anda</h2>
        </div>
        <div class="flex gap-2">
            <button type="button" onclick="window.print()" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-bold text-slate-700 shadow-sm transition hover:bg-slate-50">
                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" /></svg>
                Cetak Tiket
            </button>
            <a href="{{ route('events.show', $registration->event) }}" class="rounded-xl bg-brand-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-brand-700">Lihat Event</a>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2">
            <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
                <div class="relative bg-slate-950 p-6 sm:p-8">
                    <div class="absolute inset-0 bg-gradient-to-br from-brand-700 via-brand-800 to-slate-950"></div>
                    <div class="bg-grid absolute inset-0 opacity-40"></div>
                    <div class="relative flex items-start justify-between gap-4">
                        <div>
                            <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-brand-300">EventSphere E-Ticket</p>
                            <h3 class="mt-2 text-xl font-extrabold leading-tight text-white sm:text-2xl">{{ $registration->event->title }}</h3>
                            <p class="mt-1 text-sm text-slate-300">{{ $registration->event->category?->name ?? 'Event' }}</p>
                        </div>
                        <span class="rounded-full bg-white/10 px-3 py-1 text-[11px] font-bold text-white ring-1 ring-inset ring-white/20">{{ $registration->status->label() }}</span>
                    </div>
                </div>

                <div class="grid gap-6 p-6 sm:grid-cols-5 sm:p-8">
                    <div class="space-y-4 sm:col-span-3">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Peserta</p>
                                <p class="mt-0.5 text-sm font-bold text-slate-900">{{ $registration->user->name }}</p>
                            </div>
                            <div>
                                <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Kode Tiket</p>
                                <p class="mt-0.5 font-mono text-sm font-bold tracking-wider text-slate-900">{{ $registration->ticket_code }}</p>
                            </div>
                            <div>
                                <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Tanggal</p>
                                <p class="mt-0.5 text-sm font-bold text-slate-900">{{ $registration->event->starts_at->translatedFormat('d M Y') }}</p>
                            </div>
                            <div>
                                <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Waktu</p>
                                <p class="mt-0.5 text-sm font-bold text-slate-900">{{ $registration->event->starts_at->format('H:i') }} WIB</p>
                            </div>
                            <div class="col-span-2">
                                <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Lokasi</p>
                                <p class="mt-0.5 text-sm font-bold text-slate-900">{{ $registration->event->venue }}</p>
                                <p class="text-xs text-slate-500">{{ $registration->event->address ?: $registration->event->city }}</p>
                            </div>
                        </div>

                        <div class="rounded-xl bg-slate-50 p-4">
                            <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Status pendaftaran</p>
                            <span class="mt-1 inline-flex rounded-full px-2.5 py-1 text-xs font-bold ring-1 ring-inset {{ $registration->status->badgeClasses() }}">{{ $registration->status->label() }}</span>
                            @if ($registration->checked_in_at)
                                <p class="mt-2 text-xs text-slate-500">Check-in: {{ $registration->checked_in_at->translatedFormat('d M Y, H:i') }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="flex flex-col items-center justify-center sm:col-span-2">
                        <div class="w-40 rounded-2xl border border-slate-200 bg-white p-3 shadow-sm">
                            <x-ticket-qr :code="$registration->ticket_code" />
                        </div>
                        <p class="mt-3 text-center text-[11px] text-slate-500">Tunjukkan kode ini kepada panitia saat check-in.</p>
                    </div>
                </div>

                <div class="flex items-center justify-between gap-3 border-t border-dashed border-slate-200 bg-slate-50 px-6 py-4 text-xs text-slate-500">
                    <span>Diterbitkan {{ $registration->created_at->translatedFormat('d M Y, H:i') }}</span>
                    <span class="font-mono">{{ $registration->ticket_code }}</span>
                </div>
            </div>
        </div>

        <aside class="space-y-4 print-hidden">
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <h3 class="text-sm font-bold text-slate-900">Diselenggarakan oleh</h3>
                <div class="mt-3 flex items-center gap-3">
                    <img src="{{ $registration->event->organizer->avatarUrl() }}" alt="" class="size-11 rounded-full object-cover">
                    <div>
                        <p class="text-sm font-bold text-slate-900">{{ $registration->event->organizer->organization_name ?: $registration->event->organizer->name }}</p>
                        <p class="text-xs text-slate-500">{{ $registration->event->organizer->email }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <h3 class="text-sm font-bold text-slate-900">Butuh bantuan?</h3>
                <p class="mt-1 text-xs leading-relaxed text-slate-500">Hubungi penyelenggara jika ada pertanyaan mengenai jadwal, lokasi, atau tiket Anda.</p>
            </div>

            @if ($registration->status !== \App\RegistrationStatus::Cancelled && ! $registration->event->starts_at->isPast())
                <form method="POST" action="{{ route('registrations.cancel', $registration) }}" onsubmit="return confirm('Yakin ingin membatalkan pendaftaran ini?')">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="w-full rounded-xl border border-rose-200 bg-white px-4 py-2.5 text-sm font-bold text-rose-600 transition hover:bg-rose-50">
                        Batalkan Pendaftaran
                    </button>
                </form>
            @endif
        </aside>
    </div>
@endsection
