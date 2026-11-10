@extends('layouts.dashboard')

@section('title', 'Buat Event')
@section('heading', 'Buat Event Baru')

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <a href="{{ route('organizer.events.index') }}" class="text-xs font-bold text-brand-700 hover:text-brand-800">← Kembali ke event saya</a>
            <h2 class="mt-1 text-xl font-extrabold tracking-tight text-slate-900">Detail event baru</h2>
            <p class="mt-1 text-sm text-slate-600">Lengkapi informasi di bawah, lalu simpan sebagai draf atau langsung terbitkan.</p>
        </div>
    </div>

    <form method="POST" action="{{ route('organizer.events.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        @include('organizer.events._form', ['event' => null])

        <div class="flex flex-wrap items-center justify-end gap-3 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <a href="{{ route('organizer.events.index') }}" class="rounded-xl px-4 py-2.5 text-sm font-bold text-slate-600 hover:text-slate-900">Batal</a>
            <button type="submit" class="rounded-xl bg-brand-600 px-6 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-brand-700">Simpan Event</button>
        </div>
    </form>
@endsection
