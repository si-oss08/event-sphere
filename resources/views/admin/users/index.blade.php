@extends('layouts.dashboard')

@section('title', 'Kelola Pengguna')
@section('heading', 'Kelola Pengguna')

@section('content')
    <div>
        <h2 class="section-title">Semua pengguna</h2>
        <p class="mt-1 text-sm text-zinc-400">Atur peran pengguna dan tinjau aktivitas akun.</p>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <x-stat-card label="Total pengguna" :value="$summary['total']" hint="Semua peran" icon="users" tone="brand" />
        <x-stat-card label="Penyelenggara" :value="$summary['organizer']" hint="Pengelola event" icon="calendar" tone="gold" />
        <x-stat-card label="Peserta" :value="$summary['participant']" hint="Pendaftar event" icon="ticket" tone="neutral" />
        <x-stat-card label="Administrator" :value="$summary['admin']" hint="Akses penuh" icon="chart" tone="amber" />
    </div>

    <form method="GET" class="flex flex-col gap-3 rounded-lg border border-line bg-surface p-4 sm:flex-row">
        <div class="relative flex-1">
            <div class="pointer-events-none absolute inset-y-0 left-0 z-10 flex items-center pl-3.5">
                <svg class="size-4 text-zinc-500" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
            </div>
            <input type="search" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Cari nama atau email…" class="input pl-10">
        </div>
        <select name="role" class="select sm:w-48">
            <option value="">Semua peran</option>
            @foreach (\App\UserRole::cases() as $role)
                <option value="{{ $role->value }}" @selected(($filters['role'] ?? '') === $role->value)>{{ $role->label() }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn-primary">Terapkan</button>
    </form>

    <div class="table-wrap">
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Pengguna</th>
                        <th>Peran</th>
                        <th>Pendaftaran</th>
                        <th>Bergabung</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>
                                <div class="flex items-center gap-3">
                                    <img src="{{ $user->avatarUrl() }}" alt="" class="size-9 rounded-md object-cover">
                                    <div class="min-w-0">
                                        <p class="truncate text-sm font-semibold text-ink">{{ $user->name }} @if ($user->is(auth()->user()))<span class="ml-1 rounded border border-line bg-surface-2 px-1.5 py-0.5 text-[10px] font-semibold text-zinc-400">Anda</span>@endif</p>
                                        <p class="truncate text-xs text-zinc-500">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <form method="POST" action="{{ route('admin.users.update', $user) }}" class="flex items-center gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="role" class="select w-36 px-2 py-1.5 text-xs">
                                        @foreach (\App\UserRole::cases() as $role)
                                            <option value="{{ $role->value }}" @selected($user->role === $role)>{{ $role->label() }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="rounded-md border border-line bg-surface-2 px-2.5 py-1.5 text-[11px] font-semibold text-zinc-200 transition hover:border-line-strong">Ubah</button>
                                </form>
                            </td>
                            <td class="text-xs font-medium text-zinc-300">{{ $user->registrations_count }}</td>
                            <td class="text-xs text-zinc-500">{{ $user->created_at->translatedFormat('d M Y') }}</td>
                            <td class="text-right">
                                @if (! $user->is(auth()->user()))
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Hapus pengguna ini? Seluruh datanya akan ikut terhapus.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-danger px-3 py-1.5 text-xs">Hapus</button>
                                    </form>
                                @else
                                    <span class="text-xs text-zinc-600">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-14 text-center">
                                <p class="text-sm font-semibold text-zinc-200">Tidak ada pengguna yang cocok</p>
                                <p class="mt-1 text-sm text-zinc-500">Coba ubah kata kunci atau filter peran.</p>
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
