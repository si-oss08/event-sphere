@if (session('status'))
    <div class="flex items-start gap-3 rounded-lg border border-emerald-500/25 bg-emerald-500/[0.06] p-4 text-sm text-emerald-200">
        <svg class="mt-0.5 size-5 shrink-0 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
        <p class="font-medium">{{ session('status') }}</p>
    </div>
@endif

@if (session('error'))
    <div class="flex items-start gap-3 rounded-lg border border-rose-500/25 bg-rose-500/[0.06] p-4 text-sm text-rose-200">
        <svg class="mt-0.5 size-5 shrink-0 text-rose-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" /></svg>
        <p class="font-medium">{{ session('error') }}</p>
    </div>
@endif

@if (isset($errors) && $errors->any())
    <div class="flex items-start gap-3 rounded-lg border border-rose-500/25 bg-rose-500/[0.06] p-4 text-sm text-rose-200">
        <svg class="mt-0.5 size-5 shrink-0 text-rose-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" /></svg>
        <div>
            <p class="font-semibold">Periksa kembali data yang Anda masukkan.</p>
            <ul class="mt-1 list-inside list-disc space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
