@extends('layouts.auth')

@section('title', 'Masuk')

@section('content')
    <div>
        <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">Selamat datang kembali</h1>
        <p class="mt-2 text-sm text-slate-600">Masuk untuk mengelola event dan tiket Anda.</p>

        <form method="POST" action="{{ route('login.store') }}" class="mt-8 space-y-5">
            @csrf

            <div>
                <label for="email" class="mb-1.5 block text-sm font-semibold text-slate-700">Alamat email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email" placeholder="nama@email.com" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-brand-500 focus:ring-4 focus:ring-brand-100">
            </div>

            <div>
                <div class="mb-1.5 flex items-center justify-between">
                    <label for="password" class="block text-sm font-semibold text-slate-700">Kata sandi</label>
                    <button type="button" data-password-toggle="#password" class="text-xs font-bold text-brand-700 hover:text-brand-800">Lihat</button>
                </div>
                <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-brand-500 focus:ring-4 focus:ring-brand-100">
            </div>

            <label class="flex items-center gap-2.5 text-sm text-slate-600">
                <input type="checkbox" name="remember" value="1" class="size-4 rounded border-slate-300 text-brand-600 focus:ring-brand-500">
                Ingat saya di perangkat ini
            </label>

            <button type="submit" class="w-full rounded-xl bg-brand-600 px-4 py-3 text-sm font-bold text-white shadow-lg shadow-brand-600/25 transition hover:bg-brand-700">
                Masuk ke Dashboard
            </button>
        </form>

        <p class="mt-6 text-center text-sm text-slate-600">
            Belum punya akun?
            <a href="{{ route('register') }}" class="font-bold text-brand-700 hover:text-brand-800">Daftar sekarang</a>
        </p>

        <div class="mt-8 rounded-2xl border border-slate-200 bg-white p-4">
            <p class="text-xs font-bold uppercase tracking-wider text-slate-500">Akun demo</p>
            <div class="mt-2 grid gap-1.5 text-xs text-slate-600">
                <p><span class="font-semibold text-slate-800">Admin:</span> admin@eventsphere.test / password</p>
                <p><span class="font-semibold text-slate-800">Penyelenggara:</span> organizer@eventsphere.test / password</p>
                <p><span class="font-semibold text-slate-800">Peserta:</span> participant@eventsphere.test / password</p>
            </div>
        </div>

        <p class="mt-6 text-center text-xs text-slate-500">
            <a href="{{ route('home') }}" class="font-semibold hover:text-brand-700">← Kembali ke beranda</a>
        </p>
    </div>
@endsection
