@extends('layouts.app')

@section('title', 'Akses Ditolak — EventSphere')

@section('content')
    <div class="mx-auto max-w-3xl px-4 py-20 sm:px-6 lg:px-8">
        <div class="rounded-xl border border-line bg-surface p-8 text-center sm:p-12">
            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-rose-400">403 — Akses ditolak</p>
            <h1 class="mt-3 text-3xl font-bold tracking-tight text-ink">Anda tidak memiliki akses ke halaman ini</h1>
            <p class="mx-auto mt-3 max-w-2xl text-sm leading-relaxed text-zinc-400">
                Halaman ini hanya dapat diakses oleh peran pengguna tertentu. Jika Anda merasa ini sebuah kekeliruan,
                silakan masuk dengan akun yang sesuai atau hubungi administrator.
            </p>
            <div class="mt-7 flex flex-wrap justify-center gap-3">
                <a href="{{ route('dashboard') }}" class="btn-primary px-5">Ke Dashboard Saya</a>
                <a href="{{ route('home') }}" class="btn-secondary px-5">Kembali ke Beranda</a>
            </div>
        </div>
    </div>
@endsection
