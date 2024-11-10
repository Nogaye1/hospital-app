<?php
// app/Http/Controllers/FactureController.php

namespace App\Http\Controllers;

use App\Models\Facture;
use Illuminate\Http\Request;

class FactureController extends Controller
{
    public function index()
    {
        $factures = Facture::with(['rendezvous', 'paiements'])->get();
        return response()->json($factures, 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'rendezvous_id' => 'required|exists:rendezvous,id',
            'montant_total' => 'required|numeric',
            'date_facture' => 'required|date',
            'statut' => 'required|string',
        ]);

        $facture = Facture::create($validatedData);
        return response()->json(['facture' => $facture, 'message' => 'Facture créée avec succès'], 201);
    }

    public function show($id)
    {
        $facture = Facture::with(['rendezvous', 'paiements'])->findOrFail($id);
        return response()->json($facture, 200);
    }

    public function update(Request $request, $id)
    {
        $facture = Facture::findOrFail($id);

        $validatedData = $request->validate([
            'rendezvous_id' => 'exists:rendezvous,id',
            'montant_total' => 'numeric',
            'date_facture' => 'date',
            'statut' => 'string',
        ]);

        $facture->update($validatedData);
        return response()->json(['facture' => $facture, 'message' => 'Facture mise à jour avec succès'], 200);
    }

    public function destroy($id)
    {
        $facture = Facture::findOrFail($id);
        $facture->delete();

        return response()->json(['message' => 'Facture supprimée avec succès'], 200);
    }
}
