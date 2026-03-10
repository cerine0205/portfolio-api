<?php

use App\Http\Controllers\CertificateController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SkillController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::apiResource('projects', ProjectController::class)
    ->only(['index', 'store', 'update', 'destroy']);

Route::apiResource('certificates', CertificateController::class)
    ->only(['index', 'store', 'update', 'destroy']);

Route::apiResource('messages', MessageController::class)
    ->only(['index', 'store', 'destroy']);

Route::patch('messages/{id}/read', [MessageController::class, 'markAsRead']);

Route::apiResource('skills', SkillController::class)
    ->only(['index', 'store', 'destroy']);
