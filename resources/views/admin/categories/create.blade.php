@extends('layouts.dashboard')

@section('title', 'Tambah Kategori')
@section('heading', 'Tambah Kategori')

@section('content')
    <div>
        <a href="{{ route('admin.categories.index') }}" class="text-xs font-bold text-brand-700 hover:text-brand-800">← Kembali ke kategori</a>
        <h2 class="mt-1 text-xl font-extrabold tracking-tight text-slate-900">Kategori baru</h2>
        <p class="mt-1 text-sm text-slate-600">Buat kategori untuk mengelompokkan event.</p>
    </div>

    <form method="POST" action="{{ route('admin.categories.store') }}" class="space-y-6">
        @csrf

        @include('admin.categories._form', ['category' => null])

        <div class="flex items-center justify-end gap-3 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <a href="{{ route('admin.categories.index') }}" class="rounded-xl px-4 py-2.5 text-sm font-bold text-slate-600 hover:text-slate-900">Batal</a>
            <button type="submit" class="rounded-xl bg-brand-600 px-6 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-brand-700">Simpan Kategori</button>
        </div>
    </form>
@endsection
