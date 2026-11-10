@extends('layouts.dashboard')

@section('title', 'Edit Event')
@section('heading', 'Edit Event')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <a href="{{ route('organizer.events.index') }}" class="text-xs font-semibold text-accent hover:text-accent-soft">← Kembali ke event saya</a>
            <h2 class="mt-1 section-title">{{ $event->title }}</h2>
            <p class="mt-1 text-sm text-zinc-400">Perbarui detail event. Perubahan langsung terlihat pada halaman publik.</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('events.show', $event) }}" class="btn-secondary">Lihat Halaman</a>
            <a href="{{ route('organizer.events.registrants', $event) }}" class="btn-primary">Kelola Peserta</a>
        </div>
    </div>

    <form method="POST" action="{{ route('organizer.events.update', $event) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PATCH')

        @include('organizer.events._form', ['event' => $event])

        <div class="flex flex-wrap items-center justify-end gap-3 rounded-xl border border-line bg-surface p-4">
            <a href="{{ route('organizer.events.index') }}" class="btn-ghost">Batal</a>
            <button type="submit" class="btn-primary px-6">Simpan Perubahan</button>
        </div>
    </form>
@endsection
