<section class="bg-[#111827] rounded-[2rem] shadow-2xl shadow-black/50 border border-white/5 overflow-hidden">
    <div class="bg-gradient-to-r from-[#005ab7] to-blue-700 p-8 text-white">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-white/10 backdrop-blur-xl rounded-2xl border border-white/10">
                <span class="material-symbols-outlined text-2xl">shield_lock</span>
            </div>
            <div>
                <h2 class="text-lg font-black uppercase tracking-tighter text-white">Authentification</h2>
                <p class="text-xs text-blue-100/70">Mise à jour des identifiants cryptographiques.</p>
            </div>
        </div>
    </div>

    <form method="post" action="{{ route('profile.password.update') }}" class="p-8 space-y-8">
        @csrf
        @method('put')

        <div class="space-y-6">
            <div class="group">
                <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1 mb-2 block group-focus-within:text-blue-400 transition-colors">Clé actuelle</label>
                <div class="relative">
                    <input name="current_password" type="password" 
                           class="w-full bg-[#0a0f18] border-2 border-white/5 rounded-2xl py-4 px-6 text-sm text-white focus:border-[#005ab7] focus:ring-0 transition-all outline-none placeholder:text-slate-700"
                           placeholder="Identifiant actuel">
                </div>
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 ml-2" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="group">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1 mb-2 block group-focus-within:text-blue-400 transition-colors">Nouvelle clé</label>
                    <input name="password" type="password" 
                           class="w-full bg-[#0a0f18] border-2 border-white/5 rounded-2xl py-4 px-6 text-sm text-white focus:border-[#005ab7] focus:ring-0 transition-all outline-none placeholder:text-slate-700"
                           placeholder="8 caractères min.">
                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 ml-2" />
                </div>

                <div class="group">
                    <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-1 mb-2 block group-focus-within:text-blue-400 transition-colors">Confirmation</label>
                    <input name="password_confirmation" type="password" 
                           class="w-full bg-[#0a0f18] border-2 border-white/5 rounded-2xl py-4 px-6 text-sm text-white focus:border-[#005ab7] focus:ring-0 transition-all outline-none placeholder:text-slate-700"
                           placeholder="Répétez la clé">
                </div>
            </div>
        </div>

        <div class="pt-4">
            <button type="submit" 
                    class="w-full bg-[#005ab7] hover:bg-blue-600 text-white font-black py-5 rounded-2xl text-[11px] uppercase tracking-[0.3em] transition-all shadow-xl shadow-blue-900/20 active:scale-[0.98]">
                Mettre à jour le système
            </button>
        </div>
    </form>
</section>