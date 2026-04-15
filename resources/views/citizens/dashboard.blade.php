<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Citoyen | SNIC RDC</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20,400,0,0" />
    
    <style>
        .bg-rdc-official { background-color: #f8fafc; position: relative; min-height: 100vh; width: 100%; }
        .bg-rdc-official::before {
            content: ""; position: fixed; inset: 0; pointer-events: none; z-index: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='120' height='120' viewBox='0 0 120 120' xmlns='http://www.w3.org/2000/svg'%3E%3Ctext x='50%25' y='50%25' font-size='14' font-weight='900' fill='rgba(0, 90, 183, 0.04)' text-anchor='middle' transform='rotate(-35, 60, 60)' font-family='sans-serif'%3ERDC%3C/text%3E%3C/svg%3E");
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
                        <p class="text-[8px] font-bold text-slate-400 uppercase tracking-widest mt-1">Identité Numérique ({{ Auth::user()->citizenProfile?->national_id }})</p>
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

        @if (session('success_password'))
            <div x-data="{ show: true }" 
                x-show="show" 
                x-init="setTimeout(() => show = false, 5000)"
                x-transition:enter="transition ease-out duration-500"
                x-transition:enter-start="opacity-0 -translate-y-4"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-500"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                
                <div class="bg-[#005ab7]/10 border border-[#005ab7]/20 rounded-2xl p-4 backdrop-blur-md flex items-center gap-4">
                    <div class="bg-[#005ab7] p-2 rounded-xl shadow-lg shadow-blue-500/20">
                        <span class="material-symbols-outlined text-white text-sm">verified_user</span>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-blue-400 uppercase tracking-widest">Système mis à jour</p>
                        <p class="text-xs text-slate-400 font-medium">{{ session('success_password') }}</p>
                    </div>
                    <button @click="show = false" class="ml-auto text-slate-600 hover:text-white transition-colors">
                        <span class="material-symbols-outlined text-sm">close</span>
                    </button>
                </div>
            </div>
        @endif

        <div class="relative z-10 pt-24">
            
            <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
                
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                    
                    <div class="lg:col-span-8 space-y-8">
                        
                        <div class="relative bg-gradient-to-br from-[#005ab7] to-[#003d7a] aspect-[1.586/1] w-full rounded-[2.5rem] p-7 text-white shadow-2xl overflow-hidden border-4 border-white/10">
                            <img class="absolute inset-0 opacity-10 w-full h-full object-contain scale-125" src="{{ asset('photos/logo-rdc.png') }}"/>
                            
                            <div class="relative z-10 h-full flex flex-col justify-between">
                                <div class="flex justify-between items-start border-b border-white/20 pb-3">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('photos/drc_logo.png') }}" class="h-9 w-auto">
                                        <h3 class="text-base font-black tracking-tighter uppercase italic">Carte d'Identité Nationale</h3>
                                    </div>
                                    <p class="text-[7px] font-bold opacity-70 text-right uppercase leading-tight">RÉPUBLIQUE DÉMOCRATIQUE DU CONGO<br>OFFICE NATIONAL D'IDENTIFICATION (ONIP)</p>
                                </div>

                                <div class="flex gap-6 mt-4">
                                    <div class="w-32 h-40 bg-white/10 rounded-2xl border border-white/30 overflow-hidden shadow-inner backdrop-blur-md">
                                        @if(Auth::user()->citizenProfile?->photo)
                                            <img src="{{ asset('storage/' . Auth::user()->citizenProfile->photo) }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="flex items-center justify-center h-full"><span class="material-symbols-outlined text-5xl opacity-20">person</span></div>
                                        @endif
                                    </div>

                                    <div class="flex-1 grid grid-cols-2 gap-y-2">
                                        <div class="col-span-2">
                                            <p class="text-[7px] uppercase opacity-60 font-black">Nom & Postnom</p>
                                            <p class="text-lg font-black uppercase text-yellow-400 leading-none">{{ Auth::user()->citizenProfile?->last_name }} {{ Auth::user()->citizenProfile?->middle_name }}</p>
                                        </div>
                                        <div>
                                            <p class="text-[7px] uppercase opacity-60 font-black">Prénom</p>
                                            <p class="text-sm font-bold uppercase">{{ Auth::user()->citizenProfile?->first_name }}</p>
                                        </div>
                                        <div>
                                            <p class="text-[7px] uppercase opacity-60 font-black">Né le / à</p>
                                            <p class="text-[10px] font-bold uppercase">{{ Auth::user()->citizenProfile?->birth_date }} - {{ Auth::user()->citizenProfile?->birth_place }}</p>
                                        </div>

                                        <div class="col-span-2 grid grid-cols-2 gap-2 py-1 border-y border-white/10 mt-1">
                                            <div>
                                                <p class="text-[6px] uppercase opacity-60 font-black italic">Filiation Paternelle</p>
                                                <p class="text-[9px] font-bold uppercase text-blue-100">{{ Auth::user()->citizenProfile?->father_name }}</p>
                                            </div>
                                            <div>
                                                <p class="text-[6px] uppercase opacity-60 font-black italic">Filiation Maternelle</p>
                                                <p class="text-[9px] font-bold uppercase text-blue-100">{{ Auth::user()->citizenProfile?->mother_name }}</p>
                                            </div>
                                        </div>

                                        <div class="col-span-2">
                                            <div class="grid grid-cols-3 gap-2">
                                                <div><p class="text-[6px] uppercase opacity-60 font-black">Province</p><p class="font-bold text-[9px] uppercase text-blue-200">{{ Auth::user()->citizenProfile?->province }}</p></div>
                                                <div><p class="text-[6px] uppercase opacity-60 font-black">Territoire</p><p class="font-bold text-[9px] uppercase text-blue-200">{{ Auth::user()->citizenProfile?->territory }}</p></div>
                                                <div><p class="text-[6px] uppercase opacity-60 font-black">Secteur</p><p class="font-bold text-[9px] uppercase text-blue-200">{{ Auth::user()->citizenProfile?->sector }}</p></div>
                                            </div>
                                            <p class="text-[6px] uppercase opacity-60 font-black mt-1">Adresse Résidentielle</p>
                                            <p class="font-bold text-[8px] uppercase italic opacity-90 leading-tight">{{ Auth::user()->citizenProfile?->address }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex justify-between items-end border-t border-white/20 pt-3">
                                    <div>
                                        <p class="text-[7px] uppercase opacity-60 font-black tracking-widest mb-0.5">Numéro National (NN)</p>
                                        <p class="text-2xl font-black tracking-[0.1em] text-white">{{ Auth::user()->citizenProfile?->national_id }}</p>
                                    </div>
                                    <div class="bg-white p-1.5 rounded-lg shadow-xl">
                                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=RDC-SNIC:{{ Auth::user()->citizenProfile?->national_id }}|NAME:{{ Auth::user()->citizenProfile?->last_name }}" class="w-12 h-12">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm flex items-center gap-4">
                                <div class="p-3 bg-red-50 text-red-600 rounded-2xl"><span class="material-symbols-outlined">medical_services</span></div>
                                <div><p class="text-[9px] font-black text-slate-400 uppercase">Carnet de Santé</p><p class="text-xs font-black text-slate-800">{{ Auth::user()->citizenProfile?->health_record_number ?? 'NON ENREGISTRÉ' }}</p></div>
                            </div>
                            <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm flex items-center gap-4">
                                <div class="p-3 bg-slate-100 text-slate-600 rounded-2xl"><span class="material-symbols-outlined">gavel</span></div>
                                <div><p class="text-[9px] font-black text-slate-400 uppercase">Casier Judiciaire</p><p class="text-xs font-black text-green-600">{{ Auth::user()->citizenProfile?->criminal_record_number ?? 'VIERGE' }}</p></div>
                            </div>
                            <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm flex items-center gap-4">
                                <div class="p-3 bg-blue-50 text-blue-600 rounded-2xl"><span class="material-symbols-outlined">shield_person</span></div>
                                <div><p class="text-[9px] font-black text-slate-400 uppercase">Sécurité Sociale (CNSS)</p><p class="text-xs font-black text-slate-800">{{ Auth::user()->citizenProfile?->social_security_number ?? 'EN ATTENTE' }}</p></div>
                            </div>
                            <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm flex items-center gap-4">
                                <div class="p-3 bg-emerald-50 text-emerald-600 rounded-2xl"><span class="material-symbols-outlined">payments</span></div>
                                <div><p class="text-[9px] font-black text-slate-400 uppercase">Identifiant Fiscal (NIF)</p><p class="text-xs font-black text-slate-800">{{ Auth::user()->citizenProfile?->tax_id_number ?? 'NON ASSUJETTI' }}</p></div>
                            </div>
                            <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm flex items-center gap-4">
                                <div class="p-3 bg-purple-50 text-purple-600 rounded-2xl"><span class="material-symbols-outlined">school</span></div>
                                <div><p class="text-[9px] font-black text-slate-400 uppercase">Carte d'Étudiant</p><p class="text-xs font-black text-slate-800">{{ Auth::user()->citizenProfile?->student_card_number ?? 'N/A' }}</p></div>
                            </div>
                            <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm flex items-center gap-4">
                                <div class="p-3 bg-amber-50 text-amber-600 rounded-2xl"><span class="material-symbols-outlined">passport</span></div>
                                <div><p class="text-[9px] font-black text-slate-400 uppercase">Passeport Biométrique</p><p class="text-xs font-black text-slate-800">{{ Auth::user()->citizenProfile?->passport_number ?? 'NON ÉMIS' }}</p></div>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-4 space-y-6">
                        <div class="sticky top-24 space-y-6">
                            <div class="bg-white rounded-[2.5rem] p-8 shadow-xl border border-slate-50">
                                <div class="text-center mb-8">
                                    <span class="material-symbols-outlined text-4xl text-blue-500 mb-2">contact_mail</span>
                                    <h4 class="text-sm font-black uppercase text-slate-800 tracking-tighter">Coordonnées de secours</h4>
                                </div>
                                
                                <div class="space-y-4">
                                    <div class="p-4 bg-slate-50 rounded-2xl flex items-center gap-3">
                                        <span class="material-symbols-outlined text-slate-400">email</span>
                                        <div><p class="text-[8px] font-black uppercase text-slate-400">Email OTP</p><p class="text-[10px] font-bold text-slate-700">{{ Auth::user()->citizenProfile?->email }}</p></div>
                                    </div>
                                    <div class="p-4 bg-slate-50 rounded-2xl flex items-center gap-3">
                                        <span class="material-symbols-outlined text-slate-400">call</span>
                                        <div><p class="text-[8px] font-black uppercase text-slate-400">Téléphone</p><p class="text-[10px] font-bold text-slate-700">{{ Auth::user()->citizenProfile?->phone ?? 'NON RENSEIGNÉ' }}</p></div>
                                    </div>
                                </div>

                                <div class="mt-8 pt-6 border-t border-slate-100 flex items-center gap-4 text-green-700 p-4 bg-green-50 rounded-3xl">
                                    <span class="material-symbols-outlined">check_circle</span>
                                    <div><p class="text-[8px] uppercase font-black opacity-60">Statut</p><p class="font-black text-xs">Identité Certifiée</p></div>
                                </div>
                            </div>

                            <div class="bg-white rounded-[2.5rem] p-8 shadow-xl border border-slate-50 sticky top-28">
                                <div class="flex items-center gap-4 mb-6">
                                    <div class="p-3 bg-amber-50 text-amber-600 rounded-2xl">
                                        <span class="material-symbols-outlined">edit_note</span>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-black uppercase text-slate-800 tracking-tighter leading-none">Rectification</h4>
                                        <p class="text-[9px] font-bold text-slate-400 uppercase mt-1">Mise à jour des données</p>
                                    </div>
                                </div>

                                <p class="text-[11px] text-slate-500 leading-relaxed mb-6 font-medium">
                                    Une erreur sur votre filiation ou votre adresse ? Soumettez une demande officielle accompagnée d'une pièce justificative.
                                </p>

                                <div class="space-y-3 mb-8">
                                    <div class="flex justify-between items-center p-3 bg-slate-50 rounded-xl border border-dashed border-slate-200">
                                        <div class="flex items-center gap-2">
                                            <span class="material-symbols-outlined text-amber-500 text-sm">history</span>
                                            <span class="text-[10px] font-bold text-slate-600">Changement d'adresse</span>
                                        </div>
                                        <span class="px-2 py-0.5 bg-amber-100 text-amber-700 text-[8px] font-black rounded-full uppercase">En cours</span>
                                    </div>
                                </div>

                                <button onclick="window.location.href='/rectification/create'" 
                                        class="w-full group flex items-center justify-center gap-3 py-5 bg-[#005ab7] text-white font-black rounded-2xl hover:bg-slate-900 transition-all uppercase text-[10px] tracking-widest shadow-xl shadow-blue-200">
                                    <span class="material-symbols-outlined text-sm group-hover:rotate-12 transition-transform">add_circle</span>
                                    Nouvelle Requête
                                </button>
                                
                                <p class="text-center text-[8px] text-slate-400 font-bold mt-4 uppercase tracking-tighter">
                                    Délai de traitement : 48h à 72h ouvrables
                                </p>
                            </div>
                        </div>                               
                    </div>

                </div>
            </main>
        </div>
    </div>
</body>
</html>