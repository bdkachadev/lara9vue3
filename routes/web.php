<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\TestController;

use Inertia\Inertia;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\OrderController;


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

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });
Route::get('/test', [TestController::class, 'test']);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, "index"])->name("dashboard");
    Route::prefix('manage')->name("manage.")->group(function () {

        // product detail page
        Route::get('/products/detail/{id}', [ProductController::class, 'detail'])->name('products.detail');


        Route::get('/carts/clearAllCart', [CartController::class, 'clearAllCart'])->name('carts.clearAllCart');
        Route::post('/carts/changeQuantity', [CartController::class, "changeQuantity"])->name("carts.changeQuantity");
        Route::get('/carts/checkout/{id?}', [CartController::class, "checkout"])->name("carts.checkout");
        Route::post('/carts/removeFromCheckout', [CartController::class, "removeFromCheckout"])->name("carts.removeFromCheckout");
        Route::post('/checkout/getStripeSession', [StripeController::class, "getStripeSession"])->name("checkout.getStripeSession");
        Route::post('/checkout/purchase', [StripeController::class, "purchase"])->name('checkout.purchase');

        Route::resource('/users', UserController::class);
        Route::resource('/roles', RoleController::class);
        Route::resource('/permissions', PermissionController::class);
        Route::resource('/products', ProductController::class);
        Route::resource('/carts', CartController::class);
        Route::resource('/orders', OrderController::class);
    });

    // client side routes
    Route::get('/home', [HomeController::class, "index"])->name("home");
    Route::get('/', [HomeController::class, "index"])->name("home");
    Route::get('/getCount', [HomeController::class, "getCount"])->name("getCount");
});

// Route::middleware(['auth', 'verified'])->group(function () {
//     Route::get('/home', [HomeController::class, "index"])->name("home");
// });
require __DIR__ . '/auth.php';
