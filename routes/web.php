<?php

use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::resource('users', UserController::class)->except('show');
Route::resource('permissions', RoleController::class)->except('show','destroy');


