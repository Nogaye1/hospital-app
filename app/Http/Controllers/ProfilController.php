<?php

namespace App\Http\Controllers;

use App\Models\Profil;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProfilController extends Controller
{
    public function index()
    {
        try {
            $profils = Profil::with(['user', 'role'])->get();
            return response()->json($profils, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erreur lors de la récupération des profils', 'error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'user_id' => 'required|exists:users,id',
                'role_id' => 'required|exists:roles,id',
            ]);

            $profil = Profil::create($validatedData);
            return response()->json(['profil' => $profil, 'message' => 'Profil créé avec succès'], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erreur lors de la création du profil', 'error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function show($id)
    {
        try {
            $profil = Profil::with(['user', 'role'])->findOrFail($id);
            return response()->json($profil, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erreur lors de la récupération du profil', 'error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $profil = Profil::findOrFail($id);

            $validatedData = $request->validate([
                'user_id' => 'exists:users,id',
                'role_id' => 'exists:roles,id',
            ]);

            $profil->update($validatedData);
            return response()->json(['profil' => $profil, 'message' => 'Profil mis à jour avec succès'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erreur lors de la mise à jour du profil', 'error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy($id)
    {
        try {
            $profil = Profil::findOrFail($id);
            $profil->delete();
            return response()->json(['message' => 'Profil supprimé avec succès'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erreur lors de la suppression du profil', 'error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }
}
