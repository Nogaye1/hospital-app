<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    public function show($id)
    {
        $medicalRecord = MedicalRecord::findOrFail($id);
        return response()->json($medicalRecord, 200);
    }

    public function update(Request $request, $id)
    {
        $medicalRecord = MedicalRecord::findOrFail($id);

        $validatedData = $request->validate([
            'diagnosis' => 'required|string',
            'treatment' => 'required|string',
        ]);

        $medicalRecord->update($validatedData);

        return response()->json(['medicalRecord' => $medicalRecord, 'message' => 'Dossier médical mis à jour avec succès'], 200);
    }
}
