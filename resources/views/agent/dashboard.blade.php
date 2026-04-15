<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S.N.I.C. - Espace Agent Autorisé</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20,400,0,0" />
    
    <style>
        /* Même fond et filigrane que le citoyen pour la cohérence */
        .bg-rdc-official { background-color: #f8fafc; position: relative; min-height: 100vh; width: 100%; }
        .bg-rdc-official::before {
            content: ""; position: fixed; inset: 0; pointer-events: none; z-index: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='120' height='120' viewBox='0 0 120 120' xmlns='http://www.w3.org/2000/svg'%3E%3Ctext x='50%25' y='50%25' font-size='14' font-weight='900' fill='rgba(0, 90, 183, 0.04)' text-anchor='middle' transform='rotate(-35, 60, 60)' font-family='sans-serif'%3EAGENT%3C/text%3E%3C/svg%3E");
            background-repeat: repeat;
        }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 20; display: inline-block; vertical-align: middle; }
    </style>
</head>
<body class="antialiased font-sans">

    <div class="bg-rdc-official">
        
        <nav class="fixed top-0 left-0 right-0 z-50 bg-white/90 backdrop-blur-xl border-b border-slate-100 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('photos/drc_logo.png') }}" alt="Logo RDC" class="h-12 w-auto">
                    <div>
                        <h1 class="text-sm font-black text-[#005ab7] uppercase tracking-tighter leading-none">République Démocratique du Congo</h1>
                        <p class="text-[8px] font-bold text-blue-500 uppercase tracking-widest mt-1 italic">Agent : {{ Auth::user()->name }} (Session Active)</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-2 px-4 py-2 text-red-500 font-bold text-[10px] hover:bg-red-50 rounded-xl transition-all uppercase tracking-widest">
                        <span class="material-symbols-outlined text-sm">logout</span> Déconnexion
                    </button>
                </form>
            </div>
        </nav>

        <div class="relative z-10 pt-24">
            <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
                
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                    
                    <div class="lg:col-span-8 space-y-8">
                        
                        <div class="relative bg-gradient-to-br from-slate-900 to-[#003d7a] rounded-[2.5rem] p-10 text-white shadow-2xl overflow-hidden border-4 border-white/10">
                            <div class="relative z-10">
                                <h2 class="text-3xl font-black tracking-tighter uppercase mb-2">Gestion des Enrôlements</h2>
                                <p class="text-xs font-bold text-blue-300 uppercase tracking-[0.2em] mb-8">Bureau Central de Kinshasa - Station 04</p>
                                
                                <div class="flex flex-wrap gap-4">
                                    <a href="{{ route('agent.create') }}" class="flex items-center gap-3 px-8 py-4 bg-[#005ab7] text-white rounded-2xl font-black text-[10px] tracking-widest uppercase hover:bg-white hover:text-[#005ab7] transition-all shadow-xl">
                                        <span class="material-symbols-outlined">person_add</span> Nouvel Enrôlement
                                    </a>
                                    <div class="flex items-center gap-3 px-8 py-4 bg-white/10 rounded-2xl font-black text-[10px] tracking-widest uppercase border border-white/20">
                                        <span class="material-symbols-outlined text-green-400">task_alt</span> 12 Traités aujourd'hui
                                    </div>
                                </div>
                            </div>
                            <span class="material-symbols-outlined absolute -right-8 -bottom-8 text-[200px] text-white/5">badge</span>
                        </div>

                        <div class="bg-white rounded-[2.5rem] shadow-xl border border-slate-50 overflow-hidden">
                            <div class="p-8 border-b border-slate-50 flex justify-between items-center">
                                <h3 class="text-sm font-black uppercase tracking-tighter text-slate-800">Files d'attente de validation</h3>
                                <button class="text-[9px] font-black text-blue-600 uppercase tracking-widest">Voir tout</button>
                            </div>
                            
                            <div class="overflow-x-auto">
                                <table class="w-full text-left border-collapse">
                                    <thead>
                                        <tr class="text-[9px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">
                                            <th class="px-8 py-4">Candidat</th>
                                            <th class="px-8 py-4">Provenance</th>
                                            <th class="px-8 py-4">Statut</th>
                                            <th class="px-8 py-4 text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-50">
                                        @forelse($citizens as $citizen)
                                        <tr class="hover:bg-slate-50/80 transition-all group">
                                            <td class="px-8 py-5 flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-xl overflow-hidden shadow-sm border border-slate-100">
                                                    @if($citizen->photo)
                                                        <img src="{{ asset('storage/' . $citizen->photo) }}" class="w-full h-full object-cover">
                                                    @else
                                                        <div class="w-full h-full bg-blue-50 flex items-center justify-center font-black text-[#005ab7] text-xs">
                                                            {{ strtoupper(substr($citizen->first_name, 0, 1)) }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <p class="text-[11px] font-black uppercase text-slate-800">{{ $citizen->first_name }} {{ $citizen->last_name }}</p>
                                                    <p class="text-[9px] font-bold text-blue-500 font-mono tracking-tighter">{{ $citizen->national_id }}</p>
                                                </div>
                                            </td>
                                            <td class="px-8 py-5 text-[10px] font-bold text-slate-500 uppercase">{{ $citizen->province }}</td>
                                            <td class="px-8 py-5">
                                                <span class="px-3 py-1 bg-green-50 text-green-600 rounded-full text-[8px] font-black uppercase tracking-widest border border-green-100">
                                                    Validé
                                                </span>
                                            </td>
                                            <td class="px-8 py-5 text-right">
                                                <a href="{{ route('citizen.card', $citizen->id) }}" class="p-2 hover:bg-[#005ab7] hover:text-white text-slate-300 rounded-lg transition-all inline-block">
                                                    <span class="material-symbols-outlined text-lg">visibility</span>
                                                </a>
                                            </td>
                                        </tr>
                                        @empty
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-4 space-y-6">
                        <div class="sticky top-24 space-y-6">
                            
                            <div class="bg-white rounded-[2.5rem] p-8 shadow-xl border border-slate-50">
                                <div class="flex items-center gap-4 mb-8">
                                    <div class="p-3 bg-blue-50 text-[#005ab7] rounded-2xl">
                                        <span class="material-symbols-outlined">analytics</span>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-black uppercase text-slate-800 tracking-tighter">Performances</h4>
                                        <p class="text-[9px] font-bold text-slate-400 uppercase">Mois de Avril 2026</p>
                                    </div>
                                </div>
                                
                                <div class="space-y-4">
                                    <div class="p-4 bg-slate-50 rounded-2xl flex justify-between items-center border border-slate-100">
                                        <div>
                                            <p class="text-[8px] font-black uppercase text-slate-400">Total National (SNIC)</p>
                                            <p class="text-xl font-black text-slate-800 tracking-tighter">{{ number_format($totalEnrolled) }}</p>
                                        </div>
                                        <span class="material-symbols-outlined text-blue-200 text-3xl">public</span>
                                    </div>
                                    <div class="p-4 bg-blue-50/50 rounded-2xl flex justify-between items-center border border-blue-100">
                                        <div>
                                            <p class="text-[8px] font-black uppercase text-[#005ab7]">Mes Enrôlements</p>
                                            <p class="text-xl font-black text-[#005ab7] tracking-tighter">{{ number_format($myEnrollements) }}</p>
                                        </div>
                                        <span class="material-symbols-outlined text-blue-300 text-3xl">person_pin</span>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-white rounded-[2.5rem] p-8 shadow-xl border border-slate-50">
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-6">Accès Rapide</p>
                                <div class="grid grid-cols-2 gap-3">
                                    <button class="p-4 bg-slate-50 rounded-2xl hover:bg-blue-50 transition-all text-center group">
                                        <span class="material-symbols-outlined text-slate-400 group-hover:text-blue-500 mb-2">print</span>
                                        <p class="text-[8px] font-black uppercase text-slate-600">Impression</p>
                                    </button>
                                    <button class="p-4 bg-slate-50 rounded-2xl hover:bg-blue-50 transition-all text-center group">
                                        <span class="material-symbols-outlined text-slate-400 group-hover:text-blue-500 mb-2">search</span>
                                        <p class="text-[8px] font-black uppercase text-slate-600">Recherche</p>
                                    </button>
                                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-4 py-2 bg-blue-600/10 text-blue-500 font-bold text-[10px] rounded-xl hover:bg-blue-600 hover:text-white transition-all uppercase">
                                        <span class="material-symbols-outlined text-sm">badge</span> Voir Ma Carte (Citoyen)
                                    </a>
                                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-6 py-3 bg-[#0a0f18] hover:bg-[#005ab7] border border-white/5 rounded-2xl text-white transition-all group shadow-lg shadow-black/20">
                                        <div class="p-2 bg-white/5 rounded-lg group-hover:bg-white/20 transition-colors">
                                            <span class="material-symbols-outlined text-sm">shield_lock</span>
                                        </div>
                                        <div class="text-left">
                                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-500 group-hover:text-blue-200">Sécurité</p>
                                            <p class="text-xs font-bold">Modifier ma clé</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>                               
                    </div>

                </div>

                @if(session('success'))
                <div class="mb-6 p-5 bg-slate-900 rounded-[2rem] border-l-8 border-blue-500 shadow-2xl">
                    <div class="flex items-center gap-4">
                        <div class="bg-blue-500 p-2 rounded-full">
                            <span class="material-symbols-outlined text-white text-sm">check</span>
                        </div>
                        <div class="flex-1">
                            <p class="text-[10px] font-black uppercase tracking-widest text-blue-400">Confirmation d'Enrôlement</p>
                            <p class="text-white font-bold text-sm">{{ session('success') }}</p>
                        </div>
                        <button onclick="navigator.clipboard.writeText('{{ explode(': ', session('success'))[2] ?? '' }}')" 
                                class="px-4 py-2 bg-white/10 hover:bg-white/20 text-white rounded-xl text-[8px] font-black uppercase transition-all">
                            Copier Password
                        </button>
                    </div>
                </div>
                @endif
            </main>
        </div>
    </div>
</body>
</html>