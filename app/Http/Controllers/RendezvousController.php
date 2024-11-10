<?php
// app/Http/Controllers/RendezvousController.php

namespace App\Http\Controllers;

use App\Models\Rendezvous;
use App\Models\User;
use Illuminate\Http\Request;

class RendezvousController extends Controller
{
    public function index()
    {
        $rendezvous = Rendezvous::with(['user'])->get();
        return response()->json($rendezvous, 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'date_debut' => 'required|date',
            'date_fin' => 'nullable|date',
            'heure_debut' => 'required|date_format:H:i',
            'heure_fin' => 'nullable|date_format:H:i',
            'motif' => 'required|string',
        ]);

        $rendezvous = Rendezvous::create($validatedData);
        return response()->json(['rendezvous' => $rendezvous, 'message' => 'Rendez-vous créé avec succès'], 201);
    }

    public function show($id)
    {
        $rendezvous = Rendezvous::with(['user'])->findOrFail($id);
        return response()->json($rendezvous, 200);
    }

    public function update(Request $request, $id)
    {
        $rendezvous = Rendezvous::findOrFail($id);

        $validatedData = $request->validate([
            'user_id' => 'exists:users,id',
            'date_debut' => 'nullable|date',
            'date_fin' => 'nullable|date',
            'heure_debut' => 'nullable|date_format:H:i',
            'heure_fin' => 'nullable|date_format:H:i',
            'motif' => 'nullable|string',
        ]);

        $rendezvous->update($validatedData);
        return response()->json(['rendezvous' => $rendezvous, 'message' => 'Rendez-vous mis à jour avec succès'], 200);
    }

    public function destroy($id)
    {
        $rendezvous = Rendezvous::findOrFail($id);
        $rendezvous->delete();
        return response()->json(['message' => 'Rendez-vous supprimé avec succès'], 200);
    }    
}
