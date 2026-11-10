@extends('layouts.dashboard')

@section('title', 'Kelola Pengguna')
@section('heading', 'Kelola Pengguna')

@section('content')
    <div>
        <h2 class="text-xl font-extrabold tracking-tight text-slate-900">Semua pengguna</h2>
        <p class="mt-1 text-sm text-slate-600">Atur peran pengguna dan tinjau aktivitas akun.</p>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <x-stat-card label="Total pengguna" :value="$summary['total']" hint="Semua peran" icon="users" tone="brand" />
        <x-stat-card label="Penyelenggara" :value="$summary['organizer']" hint="Pengelola event" icon="calendar" tone="violet" />
        <x-stat-card label="Peserta" :value="$summary['participant']" hint="Pendaftar event" icon="ticket" tone="sky" />
        <x-stat-card label="Administrator" :value="$summary['admin']" hint="Akses penuh" icon="chart" tone="rose" />
    </div>

    <form method="GET" class="flex flex-col gap-3 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:flex-row">
        <div class="relative flex-1">
            <div class="pointer-events-none absolute inset-y-0 left-0 z-10 flex items-center pl-3.5">
                <svg class="size-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
            </div>
            <input type="search" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Cari nama atau email…" class="w-full rounded-xl border border-slate-200 bg-slate-50 py-2.5 pl-10 pr-3 text-sm outline-none focus:border-brand-400 focus:bg-white focus:ring-2 focus:ring-brand-100">
        </div>
        <select name="role" class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm outline-none focus:border-brand-400 focus:bg-white focus:ring-2 focus:ring-brand-100">
            <option value="">Semua peran</option>
            @foreach (\App\UserRole::cases() as $role)
                <option value="{{ $role->value }}" @selected(($filters['role'] ?? '') === $role->value)>{{ $role->label() }}</option>
            @endforeach
        </select>
        <button type="submit" class="rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-bold text-white transition hover:bg-slate-800">Terapkan</button>
    </form>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100 text-left text-sm">
                <thead class="bg-slate-50 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-5 py-3">Pengguna</th>
                        <th class="px-5 py-3">Peran</th>
                        <th class="px-5 py-3">Pendaftaran</th>
                        <th class="px-5 py-3">Bergabung</th>
                        <th class="px-5 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($users as $user)
                        <tr class="hover:bg-slate-50/60">
                            <td class="px-5 py-3">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $user->avatarUrl() }}" alt="" class="size-9 rounded-full object-cover">
                                    <div class="min-w-0">
                                        <p class="truncate text-sm font-bold text-slate-900">{{ $user->name }} @if ($user->is(auth()->user()))<span class="ml-1 rounded bg-brand-50 px-1.5 py-0.5 text-[10px] font-bold text-brand-700">Anda</span>@endif</p>
                                        <p class="truncate text-xs text-slate-500">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-3">
                                <form method="POST" action="{{ route('admin.users.update', $user) }}" class="flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="role" class="rounded-lg border border-slate-200 bg-white px-2 py-1.5 text-xs outline-none focus:border-brand-400 focus:ring-2 focus:ring-brand-100">
                                        @foreach (\App\UserRole::cases() as $role)
                                            <option value="{{ $role->value }}" @selected($user->role === $role)>{{ $role->label() }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="rounded-lg bg-slate-900 px-2.5 py-1.5 text-[11px] font-bold text-white hover:bg-slate-800">Ubah</button>
                                </form>
                            </td>
                            <td class="px-5 py-3 text-xs font-semibold text-slate-700">{{ $user->registrations_count }}</td>
                            <td class="px-5 py-3 text-xs text-slate-500">{{ $user->created_at->translatedFormat('d M Y') }}</td>
                            <td class="px-5 py-3 text-right">
                                @if (! $user->is(auth()->user()))
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Hapus pengguna ini? Seluruh datanya akan ikut terhapus.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-lg border border-rose-200 px-3 py-1.5 text-xs font-bold text-rose-600 hover:bg-rose-50">Hapus</button>
                                    </form>
                                @else
                                    <span class="text-xs text-slate-400">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-14 text-center">
                                <p class="text-sm font-bold text-slate-800">Tidak ada pengguna yang cocok</p>
                                <p class="mt-1 text-sm text-slate-500">Coba ubah kata kunci atau filter peran.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div>
        {{ $users->links() }}
    </div>
@endsection
