@extends('layouts.app')

@section('title', 'Akses Ditolak — EventSphere')

@section('content')
    <div class="mx-auto max-w-3xl px-4 py-20 sm:px-6 lg:px-8">
        <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm sm:p-12">
            <p class="text-sm font-bold uppercase tracking-[0.18em] text-rose-600">403 — Akses ditolak</p>
            <h1 class="mt-3 text-3xl font-extrabold tracking-tight text-slate-900">Anda tidak memiliki akses ke halaman ini</h1>
            <p class="mt-3 max-w-2xl text-sm leading-relaxed text-slate-600">
                Halaman ini hanya dapat diakses oleh peran pengguna tertentu. Jika Anda merasa ini sebuah kekeliruan,
                silakan masuk dengan akun yang sesuai atau hubungi administrator.
            </p>
            <div class="mt-7 flex flex-wrap gap-3">
                <a href="{{ route('dashboard') }}" class="rounded-xl bg-brand-600 px-5 py-2.5 text-sm font-bold text-white transition hover:bg-brand-700">Ke Dashboard Saya</a>
                <a href="{{ route('home') }}" class="rounded-xl border border-slate-200 px-5 py-2.5 text-sm font-bold text-slate-700 transition hover:bg-slate-50">Kembali ke Beranda</a>
            </div>
        </div>
    </div>
@endsection
