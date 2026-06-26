<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', "Tableau de bord — O'pizza")</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f6f5fb] text-slate-800 antialiased font-sans">
<div x-data="{ open: false }" class="min-h-screen lg:flex">

    {{-- Overlay mobile --}}
    <div x-show="open" @click="open = false" x-cloak class="fixed inset-0 z-30 bg-slate-900/40 lg:hidden"></div>

    {{-- Barre latérale --}}
    <aside :class="open ? 'translate-x-0' : '-translate-x-full'"
           class="fixed lg:sticky lg:top-0 lg:h-screen z-40 inset-y-0 left-0 w-72 shrink-0 bg-slate-900 text-slate-300 transform transition-transform lg:translate-x-0 flex flex-col">
        <div class="flex items-center gap-3 px-6 h-20 border-b border-white/10">
            <x-logo class="h-9 w-9" />
            <span class="font-serif text-lg font-bold text-white">Restaurant <span class="text-brand-400">O'pizza</span></span>
        </div>

        @php $active = $active ?? 'dashboard'; @endphp
        <nav class="flex-1 overflow-y-auto no-scrollbar px-4 py-6 space-y-1.5">
            @foreach (config('navigation') as $key => $item)
                @if (empty($item['children']))
                    {{-- Élément simple --}}
                    <a href="{{ url('/dashboard') }}"
                       class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition {{ $active === $key ? 'bg-brand-500 text-white shadow-lg shadow-brand-500/20' : 'hover:bg-white/5 hover:text-white' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}"/></svg>
                        {{ $item['label'] }}
                    </a>
                @else
                    {{-- Groupe avec sous-liste (accordéon) --}}
                    @php $groupActive = in_array($active, array_keys($item['children'])); @endphp
                    <div x-data="{ open: {{ $groupActive ? 'true' : 'false' }} }">
                        <button type="button" @click="open = !open"
                                class="w-full flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition {{ $groupActive ? 'bg-white/10 text-white' : 'text-slate-300 hover:bg-white/5 hover:text-white' }}">
                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg {{ $groupActive ? 'bg-brand-500 text-white' : 'bg-white/5 text-brand-300' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}"/></svg>
                            </span>
                            <span class="flex-1 text-left">{{ $item['label'] }}</span>
                            <svg xmlns="http://www.w3.org/2000/svg" :class="open ? 'rotate-90' : ''" class="h-4 w-4 shrink-0 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/></svg>
                        </button>

                        <div x-show="open" x-collapse x-cloak
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 -translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             class="mt-1 ml-5 space-y-0.5 border-l border-white/10 pl-3">
                            @foreach ($item['children'] as $slug => $child)
                                <a href="{{ url('/dashboard/'.$slug) }}"
                                   class="flex items-center gap-2.5 rounded-lg px-3 py-2 text-[13px] transition {{ $active === $slug ? 'bg-brand-500/15 text-brand-300 font-semibold' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $child['icon'] }}"/></svg>
                                    <span>{{ $child['label'] }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        </nav>

        <div class="p-4 border-t border-white/10">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium text-slate-400 hover:bg-white/5 hover:text-white transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75"/></svg>
                    Se déconnecter
                </button>
            </form>
        </div>
    </aside>

    {{-- Contenu --}}
    <div class="flex-1 min-w-0 flex flex-col">
        <header class="sticky top-0 z-20 flex items-center gap-4 bg-white/80 backdrop-blur border-b border-slate-100 px-5 sm:px-8 h-20">
            <button @click="open = !open" class="lg:hidden text-slate-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5"/></svg>
            </button>

            <div class="flex items-center gap-3">
                <x-logo class="h-11 w-11 sm:h-12 sm:w-12 drop-shadow" />
                <h2 class="font-serif text-2xl sm:text-3xl font-extrabold tracking-wide text-slate-900">SUIVI OPÉRATIONNEL</h2>
            </div>

            <div class="ml-auto flex items-center gap-3">
                <button class="relative rounded-xl p-2.5 text-slate-500 hover:bg-slate-100 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0"/></svg>
                    <span class="absolute top-1.5 right-1.5 h-2 w-2 rounded-full bg-brand-500"></span>
                </button>
                <div class="flex items-center gap-3 pl-3 border-l border-slate-200">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gradient-to-br from-brand-400 to-brand-600 text-white font-semibold">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <div class="hidden sm:block leading-tight">
                        <p class="text-sm font-semibold text-slate-900">{{ auth()->user()->name ?? 'Admin' }}</p>
                        <p class="text-xs text-slate-400">Gérant</p>
                    </div>
                </div>
            </div>
        </header>

        <main class="flex-1 p-5 sm:p-8">
            @yield('content')
        </main>
    </div>
</div>

<script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<style>[x-cloak]{display:none!important}</style>
</body>
</html>
