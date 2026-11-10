@extends('layouts.dashboard')

@section('title', 'Tambah Kategori')
@section('heading', 'Tambah Kategori')

@section('content')
    <div>
        <a href="{{ route('admin.categories.index') }}" class="text-xs font-semibold text-accent hover:text-accent-soft">← Kembali ke kategori</a>
        <h2 class="mt-1 section-title">Kategori baru</h2>
        <p class="mt-1 text-sm text-zinc-400">Buat kategori untuk mengelompokkan event.</p>
    </div>

    <form method="POST" action="{{ route('admin.categories.store') }}" class="space-y-6">
        @csrf

        @include('admin.categories._form', ['category' => null])

        <div class="flex items-center justify-end gap-3 rounded-xl border border-line bg-surface p-4">
            <a href="{{ route('admin.categories.index') }}" class="btn-ghost">Batal</a>
            <button type="submit" class="btn-primary px-6">Simpan Kategori</button>
        </div>
    </form>
@endsection
