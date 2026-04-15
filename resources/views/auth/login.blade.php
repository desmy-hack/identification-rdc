<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Sécurisée | SNIC RDC</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20,400,0,0" />
    
    <style>
        .bg-rdc-portal { 
            background: radial-gradient(circle at top right, #005ab7, #002d5b);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        .bg-rdc-portal::before {
            content: ""; position: absolute; inset: 0; pointer-events: none; opacity: 0.05;
            background-image: url("data:image/svg+xml,%3Csvg width='120' height='120' viewBox='0 0 120 120' xmlns='http://www.w3.org/2000/svg'%3E%3Ctext x='50%25' y='50%25' font-size='14' font-weight='900' fill='white' text-anchor='middle' transform='rotate(-35, 60, 60)' font-family='sans-serif'%3ERDC%3C/text%3E%3C/svg%3E");
            background-repeat: repeat;
        }
    </style>
</head>
<body class="antialiased font-sans">

    <div class="bg-rdc-portal p-6">
        
        <div class="absolute top-12 flex flex-col items-center">
            <img src="{{ asset('photos/drc_logo.png') }}" class="h-20 w-auto mb-4 drop-shadow-2xl">
            <h1 class="text-white text-xs font-black uppercase tracking-[0.3em] text-center">
                République Démocratique du Congo<br>
                <span class="text-blue-300 opacity-60 text-[9px]">Système National d'Identification des Citoyens</span>
            </h1>
        </div>

        <div class="relative w-full max-w-[450px] bg-white rounded-[2.5rem] shadow-[0_35px_60px_-15px_rgba(0,0,0,0.3)] p-10 border border-white/20">
            
            <div class="text-center mb-8">
                <div class="inline-flex p-4 bg-blue-50 rounded-3xl text-[#005ab7] mb-4 shadow-inner">
                    <span class="material-symbols-outlined text-3xl">fingerprint</span>
                </div>
                <h2 class="text-2xl font-black text-slate-800 uppercase tracking-tighter">Portail d'Accès</h2>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1 italic">Saisissez vos accès officiels</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 rounded-2xl border border-red-100 flex items-center gap-3">
                    <span class="material-symbols-outlined text-red-500 text-sm">warning</span>
                    <p class="text-[10px] font-black text-red-600 uppercase tracking-tight">Identifiants incorrects ou accès refusé.</p>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf
                
                <div class="space-y-2">
                    <label class="text-[9px] font-black uppercase text-slate-400 ml-4 tracking-widest">Identifiant National ou Email</label>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-[#005ab7] transition-all">person</span>
                        <input type="text" name="email" value="{{ old('email') }}" required autofocus
                               class="w-full pl-14 pr-6 py-5 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-[#005ab7] font-bold text-slate-700 text-sm transition-all shadow-inner"
                               placeholder="Ex: 35519751483">
                    </div>
                </div>

                <div class="space-y-2">
                    <div class="flex justify-between items-center px-4">
                        <label class="text-[9px] font-black uppercase text-slate-400 tracking-widest">Mot de passe</label>
                        <a href="{{ route('password.request') }}" class="text-[8px] font-black text-[#005ab7] uppercase hover:underline">Oublié ?</a>
                    </div>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-5 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-[#005ab7] transition-all">lock</span>
                        <input type="password" name="password" required 
                               class="w-full pl-14 pr-6 py-5 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-[#005ab7] font-bold text-slate-700 text-sm transition-all shadow-inner"
                               placeholder="••••••••••••">
                    </div>
                </div>

                <div class="space-y-2 py-2">
                    <label class="text-[9px] font-black uppercase text-slate-400 ml-4 tracking-widest">Type de session</label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="cursor-pointer group">
                            <input type="radio" name="role_hint" value="citizen" class="hidden peer" checked>
                            <div class="flex items-center justify-center gap-3 p-4 rounded-2xl bg-slate-50 border-2 border-transparent peer-checked:border-[#005ab7] peer-checked:bg-blue-50 transition-all">
                                <span class="material-symbols-outlined text-lg text-slate-400 peer-checked:text-[#005ab7]">person</span>
                                <p class="text-[9px] font-black uppercase text-slate-500 peer-checked:text-[#005ab7]">Citoyen</p>
                            </div>
                        </label>
                        
                        <label class="cursor-pointer group">
                            <input type="radio" name="role_hint" value="agent" class="hidden peer">
                            <div class="flex items-center justify-center gap-3 p-4 rounded-2xl bg-slate-50 border-2 border-transparent peer-checked:border-[#005ab7] peer-checked:bg-blue-50 transition-all">
                                <span class="material-symbols-outlined text-lg text-slate-400 peer-checked:text-[#005ab7]">support_agent</span>
                                <p class="text-[9px] font-black uppercase text-slate-500 peer-checked:text-[#005ab7]">Agent / Staff</p>
                            </div>
                        </label>
                    </div>
                </div>

                <button type="submit" 
                        class="w-full py-5 bg-[#005ab7] text-white font-black rounded-2xl hover:bg-slate-900 transition-all uppercase text-[11px] tracking-[0.2em] shadow-xl shadow-blue-900/20 mt-2 flex items-center justify-center gap-3">
                    Accéder au Dashboard
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </button>
            </form>

            <div class="mt-8 pt-8 border-t border-slate-100 text-center">
                <p class="text-[10px] font-bold text-slate-500 uppercase">
                    Pas encore enrôlé ? 
                    <a href="#" class="text-[#005ab7] font-black hover:underline ml-1">Suivre mon dossier</a>
                </p>
            </div>
        </div>

        <div class="absolute bottom-8 flex items-center gap-2 px-6 py-3 bg-white/5 rounded-full border border-white/10 backdrop-blur-sm">
            <span class="material-symbols-outlined text-white/60 text-[14px]">verified_user</span>
            <span class="text-[8px] font-black text-white/60 uppercase tracking-[0.2em]">Sécurité ONIP : Connexion Biométrique et SSL Active</span>
        </div>
    </div>
</body>
</html>