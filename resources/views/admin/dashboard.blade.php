<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration Centrale | SNIC RDC</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20,400,0,0" />
    
    <style>
        .bg-rdc-admin { background-color: #f1f5f9; position: relative; min-height: 100vh; width: 100%; }
        .bg-rdc-admin::before {
            content: ""; position: fixed; inset: 0; pointer-events: none; z-index: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='120' height='120' viewBox='0 0 120 120' xmlns='http://www.w3.org/2000/svg'%3E%3Ctext x='50%25' y='50%25' font-size='10' font-weight='900' fill='rgba(15, 23, 42, 0.03)' text-anchor='middle' transform='rotate(-35, 60, 60)' font-family='sans-serif'%3EADMIN-SNIC%3C/text%3E%3C/svg%3E");
            background-repeat: repeat;
        }
    </style>

    <script>
        function openModal() { 
            document.getElementById('agentModal').classList.remove('hidden'); 
        }

        function closeModal() { 
            document.getElementById('agentModal').classList.add('hidden'); 
            document.getElementById('resultZone').classList.add('hidden'); 
            document.getElementById('searchNN').value = ''; 
        }

        async function findCitizen() {
            const nn = document.getElementById('searchNN').value;
            
            if (!nn) {
                alert("Veuillez entrer un Numéro National.");
                return;
            }

            try {
                const response = await fetch(`/admin/search-citizen/${nn}`);
                const data = await response.json();

                if(data.success) {
                    document.getElementById('resultZone').classList.remove('hidden');
                    document.getElementById('citizenName').innerText = data.name;
                    document.getElementById('citizenInfo').innerText = data.info;
                    document.getElementById('hiddenNN').value = nn;
                } else {
                    alert("Aucun citoyen trouvé avec ce Numéro National.");
                    document.getElementById('resultZone').classList.add('hidden');
                }
            } catch (error) {
                console.error("Erreur lors de la recherche:", error);
                alert("Erreur de connexion au serveur.");
            }
        }
    </script>
</head>
<body class="antialiased font-sans">

    <div class="bg-rdc-admin">
        <nav class="fixed top-0 left-0 right-0 z-50 bg-slate-900/95 backdrop-blur-xl border-b border-white/5 shadow-2xl">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('photos/drc_logo.png') }}" alt="Logo RDC" class="h-10 w-auto">
                    <div>
                        <h1 class="text-sm font-black text-white uppercase tracking-tighter leading-none">Administration S.N.I.C.</h1>
                        <p class="text-[8px] font-bold text-red-500 uppercase tracking-widest mt-1 italic">Superviseur : {{ Auth::user()->name }} (Accès Total)</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-2 px-4 py-2 bg-red-600/10 text-red-500 font-bold text-[10px] hover:bg-red-600 hover:text-white rounded-xl transition-all uppercase tracking-widest">
                        <span class="material-symbols-outlined text-sm">power_settings_new</span> Déconnexion
                    </button>
                </form>
            </div>
        </nav>

        <div class="relative z-10 pt-24">
            <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
                    <div class="bg-white p-7 rounded-[2.5rem] shadow-sm border border-slate-100">
                        <p class="text-[9px] font-black text-slate-400 uppercase mb-2">Population Enrôlée</p>
                        <h3 class="text-3xl font-black text-slate-900 italic tracking-tighter">{{ $totalCitizens }}</h3>
                        <div class="mt-4 flex items-center gap-2 text-green-600 text-[9px] font-black">
                            <span class="material-symbols-outlined text-sm">trending_up</span> BASE DE DONNÉES SQLITE
                        </div>
                    </div>
                    <div class="bg-white p-7 rounded-[2.5rem] shadow-sm border border-slate-100">
                        <p class="text-[9px] font-black text-slate-400 uppercase mb-2">Agents Actifs</p>
                        <h3 class="text-3xl font-black text-slate-900 tracking-tighter">{{ $totalAgents }}</h3>
                        <p class="mt-4 text-[9px] font-black text-blue-500 uppercase">Personnel autorisé</p>
                    </div>
                    <div class="bg-white p-7 rounded-[2.5rem] shadow-sm border border-slate-100">
                        <p class="text-[9px] font-black text-slate-400 uppercase mb-2">Sécurité Système</p>
                        <h3 class="text-3xl font-black text-emerald-600 tracking-tighter italic uppercase">Stable</h3>
                        <p class="mt-4 text-[9px] font-black text-slate-400 uppercase">Uptime : 99.9%</p>
                    </div>
                    <div class="bg-white p-7 rounded-[2.5rem] shadow-sm border border-slate-100">
                        <p class="text-[9px] font-black text-slate-400 uppercase mb-2">Alertes Intrusion</p>
                        <h3 class="text-3xl font-black text-red-500">0</h3>
                        <p class="mt-4 text-[9px] font-black text-red-400 uppercase italic">Aucune menace</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                    
                    <div class="lg:col-span-8">
                        <div class="bg-white rounded-[2.5rem] shadow-xl border border-slate-50 overflow-hidden">
                            <div class="p-8 border-b border-slate-50 flex justify-between items-center bg-slate-50/30">
                                <div>
                                    <h3 class="text-sm font-black uppercase tracking-tighter text-slate-800">Personnel d'Enrôlement</h3>
                                    <p class="text-[9px] font-bold text-slate-400 uppercase">Gestion des comptes agents de terrain</p>
                                </div>
                                <button onclick="openModal()" class="px-6 py-3 bg-slate-900 text-white text-[9px] font-black uppercase tracking-widest rounded-2xl hover:bg-[#005ab7] transition-all">
                                    Ajouter un Agent
                                </button>
                            </div>
                            
                            <div class="overflow-x-auto">
                                <table class="w-full text-left">
                                    <thead>
                                        <tr class="text-[9px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-50">
                                            <th class="px-8 py-4">Agent / Identité</th>
                                            <th class="px-8 py-4">Dernière activité</th>
                                            <th class="px-8 py-4">Statut</th>
                                            <th class="px-8 py-4 text-right">Contrôle</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-50">
                                        @forelse($agents as $agent)
                                        <tr class="hover:bg-slate-50/80 transition-all group">
                                            <td class="px-8 py-5">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-10 h-10 bg-slate-100 rounded-2xl flex items-center justify-center font-black text-slate-400 group-hover:bg-blue-600 group-hover:text-white transition-all uppercase">
                                                        {{ substr($agent->name, 0, 2) }}
                                                    </div>
                                                    <div>
                                                        <p class="text-[11px] font-black uppercase text-slate-800">{{ $agent->name }}</p>
                                                        <p class="text-[9px] font-bold text-slate-400 italic">{{ $agent->email }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-8 py-5 text-[10px] font-bold text-slate-500 uppercase italic">
                                                {{ $agent->updated_at->diffForHumans() }}
                                            </td>
                                            <td class="px-8 py-5">
                                                <span class="px-3 py-1 bg-green-50 text-green-600 rounded-full text-[8px] font-black uppercase">Actif</span>
                                            </td>
                                            <td class="px-8 py-5 text-right">
                                                <div class="flex justify-end gap-2">
                                                    <button class="p-2 bg-slate-50 text-slate-400 rounded-xl hover:bg-blue-50 hover:text-blue-600 transition-all"><span class="material-symbols-outlined text-sm">edit_square</span></button>
                                                    <button class="p-2 bg-slate-50 text-slate-400 rounded-xl hover:bg-red-50 hover:text-red-600 transition-all"><span class="material-symbols-outlined text-sm">lock</span></button>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="px-8 py-10 text-center text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                                Aucun agent enregistré dans le système
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-4 space-y-6">
                        <div class="bg-slate-900 rounded-[2.5rem] p-8 text-white shadow-2xl border-4 border-white/5 h-full">
                            <div class="flex items-center gap-4 mb-8 pb-4 border-b border-white/10">
                                <span class="material-symbols-outlined text-blue-400">shield_lock</span>
                                <h4 class="text-xs font-black uppercase tracking-widest leading-none">Journal Système <br><span class="text-[8px] text-blue-500 opacity-80 italic tracking-normal">Real-time Terminal</span></h4>
                            </div>
                            
                            <div class="space-y-6 font-mono text-[9px] opacity-80">
                                <div class="flex gap-3">
                                    <span class="text-blue-400 font-bold">[AUTO]</span>
                                    <p>Synchronisation avec la base SQLite effectuée</p>
                                </div>
                                <div class="flex gap-3">
                                    <span class="text-green-400 font-bold">[DATA]</span>
                                    <p>{{ $totalCitizens }} citoyens indexés avec succès</p>
                                </div>
                                <div class="flex gap-3">
                                    <span class="text-emerald-400 font-bold">[AUTH]</span>
                                    <p>Admin {{ Auth::user()->name }} connecté</p>
                                </div>
                                <div class="flex gap-3">
                                    <span class="text-amber-400 font-bold">[WARN]</span>
                                    <p>Surveillance des stations en cours...</p>
                                </div>
                            </div>

                            <div class="mt-12 p-6 bg-white/5 rounded-3xl border border-white/10">
                                <div class="flex justify-between items-end mb-3">
                                    <p class="text-[8px] font-black text-blue-400 uppercase tracking-widest">Charge CPU </p>
                                    <p class="text-[10px] font-bold text-white italic">14%</p>
                                </div>
                                <div class="w-full bg-white/10 h-2 rounded-full overflow-hidden">
                                    <div class="bg-blue-500 h-full w-[14%]"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div id="agentModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/60 backdrop-blur-sm">
                    <div class="bg-white w-full max-w-md rounded-[2.5rem] p-10 shadow-2xl border border-slate-100">
                        <h3 class="text-sm font-black uppercase text-slate-800 mb-6 flex items-center gap-2">
                            <span class="material-symbols-outlined text-blue-500">person_search</span>
                            Promouvoir un Citoyen
                        </h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="text-[9px] font-black text-slate-400 uppercase ml-2">Numéro National (NN)</label>
                                <input type="text" id="searchNN" placeholder="Ex: 38994366277" 
                                    class="w-full mt-1 px-6 py-4 bg-slate-50 border-none rounded-2xl text-xs font-bold focus:ring-2 focus:ring-blue-500 transition-all">
                            </div>
                            
                            <button onclick="findCitizen()" class="w-full py-4 bg-slate-900 text-white rounded-2xl text-[9px] font-black uppercase tracking-widest hover:bg-blue-600 transition-all">
                                Vérifier l'Identité
                            </button>
                            
                            <div id="resultZone" class="hidden p-5 bg-blue-50 rounded-2xl border border-blue-100 mt-6">
                                <p id="citizenName" class="text-xs font-black text-slate-800 uppercase"></p>
                                <p id="citizenInfo" class="text-[9px] text-blue-500 font-bold italic"></p>
                                
                                <form action="{{ route('admin.promote') }}" method="POST" class="mt-4">
                                    @csrf
                                    <input type="hidden" name="nn" id="hiddenNN">
                                    <button type="submit" class="w-full py-3 bg-green-600 text-white rounded-xl text-[8px] font-black uppercase tracking-widest">
                                        Confirmer comme Agent
                                    </button>
                                </form>
                            </div>
                        </div>

                        <button onclick="closeModal()" class="mt-4 w-full text-[8px] font-black text-slate-400 uppercase tracking-widest hover:text-red-500 transition-colors">Annuler</button>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>