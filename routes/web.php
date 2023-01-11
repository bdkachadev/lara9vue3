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
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AttributeController;
use App\Http\Controllers\AttributeValueController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\CustomTaxonomyController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TaxonomyAttributeController;
use App\Http\Controllers\ProductImageController;



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
        Route::post('/orders/changeStatus', [OrderController::class, "changeStatus"])->name('orders.changeStatus');
        Route::post('/orders/cancelOrder', [OrderController::class, "cancelOrder"])->name('orders.cancelOrder');

        Route::post('/general/onChangeAttribute', [GeneralController::class, 'onChangeAttribute'])->name('general.onChangeAttribute');
        Route::post('/general/checkAttributeValue', [GeneralController::class, 'checkAttributeValue'])->name('general.checkAttributeValue');
        // Route::post('/general/onChangeAttributeValue', [GeneralController::class, 'onChangeAttributeValue'])->name('general.onChangeAttributeValue');

        Route::post('/general/getNameOfAttribute', [GeneralController::class, 'getNameOfAttribute'])->name('general.getNameOfAttribute');
        Route::post('/general/onChangeVariant', [GeneralController::class, 'onChangeVariant'])->name('general.onChangeVariant');

        Route::post('/general/getAttributeName', [GeneralController::class, 'getAttributeName'])->name('general.getAttributeName');

        Route::post('/general/getSubCatObject', [GeneralController::class, 'getSubCatObject'])->name('general.getSubCatObject');
        Route::post('/general/getSubBrandObject', [GeneralController::class, 'getSubBrandObject'])->name('general.getSubBrandObject');

        Route::post('/general/getPermissionsList', [GeneralController::class, 'getPermissionsList'])->name('general.getPermissionsList');
        Route::post('/products/updateProduct', [ProductController::class, "updateProduct"])->name("products.updateProduct");


        Route::resource('/users', UserController::class);
        Route::resource('/roles', RoleController::class);
        Route::resource('/permissions', PermissionController::class);
        Route::resource('/products', ProductController::class);
        Route::resource('/carts', CartController::class);
        Route::resource('/orders', OrderController::class);
        Route::resource('/categories', CategoryController::class);
        Route::resource('/brands', BrandController::class);
        Route::resource('/attributes', AttributeController::class);
        Route::resource('/attributesValue', AttributeValueController::class);
        Route::resource('/customTaxonomy', CustomTaxonomyController::class);
        Route::resource('/tags', TagController::class);
        Route::resource('/taxonomyAttribute', TaxonomyAttributeController::class);
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
