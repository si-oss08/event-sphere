@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between gap-2">
        @if ($paginator->onFirstPage())
            <span class="inline-flex items-center rounded-lg border border-line bg-surface px-4 py-2 text-sm font-medium text-zinc-600">
                {!! __('pagination.previous') !!}
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex items-center rounded-lg border border-line bg-surface px-4 py-2 text-sm font-medium text-zinc-300 transition hover:border-line-strong hover:text-ink">
                {!! __('pagination.previous') !!}
            </a>
        @endif

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex items-center rounded-lg border border-line bg-surface px-4 py-2 text-sm font-medium text-zinc-300 transition hover:border-line-strong hover:text-ink">
                {!! __('pagination.next') !!}
            </a>
        @else
            <span class="inline-flex items-center rounded-lg border border-line bg-surface px-4 py-2 text-sm font-medium text-zinc-600">
                {!! __('pagination.next') !!}
            </span>
        @endif
    </nav>
@endif
