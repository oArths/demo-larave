<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\AuthJwtController;


Route::prefix('Auth')->group(function(){
    // Route::get('/users', [UserController::class, 'index']);
    // Route::get('/users/{user}', [UserController::class, 'show']);
    // Route::put('/users/{user}', [UserController::class, 'update']);
    // Route::post('/users/create', [UserController::class, 'store']);
    // Route::delete('/users/delete/{user?}', [UserController::class, 'destroy']);
    Route::resource('users', UserController::class);
    Route::post('user/create-token', [AuthJwtController::class, 'Create_Jwt']);
});
