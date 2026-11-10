@php
    $model = $category ?? null;
@endphp

<div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
    <div class="border-b border-slate-100 px-6 py-4">
        <h2 class="text-base font-bold text-slate-900">Informasi kategori</h2>
        <p class="mt-0.5 text-sm text-slate-500">Nama kategori akan tampil pada filter dan kartu event.</p>
    </div>

    <div class="grid gap-5 p-6 sm:grid-cols-2">
        <div class="sm:col-span-2">
            <label for="name" class="mb-1.5 block text-sm font-semibold text-slate-700">Nama kategori <span class="text-rose-500">*</span></label>
            <input id="name" type="text" name="name" value="{{ old('name', $model?->name) }}" required placeholder="Contoh: Konferensi Teknologi" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-brand-500 focus:ring-4 focus:ring-brand-100">
        </div>

        <div class="sm:col-span-2">
            <label for="description" class="mb-1.5 block text-sm font-semibold text-slate-700">Deskripsi</label>
            <textarea id="description" name="description" rows="3" placeholder="Deskripsi singkat kategori…" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-brand-500 focus:ring-4 focus:ring-brand-100">{{ old('description', $model?->description) }}</textarea>
        </div>

        <div>
            <label for="color" class="mb-1.5 block text-sm font-semibold text-slate-700">Warna kategori <span class="text-rose-500">*</span></label>
            <div class="flex items-center gap-3">
                <input id="color" type="color" name="color" value="{{ old('color', $model?->color ?? '#6366f1') }}" class="size-11 cursor-pointer rounded-xl border border-slate-300 bg-white p-1">
                <span class="text-xs text-slate-500">Digunakan pada ikon dan aksen kategori.</span>
            </div>
        </div>
    </div>
</div>
