@php
    $model = $category ?? null;
@endphp

<div class="rounded-lg border border-line bg-surface">
    <div class="border-b border-line px-6 py-4">
        <h2 class="text-base font-semibold text-ink">Informasi kategori</h2>
        <p class="mt-0.5 text-sm text-zinc-500">Nama kategori akan tampil pada filter dan kartu event.</p>
    </div>

    <div class="grid gap-5 p-6 sm:grid-cols-2">
        <div class="sm:col-span-2">
            <label for="name" class="label">Nama kategori <span class="text-rose-400">*</span></label>
            <input id="name" type="text" name="name" value="{{ old('name', $model?->name) }}" required placeholder="Contoh: Konferensi Teknologi" class="input">
        </div>

        <div class="sm:col-span-2">
            <label for="description" class="label">Deskripsi</label>
            <textarea id="description" name="description" rows="3" placeholder="Deskripsi singkat kategori…" class="input">{{ old('description', $model?->description) }}</textarea>
        </div>

        <div>
            <label for="color" class="label">Warna kategori <span class="text-rose-400">*</span></label>
            <div class="flex items-center gap-3">
                <input id="color" type="color" name="color" value="{{ old('color', $model?->color ?? '#fbbf24') }}" class="h-11 w-28 cursor-pointer rounded-md border border-line bg-canvas p-1">
                <span class="text-xs text-zinc-500">Gunakan palet emas (#FBBF24) atau krim hangat agar konsisten.</span>
            </div>
        </div>
    </div>
</div>
