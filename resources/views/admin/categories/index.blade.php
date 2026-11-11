@extends('layouts.dashboard')

@section('title', 'Kelola Kategori')
@section('heading', 'Kelola Kategori')

@section('content')
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <h2 class="section-title">Kategori event</h2>
            <p class="mt-1 text-sm text-zinc-400">Kelompokkan event agar mudah ditemukan peserta.</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="btn-primary">
            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
            Tambah Kategori
        </a>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
        @forelse ($categories as $category)
            <div class="rounded-lg border border-line bg-surface p-5">
                <div class="flex items-start justify-between gap-3">
                    <span class="flex size-10 items-center justify-center rounded-md border border-line bg-surface-2 text-accent">
                        <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" /></svg>
                    </span>
                    <span class="rounded-md border border-line bg-surface-2 px-2.5 py-1 text-[11px] font-medium text-zinc-400">{{ $category->events_count }} event</span>
                </div>

                <h3 class="mt-4 text-base font-semibold text-ink">{{ $category->name }}</h3>
                <p class="mt-1 line-clamp-2 text-sm text-zinc-500">{{ $category->description ?: 'Belum ada deskripsi.' }}</p>

                <div class="mt-4 flex gap-2 border-t border-line pt-4">
                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn-secondary flex-1 px-3 py-2 text-xs">Edit</a>
                    <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Hapus kategori ini? Event terkait akan menjadi tanpa kategori.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-danger px-3 py-2 text-xs">Hapus</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="rounded-lg border border-dashed border-line bg-surface p-10 text-center sm:col-span-2 xl:col-span-3">
                <p class="text-sm font-semibold text-zinc-200">Belum ada kategori</p>
                <p class="mt-1 text-sm text-zinc-500">Tambahkan kategori untuk mengelompokkan event.</p>
            </div>
        @endforelse
    </div>

    <div>
        {{ $categories->links() }}
    </div>
@endsection
