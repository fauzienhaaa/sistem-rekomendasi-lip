<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\RecommendationController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\TypeController;
use App\Http\Controllers\Admin\LipConditionController;
use App\Http\Controllers\Admin\UndertoneController;
use App\Http\Controllers\Admin\ProductController;

// Admin Routes
$adminRouteGroup = env('ADMIN_DOMAIN') 
    ? Route::domain(env('ADMIN_DOMAIN')) 
    : Route::prefix('admin');

$adminRouteGroup->name('admin.')->group(function () {
    Route::get('/', function () {
        if (auth()->check()) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('admin.login');
    });

    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
    Route::post('login', [AuthController::class, 'login'])->name('login.submit')->middleware('guest');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::middleware('auth')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // CRUD Routes
        Route::resource('users', UserController::class);
        Route::resource('brands', BrandController::class);
        Route::resource('types', TypeController::class);
        Route::resource('lip_conditions', LipConditionController::class);
        Route::resource('undertones', UndertoneController::class);
        Route::resource('products', ProductController::class);
    });
});

// User Routes
Route::get('/', [RecommendationController::class, 'index'])->name('recommendation.form');
Route::post('/recommendation', [RecommendationController::class, 'process'])->name('recommendation.process');