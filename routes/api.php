<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductGaleryController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransactionDetailController;
use App\Http\Controllers\SettingController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});




// ----ADDRESS---- //
Route::prefix('address')->controller(AddressController::class)->group(function () {
    Route::get('/', 'index');
});

// ----AUTHENTICATION---- //
Route::prefix('auth')->controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::get('/logout', 'logout')->middleware('auth:sanctum');
});

// ----PROFILE---- //
Route::prefix('profile')->controller(UserController::class)->middleware('auth:sanctum')->group(function () {
    Route::get('/', 'profile');
    Route::put('/edit', 'editprofile');
    Route::post('/edit/avatar', 'editprofileavatar');
});

// ----USER---- //
Route::prefix('user')->controller(UserController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/dashboard', 'index')->middleware('auth:sanctum', 'admin');
    Route::get('/{user:username}', 'show');
    Route::post('/', 'store')->middleware('auth:sanctum', 'admin');
    Route::post('/{user}', 'update')->middleware('auth:sanctum', 'admin');
    Route::post('/{user}/avatar', 'updateavatar')->middleware('auth:sanctum');
    Route::delete('/{user}', 'destroy')->middleware('auth:sanctum', 'admin');
});

// ----CATEGORY---- //
Route::prefix('category')->controller(CategoryController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/dashboard', 'index')->middleware('auth:sanctum', 'mitra');
    Route::get('/{category:slug}', 'show');
    Route::post('/', 'store')->middleware('auth:sanctum', 'mitra');
    Route::put('/{category}', 'update')->middleware('auth:sanctum', 'mitra');
    Route::delete('/{category}', 'destroy')->middleware('auth:sanctum', 'mitra');
});

// ----PRODUCT---- //
Route::prefix('product')->controller(ProductController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/dashboard', 'dashboard')->middleware('auth:sanctum', 'mitra');
    Route::get('/{product:slug}', 'show');
    Route::post('/', 'store')->middleware('auth:sanctum', 'mitra');
    Route::post('/{product}', 'update')->middleware('auth:sanctum', 'mitra');
    Route::delete('/{product}', 'destroy')->middleware('auth:sanctum', 'mitra');
});

// ----PRODUCTGALERY---- //
Route::prefix('productgalery')->controller(ProductGaleryController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/dashboard', 'index')->middleware('auth:sanctum', 'mitra');
    Route::get('/{productgalery}', 'show');
    Route::post('/', 'store')->middleware('auth:sanctum', 'mitra');
    Route::post('/{productgalery}', 'update')->middleware('auth:sanctum', 'mitra');
    Route::delete('/{productgalery}', 'destroy')->middleware('auth:sanctum', 'mitra');
});

// ----PROMOTION---- //
Route::prefix('promotion')->controller(PromotionController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/dashboard', 'index')->middleware('auth:sanctum', 'mitra');
    Route::get('/{promotion}', 'show');
    Route::post('/', 'store')->middleware('auth:sanctum', 'mitra');
    Route::post('/{promotion}', 'update')->middleware('auth:sanctum', 'mitra');
    Route::delete('/{promotion}', 'destroy')->middleware('auth:sanctum', 'mitra');
});

// ----CART---- //
Route::prefix('cart')->controller(CartController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/dashboard', 'index')->middleware('auth:sanctum', 'mitra');
    Route::get('/user', 'getbyuser')->middleware('auth:sanctum');
    Route::get('/{cart}', 'show');
    Route::post('/', 'store')->middleware('auth:sanctum');
    Route::put('/{cart}', 'update')->middleware('auth:sanctum');
    Route::delete('/{cart}', 'destroy')->middleware('auth:sanctum');
});

// ----TRANSACTION---- //
Route::prefix('transaction')->controller(TransactionController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/dashboard', 'dashboard')->middleware('auth:sanctum', 'mitra');
    Route::get('/user', 'getbyuser')->middleware('auth:sanctum');
    Route::get('/{transaction:invoice}', 'show');
    Route::post('/', 'store')->middleware('auth:sanctum');
    Route::post('/ongkir', 'ongkir')->middleware('auth:sanctum');
    Route::put('/{transaction}', 'update')->middleware('auth:sanctum');
    Route::put('/updateshipping/{transaction}', 'updateshipping')->middleware('auth:sanctum');
    Route::delete('/{transaction}', 'destroy')->middleware('auth:sanctum');
});

// ----TRANSACTIONDETAIL---- //
Route::prefix('transactiondetail')->controller(TransactionDetailController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('/dashboard', 'index')->middleware('auth:sanctum', 'mitra');
    Route::get('/{transactiondetail}', 'show');
    Route::post('/', 'store')->middleware('auth:sanctum');
    Route::put('/{transactiondetail}', 'update')->middleware('auth:sanctum');
    Route::delete('/{transactiondetail}', 'destroy')->middleware('auth:sanctum');
});

// ----SETTING---- //
Route::prefix('setting')->controller(SettingController::class)->group(function () {
    Route::get('/', 'index')->middleware('auth:sanctum', 'mitra');
    Route::get('/configuration', 'show');
    Route::get('/dashboard', 'show')->middleware('auth:sanctum', 'admin');
    Route::put('/', 'update')->middleware('auth:sanctum', 'admin');
});
