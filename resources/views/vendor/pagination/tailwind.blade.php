@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Navigasi halaman" class="flex items-center justify-between gap-3">

        <div class="flex items-center gap-2 sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center rounded-md border border-line bg-surface px-4 py-2 text-sm font-medium text-zinc-600">
                    Sebelumnya
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center rounded-md border border-line bg-surface px-4 py-2 text-sm font-medium text-zinc-300 transition hover:border-line-strong hover:text-ink">
                    Sebelumnya
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center rounded-md border border-line bg-surface px-4 py-2 text-sm font-medium text-zinc-300 transition hover:border-line-strong hover:text-ink">
                    Berikutnya
                </a>
            @else
                <span class="inline-flex items-center rounded-md border border-line bg-surface px-4 py-2 text-sm font-medium text-zinc-600">
                    Berikutnya
                </span>
            @endif
        </div>

        <div class="hidden flex-1 items-center justify-between gap-4 sm:flex">
            <p class="text-sm text-zinc-500">
                Menampilkan
                @if ($paginator->firstItem())
                    <span class="font-medium text-zinc-300">{{ $paginator->firstItem() }}</span>
                    sampai
                    <span class="font-medium text-zinc-300">{{ $paginator->lastItem() }}</span>
                @else
                    {{ $paginator->count() }}
                @endif
                dari
                <span class="font-medium text-zinc-300">{{ $paginator->total() }}</span>
                hasil
            </p>

            <div class="flex items-center gap-1">
                @if ($paginator->onFirstPage())
                    <span aria-disabled="true" aria-label="Sebelumnya" class="inline-flex size-9 items-center justify-center rounded-md border border-line bg-surface text-zinc-600">
                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" /></svg>
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Sebelumnya" class="inline-flex size-9 items-center justify-center rounded-md border border-line bg-surface text-zinc-400 transition hover:border-line-strong hover:text-ink">
                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" /></svg>
                    </a>
                @endif

                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span aria-disabled="true" class="inline-flex size-9 items-center justify-center text-sm text-zinc-600">{{ $element }}</span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span aria-current="page" class="inline-flex size-9 items-center justify-center rounded-md bg-accent text-sm font-bold text-zinc-950">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" aria-label="Ke halaman {{ $page }}" class="inline-flex size-9 items-center justify-center rounded-md border border-line bg-surface text-sm font-medium text-zinc-400 transition hover:border-line-strong hover:text-ink">{{ $page }}</a>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Berikutnya" class="inline-flex size-9 items-center justify-center rounded-md border border-line bg-surface text-zinc-400 transition hover:border-line-strong hover:text-ink">
                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /></svg>
                    </a>
                @else
                    <span aria-disabled="true" aria-label="Berikutnya" class="inline-flex size-9 items-center justify-center rounded-md border border-line bg-surface text-zinc-600">
                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /></svg>
                    </span>
                @endif
            </div>
        </div>
    </nav>
@endif
