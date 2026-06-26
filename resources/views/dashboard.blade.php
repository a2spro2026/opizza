@extends('layouts.dashboard')

@section('title', "Tableau de bord — O'pizza")

@section('content')
<div class="space-y-6">

    {{-- En-tête --}}
    <div>
        <h1 class="font-serif text-3xl font-bold text-slate-900">Bonjour, {{ auth()->user()->name }} 👋</h1>
        <p class="mt-1 text-sm text-slate-500">Voici l'activité de votre restaurant aujourd'hui, {{ now()->translatedFormat('l d F Y') }}.</p>
    </div>

    {{-- Cartes statistiques --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">
        @foreach ($stats as $s)
            <div class="group relative h-[120px] overflow-hidden rounded-xl bg-gradient-to-br {{ $s['grad'] }} p-4 text-white shadow-lg {{ $s['glow'] }} transition duration-300 hover:shadow-xl">
                {{-- effets lumineux --}}
                <div class="pointer-events-none absolute -top-8 -right-6 h-20 w-20 rounded-full bg-white/25 blur-2xl transition duration-500 group-hover:bg-white/40"></div>
                <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.28),transparent_55%)]"></div>
                <div class="pointer-events-none absolute inset-0 rounded-xl ring-1 ring-inset ring-white/20"></div>

                <div class="relative">
                    <div class="flex items-center justify-between">
                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-white/20 backdrop-blur-sm ring-1 ring-white/30">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white drop-shadow" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $s['icon'] }}"/></svg>
                        </div>
                        <span class="inline-flex items-center gap-1 rounded-full bg-white/20 px-2 py-0.5 text-[11px] font-semibold text-white ring-1 ring-white/25 backdrop-blur-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $s['up'] ? 'M4.5 15.75l7.5-7.5 7.5 7.5' : 'M19.5 8.25l-7.5 7.5-7.5-7.5' }}"/></svg>
                            {{ $s['change'] }}
                        </span>
                    </div>
                    <p class="mt-2 text-2xl font-bold tracking-tight drop-shadow-sm leading-none">{{ $s['value'] }}</p>
                    <p class="mt-1 text-xs font-medium text-white/85">{{ $s['label'] }}</p>
                    @if (!empty($s['extra']))
                        <p class="mt-1.5 inline-flex items-center gap-1 rounded-md bg-white/20 px-2 py-0.5 text-[11px] font-semibold text-white ring-1 ring-white/25">
                            {{ $s['extra'] }}
                        </p>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    {{-- Alertes de stock --}}
    <div class="rounded-2xl bg-white border border-slate-100 shadow-sm">
        <div class="flex items-center justify-between px-6 py-5 border-b border-slate-100">
            <h2 class="font-semibold text-slate-900">Alertes de stock</h2>
            <span class="inline-flex rounded-full bg-red-50 px-2.5 py-1 text-xs font-semibold text-red-500">{{ count($stock) }} à réapprovisionner</span>
        </div>
        <div class="p-6 grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($stock as $st)
                <div class="rounded-xl border border-slate-100 p-4">
                    <div class="flex items-center justify-between">
                        <p class="font-medium text-slate-900">{{ $st['name'] }}</p>
                        <span class="text-xs font-semibold {{ $st['level'] < 20 ? 'text-red-500' : 'text-amber-500' }}">{{ $st['level'] }}%</span>
                    </div>
                    <div class="mt-3 h-2 w-full rounded-full bg-slate-100 overflow-hidden">
                        <div class="h-full rounded-full {{ $st['level'] < 20 ? 'bg-red-500' : 'bg-amber-400' }}" style="width: {{ $st['level'] }}%"></div>
                    </div>
                    <p class="mt-2 text-xs text-slate-400">{{ $st['qty'] }} restants</p>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
