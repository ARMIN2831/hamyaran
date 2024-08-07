<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', function () {
    return view('admin.activity.act-add');
});
Route::prefix('')->name('home.')->group(function () {
    //Route::post('signup', [RegisterController::class, 'register'])->name('register');
});
