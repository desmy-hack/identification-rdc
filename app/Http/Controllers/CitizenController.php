<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreCitizenRequest;
use App\Http\Requests\UpdateCitizenRequest;
use App\Models\Citizen;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CitizenController extends Controller
{
    public function __construct()
    {
        // Protection des routes : seul un utilisateur authentifié peut accéder
        $this->middleware('auth');
    }

    // Récupère tous les citoyens
    public function index()
    {
        return Citizen::all();
    }

    // Affiche un citoyen spécifique
    public function show(Citizen $citizen)
    {
        $this->authorize('view', $citizen); 
        return $citizen;
    }

    // Crée un nouveau citoyen
    public function store(Request $request)
{
    $request->validate([
        'first_name' => 'required',
        'middle_name' => 'required',
        'last_name' => 'required',
    ]);

     $lastId = Citizen::max('id') + 1;

    $citizen = Citizen::create([
        'national_id' => 'RDC-' . str_pad($lastId, 4, '0', STR_PAD_LEFT),
        'first_name' => $request->first_name,
        'middle_name' => $request->middle_name,
        'last_name' => $request->last_name,
        'middle_name' => $request->middle_name,
        'birth_date' => $request->birth_date,
        'birth_place' => $request->birth_place,
        'gender' => $request->gender,
        'address' => $request->address,
        'province' => $request->province,
        'territory' => $request->territory,
        'sector' => $request->sector,
        'phone' => $request->phone,
        'father_name' => $request->father_name,
        'mother_name' => $request->mother_name,
        'photo' => $request->photo,
        'agent_id' => auth()->id(),
    ]);

    return response()->json($citizen, 201);
}

    // Met à jour un citoyen existant
    public function update(UpdateCitizenRequest $request, Citizen $citizen)
    {
        $this->authorize('update', $citizen);

        // Récupérer les données validées
        $validated = $request->validated();

        // Vérifier si certains champs critiques ont changé pour regénérer le QR code
        $fieldsThatTriggerQrUpdate = [
            'first_name', 'last_name', 'middle_name', 'birth_date', 
            'birth_place', 'gender'
        ];

        $needsQrUpdate = false;
        foreach ($fieldsThatTriggerQrUpdate as $field) {
            if (isset($validated[$field]) && $validated[$field] != $citizen->$field) {
                $needsQrUpdate = true;
                break;
            }
        }

        // Mettre à jour les données
        $citizen->update($validated);

        // Regénérer le QR code si nécessaire
        if ($needsQrUpdate) {
            $citizen->qr_code = $this->generateQrCode($citizen->national_id);
            $citizen->save();
        }

        return response()->json($citizen);
    }

    // Supprime un citoyen
    public function destroy(Citizen $citizen)
    {
        $this->authorize('delete', $citizen);
        $citizen->delete();
        return response()->json(['message' => 'Citoyen supprimé']);
    }

    // Génère un numéro national unique
    private function generateNationalId()
    {
        do {
            $id = mt_rand(10000000000, 99999999999); 
        } while (Citizen::where('national_id', $id)->exists());

        return $id;
    }

    // Génère le QR code et retourne le chemin accessible
    private function generateQrCode($nationalId)
    {
        $path = 'public/qr_codes/' . $nationalId . '.png';
        QrCode::format('png')->size(200)->generate($nationalId, storage_path('app/' . $path));
        return 'storage/qr_codes/' . $nationalId . '.png';
    }
}
