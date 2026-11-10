@extends('layouts.app')

@section('title', 'Halaman Tidak Ditemukan — EventSphere')

@section('content')
    <div class="mx-auto max-w-3xl px-4 py-20 sm:px-6 lg:px-8">
        <div class="rounded-xl border border-line bg-surface p-8 text-center sm:p-12">
            <p class="eyebrow">404 — Tidak ditemukan</p>
            <h1 class="mt-3 text-3xl font-bold tracking-tight text-ink">Halaman yang Anda cari tidak ada</h1>
            <p class="mx-auto mt-3 max-w-xl text-sm leading-relaxed text-zinc-400">
                Tautan mungkin sudah kedaluwarsa, atau event yang Anda cari telah dihapus oleh penyelenggara.
                Coba jelajahi event lain yang masih tersedia.
            </p>
            <div class="mt-7 flex flex-wrap justify-center gap-3">
                <a href="{{ route('events.index') }}" class="btn-primary px-5">Jelajahi Event</a>
                <a href="{{ route('home') }}" class="btn-secondary px-5">Kembali ke Beranda</a>
            </div>
        </div>
    </div>
@endsection
