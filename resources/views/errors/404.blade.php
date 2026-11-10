@extends('layouts.app')

@section('title', 'Halaman Tidak Ditemukan — EventSphere')

@section('content')
    <div class="mx-auto max-w-3xl px-4 py-20 sm:px-6 lg:px-8">
        <div class="rounded-3xl border border-slate-200 bg-white p-8 text-center shadow-sm sm:p-12">
            <p class="text-sm font-bold uppercase tracking-[0.18em] text-brand-600">404 — Tidak ditemukan</p>
            <h1 class="mt-3 text-3xl font-extrabold tracking-tight text-slate-900">Halaman yang Anda cari tidak ada</h1>
            <p class="mx-auto mt-3 max-w-xl text-sm leading-relaxed text-slate-600">
                Tautan mungkin sudah kedaluwarsa, atau event yang Anda cari telah dihapus oleh penyelenggara.
                Coba jelajahi event lain yang masih tersedia.
            </p>
            <div class="mt-7 flex flex-wrap justify-center gap-3">
                <a href="{{ route('events.index') }}" class="rounded-xl bg-brand-600 px-5 py-2.5 text-sm font-bold text-white transition hover:bg-brand-700">Jelajahi Event</a>
                <a href="{{ route('home') }}" class="rounded-xl border border-slate-200 px-5 py-2.5 text-sm font-bold text-slate-700 transition hover:bg-slate-50">Kembali ke Beranda</a>
            </div>
        </div>
    </div>
@endsection
