@extends('layouts.dashboard')

@section('title', 'Tiket '.$registration->ticket_code)
@section('heading', 'Detail Tiket')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3 print-hidden">
        <div>
            <a href="{{ route('registrations.index') }}" class="text-xs font-semibold text-accent hover:text-accent-soft">← Kembali ke tiket saya</a>
            <h2 class="mt-1 section-title">Tiket digital Anda</h2>
        </div>
        <div class="flex gap-2">
            <button type="button" onclick="window.print()" class="btn-secondary">
                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" /></svg>
                Cetak Tiket
            </button>
            <a href="{{ route('events.show', $registration->event) }}" class="btn-primary">Lihat Event</a>
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2">
            <div class="overflow-hidden rounded-xl border border-line bg-surface">
                <div class="relative border-b border-line bg-[#08080a] p-6 sm:p-8">
                    <div class="bg-grid absolute inset-0 opacity-60"></div>
                    <div class="relative flex items-start justify-between gap-4">
                        <div>
                            <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-accent">EventSphere E-Ticket</p>
                            <h3 class="mt-2 text-xl font-bold leading-tight text-ink sm:text-2xl">{{ $registration->event->title }}</h3>
                            <p class="mt-1 text-sm text-zinc-400">{{ $registration->event->category?->name ?? 'Event' }}</p>
                        </div>
                        <span class="rounded-md px-3 py-1 text-[11px] font-semibold ring-1 ring-inset {{ $registration->status->badgeClasses() }}">{{ $registration->status->label() }}</span>
                    </div>
                </div>

                <div class="grid gap-6 border-b border-dashed border-line p-6 sm:grid-cols-5 sm:p-8">
                    <div class="space-y-5 sm:col-span-3">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-[11px] font-semibold uppercase tracking-[0.12em] text-zinc-500">Peserta</p>
                                <p class="mt-0.5 text-sm font-semibold text-ink">{{ $registration->user->name }}</p>
                            </div>
                            <div>
                                <p class="text-[11px] font-semibold uppercase tracking-[0.12em] text-zinc-500">Kode Tiket</p>
                                <p class="mt-0.5 font-mono text-sm font-semibold tracking-wider text-ink">{{ $registration->ticket_code }}</p>
                            </div>
                            <div>
                                <p class="text-[11px] font-semibold uppercase tracking-[0.12em] text-zinc-500">Tanggal</p>
                                <p class="mt-0.5 text-sm font-semibold text-ink">{{ $registration->event->starts_at->translatedFormat('d M Y') }}</p>
                            </div>
                            <div>
                                <p class="text-[11px] font-semibold uppercase tracking-[0.12em] text-zinc-500">Waktu</p>
                                <p class="mt-0.5 text-sm font-semibold text-ink">{{ $registration->event->starts_at->format('H:i') }} WIB</p>
                            </div>
                            <div class="col-span-2">
                                <p class="text-[11px] font-semibold uppercase tracking-[0.12em] text-zinc-500">Lokasi</p>
                                <p class="mt-0.5 text-sm font-semibold text-ink">{{ $registration->event->venue }}</p>
                                <p class="text-xs text-zinc-500">{{ $registration->event->address ?: $registration->event->city }}</p>
                            </div>
                        </div>

                        <div class="rounded-lg border border-line bg-surface-2 p-4">
                            <p class="text-[11px] font-semibold uppercase tracking-[0.12em] text-zinc-500">Status pendaftaran</p>
                            <span class="mt-1.5 inline-flex rounded-md px-2.5 py-1 text-xs font-semibold ring-1 ring-inset {{ $registration->status->badgeClasses() }}">{{ $registration->status->label() }}</span>
                            @if ($registration->checked_in_at)
                                <p class="mt-2 text-xs text-zinc-500">Check-in: {{ $registration->checked_in_at->translatedFormat('d M Y, H:i') }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="flex flex-col items-center justify-center sm:col-span-2">
                        <div class="w-40 rounded-lg border border-line bg-stone-50 p-3">
                            <x-ticket-qr :code="$registration->ticket_code" />
                        </div>
                        <p class="mt-3 text-center text-[11px] leading-relaxed text-zinc-500">Tunjukkan kode ini kepada panitia saat check-in.</p>
                    </div>
                </div>

                <div class="flex items-center justify-between gap-3 bg-surface-2 px-6 py-4 text-xs text-zinc-500">
                    <span>Diterbitkan {{ $registration->created_at->translatedFormat('d M Y, H:i') }}</span>
                    <span class="font-mono">{{ $registration->ticket_code }}</span>
                </div>
            </div>
        </div>

        <aside class="space-y-4 print-hidden">
            <div class="rounded-xl border border-line bg-surface p-5">
                <h3 class="text-sm font-semibold text-ink">Diselenggarakan oleh</h3>
                <div class="mt-3 flex items-center gap-3">
                    <img src="{{ $registration->event->organizer->avatarUrl() }}" alt="" class="size-11 rounded-lg object-cover">
                    <div>
                        <p class="text-sm font-semibold text-ink">{{ $registration->event->organizer->organization_name ?: $registration->event->organizer->name }}</p>
                        <p class="text-xs text-zinc-500">{{ $registration->event->organizer->email }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-xl border border-line bg-surface p-5">
                <h3 class="text-sm font-semibold text-ink">Butuh bantuan?</h3>
                <p class="mt-1 text-xs leading-relaxed text-zinc-500">Hubungi penyelenggara jika ada pertanyaan mengenai jadwal, lokasi, atau tiket Anda.</p>
            </div>

            @if ($registration->status !== \App\RegistrationStatus::Cancelled && ! $registration->event->starts_at->isPast())
                <form method="POST" action="{{ route('registrations.cancel', $registration) }}" onsubmit="return confirm('Yakin ingin membatalkan pendaftaran ini?')">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn-danger w-full">
                        Batalkan Pendaftaran
                    </button>
                </form>
            @endif
        </aside>
    </div>
@endsection
