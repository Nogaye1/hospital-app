<?php
// app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    // Récupérer tous les utilisateurs
    public function index()
    {
        return response()->json(User::all(), 200);
    }

    // Ajouter un nouvel utilisateur (inscription)
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'date_naissance' => 'required|date',
            'adresse' => 'required|string',
            'telephone' => 'required|string|unique:users,telephone',
            'email' => 'required|email|unique:users,email',
            'specialite' => 'nullable|string|max:255',
            'password' => 'required|string|min:8|confirmed', // Assurez-vous que le mot de passe est confirmé
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']); // Hasher le mot de passe

        $user = User::create($validatedData);

        return response()->json(['user' => $user, 'message' => 'Utilisateur inscrit avec succès'], 201);
    }

    // Connexion de l'utilisateur
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            throw ValidationException::withMessages([
                'email' => ['Les identifiants fournis sont incorrects.'],
            ]);
        }

        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['access_token' => $token, 'token_type' => 'Bearer'], 200);
    }

    // Déconnexion de l'utilisateur
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Déconnexion réussie et token révoqué'], 200);
    }

    // Récupérer un utilisateur spécifique
    public function show($id)
    {
        $user = User::with(['profil', 'rendezvous', 'antecedentsMedicaux', 'paiements'])->findOrFail($id);
        return response()->json($user, 200);
    }

    // Mettre à jour un utilisateur
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'nom' => 'string|max:255',
            'prenom' => 'string|max:255',
            'date_naissance' => 'date',
            'adresse' => 'string',
            'telephone' => 'string|unique:users,telephone,' . $id,
            'email' => 'email|unique:users,email,' . $id,
            'specialite' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:8',
        ]);

        if (isset($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }

        $user->update($validatedData);

        return response()->json(['user' => $user, 'message' => 'Utilisateur mis à jour avec succès'], 200);
    }

    // Supprimer un utilisateur
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'Utilisateur supprimé avec succès'], 200);
    }
}
