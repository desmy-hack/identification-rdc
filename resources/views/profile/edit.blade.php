<x-app-layout>
    <style>
        nav { display: none !important; }
    </style>
    <div class="min-h-screen bg-[#0a0f18] py-12 relative overflow-hidden text-slate-200">
        
        <div class="absolute inset-0 z-0 pointer-events-none opacity-[0.05] select-none flex flex-wrap gap-x-24 gap-y-16 p-10 justify-around content-around">
            @for ($i = 0; $i < 60; $i++)
                <div class="text-[10px] font-black uppercase tracking-[0.4em] -rotate-45 text-blue-500">
                    RDC
                </div>
            @endfor
        </div>

        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            
            <div class="mb-10 text-center">
                <div class="inline-block px-3 py-1 rounded-full bg-blue-500/10 border border-blue-500/20 mb-4">
                    <p class="text-[9px] font-black text-blue-400 uppercase tracking-[0.3em]">Accès Sécurisé</p>
                </div>
                <h1 class="text-3xl font-black text-white uppercase tracking-tighter">
                    Sécurisation <span class="text-[#005ab7]">du Profil</span>
                </h1>
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] mt-2 italic">
                    Système National d'Identification Citoyenne
                </p>
            </div>

            <div class="space-y-6">
                @include('profile.partials.update-password-form')
            </div>

            <div class="mt-10 text-center">
                <a href="{{ route('dashboard') }}" 
                   class="group inline-flex items-center gap-2 text-[10px] font-black text-slate-500 hover:text-white uppercase tracking-widest transition-all">
                    <span class="material-symbols-outlined text-sm transition-transform group-hover:-translate-x-1">arrow_back</span>
                    Retour au terminal
                </a>
            </div>
        </div>
    </div>
</x-app-layout>