<?php

namespace App\Http\Controllers;

use App\Models\Citizen;
use App\Models\ModificationRequest; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Spatie\LaravelPdf\Facades\Pdf;
use Illuminate\Support\Facades\Auth;

class CitizenController extends Controller
{
    /**
     * Enrôlement d'un nouveau citoyen
     * La génération du national_id et du QR Code est déléguée au modèle (Boot method)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            // Identité de base
            'first_name'   => 'required|string|max:255',
            'middle_name'  => 'required|string|max:255', 
            'last_name'    => 'required|string|max:255', 
            'email'        => 'required|email|unique:citizens,email',
            'birth_date'   => 'required|date',
            'birth_place'  => 'required|string',
            'gender'       => 'required|in:M,F',
            'address'      => 'required|string',
            'province'     => 'required|string',   
            'territory'    => 'required|string',  
            'sector'       => 'required|string',  
            'phone'        => 'nullable|string',
            'father_name'  => 'required|string',
            'mother_name'  => 'required|string',
            'photo'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

            // Identité Numérique (Champs issus de la 2ème migration)
            'criminal_record_number' => 'nullable|string',
            'health_record_number'   => 'nullable|string',
            'student_card_number'    => 'nullable|string',
            'social_security_number' => 'nullable|string',
            'tax_id_number'          => 'nullable|string',
            'passport_number'        => 'nullable|string',
        ]);

        // Gestion de l'upload de la photo
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('citizens/photos', 'public');
            $validated['photo'] = $path;
        }

        // Liaison avec l'agent connecté
        $validated['agent_id'] = auth()->id();

        /**
         * Création du citoyen. 
         * Le modèle Citizen s'occupe de :
         * 1. Générer le national_id (Event: creating)
         * 2. Générer le fichier QR Code physique (Event: created)
         */
        $citizen = Citizen::create($validated);

        return redirect()->route('dashboard')
            ->with('success', 'Citoyen enrôlé avec succès !')
            ->with('citizen_id', $citizen->id);
    }

    /**
     * Génération de la carte physique en PDF
     */
    public function generateCard($id)
    {
        $citizen = Citizen::findOrFail($id);
        
        // Ton code QR Code (HMAC, etc.) reste ici...
        $key = config('app.key');
        $signature = substr(hash_hmac('sha256', $citizen->national_id, $key), 0, 8);
        $qrContent = "RDC-ID:" . $citizen->national_id . ":" . $signature;
        $qrRaw = QrCode::format('png')->size(300)->margin(1)->errorCorrection('H')
            ->merge(public_path('photos/logo-rdc.png'), .3, true)
            ->generate($qrContent);
        $qrBase64 = 'data:image/png;base64,' . base64_encode($qrRaw);

        // Génération du PDF avec les arguments pour Kali
        return Pdf::view('citizen_card', compact('citizen', 'qrBase64'))
            ->format('a5')
            ->landscape()
            ->withBrowsershot(function ($browsershot) {
                $browsershot->noSandbox() // Indispensable sur Kali
                    ->setOption('args', [
                        '--disable-setuid-sandbox', 
                        '--disable-dev-shm-usage', 
                        '--disable-extensions',
                        '--no-zygote'
                    ]);
            })
            ->name('Carte_RDC_' . $citizen->national_id . '.pdf')
            ->download();
    }

    /**
     * API de Vérification du QR Code (Scanner)
     */
    public function verify(Request $request)
    {
        $input = $request->input('qr_data'); 
        $parts = explode(':', $input);

        if (count($parts) !== 3 || $parts[0] !== 'RDC-ID') {
            return response()->json(['status' => 'error', 'message' => 'Format QR invalide'], 400);
        }

        $id = $parts[1];
        $receivedSig = $parts[2];
        $expectedSig = substr(hash_hmac('sha256', $id, config('app.key')), 0, 8);

        // Vérification de l'intégrité de la signature
        if ($receivedSig === $expectedSig) {
            $citizen = Citizen::where('national_id', $id)->first();
            
            if (!$citizen) {
                return response()->json(['status' => 'error', 'message' => 'ID introuvable en base de données'], 404);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Carte Authentique',
                'data' => $citizen
            ]);
        }

        return response()->json(['status' => 'danger', 'message' => 'ALERTE : Carte falsifiée !'], 403);
    }

    /**
     * Demande de modification (Update)
     */
    public function requestUpdate(Request $request, Citizen $citizen)
    {
        $validatedData = $request->validate([
            'address'   => 'sometimes|string',
            'phone'     => 'sometimes|string',
            'province'  => 'sometimes|string',
        ]);

        $modification = ModificationRequest::create([
            'citizen_id' => $citizen->id,
            'old_data'   => json_encode($citizen->only(array_keys($validatedData))),
            'new_data'   => json_encode($validatedData),
            'status'     => 'pending'
        ]);

        return response()->json(['message' => 'Demande transmise', 'id' => $modification->id], 202);
    }

    // app/Http/Controllers/CitizenController.php

    public function index()
    {
        // Au lieu de prendre l'utilisateur "statique" de la session, 
        // on va chercher l'utilisateur en base de données avec son profil complet.
        $user = \App\Models\User::with('citizenProfile')->find(Auth::id());

        if (!$user || !$user->citizenProfile) {
            // Petit diagnostic rapide pour toi dans les logs si c'est vide
            \Log::error("Profil introuvable pour l'utilisateur ID: " . Auth::id());
        }

        return view('citizens.dashboard', compact('user'));
    }
}