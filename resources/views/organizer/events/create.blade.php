@extends('layouts.dashboard')

@section('title', 'Buat Event')
@section('heading', 'Buat Event Baru')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <a href="{{ route('organizer.events.index') }}" class="text-xs font-semibold text-accent hover:text-accent-soft">← Kembali ke event saya</a>
            <h2 class="mt-1 section-title">Detail event baru</h2>
            <p class="mt-1 text-sm text-zinc-400">Lengkapi informasi di bawah, lalu simpan sebagai draf atau langsung terbitkan.</p>
        </div>
    </div>

    <form method="POST" action="{{ route('organizer.events.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        @include('organizer.events._form', ['event' => null])

        <div class="flex flex-wrap items-center justify-end gap-3 rounded-xl border border-line bg-surface p-4">
            <a href="{{ route('organizer.events.index') }}" class="btn-ghost">Batal</a>
            <button type="submit" class="btn-primary px-6">Simpan Event</button>
        </div>
    </form>
@endsection
