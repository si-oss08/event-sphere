@extends('layouts.dashboard')

@section('title', 'Profil Saya')
@section('heading', 'Profil Saya')

@section('content')
    <div class="grid gap-6 lg:grid-cols-3">
        <div class="lg:col-span-1">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 text-center shadow-sm">
                <img src="{{ $user->avatarUrl() }}" alt="{{ $user->name }}" class="mx-auto size-24 rounded-full object-cover ring-4 ring-slate-100">
                <h2 class="mt-4 text-lg font-extrabold text-slate-900">{{ $user->name }}</h2>
                <p class="text-sm text-slate-500">{{ $user->email }}</p>
                <span class="mt-3 inline-flex rounded-full px-3 py-1 text-xs font-bold ring-1 ring-inset {{ $user->role->badgeClasses() }}">{{ $user->role->label() }}</span>

                @if ($user->organization_name)
                    <p class="mt-4 text-sm font-semibold text-slate-700">{{ $user->organization_name }}</p>
                @endif
                @if ($user->bio)
                    <p class="mt-2 text-xs leading-relaxed text-slate-500">{{ $user->bio }}</p>
                @endif

                <p class="mt-5 border-t border-slate-100 pt-4 text-xs text-slate-400">Bergabung {{ $user->created_at->translatedFormat('F Y') }}</p>
            </div>
        </div>

        <div class="lg:col-span-2">
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="rounded-2xl border border-slate-200 bg-white shadow-sm">
                @csrf
                @method('PATCH')

                <div class="border-b border-slate-100 px-6 py-4">
                    <h2 class="text-base font-bold text-slate-900">Informasi profil</h2>
                    <p class="mt-0.5 text-sm text-slate-500">Perbarui data diri yang digunakan pada tiket dan komunikasi event.</p>
                </div>

                <div class="grid gap-5 p-6 sm:grid-cols-2">
                    <div class="sm:col-span-1">
                        <label for="name" class="mb-1.5 block text-sm font-semibold text-slate-700">Nama lengkap</label>
                        <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 outline-none transition focus:border-brand-500 focus:ring-4 focus:ring-brand-100">
                    </div>

                    <div class="sm:col-span-1">
                        <label for="email" class="mb-1.5 block text-sm font-semibold text-slate-700">Alamat email</label>
                        <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 outline-none transition focus:border-brand-500 focus:ring-4 focus:ring-brand-100">
                    </div>

                    <div class="sm:col-span-1">
                        <label for="phone" class="mb-1.5 block text-sm font-semibold text-slate-700">Nomor telepon</label>
                        <input id="phone" type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="08xxxxxxxxxx" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-brand-500 focus:ring-4 focus:ring-brand-100">
                    </div>

                    <div class="sm:col-span-1">
                        <label for="avatar" class="mb-1.5 block text-sm font-semibold text-slate-700">Foto profil</label>
                        <input id="avatar" type="file" name="avatar" accept="image/*" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm text-slate-600 file:mr-3 file:rounded-lg file:border-0 file:bg-brand-50 file:px-3 file:py-1.5 file:text-xs file:font-bold file:text-brand-700">
                    </div>

                    @if ($user->isOrganizer())
                        <div class="sm:col-span-2">
                            <label for="organization_name" class="mb-1.5 block text-sm font-semibold text-slate-700">Nama organisasi</label>
                            <input id="organization_name" type="text" name="organization_name" value="{{ old('organization_name', $user->organization_name) }}" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 outline-none transition focus:border-brand-500 focus:ring-4 focus:ring-brand-100">
                        </div>
                    @endif

                    <div class="sm:col-span-2">
                        <label for="bio" class="mb-1.5 block text-sm font-semibold text-slate-700">Bio singkat</label>
                        <textarea id="bio" name="bio" rows="4" placeholder="Ceritakan sedikit tentang Anda atau organisasi Anda…" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-brand-500 focus:ring-4 focus:ring-brand-100">{{ old('bio', $user->bio) }}</textarea>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 border-t border-slate-100 px-6 py-4">
                    <a href="{{ route('dashboard') }}" class="rounded-xl px-4 py-2.5 text-sm font-bold text-slate-600 hover:text-slate-900">Batal</a>
                    <button type="submit" class="rounded-xl bg-brand-600 px-5 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-brand-700">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
