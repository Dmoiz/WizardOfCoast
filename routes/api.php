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
    Route::middleware('request.logging')->put('/create', [UserController::class, 'create']);
    Route::middleware('request.logging')->post('/login', [UserController::class, 'login']);
    Route::middleware('request.logging')->post('/recover', [UserController::class, 'recover_password']);
});

Route::prefix('/card')->group(function() {
    Route::middleware('request.logging')->put('/create', [CardController::class, 'create'])->middleware('auth:sanctum', 'ability:Administrador');
    Route::middleware('request.logging')->get('/search/{name}', [CardController::class, 'searcher']);
    Route::middleware('request.logging')->post('/sell/{id}', [CardController::class, 'sell'])->middleware('auth:sanctum', 'ability:Particular,Profesional');
    Route::middleware('request.logging')->post('/edit/{id}', [CardController::class, 'edit'])->middleware('auth:sanctum', 'ability:Administrador');
    Route::middleware('request.logging')->get('/buy', [CardController::class, 'buy'])->middleware('auth:sanctum', 'ability:Particular,Profesional');
});

Route::prefix('/collection')->group(function() {
    Route::middleware('request.logging')->put('/create', [CollectionController::class, 'create'])->middleware('auth:sanctum', 'ability:Administrador');
    Route::middleware('request.logging')->post('/edit/{id}', [CollectionController::class, 'edit'])->middleware('auth:sanctum', 'ability:Administrador');
});
