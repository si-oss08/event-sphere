@extends('layouts.auth')

@section('title', 'Daftar Akun')

@section('content')
    <div>
        <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">Buat akun EventSphere</h1>
        <p class="mt-2 text-sm text-slate-600">Gratis, dan hanya butuh kurang dari satu menit.</p>

        <form method="POST" action="{{ route('register.store') }}" class="mt-7 space-y-5">
            @csrf

            <div>
                <span class="mb-2 block text-sm font-semibold text-slate-700">Saya mendaftar sebagai</span>
                <div class="grid grid-cols-2 gap-3">
                    <label class="relative flex cursor-pointer flex-col rounded-xl border border-slate-300 bg-white p-3 transition hover:border-brand-300 has-[:checked]:border-brand-600 has-[:checked]:bg-brand-50">
                        <input type="radio" name="role" value="participant" class="sr-only" @checked(old('role', 'participant') === 'participant') data-role-input>
                        <span class="text-sm font-bold text-slate-900">Peserta</span>
                        <span class="mt-0.5 text-xs text-slate-500">Cari &amp; ikuti event</span>
                    </label>
                    <label class="relative flex cursor-pointer flex-col rounded-xl border border-slate-300 bg-white p-3 transition hover:border-brand-300 has-[:checked]:border-brand-600 has-[:checked]:bg-brand-50">
                        <input type="radio" name="role" value="organizer" class="sr-only" @checked(old('role') === 'organizer') data-role-input>
                        <span class="text-sm font-bold text-slate-900">Penyelenggara</span>
                        <span class="mt-0.5 text-xs text-slate-500">Buat &amp; kelola event</span>
                    </label>
                </div>
            </div>

            <div>
                <label for="name" class="mb-1.5 block text-sm font-semibold text-slate-700">Nama lengkap</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Nama sesuai identitas" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-brand-500 focus:ring-4 focus:ring-brand-100">
            </div>

            <div id="organization-field" class="hidden">
                <label for="organization_name" class="mb-1.5 block text-sm font-semibold text-slate-700">Nama organisasi / komunitas</label>
                <input id="organization_name" type="text" name="organization_name" value="{{ old('organization_name') }}" placeholder="Contoh: Komunitas Developer Bandung" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-brand-500 focus:ring-4 focus:ring-brand-100">
            </div>

            <div>
                <label for="email" class="mb-1.5 block text-sm font-semibold text-slate-700">Alamat email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="nama@email.com" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-brand-500 focus:ring-4 focus:ring-brand-100">
            </div>

            <div>
                <label for="password" class="mb-1.5 block text-sm font-semibold text-slate-700">Kata sandi</label>
                <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-brand-500 focus:ring-4 focus:ring-brand-100">
            </div>

            <div>
                <label for="password_confirmation" class="mb-1.5 block text-sm font-semibold text-slate-700">Ulangi kata sandi</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi kata sandi" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-brand-500 focus:ring-4 focus:ring-brand-100">
            </div>

            <button type="submit" class="w-full rounded-xl bg-brand-600 px-4 py-3 text-sm font-bold text-white shadow-lg shadow-brand-600/25 transition hover:bg-brand-700">
                Buat Akun
            </button>
        </form>

        <p class="mt-6 text-center text-sm text-slate-600">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="font-bold text-brand-700 hover:text-brand-800">Masuk di sini</a>
        </p>

        <p class="mt-6 text-center text-xs text-slate-500">
            <a href="{{ route('home') }}" class="font-semibold hover:text-brand-700">← Kembali ke beranda</a>
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
