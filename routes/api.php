<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\auth\authController;
use App\Http\Controllers\Api\ArtikelController;
use App\Http\Controllers\Api\PengepulController;
use App\Http\Controllers\Api\janjitemuController;
use App\Http\Controllers\Api\DaftarHargaController;


Route::post('register', [AuthController::class, 'register']);
Route::post('login',    [AuthController::class, 'login']);

Route::resource('users', UserController::class);
Route::resource('artikel', ArtikelController::class);
Route::resource('pengepul', PengepulController::class);
Route::post('pengepul/import', [PengepulController::class, 'import']);
Route::resource('janji_temu', janjitemuController::class);
Route::resource('daftar_harga', DaftarHargaController::class);

