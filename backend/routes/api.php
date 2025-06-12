<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\WeekController;
use App\Http\Controllers\LeagueController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\SimulationController;
use App\Http\Controllers\PredictionController;

Route::get('/teams', [TeamController::class, 'index']);

Route::get('/weeks', [WeekController::class, 'index']);

Route::get('/leagues', [LeagueController::class, 'index']);

Route::get('/matches', [MatchController::class, 'index']);
Route::get('/matches/week/{weekId}', [MatchController::class, 'byWeek']);

Route::prefix('/simulate')->group(function () {
    Route::post('/week/{id}', [SimulationController::class, 'simulateWeek']);
    Route::post('/next', [SimulationController::class, 'simulateNext']);
    Route::post('/reset', [SimulationController::class, 'reset']);
    Route::post('/predict', [SimulationController::class, 'predict']);
});

Route::get('/predictions', [PredictionController::class, 'index']);