@extends('layouts.app')

@section('title', "Connexion — Restaurant O'pizza")

@section('content')
<div class="min-h-screen p-3 sm:p-5 bg-gradient-to-br from-violet-100 via-[#f6f5fb] to-indigo-100 flex items-center justify-center">
    <div class="w-full max-w-5xl rounded-[28px] p-[2px] bg-gradient-to-br from-violet-400 via-indigo-400 to-fuchsia-400 shadow-2xl shadow-indigo-200/60">
        <div class="grid lg:grid-cols-2 rounded-[26px] bg-white overflow-hidden min-h-[600px]">

            {{-- Panneau visuel --}}
            <div class="relative hidden lg:block">
                <img src="https://images.unsplash.com/photo-1414235077428-338989a2e8c0?auto=format&fit=crop&w=1200&q=80"
                     alt="Restaurant" class="absolute inset-0 h-full w-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/50 to-slate-900/30"></div>
                <div class="relative h-full flex flex-col justify-between p-10 text-white">
                    <a href="{{ url('/') }}" class="flex items-center gap-3">
                        <x-logo class="h-10 w-10" />
                        <span class="font-serif text-2xl font-bold">Restaurant <span class="text-brand-400">O'pizza</span></span>
                    </a>
                    <div>
                        <h2 class="font-serif text-3xl font-bold leading-tight">Bon retour parmi nous.</h2>
                        <p class="mt-3 text-sm text-white/75 max-w-sm">Accédez à votre tableau de bord pour piloter les commandes, la salle et les stocks de votre établissement.</p>
                    </div>
                </div>
            </div>

            {{-- Formulaire --}}
            <div class="flex items-center justify-center p-8 sm:p-12">
                <div class="w-full max-w-sm">
                    <div class="lg:hidden mb-8 flex items-center gap-3">
                        <x-logo class="h-9 w-9" />
                        <span class="font-serif text-xl font-bold text-slate-900">Restaurant <span class="text-brand-600">O'pizza</span></span>
                    </div>

                    <h1 class="font-serif text-3xl font-bold text-slate-900">Se connecter</h1>
                    <p class="mt-2 text-sm text-slate-500">Saisissez vos identifiants pour intégrer votre session.</p>

                    @if ($errors->any())
                        <div class="mt-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    @if (session('status'))
                        <div class="mt-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login.attempt') }}" class="mt-7 space-y-5">
                        @csrf

                        <div>
                            <label for="email" class="block text-sm font-medium text-slate-700 mb-1.5">Adresse e-mail</label>
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"/></svg>
                                </span>
                                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                                       placeholder="vous@opizza.fr"
                                       class="w-full rounded-xl border border-slate-200 bg-slate-50 pl-11 pr-4 py-3 text-sm text-slate-900 placeholder-slate-400 focus:border-brand-400 focus:bg-white focus:ring-4 focus:ring-brand-100 outline-none transition">
                            </div>
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label for="password" class="block text-sm font-medium text-slate-700">Mot de passe</label>
                            </div>
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/></svg>
                                </span>
                                <input id="password" name="password" type="password" required
                                       placeholder="••••••••"
                                       class="w-full rounded-xl border border-slate-200 bg-slate-50 pl-11 pr-4 py-3 text-sm text-slate-900 placeholder-slate-400 focus:border-brand-400 focus:bg-white focus:ring-4 focus:ring-brand-100 outline-none transition">
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <label class="flex items-center gap-2 text-sm text-slate-600 select-none">
                                <input type="checkbox" name="remember" class="h-4 w-4 rounded border-slate-300 text-brand-600 focus:ring-brand-400">
                                Se souvenir de moi
                            </label>
                        </div>

                        <button type="submit"
                                class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-brand-500 px-5 py-3 text-sm font-semibold text-white hover:bg-brand-600 active:scale-[.99] transition shadow-lg shadow-brand-500/30">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l3 3m0 0-3 3m3-3H2.25"/></svg>
                            Intégrer ma session
                        </button>
                    </form>

                    <div class="mt-6 rounded-xl bg-indigo-50 border border-indigo-100 px-4 py-3 text-xs text-indigo-700">
                        <p class="font-semibold mb-0.5">Compte de démonstration</p>
                        <p>E-mail : <span class="font-mono">admin@opizza.fr</span> · Mot de passe : <span class="font-mono">password</span></p>
                    </div>

                    <p class="mt-6 text-center text-sm text-slate-500">
                        <a href="{{ url('/') }}" class="font-medium text-slate-700 hover:text-brand-600 transition">← Retour à l'accueil</a>
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
