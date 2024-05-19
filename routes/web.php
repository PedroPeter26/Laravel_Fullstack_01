<?php

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

use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/logincred', function (){
    return view('login');
})->name('logincred');

Route::get('/registercred', function () {
    return view('register');
})->name('registercred');

Route::get('/dashboard', function () {
    return view('dashboard');
});


Route::post('dashboard',[AuthController::class, 'login'])->name('dashboard');
Route::post('register', [AuthController::class, 'register'])->name('registerpost');
Route::post('loginpost', [AuthController::class, 'login'])->name('loginpost');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});
