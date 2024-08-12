<?php

use App\Http\Controllers\ConveneController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('dashboard')->middleware('checkLogin')->group(function () {
    Route::get('/', function () {
        return view('layouts.app');
    })->name('dashboard');
    Route::resource('users', UserController::class)->except('show');
    Route::resource('permissions', RoleController::class)->except('show','destroy');
    Route::resource('convenes', ConveneController::class)->except('show');
    Route::get('logout', [UserController::class, 'logout'])->name('logout')->middleware('checkLogin');
});
Route::get('login', [UserController::class, 'loginIndex'])->name('loginIndex')->middleware('logged');
Route::post('login', [UserController::class, 'login'])->name('login')->middleware('logged');

