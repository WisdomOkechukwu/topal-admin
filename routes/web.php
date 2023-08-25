<?php


use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::GET('/login', [LoginController::class,'show'])->name('login');
Route::POST('/login', [LoginController::class,'handle'])->name('login-submit');

Route::GET('/home', [HomeController::class,'home'])->name('home');
