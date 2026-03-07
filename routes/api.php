<?php

use App\Http\Controllers\CertificateController;
use App\Http\Controllers\ProjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::apiResource('projects', ProjectController::class)
    ->only(['index','store','update','destroy']);

Route::apiResource('certificates', CertificateController::class)
    ->only(['index','store','update','destroy']);