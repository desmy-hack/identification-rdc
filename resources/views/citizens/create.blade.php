<x-app-layout>
<script>
    function citizenWizard() {
        return {
            step: 1,
            totalSteps: 6, 
            photoPreview: null,
            form: {
                last_name: '', middle_name: '', first_name: '',
                email: '', birth_date: '', birth_place: '', gender: '',
                address: '', province: '', territory: '', sector: '',
                phone: '', father_name: '', mother_name: '', 
                criminal_record_number: '', health_record_number: '',
                student_card_number: '', social_security_number: '',
                tax_id_number: '', passport_number: ''
            },
         
            get progress() { return (this.step / this.totalSteps) * 100; },
            
            next() {
                const currentDiv = document.querySelector(`[data-step="${this.step}"]`);
                if (currentDiv) {
                    const inputs = currentDiv.querySelectorAll('input[required], select[required]');
                    let isValid = true;
                    inputs.forEach(input => {
                        if (!input.checkValidity()) {
                            input.reportValidity();
                            isValid = false;
                        }
                    });
                    if (!isValid) return;
                }

                if (this.step < this.totalSteps) {
                    this.step++;
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            },
            
            prev() {
                if (this.step > 1) {
                    this.step--;
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                }
            },

            updatePhotoPreview(event) {
                const file = event.target.files[0];
                if (!file) return;
                const reader = new FileReader();
                reader.onload = (e) => { this.photoPreview = e.target.result; };
                reader.readAsDataURL(file);
            }
        }
    }
</script>

<style>
    nav { display: none !important; }
    [x-cloak] { display: none !important; }
    .bg-rdc-official { background-color: #f8fafc; position: relative; min-height: 100vh; }
    .bg-rdc-official::before {
        content: ""; position: fixed; inset: 0; pointer-events: none; z-index: 0;
        background-image: url("data:image/svg+xml,%3Csvg width='120' height='120' viewBox='0 0 120 120' xmlns='http://www.w3.org/2000/svg'%3E%3Ctext x='50%25' y='50%25' font-size='16' font-weight='900' fill='rgba(0, 102, 204, 0.05)' text-anchor='middle' transform='rotate(-35, 60, 60)' font-family='sans-serif'%3ERDC%3C/text%3E%3C/svg%3E");
        background-repeat: repeat;
    }
    .flag-gradient-bar { background: linear-gradient(to right, #007FFF 0%, #007FFF 70%, #F7D002 70%, #F7D002 85%, #CE1126 85%, #CE1126 100%); height: 6px; }
    .id-card-rdc { background: linear-gradient(135deg, #007FFF 0%, #004b93 100%); border-right: 15px solid #CE1126; border-top: 5px solid #F7D002; }
</style>

<div x-data="citizenWizard()" x-cloak class="bg-rdc-official">
    <div class="relative z-10">
        <div class="flag-gradient-bar"></div>
        <header class="bg-white shadow-md py-4 px-6 border-b border-slate-200">
            <div class="max-w-6xl mx-auto flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('photos/drc_logo.png') }}" alt="Logo RDC" class="w-14 h-14 object-contain">
                    <h1 class="text-xl font-black text-slate-800 uppercase">Enrôlement <span class="text-[#007FFF]">Biométrique</span></h1>
                </div>
            </div>
        </header>

        <main class="max-w-4xl mx-auto px-6 py-10">
            <div class="mb-8">
                <div class="w-full bg-slate-200 h-2 rounded-full overflow-hidden">
                    <div class="h-full bg-[#007FFF] transition-all duration-500" :style="`width: ${progress}%` text-align: center"></div>
                </div>
                <p class="text-[10px] font-bold text-slate-400 mt-2 uppercase">Étape <span x-text="step"></span> sur <span x-text="totalSteps"></span></p>
            </div>


            @if ($errors->any())
                <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                    <strong>Oups ! Il y a des erreurs :</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            <form action="{{ route('agent.store') }}" method="POST" enctype="multipart/form-data">                
                @csrf
                <div class="bg-white rounded-[2.5rem] shadow-2xl border border-slate-100 overflow-hidden">
                    <div class="p-10 md:p-14">
                        
                        <div x-show="step === 1" data-step="1" class="space-y-6">
                            <h2 class="text-2xl font-black text-slate-800 uppercase border-b-4 border-[#F7D002] inline-block mb-6">1. Identité</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <input type="text" name="last_name" x-model="form.last_name" required placeholder="NOM" class="w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-2xl font-bold uppercase outline-none">
                                <input type="text" name="middle_name" x-model="form.middle_name" required placeholder="POSTNOM" class="w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-2xl font-bold uppercase outline-none">
                                <input type="text" name="first_name" x-model="form.first_name" required placeholder="PRÉNOM" class="w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-2xl font-bold uppercase outline-none">
                                <select name="gender" x-model="form.gender" required class="w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-2xl font-bold outline-none">
                                    <option value="">GENRE</option>
                                    <option value="M">MASCULIN</option>
                                    <option value="F">FÉMININ</option>
                                </select>
                                <input type="date" name="birth_date" x-model="form.birth_date" required class="w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-2xl font-bold outline-none">
                                <input type="text" name="birth_place" x-model="form.birth_place" required placeholder="LIEU DE NAISSANCE" class="w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-2xl font-bold uppercase outline-none">
                            </div>
                        </div>

                        <div x-show="step === 2" data-step="2" class="space-y-6">
                            <h2 class="text-2xl font-black text-slate-800 uppercase border-b-4 border-[#F7D002] inline-block mb-6">2. Origine</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <input type="text" name="province" x-model="form.province" required placeholder="PROVINCE D'ORIGINE" class="w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-2xl font-bold uppercase outline-none">
                                <input type="text" name="territory" x-model="form.territory" required placeholder="TERRITOIRE D'ORIGINE" class="w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-2xl font-bold uppercase outline-none">
                                <input type="text" name="sector" x-model="form.sector" required placeholder="SECTEUR / CHEFFERIE" class="w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-2xl font-bold uppercase outline-none col-span-1 md:col-span-2">
                            </div>
                        </div>

                        <div x-show="step === 3" data-step="3" class="space-y-6">
                            <h2 class="text-2xl font-black text-slate-800 uppercase border-b-4 border-[#F7D002] inline-block mb-6">3. Filiation & Contact</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <input type="text" name="father_name" x-model="form.father_name" required placeholder="NOM DU PÈRE" class="w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-2xl font-bold uppercase outline-none">
                                <input type="text" name="mother_name" x-model="form.mother_name" required placeholder="NOM DE LA MÈRE" class="w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-2xl font-bold uppercase outline-none">
                                <input type="email" name="email" x-model="form.email" required placeholder="EMAIL" class="w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-2xl font-bold outline-none">
                                <input type="text" name="phone" x-model="form.phone" placeholder="TÉLÉPHONE" class="w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-2xl font-bold outline-none">
                                <input type="text" name="address" x-model="form.address" required placeholder="ADRESSE ACTUELLE" class="w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-2xl font-bold uppercase col-span-1 md:col-span-2 outline-none">
                            </div>
                        </div>

                        <div x-show="step === 4" data-step="4" class="space-y-6">
                            <h2 class="text-2xl font-black text-slate-800 uppercase border-b-4 border-[#F7D002] inline-block mb-6">4. Documents & Services</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <input type="text" name="criminal_record_number" x-model="form.criminal_record_number" placeholder="N° CASIER JUDICIAIRE" class="w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-2xl font-bold outline-none">
                                <input type="text" name="health_record_number" x-model="form.health_record_number" placeholder="N° CARNET DE SANTÉ" class="w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-2xl font-bold outline-none">
                                <input type="text" name="student_card_number" x-model="form.student_card_number" placeholder="N° CARTE ÉTUDIANT" class="w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-2xl font-bold outline-none">
                                <input type="text" name="social_security_number" x-model="form.social_security_number" placeholder="N° CNSS" class="w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-2xl font-bold outline-none">
                                <input type="text" name="tax_id_number" x-model="form.tax_id_number" placeholder="N° IMPÔT (NIF)" class="w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-2xl font-bold outline-none">
                                <input type="text" name="passport_number" x-model="form.passport_number" placeholder="N° PASSEPORT" class="w-full p-4 bg-slate-50 border-2 border-slate-100 rounded-2xl font-bold outline-none">
                            </div>
                        </div>

                        <div x-show="step === 5" data-step="5" class="text-center">
                            <h2 class="text-2xl font-black text-slate-800 uppercase mb-10">5. Capture Photo</h2>
                            <div class="w-48 h-60 mx-auto bg-slate-100 rounded-3xl border-4 border-white shadow-2xl overflow-hidden mb-8 relative">
                                <template x-if="photoPreview"><img :src="photoPreview" class="w-full h-full object-cover"></template>
                            </div>
                            <label class="px-10 py-4 bg-[#007FFF] text-white rounded-2xl font-black uppercase text-xs cursor-pointer shadow-lg inline-block transition-transform hover:scale-105">
                                Prendre Photo
                                <input type="file" name="photo" class="hidden" accept="image/*" @change="updatePhotoPreview" required>
                            </label>
                        </div>

                        <div x-show="step === 6" data-step="5" class="text-center" x-transition>
                            <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-10">5. Aperçu Final de l'Enrôlement</h3>
                            
                            <div class="mx-auto w-[520px] max-w-full h-[320px] rounded-[2rem] p-6 text-white shadow-2xl relative text-left overflow-hidden id-card-rdc">
                                
                                <div class="absolute inset-0 flex items-center justify-center opacity-10 pointer-events-none">
                                    <h1 class="text-[140px] font-black rotate-[-25deg]">RDC</h1>
                                </div>

                                <div class="relative z-10 flex justify-between items-start border-b border-white/30 pb-3 mb-4">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('photos/drc_logo.png') }}" class="w-12 h-12 object-contain bg-white rounded-full p-1 shadow-lg">
                                        <div>
                                            <p class="text-[10px] font-black uppercase leading-tight">République Démocratique du Congo</p>
                                            <p class="text-[8px] font-bold text-yellow-300 uppercase tracking-tighter">Office National d'Identification de la Population</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-[7px] font-bold opacity-70 uppercase tracking-widest">Numéro National (NN)</p>
                                        <p class="text-[10px] font-mono font-bold text-yellow-400 animate-pulse">GÉNÉRATION EN COURS...</p>
                                    </div>
                                </div>

                                <div class="relative z-10 flex gap-5">
                                    <div class="flex flex-col gap-2">
                                        <div class="w-28 h-36 bg-slate-200/20 rounded-xl border-2 border-white/40 overflow-hidden shadow-inner backdrop-blur-sm">
                                            <template x-if="photoPreview">
                                                <img :src="photoPreview" class="w-full h-full object-cover">
                                            </template>
                                        </div>
                                        <div class="w-28 h-8 border border-white/20 rounded flex items-center justify-center opacity-30">
                                            <span class="text-[5px] uppercase italic">Signature Numérique</span>
                                        </div>
                                    </div>

                                    <div class="flex-1 grid grid-cols-2 gap-x-4 gap-y-2">
                                        <div class="col-span-2">
                                            <p class="text-[7px] text-yellow-300 font-bold uppercase leading-none">Noms</p>
                                            <p class="text-sm font-black uppercase truncate" x-text="form.last_name + ' ' + form.middle_name"></p>
                                            <p class="text-[10px] font-bold opacity-90 uppercase" x-text="form.first_name"></p>
                                        </div>

                                        <div><p class="text-[7px] text-yellow-300 font-bold uppercase leading-none">Né(e) le</p><p class="text-[9px] font-bold" x-text="form.birth_date"></p></div>
                                        <div><p class="text-[7px] text-yellow-300 font-bold uppercase leading-none">À</p><p class="text-[9px] font-bold uppercase truncate" x-text="form.birth_place"></p></div>
                                        
                                        <div><p class="text-[7px] text-yellow-300 font-bold uppercase leading-none">Père</p><p class="text-[8px] font-bold uppercase truncate" x-text="form.father_name"></p></div>
                                        <div><p class="text-[7px] text-yellow-300 font-bold uppercase leading-none">Mère</p><p class="text-[8px] font-bold uppercase truncate" x-text="form.mother_name"></p></div>

                                        <div><p class="text-[7px] text-yellow-300 font-bold uppercase leading-none">Province</p><p class="text-[9px] font-bold uppercase truncate" x-text="form.province"></p></div>
                                        <div><p class="text-[7px] text-yellow-300 font-bold uppercase leading-none">Territoire</p><p class="text-[9px] font-bold uppercase truncate" x-text="form.territory"></p></div>

                                        <div class="col-span-2">
                                            <p class="text-[7px] text-yellow-300 font-bold uppercase leading-none">Adresse Actuelle</p>
                                            <p class="text-[8px] font-bold uppercase truncate" x-text="form.address"></p>
                                        </div>
                                    </div>

                                    <div class="flex flex-col items-center justify-between py-1">
                                        <div class="text-center">
                                            <p class="text-[7px] text-yellow-300 font-bold uppercase">Sexe</p>
                                            <p class="text-xs font-black" x-text="form.gender"></p>
                                        </div>
                                        <div class="w-16 h-16 bg-white/10 p-1 rounded-lg border border-white/30 backdrop-blur-md flex items-center justify-center">
                                            <div class="text-center">
                                                <svg class="w-8 h-8 mx-auto opacity-40 animate-spin" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                                </svg>
                                                <p class="text-[5px] mt-1 uppercase opacity-60">QR Auto</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <div class="bg-slate-50 p-8 flex justify-between border-t border-slate-100">
                        <button type="button" x-show="step > 1" @click="prev" class="px-8 py-4 text-slate-400 font-black uppercase text-[10px] tracking-widest">Précédent</button>
                        <div class="ml-auto">
                            <button type="button" x-show="step < totalSteps" @click="next" class="px-12 py-5 bg-[#007FFF] text-white rounded-2xl font-black uppercase text-[10px] tracking-widest shadow-xl">Continuer</button>
                            <button type="submit" x-show="step === totalSteps" class="px-12 py-5 bg-[#CE1126] text-white rounded-2xl font-black uppercase text-[10px] tracking-widest shadow-xl">Valider l'Enrôlement</button>
                        </div>
                    </div>
                </div>
            </form>
        </main>
    </div>
</div>
</x-app-layout>