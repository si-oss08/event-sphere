<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Masuk') — EventSphere</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-canvas font-sans text-ink antialiased">
    <div class="grid min-h-screen lg:grid-cols-2">
        <aside class="relative hidden overflow-hidden border-r border-line bg-[#08080a] p-12 lg:flex lg:flex-col lg:justify-between">
            <div class="bg-grid absolute inset-0"></div>
            <div class="absolute inset-y-0 left-0 w-px bg-accent/60"></div>

            <a href="{{ route('home') }}" class="relative flex items-center gap-2.5">
                <span class="flex size-10 items-center justify-center rounded-lg bg-accent text-zinc-950">
                    <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" /></svg>
                </span>
                <span class="text-lg font-bold tracking-tight text-ink">Event<span class="text-accent">Sphere</span></span>
            </a>

            <div class="relative max-w-md">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-accent">Sistem Informasi Event</p>
                <h1 class="mt-4 text-balance text-4xl font-bold leading-[1.15] tracking-tight text-ink">
                    Kelola setiap acara. Hadirkan pengalaman yang berkesan.
                </h1>
                <p class="mt-5 text-sm leading-relaxed text-zinc-400">
                    Dari konferensi teknologi hingga festival musik, EventSphere membantu penyelenggara
                    mengelola pendaftaran dan peserta, serta memudahkan peserta menemukan event favoritnya.
                </p>

                <div class="mt-10 grid grid-cols-3 gap-3">
                    <div class="rounded-lg border border-line bg-surface px-4 py-4">
                        <p class="text-2xl font-bold tracking-tight text-ink">3</p>
                        <p class="mt-1 text-[11px] font-medium text-zinc-500">Peran pengguna</p>
                    </div>
                    <div class="rounded-lg border border-line bg-surface px-4 py-4">
                        <p class="text-2xl font-bold tracking-tight text-ink">100%</p>
                        <p class="mt-1 text-[11px] font-medium text-zinc-500">Berbasis web</p>
                    </div>
                    <div class="rounded-lg border border-line bg-surface px-4 py-4">
                        <p class="text-2xl font-bold tracking-tight text-ink">24/7</p>
                        <p class="mt-1 text-[11px] font-medium text-zinc-500">Akses tiket</p>
                    </div>
                </div>
            </div>

            <p class="relative text-xs text-zinc-600">&copy; {{ date('Y') }} EventSphere. Semua hak dilindungi.</p>
        </aside>

        <main class="flex items-center justify-center px-4 py-12 sm:px-8">
            <div class="w-full max-w-md">
                <a href="{{ route('home') }}" class="mb-8 flex items-center gap-2.5 lg:hidden">
                    <span class="flex size-10 items-center justify-center rounded-lg bg-accent text-zinc-950">
                        <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" /></svg>
                    </span>
                    <span class="text-lg font-bold tracking-tight text-ink">Event<span class="text-accent">Sphere</span></span>
                </a>

                <div class="mb-6 space-y-3">
                    <x-flash />
                </div>

                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
