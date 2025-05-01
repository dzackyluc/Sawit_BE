<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\auth\authController;
use App\Http\Controllers\Api\artikelController;
use App\Http\Controllers\Api\pengepulController;
use App\Http\Controllers\Api\janjitemuController;
use App\Http\Controllers\Api\daftarhargaController;
use App\Http\Controllers\Api\taskController;
use App\Http\Controllers\Api\FcmTokenController;
use App\Http\Controllers\Api\transaksiController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login',    [AuthController::class, 'login']);

Route::resource('users', UserController::class);
Route::resource('artikel', artikelController::class);
Route::resource('pengepul', pengepulController::class);
// Route::post('/pengepul', [PengepulController::class, 'store']);

Route::post('pengepul/import', [pengepulController::class, 'import']);
Route::apiResource('janji-temu', JanjiTemuController::class)->only(['index', 'store','show','update','destroy']);
Route::post('janji-temu/{id}/approve', [JanjiTemuController::class, 'approve']);
Route::post('janji-temu/{id}/reject', [JanjiTemuController::class, 'reject']);
Route::resource('daftar_harga', daftarhargaController::class);
Route::resource('task', taskController::class);
Route::resource('transaksi', transaksiController::class);
Route::post('/fcm-token/update', [FcmTokenController::class, 'update']);


Route::middleware('auth:sanctum')->group(function () {

});






