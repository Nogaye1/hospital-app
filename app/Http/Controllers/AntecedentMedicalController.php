<?php

namespace App\Http\Controllers;

use App\Models\AntecedentMedical;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AntecedentMedicalController extends Controller
{
    public function index()
    {
        try {
            $antecedents = AntecedentMedical::with('user')->get();
            return response()->json($antecedents, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erreur lors de la récupération des antécédents médicaux', 'error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'user_id' => 'required|exists:users,id',
                'date_debut' => 'required|date',
                'date_fin' => 'nullable|date',
                'heure_debut' => 'required|date_format:H:i',
                'heure_fin' => 'nullable|date_format:H:i',
                'motif' => 'required|string',
            ]);

            $antecedent = AntecedentMedical::create($validatedData);
            return response()->json(['antecedent' => $antecedent, 'message' => 'Antécédent médical créé avec succès'], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erreur lors de la création de l\'antécédent médical', 'error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function show($id)
    {
        try {
            $antecedent = AntecedentMedical::with('user')->findOrFail($id);
            return response()->json($antecedent, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erreur lors de la récupération de l\'antécédent médical', 'error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $antecedent = AntecedentMedical::findOrFail($id);

            $validatedData = $request->validate([
                'user_id' => 'exists:users,id',
                'date_debut' => 'date',
                'date_fin' => 'nullable|date',
                'heure_debut' => 'date_format:H:i',
                'heure_fin' => 'nullable|date_format:H:i',
                'motif' => 'string',
            ]);

            $antecedent->update($validatedData);
            return response()->json(['antecedent' => $antecedent, 'message' => 'Antécédent médical mis à jour avec succès'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erreur lors de la mise à jour de l\'antécédent médical', 'error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy($id)
    {
        try {
            $antecedent = AntecedentMedical::findOrFail($id);
            $antecedent->delete();
            return response()->json(['message' => 'Antécédent médical supprimé avec succès'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erreur lors de la suppression de l\'antécédent médical', 'error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }    
}
