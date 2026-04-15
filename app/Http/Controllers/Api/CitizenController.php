<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Citizen; 
use App\Models\User; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache; 
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;

class CitizenController extends Controller
{
    // GET /api/citizens : Liste paginée des citoyens
    public function index()
    {
        return response()->json(Citizen::latest()->paginate(10));
    }

    // GET /api/citizens/{id} : Détails complets
    public function show($id)
    {
        $citizen = Citizen::find($id);
        if (!$citizen) {
            return response()->json(['message' => 'Citoyen non trouvé'], 404);
        }
        return response()->json($citizen);
    }

    // POST /api/citizens : Enrôlement initial (Agent/Admin)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name'   => 'required|string|max:255',
            'middle_name'  => 'required|string|max:255', 
            'last_name'    => 'required|string|max:255', 
            'email'        => 'required|email|unique:citizens,email', // Email requis pour vérification future
            'birth_date'   => 'required|date',
            'birth_place'  => 'required|string',
            'gender'       => 'required|in:M,F',
            'address'      => 'required|string',
            'province'     => 'required|string',   
            'territory'    => 'required|string',  
            'sector'       => 'required|string',  
            'father_name'  => 'required|string',
            'mother_name'  => 'required|string',
        ]);

        do {
            $nationalId = mt_rand(10000000000, 99999999999);
        } while (Citizen::where('national_id', $nationalId)->exists());
        $validated['national_id'] = $nationalId;
        $validated['agent_id'] = auth()->id() ?? 1; 

        $citizen = Citizen::create($validated);
        $citizen->generateQrCode();

        return response()->json([
            'message' => 'Citoyen enrôlé et QR Code généré',
            'citizen' => $citizen,
            'qr_url' => asset('storage/' . $citizen->qr_code)
        ], 201);

        return response()->json([
            'message' => 'Citoyen enrôlé avec succès',
            'citizen' => $citizen
        ], 201);
    }

    /**
     *  Envoi du code de vérification
     */
    public function sendVerificationCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'national_id' => 'required|exists:citizens,national_id'
        ]);

        $citizen = Citizen::where('national_id', $request->national_id)
                        ->where('email', $request->email)
                        ->first();

        if (!$citizen) {
            return response()->json(['message' => 'Cet email ne correspond pas à ce citoyen.'], 403);
        }

        $code = mt_rand(100000, 999999);

        // Stockage en cache (10 min)
        Cache::put('verify_code_' . $request->email, $code, now()->addMinutes(10));

        // Simulation d'envoi (Log ou Mail)
        return response()->json([
            'message' => 'Code de vérification envoyé à ' . $request->email,
            'code_debug' => $code // Supprimer en prod
        ]);
    }

    /**
     *  Confirmation du code et création du compte User
     */
    public function confirmAndRegister(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|integer',
            'password' => 'required|min:8|confirmed',
        ]);

        $storedCode = Cache::get('verify_code_' . $request->email);

        if (!$storedCode || $storedCode != $request->code) {
            return response()->json(['message' => 'Code invalide ou expiré.'], 422);
        }

        $citizen = Citizen::where('email', $request->email)->first();

        // Création du compte utilisateur lié au citoyen
        $user = User::create([
            'name' => $citizen->first_name . ' ' . $citizen->last_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'national_id' => $citizen->national_id,
            'role' => 'citizen',
        ]);

        Cache::forget('verify_code_' . $request->email);

        return response()->json([
            'message' => 'Identité confirmée et compte créé avec succès !',
            'user' => $user
        ], 201);
    }

    public function destroy($id)
    {
        $citizen = Citizen::find($id);
        if (!$citizen) return response()->json(['message'=>'Citoyen non trouvé'], 404);
        $citizen->delete();
        return response()->json(['message'=>'Citoyen supprimé']);
    }

    public function generateCard($id)
    {
        $citizen = Citizen::findOrFail($id); 
        
        $key = config('app.key');
        $signature = substr(hash_hmac('sha256', $citizen->national_id, $key), 0, 8);
        $qrContent = "RDC-ID:" . $citizen->national_id . ":" . $signature;

        $qrCode = QrCode::format('png')->merge(public_path('photos/logo-rdc.png'), .2, true)
            ->size(150)->errorCorrection('H')->generate($qrContent);
        
        $qrBase64 = 'data:image/png;base64,' . base64_encode($qrCode);

        return Pdf::loadView('citizen_card', compact('citizen', 'qrBase64'))
                  ->download('ID_'.$citizen->national_id.'.pdf');
    }

    public function verify(Request $request)
    {
        $data = explode(':', $request->qr_data);
        
        if (count($data) !== 3 || $data[0] !== 'RDC-ID') {
            return response()->json(['status' => 'error', 'message' => 'Format QR invalide'], 400);
        }

        $id = $data[1];
        $receivedSignature = $data[2];
        
        
        $expectedSignature = substr(hash_hmac('sha256', $id, config('app.key')), 0, 8);

        if ($receivedSignature === $expectedSignature) {
            $citizen = Citizen::where('national_id', $id)->first();
            return response()->json([
                'status' => 'success',
                'message' => 'Carte Authentique',
                'citizen' => $citizen
            ]);
        }

        return response()->json(['status' => 'danger', 'message' => 'ATTENTION : Carte Falsifiée !'], 403);
    }
}