<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::redirect('/', '/login');

/// Login
Route::get('/login', [AuthController::class, 'loginView'])->middleware('guest'); /// hanya bisa diakses oleh pengguna yang belum login
Route::post('/login', [AuthController::class, 'login']);

/// Register
Route::view('/register', 'register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register']);

/// Logout
Route::post('/logout', [AuthController::class, 'logout']);

/// Dashboard
Route::view('/dashboard', 'dashboard')->middleware('auth');
