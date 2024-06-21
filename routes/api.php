<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DataController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('data', [DataController::class, 'store']);
Route::post('/data/last-five-days', [DataController::class, 'getLastFiveDaysScores']);
Route::post('/data/by-date', [DataController::class, 'getDataByDate']);
