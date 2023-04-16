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

Route::get('/', function () {
    return view('welcome');
});
// Route::get('/movies' , [\App\Http\Controllers\MovieController::class,'saveInDB_Api']);
Route::get('/movie/{id}' , [\App\Http\Controllers\MovieController::class,'getMovie']);
Route::get('/movie-edit/{id}' , [\App\Http\Controllers\MovieController::class,'getEditMovie']);
Route::post('/edit/{id}' , [\App\Http\Controllers\MovieController::class,'edit']);
Route::delete('/delete/{id}' , [\App\Http\Controllers\MovieController::class,'delete']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
