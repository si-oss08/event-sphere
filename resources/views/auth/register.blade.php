@extends('layouts.auth')

@section('title', 'Daftar Akun')

@section('content')
    <div>
        <h1 class="text-2xl font-bold tracking-tight text-ink">Buat akun EventSphere</h1>
        <p class="mt-2 text-sm text-zinc-400">Gratis, dan hanya butuh kurang dari satu menit.</p>

        <form method="POST" action="{{ route('register.store') }}" class="mt-7 space-y-5">
            @csrf

            <div>
                <span class="mb-2 block text-sm font-medium text-zinc-300">Saya mendaftar sebagai</span>
                <div class="grid grid-cols-2 gap-3">
                    <label class="relative flex cursor-pointer flex-col rounded-lg border border-line bg-surface p-3 transition hover:border-line-strong has-[:checked]:border-emerald-500/50 has-[:checked]:bg-emerald-500/[0.06]">
                        <input type="radio" name="role" value="participant" class="sr-only" @checked(old('role', 'participant') === 'participant') data-role-input>
                        <span class="text-sm font-semibold text-ink">Peserta</span>
                        <span class="mt-0.5 text-xs text-zinc-500">Cari &amp; ikuti event</span>
                    </label>
                    <label class="relative flex cursor-pointer flex-col rounded-lg border border-line bg-surface p-3 transition hover:border-line-strong has-[:checked]:border-emerald-500/50 has-[:checked]:bg-emerald-500/[0.06]">
                        <input type="radio" name="role" value="organizer" class="sr-only" @checked(old('role') === 'organizer') data-role-input>
                        <span class="text-sm font-semibold text-ink">Penyelenggara</span>
                        <span class="mt-0.5 text-xs text-zinc-500">Buat &amp; kelola event</span>
                    </label>
                </div>
            </div>

            <div>
                <label for="name" class="label">Nama lengkap</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Nama sesuai identitas" class="input py-3">
            </div>

            <div id="organization-field" class="hidden">
                <label for="organization_name" class="label">Nama organisasi / komunitas</label>
                <input id="organization_name" type="text" name="organization_name" value="{{ old('organization_name') }}" placeholder="Contoh: Komunitas Developer Bandung" class="input py-3">
            </div>

            <div>
                <label for="email" class="label">Alamat email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="nama@email.com" class="input py-3">
            </div>

            <div>
                <label for="password" class="label">Kata sandi</label>
                <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter" class="input py-3">
            </div>

            <div>
                <label for="password_confirmation" class="label">Ulangi kata sandi</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi kata sandi" class="input py-3">
            </div>

            <button type="submit" class="btn-primary w-full py-3">
                Buat Akun
            </button>
        </form>

        <p class="mt-6 text-center text-sm text-zinc-400">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="font-semibold text-accent hover:text-accent-soft">Masuk di sini</a>
        </p>

        <p class="mt-6 text-center text-xs text-zinc-500">
            <a href="{{ route('home') }}" class="font-medium transition hover:text-accent-soft">← Kembali ke beranda</a>
        </p>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const field = document.getElementById('organization-field');
            const sync = () => {
                const role = document.querySelector('[data-role-input]:checked')?.value;
                field.classList.toggle('hidden', role !== 'organizer');
            };

            document.querySelectorAll('[data-role-input]').forEach((input) => input.addEventListener('change', sync));
            sync();
        });
    </script>
@endsection
