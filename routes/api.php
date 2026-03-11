<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SkillController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('projects', [ProjectController::class, 'index']);
Route::get('certificates', [CertificateController::class, 'index']);
Route::get('skills', [SkillController::class, 'index']);

Route::post('messages', [MessageController::class, 'store']);

Route::post('login', [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    Route::apiResource('projects', ProjectController::class)
        ->only(['store', 'update', 'destroy']);

    Route::apiResource('certificates', CertificateController::class)
        ->only(['store', 'update', 'destroy']);

    Route::apiResource('skills', SkillController::class)
        ->only(['store', 'destroy']);

    Route::apiResource('messages', MessageController::class)
        ->only(['index', 'destroy']);

    Route::patch('messages/{id}/read', [MessageController::class, 'markAsRead']);

    Route::post('logout', [AuthController::class, 'logout']);

});