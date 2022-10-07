<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;



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

Route::middleware(['auth', 'verified', "role:admin|manager|user"])->group(function () {
    Route::get('/dashboard', [DashboardController::class, "index"])->name("dashboard");
});

Route::middleware(['auth', 'verified', "role:admin"])->group(function () {

    Route::prefix('manage')->name("manage.")->group(function () {
        Route::get('/users', [UserController::class, "index"])->name("users.index");
        Route::get('/roles', [RoleController::class, "index"])->name("roles.index");
        Route::get('/permissions', [PermissionController::class, "index"])->name("permissions.index");
    });
});

Route::prefix('manager')->name('manager.')->middleware(['auth', 'verified', "role:manager"])->group(function () {
});

Route::middleware(['auth', 'verified', "role:user"])->group(function () {
});



require __DIR__ . '/auth.php';
