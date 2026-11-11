@extends('layouts.auth')

@section('title', 'Masuk')

@section('content')
    <div>
        <p class="eyebrow">Akses Akun</p>
        <h1 class="mt-3 font-display text-3xl font-extrabold tracking-tight text-ink">Selamat datang kembali</h1>
        <p class="mt-2 text-sm text-zinc-400">Masuk untuk mengelola event dan tiket Anda.</p>

        <form method="POST" action="{{ route('login.store') }}" class="mt-8 space-y-5">
            @csrf

            <div>
                <label for="email" class="label">Alamat email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email" placeholder="nama@email.com" class="input py-3">
            </div>

            <div>
                <div class="mb-1.5 flex items-center justify-between">
                    <label for="password" class="block text-sm font-medium text-zinc-300">Kata sandi</label>
                    <button type="button" data-password-toggle="#password" class="text-xs font-semibold text-accent hover:text-accent-soft">Lihat</button>
                </div>
                <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" class="input py-3">
            </div>

            <label class="flex items-center gap-2.5 text-sm text-zinc-400">
                <input type="checkbox" name="remember" value="1" class="size-4 cursor-pointer">
                Ingat saya di perangkat ini
            </label>

            <button type="submit" class="btn-primary w-full py-3">
                Masuk ke Dashboard
            </button>
        </form>

        <p class="mt-6 text-center text-sm text-zinc-400">
            Belum punya akun?
            <a href="{{ route('register') }}" class="font-semibold text-accent hover:text-accent-soft">Daftar sekarang</a>
        </p>

        <div class="mt-8 rounded-lg border border-line bg-canvas p-4">
            <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-accent">Akun demo</p>
            <div class="mt-3 grid gap-1.5 text-xs text-zinc-400">
                <p><span class="font-semibold text-zinc-200">Admin:</span> admin@eventsphere.test / password</p>
                <p><span class="font-semibold text-zinc-200">Penyelenggara:</span> organizer@eventsphere.test / password</p>
                <p><span class="font-semibold text-zinc-200">Peserta:</span> participant@eventsphere.test / password</p>
            </div>
        </div>

        <p class="mt-6 text-center text-xs text-zinc-500">
            <a href="{{ route('home') }}" class="font-medium transition hover:text-accent-soft">← Kembali ke beranda</a>
        </p>
    </div>
@endsection
