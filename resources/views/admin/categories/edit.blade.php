@extends('layouts.dashboard')

@section('title', 'Edit Kategori')
@section('heading', 'Edit Kategori')

@section('content')
    <div>
        <a href="{{ route('admin.categories.index') }}" class="text-xs font-semibold text-accent hover:text-accent-soft">← Kembali ke kategori</a>
        <h2 class="mt-1 section-title">{{ $category->name }}</h2>
        <p class="mt-1 text-sm text-zinc-400">Perbarui nama, deskripsi, atau warna kategori.</p>
    </div>

    <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="space-y-6">
        @csrf
        @method('PATCH')

        @include('admin.categories._form', ['category' => $category])

        <div class="flex items-center justify-end gap-3 rounded-lg border border-line bg-surface p-4">
            <a href="{{ route('admin.categories.index') }}" class="btn-ghost">Batal</a>
            <button type="submit" class="btn-primary px-6">Simpan Perubahan</button>
        </div>
    </form>
@endsection
