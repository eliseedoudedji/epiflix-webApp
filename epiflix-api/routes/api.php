<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::middleware('auth:sanctum')->group(function(){
    
    Route::get('/users', [AuthController::class,'users']);
    Route::get('/users/{id}', [AuthController::class,'oneUser']);
    Route::post('/users/delete/{id}', [AuthController::class,'destroyUser']);
    Route::post('/users/update/{id}', [AuthController::class,'updateUser']);
});



Route::post('/register', [AuthController::class,'register']);
Route::post('/login', [AuthController::class,'login']);