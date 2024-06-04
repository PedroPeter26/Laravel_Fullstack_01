<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;


Route::get('/', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/verification/notice', function (Request $request) {
    return view('auth.verification', ['email' => $request->query('email')]);
})->name('verification.notice');

Route::post('/verification/verify', [AuthController::class, 'verify'])->name('verification.verify');

//* Rutas protegidas
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::get('/map', [DashboardController::class, 'showMap'])->name('map');
    Route::get('/users/map', [UserController::class, 'showUserMap'])->name('users.map');
});

require __DIR__.'/auth.php';