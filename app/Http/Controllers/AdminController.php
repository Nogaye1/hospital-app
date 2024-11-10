<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Rendezvous;
use App\Models\Paiement;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Récupérer les statistiques de l'application.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function statistics()
    {
        $statistics = [
            'total_users' => User::count(),
            'total_appointments' => Rendezvous::count(),
            'total_revenue' => Paiement::sum('montant'),
            // Ajouter d'autres statistiques si nécessaire
        ];

        return response()->json($statistics, 200);
    }
}
