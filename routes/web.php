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
Route::get('/login', [AuthController::class, 'loginView'])->middleware('guest:staff,web'); /// hanya bisa diakses oleh pengguna yang belum login, jangan lupa tambahkan guard staff dan web
Route::post('/login', [AuthController::class, 'login']);

/// Register
Route::view('/register', 'register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register']);

/// Logout
Route::post('/logout', [AuthController::class, 'logout']);

/// Dashboard
/// [Login multiple table] 5. jika menggunakan middleware auth, tambahkan juga nama guard seletah titik dua `:`, agar tidak mental
Route::view('/dashboard', 'dashboard')->middleware('auth:staff,web');
