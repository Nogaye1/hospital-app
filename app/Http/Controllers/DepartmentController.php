<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::all();
        return response()->json($departments, 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $department = Department::create($validatedData);
        return response()->json(['department' => $department, 'message' => 'Département créé avec succès'], 201);
    }

    public function show($id)
    {
        $department = Department::findOrFail($id);
        return response()->json($department, 200);
    }

    public function update(Request $request, $id)
    {
        $department = Department::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'string',
            'description' => 'nullable|string',
        ]);

        $department->update($validatedData);
        return response()->json(['department' => $department, 'message' => 'Département mis à jour avec succès'], 200);
    }

    public function destroy($id)
    {
        $department = Department::findOrFail($id);
        $department->delete();
        return response()->json(['message' => 'Département supprimé avec succès'], 200);
    }
}
