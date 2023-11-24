<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\EndpointsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// PUBLIC ROUTES

// Auth
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);


// --------------------------------------------------------------------------------------------------------------------------------


// PROCTECTED ROUTES

Route::group(['middleware' => ['auth:sanctum']], function() {
    // Projects
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/{id}', [ProjectController::class, 'show'])->name('projects.show');
    Route::put('/projects/{id}', [ProjectController::class, 'update'])->name('projects.update');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::delete('/projects/{id}', [ProjectController::class, 'destroy'])->name('projects.destroy');

    // Endpoints
    Route::get('/projects/{projectId}/endpoints', [EndpointsController::class, 'index'])->name('endpoints.index');
    Route::get('projects/{projectId}/endpoints/{endpointId}', [EndpointsController::class, 'show'])->name('endpoints.show');
    Route::post('/projects/{projectId}/endpoints', [EndpointsController::class, 'store'])->name('endpoints.store');
});

//App
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
