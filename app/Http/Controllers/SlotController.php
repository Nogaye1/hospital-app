<?php

namespace App\Http\Controllers;

use App\Models\Slot;
use Illuminate\Http\Request;

class SlotController extends Controller
{
    public function index()
    {
        $slots = Slot::with('user')->get();
        return response()->json($slots, 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
        ]);

        $slot = Slot::create($validatedData);
        return response()->json(['slot' => $slot, 'message' => 'Créneau horaire créé avec succès'], 201);
    }

    public function show($id)
    {
        $slot = Slot::with('user')->findOrFail($id);
        return response()->json($slot, 200);
    }

    public function update(Request $request, $id)
    {
        $slot = Slot::findOrFail($id);

        $validatedData = $request->validate([
            'user_id' => 'exists:users,id',
            'date' => 'date',
            'start_time' => 'date_format:H:i',
            'end_time' => 'date_format:H:i',
        ]);

        $slot->update($validatedData);
        return response()->json(['slot' => $slot, 'message' => 'Créneau horaire mis à jour avec succès'], 200);
    }

    public function destroy($id)
    {
        $slot = Slot::findOrFail($id);
        $slot->delete();
        return response()->json(['message' => 'Créneau horaire supprimé avec succès'], 200);
    }
}
