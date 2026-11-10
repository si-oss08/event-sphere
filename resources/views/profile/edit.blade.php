@extends('layouts.dashboard')

@section('title', 'Profil Saya')
@section('heading', 'Profil Saya')

@section('content')
    <div class="grid gap-6 lg:grid-cols-3">
        <div class="lg:col-span-1">
            <div class="rounded-xl border border-line bg-surface p-6 text-center">
                <img src="{{ $user->avatarUrl() }}" alt="{{ $user->name }}" class="mx-auto size-24 rounded-lg object-cover ring-1 ring-line">
                <h2 class="mt-4 text-lg font-bold text-ink">{{ $user->name }}</h2>
                <p class="text-sm text-zinc-500">{{ $user->email }}</p>
                <span class="mt-3 inline-flex rounded-md px-3 py-1 text-xs font-semibold ring-1 ring-inset {{ $user->role->badgeClasses() }}">{{ $user->role->label() }}</span>

                @if ($user->organization_name)
                    <p class="mt-4 text-sm font-semibold text-zinc-300">{{ $user->organization_name }}</p>
                @endif
                @if ($user->bio)
                    <p class="mt-2 text-xs leading-relaxed text-zinc-500">{{ $user->bio }}</p>
                @endif

                <p class="mt-5 border-t border-line pt-4 text-xs text-zinc-600">Bergabung {{ $user->created_at->translatedFormat('F Y') }}</p>
            </div>
        </div>

        <div class="lg:col-span-2">
            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="rounded-xl border border-line bg-surface">
                @csrf
                @method('PATCH')

                <div class="border-b border-line px-6 py-4">
                    <h2 class="text-base font-semibold text-ink">Informasi profil</h2>
                    <p class="mt-0.5 text-sm text-zinc-500">Perbarui data diri yang digunakan pada tiket dan komunikasi event.</p>
                </div>

                <div class="grid gap-5 p-6 sm:grid-cols-2">
                    <div class="sm:col-span-1">
                        <label for="name" class="label">Nama lengkap</label>
                        <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required class="input">
                    </div>

                    <div class="sm:col-span-1">
                        <label for="email" class="label">Alamat email</label>
                        <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required class="input">
                    </div>

                    <div class="sm:col-span-1">
                        <label for="phone" class="label">Nomor telepon</label>
                        <input id="phone" type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="08xxxxxxxxxx" class="input">
                    </div>

                    <div class="sm:col-span-1">
                        <label for="avatar" class="label">Foto profil</label>
                        <input id="avatar" type="file" name="avatar" accept="image/*" class="w-full rounded-lg border border-line bg-surface-2 px-3 py-2 text-sm text-zinc-400 file:mr-3 file:rounded-md file:border-0 file:bg-emerald-500/10 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-emerald-300">
                    </div>

                    @if ($user->isOrganizer())
                        <div class="sm:col-span-2">
                            <label for="organization_name" class="label">Nama organisasi</label>
                            <input id="organization_name" type="text" name="organization_name" value="{{ old('organization_name', $user->organization_name) }}" class="input">
                        </div>
                    @endif

                    <div class="sm:col-span-2">
                        <label for="bio" class="label">Bio singkat</label>
                        <textarea id="bio" name="bio" rows="4" placeholder="Ceritakan sedikit tentang Anda atau organisasi Anda…" class="input">{{ old('bio', $user->bio) }}</textarea>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 border-t border-line px-6 py-4">
                    <a href="{{ route('dashboard') }}" class="btn-ghost">Batal</a>
                    <button type="submit" class="btn-primary px-5">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
