<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;


Route::post('register', [UsuarioController::class,'register']);
Route::post('login', [UsuarioController::class,'login']);



Route::group(['middeleware'=>['auth:sanctum']], function () {
    Route::get('show', [UsuarioController::class,'show']);
    Route::get('logout', [UsuarioController::class,'logout']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
