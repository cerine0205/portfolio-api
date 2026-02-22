<?php

use App\Http\Controllers\ProjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::get('/projects', [ProjectController::class, 'index']);      // list
Route::post('/projects', [ProjectController::class, 'store']);     // create
Route::delete('/projects/{id}', [ProjectController::class, 'destroy']); // delete
Route::put('/projects/{id}', [ProjectController::class, 'update']); // update
