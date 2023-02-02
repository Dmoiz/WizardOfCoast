<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\CollectionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/user')->group(function() {
    Route::put('/create', [UserController::class, 'create']);
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/recover', [UserController::class, 'recover_password']);
});

Route::prefix('/card')->group(function() {
    Route::put('/create', [CardController::class, 'create'])->middleware('auth:sanctum', 'ability:Administrador');
});

Route::prefix('/collection')->group(function() {
    Route::put('/create', [CollectionController::class, 'create']);
});
