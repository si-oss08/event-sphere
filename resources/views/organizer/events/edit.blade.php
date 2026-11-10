@extends('layouts.dashboard')

@section('title', 'Edit Event')
@section('heading', 'Edit Event')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <a href="{{ route('organizer.events.index') }}" class="text-xs font-bold text-brand-700 hover:text-brand-800">← Kembali ke event saya</a>
            <h2 class="mt-1 text-xl font-extrabold tracking-tight text-slate-900">{{ $event->title }}</h2>
            <p class="mt-1 text-sm text-slate-600">Perbarui detail event. Perubahan langsung terlihat pada halaman publik.</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('events.show', $event) }}" class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-bold text-slate-700 shadow-sm transition hover:bg-slate-50">Lihat Halaman</a>
            <a href="{{ route('organizer.events.registrants', $event) }}" class="rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-slate-800">Kelola Peserta</a>
        </div>
    </div>

    <form method="POST" action="{{ route('organizer.events.update', $event) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PATCH')

        @include('organizer.events._form', ['event' => $event])

        <div class="flex flex-wrap items-center justify-end gap-3 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <a href="{{ route('organizer.events.index') }}" class="rounded-xl px-4 py-2.5 text-sm font-bold text-slate-600 hover:text-slate-900">Batal</a>
            <button type="submit" class="rounded-xl bg-brand-600 px-6 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-brand-700">Simpan Perubahan</button>
        </div>
    </form>
@endsection
