<?php
// app/Http/Controllers/RoleController.php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{
    public function index()
    {
        try {
            $roles = Role::all();
            return response()->json($roles, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erreur lors de la récupération des rôles', 'error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'role_name' => 'required|string|max:255|unique:roles,role_name',
            ]);

            $role = Role::create($validatedData);
            return response()->json(['role' => $role, 'message' => 'Rôle créé avec succès'], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erreur lors de la création du rôle', 'error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function show($id)
    {
        try {
            $role = Role::findOrFail($id);
            return response()->json($role, Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erreur lors de la récupération du rôle', 'error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $role = Role::findOrFail($id);

            $validatedData = $request->validate([
                'role_name' => 'string|max:255|unique:roles,role_name,' . $id,
            ]);

            $role->update($validatedData);
            return response()->json(['role' => $role, 'message' => 'Rôle mis à jour avec succès'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erreur lors de la mise à jour du rôle', 'error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy($id)
    {
        try {
            $role = Role::findOrFail($id);
            $role->delete();
            return response()->json(['message' => 'Rôle supprimé avec succès'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erreur lors de la suppression du rôle', 'error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }
}
