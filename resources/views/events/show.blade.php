@extends('layouts.app')

@section('title', $event->title.' — EventSphere')
@section('description', \Illuminate\Support\Str::limit(strip_tags($event->description), 150))

@section('content')
    <div class="mx-auto max-w-7xl px-4 pt-8 sm:px-6 lg:px-8">
        <nav class="flex flex-wrap items-center gap-2 text-xs font-medium text-zinc-500">
            <a href="{{ route('home') }}" class="transition hover:text-accent-soft">Beranda</a>
            <span class="text-zinc-700">/</span>
            <a href="{{ route('events.index') }}" class="transition hover:text-accent-soft">Event</a>
            @if ($event->category)
                <span class="text-zinc-700">/</span>
                <a href="{{ route('events.index', ['category' => $event->category->slug]) }}" class="transition hover:text-accent-soft">{{ $event->category->name }}</a>
            @endif
            <span class="text-zinc-700">/</span>
            <span class="max-w-60 truncate text-zinc-300">{{ $event->title }}</span>
        </nav>

        <div class="mt-6 grid gap-8 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <div class="overflow-hidden rounded-lg border border-line bg-surface">
                    <div class="relative aspect-[16/9] bg-surface-2">
                        <img src="{{ $event->posterUrl() }}" alt="Poster {{ $event->title }}" class="h-full w-full object-cover">
                        <div class="absolute inset-x-0 bottom-0 h-32 bg-gradient-to-t from-black/75 to-transparent"></div>
                        <div class="absolute bottom-4 left-4 right-4 flex flex-wrap items-center gap-2">
                            @if ($event->category)
                                <span class="rounded border border-line bg-canvas px-3 py-1 text-[10px] font-bold uppercase tracking-[0.12em] text-accent">{{ $event->category->name }}</span>
                            @endif
                            <span class="rounded px-3 py-1 text-xs font-semibold ring-1 ring-inset {{ $event->status->badgeClasses() }}">{{ $event->status->label() }}</span>
                            @if ($event->featured)
                                <span class="rounded bg-accent px-3 py-1 text-[10px] font-bold uppercase tracking-[0.1em] text-zinc-950">★ Unggulan</span>
                            @endif
                        </div>
                    </div>

                    <div class="p-6 sm:p-8">
                        <h1 class="text-balance text-2xl font-bold leading-tight tracking-tight text-ink sm:text-3xl">
                            {{ $event->title }}
                        </h1>

                        <div class="mt-6 grid gap-3 sm:grid-cols-3">
                            <div class="rounded-lg border border-line bg-surface-2 p-3">
                                <p class="text-[11px] font-semibold uppercase tracking-[0.12em] text-zinc-500">Tanggal</p>
                                <p class="mt-1 text-sm font-semibold text-ink">{{ $event->starts_at->translatedFormat('d M Y') }}</p>
                            </div>
                            <div class="rounded-lg border border-line bg-surface-2 p-3">
                                <p class="text-[11px] font-semibold uppercase tracking-[0.12em] text-zinc-500">Waktu</p>
                                <p class="mt-1 text-sm font-semibold text-ink">{{ $event->starts_at->format('H:i') }}–{{ $event->ends_at->format('H:i') }} WIB</p>
                            </div>
                            <div class="rounded-lg border border-line bg-surface-2 p-3">
                                <p class="text-[11px] font-semibold uppercase tracking-[0.12em] text-zinc-500">Kota</p>
                                <p class="mt-1 text-sm font-semibold text-ink">{{ $event->city }}</p>
                            </div>
                        </div>

                        <div class="mt-8">
                            <h2 class="text-lg font-semibold text-ink">Tentang event ini</h2>
                            <div class="mt-3 whitespace-pre-line text-sm leading-relaxed text-zinc-400">{{ $event->description }}</div>
                        </div>

                        <div class="mt-8 border-t border-line pt-6">
                            <h2 class="text-lg font-semibold text-ink">Lokasi &amp; detail</h2>
                            <dl class="mt-4 grid gap-4 sm:grid-cols-2">
                                <div class="flex gap-3">
                                    <span class="flex size-10 shrink-0 items-center justify-center rounded-lg border border-line bg-surface-2 text-accent">
                                        <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" /></svg>
                                    </span>
                                    <div>
                                        <dt class="text-[11px] font-semibold uppercase tracking-[0.12em] text-zinc-500">Lokasi</dt>
                                        <dd class="mt-0.5 text-sm font-semibold text-ink">{{ $event->venue }}</dd>
                                        <dd class="text-sm text-zinc-400">{{ $event->address ?: $event->city }}</dd>
                                    </div>
                                </div>

                                <div class="flex gap-3">
                                    <span class="flex size-10 shrink-0 items-center justify-center rounded-lg border border-line bg-surface-2 text-accent">
                                        <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" /></svg>
                                    </span>
                                    <div>
                                        <dt class="text-[11px] font-semibold uppercase tracking-[0.12em] text-zinc-500">Kapasitas</dt>
                                        <dd class="mt-0.5 text-sm font-semibold text-ink">{{ $event->capacity }} peserta</dd>
                                        <dd class="text-sm text-zinc-400">{{ $event->seatsRemaining() }} kursi tersisa</dd>
                                    </div>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>

                @if ($event->organizer)
                    <div class="mt-6 flex flex-col gap-4 rounded-lg border border-line bg-surface p-6 sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex items-center gap-3">
                            <img src="{{ $event->organizer->avatarUrl() }}" alt="{{ $event->organizer->name }}" class="size-12 rounded-lg object-cover ring-1 ring-line">
                            <div>
                                <p class="text-[11px] font-semibold uppercase tracking-[0.12em] text-zinc-500">Diselenggarakan oleh</p>
                                <p class="text-base font-semibold text-ink">{{ $event->organizer->organization_name ?: $event->organizer->name }}</p>
                                @if ($event->organizer->bio)
                                    <p class="mt-0.5 line-clamp-1 text-xs text-zinc-500">{{ $event->organizer->bio }}</p>
                                @endif
                            </div>
                        </div>
                        <span class="inline-flex items-center gap-1.5 self-start rounded-md border border-accent/25 bg-accent/[0.05] px-3 py-1.5 text-xs font-semibold text-accent-soft sm:self-auto">
                            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                            Penyelenggara terverifikasi
                        </span>
                    </div>
                @endif
            </div>

            <aside class="lg:col-span-1">
                <div class="sticky top-24 space-y-4">
                    <div class="rounded-lg border border-line bg-surface p-6">
                        <p class="text-[11px] font-semibold uppercase tracking-[0.12em] text-zinc-500">Harga tiket</p>
                        <p class="mt-1 text-3xl font-bold tracking-tight text-ink">{{ $event->formattedPrice() }}</p>
                        <p class="text-xs text-zinc-500">{{ $event->isFree() ? 'Tidak dipungut biaya' : 'per peserta' }}</p>

                        <div class="mt-5">
                            <div class="flex items-center justify-between text-xs font-medium">
                                <span class="text-zinc-500">Kuota terisi</span>
                                <span class="text-zinc-200">{{ $event->occupancyPercentage() }}%</span>
                            </div>
                            <div class="mt-2 h-1.5 overflow-hidden rounded-full bg-surface-2">
                                <div class="h-full rounded-full bg-accent" style="width: {{ $event->occupancyPercentage() }}%"></div>
                            </div>
                            <p class="mt-2 text-xs text-zinc-500">{{ $event->seatsTaken() }} terdaftar · {{ $event->seatsRemaining() }} tersisa</p>
                        </div>

                        <div class="mt-6 border-t border-line pt-5">
                            @if ($event->hasFinished() || $event->status === \App\EventStatus::Cancelled)
                                <div class="rounded-lg border border-line bg-surface-2 p-4 text-center">
                                    <p class="text-sm font-semibold text-zinc-300">{{ $event->status === \App\EventStatus::Cancelled ? 'Event dibatalkan' : 'Event telah berlangsung' }}</p>
                                    <p class="mt-1 text-xs text-zinc-500">Pendaftaran sudah ditutup.</p>
                                </div>
                            @elseif ($event->isSoldOut())
                                <div class="rounded-lg border border-danger/25 bg-danger/[0.05] p-4 text-center">
                                    <p class="text-sm font-semibold text-rose-300">Kuota penuh</p>
                                    <p class="mt-1 text-xs text-rose-400/80">Semua kursi untuk event ini sudah terisi.</p>
                                </div>
                            @elseif (! auth()->check())
                                <a href="{{ route('login') }}" class="btn-primary w-full py-3">
                                    Masuk untuk Mendaftar
                                </a>
                                <p class="mt-3 text-center text-xs text-zinc-500">
                                    Belum punya akun? <a href="{{ route('register') }}" class="font-semibold text-accent hover:text-accent-soft">Daftar gratis</a>
                                </p>
                            @elseif (auth()->user()->isParticipant())
                                @if ($registration && $registration->status !== \App\RegistrationStatus::Cancelled)
                                    <div class="rounded-lg border border-accent/25 bg-accent/[0.05] p-4 text-center">
                                        <p class="text-sm font-semibold text-accent-soft">Anda sudah terdaftar</p>
                                        <p class="mt-1 text-xs text-accent/70">Kode tiket: {{ $registration->ticket_code }}</p>
                                    </div>
                                    <a href="{{ route('registrations.show', $registration) }}" class="btn-secondary mt-3 w-full py-3 text-accent hover:border-accent/40">
                                        Lihat Tiket Saya
                                    </a>
                                @else
                                    <form method="POST" action="{{ route('events.register', $event) }}">
                                        @csrf
                                        <button type="submit" class="btn-primary w-full py-3">
                                            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 0 1 0 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 0 1 0-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375Z" /></svg>
                                            {{ $registration ? 'Aktifkan Kembali Pendaftaran' : 'Daftar Sekarang' }}
                                        </button>
                                    </form>
                                    <p class="mt-3 text-center text-xs text-zinc-500">Pendaftaran instan — tiket digital langsung tersedia.</p>
                                @endif
                            @else
                                <div class="rounded-lg border border-line bg-surface-2 p-4 text-center">
                                    <p class="text-sm font-semibold text-zinc-300">Anda masuk sebagai {{ auth()->user()->role->label() }}</p>
                                    <p class="mt-1 text-xs text-zinc-500">Hanya akun peserta yang dapat mendaftar event.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="rounded-lg border border-line bg-surface p-5">
                        <h2 class="text-sm font-semibold text-ink">Informasi penting</h2>
                        <ul class="mt-3 space-y-2.5 text-xs text-zinc-400">
                            <li class="flex gap-2"><span class="mt-1.5 size-1 shrink-0 rounded-full bg-accent"></span> Tiket digital wajib ditunjukkan saat masuk.</li>
                            <li class="flex gap-2"><span class="mt-1.5 size-1 shrink-0 rounded-full bg-accent"></span> Pembatalan dapat dilakukan sebelum event dimulai.</li>
                            <li class="flex gap-2"><span class="mt-1.5 size-1 shrink-0 rounded-full bg-accent"></span> Hubungi penyelenggara untuk pertanyaan khusus.</li>
                        </ul>
                    </div>
                </div>
            </aside>
        </div>

        @if ($relatedEvents->isNotEmpty())
            <div class="mt-14">
                <h2 class="text-2xl font-bold tracking-tight text-ink">Event serupa</h2>
                <div class="mt-6 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($relatedEvents as $related)
                        <x-event-card :event="$related" />
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection
