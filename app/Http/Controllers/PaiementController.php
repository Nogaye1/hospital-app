<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaiementController extends Controller
{
    public function index()
    {
        $paiements = Paiement::with(['user', 'facture'])->get();
        return response()->json($paiements, 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'facture_id' => 'required|exists:factures,id',
            'montant' => 'required|numeric',
            'date_paiement' => 'required|date',
            'statut' => 'required|string',
            'methode' => 'required|string',
            'phone' => 'required|string',
            'payment_method' => 'required|string|in:wave,orange_money',
        ]);

        // Crée le paiement dans la base de données
        $paiement = Paiement::create($validatedData);

        // Intégration avec l'API de paiement appropriée
        if ($validatedData['payment_method'] === 'wave') {
            $response = $this->processWavePayment([
                'amount' => $validatedData['montant'],
                'phone' => $validatedData['phone'],
            ]);
        } elseif ($validatedData['payment_method'] === 'orange_money') {
            $response = $this->processOrangeMoneyPayment([
                'amount' => $validatedData['montant'],
                'phone' => $validatedData['phone'],
            ]);
        }

        return response()->json(['paiement' => $paiement, 'api_response' => $response, 'message' => 'Paiement créé avec succès'], 201);
    }

    public function show($id)
    {
        $paiement = Paiement::with(['user', 'facture'])->findOrFail($id);
        return response()->json($paiement, 200);
    }

    public function update(Request $request, $id)
    {
        $paiement = Paiement::findOrFail($id);

        $validatedData = $request->validate([
            'user_id' => 'exists:users,id',
            'facture_id' => 'exists:factures,id',
            'montant' => 'numeric',
            'date_paiement' => 'date',
            'statut' => 'string',
            'methode' => 'string',
        ]);

        $paiement->update($validatedData);
        return response()->json(['paiement' => $paiement, 'message' => 'Paiement mis à jour avec succès'], 200);
    }

    public function destroy($id)
    {
        $paiement = Paiement::findOrFail($id);
        $paiement->delete();

        return response()->json(['message' => 'Paiement supprimé avec succès'], 200);
    }    

    private function processWavePayment($data)
    {
        // Exemple de code pour appeler l'API Wave
        $response = Http::post('https://api.wave.com/v1/payments', [
            'amount' => $data['amount'],
            'phone' => $data['phone'],
            // Autres paramètres nécessaires
        ]);

        return $response->json();
    }

    private function processOrangeMoneyPayment($data)
    {
        // Exemple de code pour appeler l'API Orange Money
        $response = Http::post('https://api.orange.com/v1/payments', [
            'amount' => $data['amount'],
            'phone' => $data['phone'],
            // Autres paramètres nécessaires
        ]);

        return $response->json();
    }
}
