@extends('layouts.dashboard')

@section('title', 'Kelola Kategori')
@section('heading', 'Kelola Kategori')

@section('content')
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <h2 class="text-xl font-extrabold tracking-tight text-slate-900">Kategori event</h2>
            <p class="mt-1 text-sm text-slate-600">Kelompokkan event agar mudah ditemukan peserta.</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-brand-600 px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-brand-700">
            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
            Tambah Kategori
        </a>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
        @forelse ($categories as $category)
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-start justify-between gap-3">
                    <span class="flex size-11 items-center justify-center rounded-xl text-white" style="background-color: {{ $category->color }}">
                        <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" /></svg>
                    </span>
                    <span class="rounded-full bg-slate-100 px-2.5 py-1 text-[11px] font-bold text-slate-600">{{ $category->events_count }} event</span>
                </div>

                <h3 class="mt-4 text-base font-bold text-slate-900">{{ $category->name }}</h3>
                <p class="mt-1 line-clamp-2 text-sm text-slate-500">{{ $category->description ?: 'Belum ada deskripsi.' }}</p>

                <div class="mt-4 flex gap-2 border-t border-slate-100 pt-4">
                    <a href="{{ route('admin.categories.edit', $category) }}" class="flex-1 rounded-lg border border-slate-200 px-3 py-2 text-center text-xs font-bold text-slate-700 transition hover:bg-slate-50">Edit</a>
                    <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Hapus kategori ini? Event terkait akan menjadi tanpa kategori.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="rounded-lg border border-rose-200 px-3 py-2 text-xs font-bold text-rose-600 transition hover:bg-rose-50">Hapus</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-10 text-center sm:col-span-2 xl:col-span-3">
                <p class="text-sm font-bold text-slate-800">Belum ada kategori</p>
                <p class="mt-1 text-sm text-slate-500">Tambahkan kategori untuk mengelompokkan event.</p>
            </div>
        @endforelse
    </div>

    <div>
        {{ $categories->links() }}
    </div>
@endsection
