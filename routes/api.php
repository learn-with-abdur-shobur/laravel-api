<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PostController;
use Illuminate\Support\Facades\Route;

Route::post( 'signup', [AuthController::class, 'signup'] );
Route::post( 'login', [AuthController::class, 'login'] );
Route::post( 'logout', [AuthController::class, 'logout'] )->middleware( 'auth:sanctum' );

Route::get( 'post', [PostController::class, 'index'] );
Route::post( 'post', [PostController::class, 'store'] );
