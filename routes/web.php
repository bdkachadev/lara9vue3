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
        Route::get('/users/edit', [UserController::class, "edit"])->name("users.edit");
        Route::post('/users/store', [UserController::class, "store"])->name("users.store");

        Route::get('/roles', [RoleController::class, "index"])->name("roles.index");
        Route::get('/roles/edit', [RoleController::class, "edit"])->name("roles.edit");
        Route::post('/roles/store', [RoleController::class, "store"])->name("roles.store");
        Route::post('/roles/givenPermission', [RoleController::class, "givenPermission"])->name("roles.permissions.given");

        Route::get('/permissions', [PermissionController::class, "index"])->name("permissions.index");
        Route::get('/permissions/edit', [PermissionController::class, "edit"])->name("permissions.edit");
        Route::post('/permissions/store', [PermissionController::class, "store"])->name("permissions.store");
        Route::post('/roles/assignRole', [PermissionController::class, "assignRole"])->name("permissions.roles.assign");
    });
});

Route::prefix('manager')->name('manager.')->middleware(['auth', 'verified', "role:manager"])->group(function () {
});

Route::middleware(['auth', 'verified', "role:user"])->group(function () {
});



require __DIR__ . '/auth.php';
