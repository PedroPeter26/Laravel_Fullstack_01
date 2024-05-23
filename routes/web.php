<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

Route::get('/', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

//* Rutas protegidas
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->check()) {
            return view('dashboard');
        } else {
            return redirect()->route('login');
        }
    })->name('dashboard');
});


//? Auth Funcs
// Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
// Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
// Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum')->name('logout');
require __DIR__.'/auth.php';