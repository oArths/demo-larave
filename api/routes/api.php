<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\UserController;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('Auth')->group( function(){

    Route::get('/user', [UserController::class, 'index'] );
    Route::get('/user/{user}', [UserController::class, 'show'] );
}
);
