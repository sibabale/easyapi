<?php

use Inertia\Inertia;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\EndpointsController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});


// Route::middleware([])->group(function () {
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
    Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
    Route::get('/projects/{id}', [ProjectController::class, 'show'])->name('projects.show');
    Route::get('/projects/{id}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
    Route::put('/projects/{id}', [ProjectController::class, 'update'])->name('projects.update');
    Route::delete('/projects/{id}', [ProjectController::class, 'destroy'])->name('projects.destroy');
// });

// Route::middleware([])->group(function () {
    Route::post('/endpoints/create', [EndpointsController::class, 'create'])->name('endpoints.create');
    Route::put('/endpoints/{endpoint}', [EndpointsController::class, 'update'])->name('endpoints.update');
    Route::delete('/endpoints/{endpoint}', [EndpointsController::class, 'destroy'])->name('endpoints.delete');

    Route::get('/projects/{projectId}/endpoints', [EndpointsController::class, 'index'])->name('endpoints.index');
    Route::post('/projects/{projectId}/endpoints', [EndpointsController::class, 'store'])->name('endpoints.store');

    Route::get('projects/{projectId}/endpoints/{endpointId}', [EndpointsController::class, 'show'])->name('endpoints.show');
// });
