<?php

use App\Presentation\Http\Controllers\Api\AppointmentController;
use App\Presentation\Http\Controllers\Api\AuthController;
use App\Presentation\Http\Controllers\Api\FollowUpController;
use App\Presentation\Http\Controllers\Api\MedicalHistoryController;
use App\Presentation\Http\Controllers\Api\MedicationController;
use App\Presentation\Http\Controllers\Api\OwnerController;
use App\Presentation\Http\Controllers\Api\PatientController;
use App\Presentation\Http\Controllers\Api\PrescriptionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes — Nura VetCare
|--------------------------------------------------------------------------
*/

// ── Auth (público) ────────────────────────────────────────────────────────
Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
});

// ── Rutas protegidas con Sanctum ─────────────────────────────────────────
Route::middleware('auth:sanctum')->group(function () {

    Route::prefix('auth')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('me',      [AuthController::class, 'me']);
    });

    Route::apiResource('patients',         PatientController::class);
    Route::apiResource('owners',           OwnerController::class);
    Route::apiResource('medications',      MedicationController::class);
    Route::apiResource('prescriptions',    PrescriptionController::class);
    Route::apiResource('appointments',     AppointmentController::class);
    Route::apiResource('medical-history',  MedicalHistoryController::class);
    Route::apiResource('follow-ups',       FollowUpController::class);
});
