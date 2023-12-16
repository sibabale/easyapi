<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\EndpointsController;
use App\Http\Controllers\FieldValueController;
use App\Http\Controllers\EndpointFieldController;

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
    Route::get('/projects', [ProjectController::class, 'index']);
    Route::get('/projects/{id}', [ProjectController::class, 'show']);
    Route::put('/projects/{id}', [ProjectController::class, 'update']);
    Route::post('/projects', [ProjectController::class, 'store']);
    Route::delete('/projects/{id}', [ProjectController::class, 'destroy']);

    // Endpoints
    Route::get('/projects/{projectId}/endpoints', [EndpointsController::class, 'index']);
    Route::put('/projects/{projectId}/endpoints', [EndpointsController::class, 'update']);
    Route::get('projects/{projectId}/endpoints/{endpointId}', [EndpointsController::class, 'show']);
    Route::post('/projects/{projectId}/endpoints', [EndpointsController::class, 'store']);
    Route::delete('/endpoints', [EndpointsController::class, 'destroy']);

    // Endpoint Fields
    Route::get('/endpoints/fields', [EndpointFieldController::class, 'index']);
    Route::get('/endpoints/field', [EndpointFieldController::class, 'show']);
    Route::put('/endpoints/fields', [EndpointFieldController::class, 'update']);
    Route::post('/endpoints/fields', [EndpointFieldController::class, 'store']);
    Route::delete('/endpoints/fields', [EndpointFieldController::class, 'destroy']);

    // Field Values
    Route::get('/endpoints/fields/values', [FieldValueController::class, 'index']);
    Route::get('/endpoints/fields/value', [FieldValueController::class, 'show']);
    Route::put('/endpoints/fields/value', [FieldValueController::class, 'update']);
    Route::post('/endpoints/fields/value', [FieldValueController::class, 'store']);
    Route::delete('/endpoints/fields/value', [FieldValueController::class, 'destroy']);

    // User friendly
    Route::get('/{userName}/projects', [ProjectController::class, 'index']);
    Route::get('/projects/{projectId}/endpoints', [EndpointsController::class, 'index']);
    Route::get('/endpoints/fields', [EndpointFieldController::class, 'index']);
    Route::get('/endpoints/fields/values', [FieldValueController::class, 'index']);

});

//App
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
