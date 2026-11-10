<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Masuk') — EventSphere</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 font-sans text-slate-900 antialiased">
    <div class="grid min-h-screen lg:grid-cols-2">
        <aside class="relative hidden overflow-hidden bg-slate-950 p-12 lg:flex lg:flex-col lg:justify-between">
            <div class="absolute inset-0 bg-gradient-to-br from-brand-700 via-brand-800 to-slate-950"></div>
            <div class="bg-grid absolute inset-0 opacity-60"></div>
            <div class="absolute -right-24 -top-24 size-96 rounded-full bg-violet-500/20 blur-3xl"></div>
            <div class="absolute -bottom-32 -left-16 size-96 rounded-full bg-brand-400/20 blur-3xl"></div>

            <a href="{{ route('home') }}" class="relative flex items-center gap-2.5">
                <span class="flex size-10 items-center justify-center rounded-xl bg-white/10 text-white ring-1 ring-white/20 backdrop-blur">
                    <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" /></svg>
                </span>
                <span class="text-lg font-extrabold tracking-tight text-white">Event<span class="text-brand-300">Sphere</span></span>
            </a>

            <div class="relative max-w-md">
                <p class="text-sm font-bold uppercase tracking-[0.2em] text-brand-300">Sistem Informasi Event</p>
                <h1 class="mt-4 text-balance text-4xl font-extrabold leading-tight tracking-tight text-white">
                    Kelola setiap acara. Hadirkan pengalaman yang berkesan.
                </h1>
                <p class="mt-5 text-base leading-relaxed text-slate-300">
                    Dari konferensi teknologi hingga festival musik, EventSphere membantu penyelenggara
                    mengelola pendaftaran dan peserta, serta memudahkan peserta menemukan event favoritnya.
                </p>

                <div class="mt-8 grid grid-cols-3 gap-4">
                    <div class="rounded-2xl bg-white/5 p-4 ring-1 ring-white/10 backdrop-blur">
                        <p class="text-2xl font-extrabold text-white">3</p>
                        <p class="mt-1 text-xs text-slate-300">Peran pengguna</p>
                    </div>
                    <div class="rounded-2xl bg-white/5 p-4 ring-1 ring-white/10 backdrop-blur">
                        <p class="text-2xl font-extrabold text-white">100%</p>
                        <p class="mt-1 text-xs text-slate-300">Berbasis web</p>
                    </div>
                    <div class="rounded-2xl bg-white/5 p-4 ring-1 ring-white/10 backdrop-blur">
                        <p class="text-2xl font-extrabold text-white">24/7</p>
                        <p class="mt-1 text-xs text-slate-300">Akses tiket</p>
                    </div>
                </div>
            </div>

            <p class="relative text-xs text-slate-400">&copy; {{ date('Y') }} EventSphere. Semua hak dilindungi.</p>
        </aside>

        <main class="flex items-center justify-center px-4 py-12 sm:px-8">
            <div class="w-full max-w-md">
                <a href="{{ route('home') }}" class="mb-8 flex items-center gap-2.5 lg:hidden">
                    <span class="flex size-10 items-center justify-center rounded-xl bg-gradient-to-br from-brand-500 to-violet-600 text-white">
                        <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" /></svg>
                    </span>
                    <span class="text-lg font-extrabold tracking-tight text-slate-900">Event<span class="text-brand-600">Sphere</span></span>
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
