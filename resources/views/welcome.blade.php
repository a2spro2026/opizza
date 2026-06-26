@extends('layouts.app')

@section('title', "Restaurant O'pizza — Gestion de restauration")

@section('content')
<div class="relative min-h-screen w-full overflow-hidden">

    {{-- Arrière-plan plein écran --}}
    <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&fit=crop&w=2000&q=80"
         alt="Salle de restaurant"
         class="absolute inset-0 h-full w-full object-cover">
    <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-black/65 to-black/45"></div>
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,rgba(249,115,22,0.22),transparent_55%)]"></div>

    {{-- Étoiles scintillantes --}}
    @php
        $stars = [
            ['6%','10%',2,'0s','3.2s'], ['12%','22%',3,'0.6s','3.8s'], ['9%','40%',2,'1.2s','3s'],
            ['16%','58%',2,'0.3s','4.2s'], ['8%','72%',3,'1.8s','3.4s'], ['14%','88%',2,'0.9s','3.6s'],
            ['28%','6%',2,'1.4s','3.9s'], ['32%','30%',2,'0.2s','3.1s'], ['26%','50%',3,'2.1s','4.4s'],
            ['34%','68%',2,'0.7s','3.3s'], ['30%','92%',2,'1.1s','3.7s'], ['48%','14%',3,'1.6s','4s'],
            ['52%','82%',2,'0.4s','3.5s'], ['62%','26%',2,'2.3s','3.8s'], ['68%','60%',3,'0.8s','3.2s'],
            ['72%','44%',2,'1.5s','4.3s'], ['78%','12%',2,'0.5s','3.6s'], ['82%','78%',3,'1.9s','3.4s'],
            ['88%','34%',2,'1.0s','3.9s'], ['90%','64%',2,'0.1s','3.1s'], ['58%','94%',2,'2.0s','4.1s'],
            ['44%','48%',2,'1.3s','3.7s'],
        ];
        $sparkles = [
            ['18%','16%',26,'0s'], ['22%','80%',20,'1.2s'], ['66%','86%',24,'0.6s'],
            ['74%','22%',18,'1.8s'], ['40%','72%',22,'0.9s'], ['52%','38%',16,'2.2s'],
        ];
    @endphp
    <div class="pointer-events-none absolute inset-0 overflow-hidden">
        @foreach ($stars as $st)
            <span class="opz-star" style="top:{{ $st[0] }};left:{{ $st[1] }};width:{{ $st[2] }}px;height:{{ $st[2] }}px;animation-delay:{{ $st[3] }};animation-duration:{{ $st[4] }}"></span>
        @endforeach
        @foreach ($sparkles as $sp)
            <svg class="opz-sparkle" style="top:{{ $sp[0] }};left:{{ $sp[1] }};width:{{ $sp[2] }}px;height:{{ $sp[2] }}px;animation-delay:{{ $sp[3] }}" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l1.85 6.35L20 10l-6.15 1.65L12 18l-1.85-6.35L4 10l6.15-1.65L12 2z"/></svg>
        @endforeach
    </div>

    <style>
        .opz-star{position:absolute;border-radius:9999px;background:#fff;box-shadow:0 0 6px 1px rgba(255,255,255,.85);opacity:.3;animation-name:opzTwinkle;animation-iteration-count:infinite;animation-timing-function:ease-in-out}
        .opz-sparkle{position:absolute;color:rgba(253,210,140,.95);filter:drop-shadow(0 0 6px rgba(249,115,22,.65));opacity:.5;animation:opzSparkle 4.5s ease-in-out infinite}
        @keyframes opzTwinkle{0%,100%{opacity:.2;transform:scale(.6)}50%{opacity:1;transform:scale(1.2)}}
        @keyframes opzSparkle{0%,100%{opacity:.25;transform:scale(.75) rotate(0deg)}50%{opacity:1;transform:scale(1.15) rotate(25deg)}}
        @media (prefers-reduced-motion: reduce){.opz-star,.opz-sparkle{animation:none;opacity:.6}}
    </style>

    {{-- Contenu centré --}}
    <main class="relative z-10 flex min-h-screen flex-col items-center justify-center px-6 py-12 text-center">

        {{-- Logo --}}
        <x-logo class="h-28 w-28 sm:h-36 sm:w-36 rounded-full shadow-2xl shadow-brand-500/40 ring-1 ring-white/10 drop-shadow-xl" />

        {{-- Nom du projet centré et stylisé --}}
        <h1 class="mt-8 font-serif font-black leading-none tracking-tight">
            <span class="block text-3xl sm:text-5xl text-white/80">Restaurant</span>
            <span class="relative inline-block mt-2 text-7xl sm:text-9xl">
                <span class="absolute inset-0 bg-gradient-to-r from-brand-400 via-amber-300 to-brand-500 bg-clip-text text-transparent blur-2xl opacity-60" aria-hidden="true">O'pizza</span>
                <span class="relative bg-gradient-to-r from-brand-300 via-amber-200 to-brand-400 bg-clip-text text-transparent drop-shadow-[0_4px_30px_rgba(249,115,22,0.45)]">O'pizza</span>
            </span>
        </h1>

        <p class="mt-7 max-w-2xl text-base sm:text-lg leading-relaxed text-white/85">
            Une explosion de saveurs à chaque bouchée. Élevez votre expérience gastronomique avec la solution
            logicielle la plus intuitive du marché&nbsp;: cuisine, salle et stocks synchronisés en temps réel.
        </p>

        {{-- Bouton centré --}}
        <div class="mt-10">
            <a href="{{ route('login') }}"
               class="group relative inline-flex items-center gap-3 rounded-full px-9 py-4 text-base font-semibold text-white transition duration-300 hover:-translate-y-0.5">
                <span class="absolute -inset-1 rounded-full bg-gradient-to-r from-brand-500 via-amber-400 to-brand-500 opacity-60 blur-lg transition duration-300 group-hover:opacity-100"></span>
                <span class="absolute inset-0 rounded-full bg-gradient-to-r from-brand-500 to-amber-500 shadow-xl shadow-brand-500/40"></span>
                <span class="relative flex items-center gap-3 tracking-wide">
                    Accéder à ma session
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
                </span>
            </a>
        </div>
    </main>
</div>
@endsection
