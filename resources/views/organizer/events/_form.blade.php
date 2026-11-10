@php
    $model = $event ?? null;
@endphp

<div class="space-y-6">
    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 px-6 py-4">
            <h2 class="text-base font-bold text-slate-900">Informasi dasar</h2>
            <p class="mt-0.5 text-sm text-slate-500">Detail utama yang akan dilihat calon peserta.</p>
        </div>

        <div class="grid gap-5 p-6 sm:grid-cols-2">
            <div class="sm:col-span-2">
                <label for="title" class="mb-1.5 block text-sm font-semibold text-slate-700">Judul event <span class="text-rose-500">*</span></label>
                <input id="title" type="text" name="title" value="{{ old('title', $model?->title) }}" required placeholder="Contoh: Indonesia Developer Summit 2026" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-brand-500 focus:ring-4 focus:ring-brand-100">
            </div>

            <div>
                <label for="category_id" class="mb-1.5 block text-sm font-semibold text-slate-700">Kategori</label>
                <select id="category_id" name="category_id" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-brand-500 focus:ring-4 focus:ring-brand-100">
                    <option value="">Tanpa kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected((int) old('category_id', $model?->category_id) === $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="status" class="mb-1.5 block text-sm font-semibold text-slate-700">Status publikasi</label>
                <select id="status" name="status" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition focus:border-brand-500 focus:ring-4 focus:ring-brand-100">
                    @foreach (\App\EventStatus::organisable() as $status)
                        <option value="{{ $status->value }}" @selected(old('status', $model?->status?->value ?? 'draft') === $status->value)>{{ $status->label() }}</option>
                    @endforeach
                </select>
            </div>

            <div class="sm:col-span-2">
                <label for="description" class="mb-1.5 block text-sm font-semibold text-slate-700">Deskripsi <span class="text-rose-500">*</span></label>
                <textarea id="description" name="description" rows="6" required placeholder="Jelaskan tema, agenda, pembicara, dan informasi penting lainnya…" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-brand-500 focus:ring-4 focus:ring-brand-100">{{ old('description', $model?->description) }}</textarea>
            </div>

            <div class="sm:col-span-2">
                <label class="flex items-start gap-3 rounded-xl border border-slate-200 bg-slate-50 p-4">
                    <input type="checkbox" name="featured" value="1" @checked(old('featured', $model?->featured)) class="mt-0.5 size-4 rounded border-slate-300 text-brand-600 focus:ring-brand-500">
                    <span>
                        <span class="block text-sm font-bold text-slate-900">Tandai sebagai event unggulan</span>
                        <span class="block text-xs text-slate-500">Event unggulan akan diprioritaskan pada halaman beranda.</span>
                    </span>
                </label>
            </div>
        </div>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 px-6 py-4">
            <h2 class="text-base font-bold text-slate-900">Waktu &amp; lokasi</h2>
            <p class="mt-0.5 text-sm text-slate-500">Kapan dan di mana event akan berlangsung.</p>
        </div>

        <div class="grid gap-5 p-6 sm:grid-cols-2">
            <div>
                <label for="starts_at" class="mb-1.5 block text-sm font-semibold text-slate-700">Waktu mulai <span class="text-rose-500">*</span></label>
                <input id="starts_at" type="datetime-local" name="starts_at" value="{{ old('starts_at', $model?->starts_at?->format('Y-m-d\TH:i')) }}" required class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 outline-none transition focus:border-brand-500 focus:ring-4 focus:ring-brand-100">
            </div>

            <div>
                <label for="ends_at" class="mb-1.5 block text-sm font-semibold text-slate-700">Waktu selesai <span class="text-rose-500">*</span></label>
                <input id="ends_at" type="datetime-local" name="ends_at" value="{{ old('ends_at', $model?->ends_at?->format('Y-m-d\TH:i')) }}" required class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 outline-none transition focus:border-brand-500 focus:ring-4 focus:ring-brand-100">
            </div>

            <div>
                <label for="venue" class="mb-1.5 block text-sm font-semibold text-slate-700">Nama lokasi <span class="text-rose-500">*</span></label>
                <input id="venue" type="text" name="venue" value="{{ old('venue', $model?->venue) }}" required placeholder="Contoh: Jakarta Convention Center" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-brand-500 focus:ring-4 focus:ring-brand-100">
            </div>

            <div>
                <label for="city" class="mb-1.5 block text-sm font-semibold text-slate-700">Kota <span class="text-rose-500">*</span></label>
                <input id="city" type="text" name="city" value="{{ old('city', $model?->city) }}" required placeholder="Contoh: Jakarta" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-brand-500 focus:ring-4 focus:ring-brand-100">
            </div>

            <div class="sm:col-span-2">
                <label for="address" class="mb-1.5 block text-sm font-semibold text-slate-700">Alamat lengkap</label>
                <input id="address" type="text" name="address" value="{{ old('address', $model?->address) }}" placeholder="Jl. Contoh No. 123, Kecamatan, Kota" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-brand-500 focus:ring-4 focus:ring-brand-100">
            </div>
        </div>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 px-6 py-4">
            <h2 class="text-base font-bold text-slate-900">Tiket &amp; media</h2>
            <p class="mt-0.5 text-sm text-slate-500">Atur kuota, harga tiket, dan poster event.</p>
        </div>

        <div class="grid gap-5 p-6 sm:grid-cols-2">
            <div>
                <label for="capacity" class="mb-1.5 block text-sm font-semibold text-slate-700">Kuota peserta <span class="text-rose-500">*</span></label>
                <input id="capacity" type="number" name="capacity" min="1" max="100000" value="{{ old('capacity', $model?->capacity ?? 100) }}" required class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 outline-none transition focus:border-brand-500 focus:ring-4 focus:ring-brand-100">
            </div>

            <div>
                <label for="price" class="mb-1.5 block text-sm font-semibold text-slate-700">Harga tiket (Rp) <span class="text-rose-500">*</span></label>
                <input id="price" type="number" name="price" min="0" step="1000" value="{{ old('price', $model?->price ?? 0) }}" required class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm text-slate-900 outline-none transition focus:border-brand-500 focus:ring-4 focus:ring-brand-100">
                <p class="mt-1 text-xs text-slate-500">Isi 0 untuk event gratis.</p>
            </div>

            <div class="sm:col-span-2">
                <label for="poster" class="mb-1.5 block text-sm font-semibold text-slate-700">Poster event</label>
                <input id="poster" type="file" name="poster" accept="image/*" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm text-slate-600 file:mr-3 file:rounded-lg file:border-0 file:bg-brand-50 file:px-3 file:py-1.5 file:text-xs file:font-bold file:text-brand-700">
                <p class="mt-1 text-xs text-slate-500">Format JPG, PNG, atau WebP. Maksimal 4 MB. Rasio ideal 16:9.</p>

                @if ($model?->poster_path)
                    <div class="mt-3 flex items-center gap-3 rounded-xl border border-slate-200 p-3">
                        <img src="{{ $model->posterUrl() }}" alt="" class="h-16 w-28 rounded-lg object-cover">
                        <p class="text-xs text-slate-500">Poster saat ini. Unggah file baru untuk mengganti.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
