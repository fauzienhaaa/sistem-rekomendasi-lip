<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecommendationController;

Route::get('/', [RecommendationController::class, 'index'])->name('recommendation.form');
Route::post('/recommendation', [RecommendationController::class, 'process'])->name('recommendation.process');