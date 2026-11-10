@php
    use App\EventStatus;
@endphp

<div class="group flex h-full flex-col overflow-hidden rounded-xl border border-line bg-surface transition hover:border-line-strong">
    <a href="{{ route('events.show', $event) }}" class="relative block aspect-[16/10] overflow-hidden bg-surface-2">
        <img src="{{ $event->posterUrl() }}" alt="Poster {{ $event->title }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.03]">
        <div class="absolute inset-x-0 bottom-0 h-24 bg-gradient-to-t from-black/70 to-transparent"></div>

        @if ($event->category)
            <span class="absolute left-3 top-3 rounded-md border border-white/10 bg-black/70 px-2.5 py-1 text-xs font-medium text-zinc-200 backdrop-blur-sm">
                {{ $event->category->name }}
            </span>
        @endif

        <span class="absolute bottom-3 left-3 flex items-center gap-1.5 rounded-md bg-accent px-2.5 py-1 text-xs font-bold text-zinc-950">
            {{ $event->formattedPrice() }}
        </span>

        @if ($event->status === EventStatus::Completed)
            <span class="absolute right-3 top-3 rounded-md bg-zinc-800/90 px-2.5 py-1 text-xs font-medium text-zinc-300 ring-1 ring-inset ring-white/10">Selesai</span>
        @elseif ($event->isSoldOut())
            <span class="absolute right-3 top-3 rounded-md bg-rose-500 px-2.5 py-1 text-xs font-semibold text-white">Kuota Penuh</span>
        @endif
    </a>

    <div class="flex flex-1 flex-col p-5">
        <h3 class="line-clamp-2 text-base font-semibold leading-snug text-ink">
            <a href="{{ route('events.show', $event) }}" class="transition hover:text-accent-soft">{{ $event->title }}</a>
        </h3>

        <div class="mt-3 space-y-1.5 text-sm text-zinc-400">
            <p class="flex items-center gap-2">
                <svg class="size-4 shrink-0 text-accent" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                </svg>
                <span>{{ $event->starts_at->translatedFormat('d M Y, H:i') }} WIB</span>
            </p>
            <p class="flex items-center gap-2">
                <svg class="size-4 shrink-0 text-accent" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                </svg>
                <span class="truncate">{{ $event->venue }}, {{ $event->city }}</span>
            </p>
        </div>

        <div class="mt-auto flex items-center justify-between border-t border-line pt-4">
            <span class="text-xs font-medium text-zinc-500">{{ $event->seatsRemaining() }} dari {{ $event->capacity }} kursi tersisa</span>
            <a href="{{ route('events.show', $event) }}" class="rounded-md border border-line bg-surface-2 px-3 py-1.5 text-xs font-semibold text-zinc-200 transition hover:border-accent/40 hover:text-accent-soft">
                Detail
            </a>
        </div>
    </div>
</div>
