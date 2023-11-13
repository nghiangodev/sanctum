<?php

use App\Http\Controllers\LoginController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user',[LoginController::class,'getUser']);

Route::prefix('v1')->group(function (){
    // Login
    Route::get('/login', [LoginController::class, 'login'])->name('login');

// Logout
    Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');

});
