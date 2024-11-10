<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\RendezvousController;
use App\Http\Controllers\AntecedentMedicalController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\FactureController;
use App\Http\Controllers\MedicalRecordController;

// Routes pour l'authentification et les utilisateurs
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

// Routes pour la gestion des utilisateurs
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);
});

// Routes pour les rôles
Route::middleware('auth:sanctum')->group(function () {
    Route::resource('roles', RoleController::class);
});

// Routes pour les profils
Route::middleware('auth:sanctum')->group(function () {
    Route::resource('profils', ProfilController::class);
});

// Routes pour les rendez-vous
Route::middleware('auth:sanctum')->group(function () {
    Route::resource('rendezvous', RendezvousController::class);
});

// Routes pour les antécédents médicaux
Route::middleware('auth:sanctum')->group(function () {
    Route::resource('antecedents-medicaux', AntecedentMedicalController::class);
});

// Routes pour les paiements
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/paiements', [PaiementController::class, 'index']);
    Route::post('/paiements', [PaiementController::class, 'store']);
    Route::get('/paiements/{id}', [PaiementController::class, 'show']);
    Route::put('/paiements/{id}', [PaiementController::class, 'update']);
    Route::delete('/paiements/{id}', [PaiementController::class, 'destroy']);
});

// Routes pour les factures
Route::middleware('auth:sanctum')->group(function () {
    Route::resource('factures', FactureController::class);
});

// Routes pour la consultation et la modification des dossiers médicaux (Médecin)
Route::middleware(['auth:sanctum', 'role:medecin'])->group(function () {
    Route::get('/medical-records/{id}', [MedicalRecordController::class, 'show']);
    Route::put('/medical-records/{id}', [MedicalRecordController::class, 'update']);
});

// Routes pour les statistics
Route::middleware('auth:sanctum')->get('/statistics', [AdminController::class, 'statistics']);

//Routes crenaux horaires

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('slots', SlotController::class);
});
// Departement 
Route::middleware('auth:sanctum')->group(function () {
    Route::resource('departments', DepartmentController::class);
});
