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
use App\Http\Controllers\UserController;

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
Route::get('/update', function (){
    return view('update');
})->name('update');


Route::post('dashboard',[AuthController::class, 'login'])->name('dashboard');
Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('loginpost', [AuthController::class, 'login'])->name('loginpost');
Route::post('logout',[AuthController::class, 'logout'])->name('logoutpost');

Route::get('/dashboard',[UserController::class, 'index']);
Route::put('update/{id}',[UserController::class, 'update'])->name('updateput');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});


#dentro del dashboard esta en ruta /dashboard pero cuadno cierro sesion me manda al logout pero logout com vista no existe debo mandarlo a la vista de login 