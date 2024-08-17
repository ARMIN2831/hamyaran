<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\classStudentController;
use App\Http\Controllers\ConveneController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\InstituteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('dashboard')->middleware('checkLogin')->group(function () {
    Route::get('/', function () {
        return view('layouts.app');
    })->name('dashboard');
    Route::resource('users', UserController::class)->except('show');
    Route::resource('roles', RoleController::class)->except('show');
    Route::resource('convenes', ConveneController::class)->except('show');
    Route::resource('courses', CourseController::class)->except('show');
    Route::resource('classrooms', ClassroomController::class)->except('show');
    Route::resource('institutes', InstituteController::class)->except('show');
    Route::resource('students', StudentController::class)->except('show');
    Route::resource('activities', ActivityController::class)->except('show');
    Route::resource('classStudents', classStudentController::class)->only('index','edit','store');
    Route::delete('classStudents/{classroom}/{student}', [ClassStudentController::class, 'destroy'])->name('classStudents.destroy');

    Route::get('/students/search', [ActivityController::class, 'search'])->name('students.search');
    Route::get('/classStudents/searchStudent', [classStudentController::class, 'searchStudent'])->name('classStudents.searchStudent');
    Route::get('/classStudents/searchClass', [classStudentController::class, 'searchClass'])->name('classStudents.searchClass');
    Route::get('logout', [UserController::class, 'logout'])->name('logout')->middleware('checkLogin');

    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('profile/password', [ProfileController::class, 'password'])->name('profile.password');
    Route::post('profile/changePassword', [ProfileController::class, 'changePassword'])->name('profile.changePassword');

    Route::get('setting/setdata', [SettingController::class, 'setdata'])->name('setting.setdata');
    Route::post('setting/setdata/update', [SettingController::class, 'update'])->name('setting.update');
    Route::get('/setting/db', [SettingController::class, 'index'])->name('backup.index');
    Route::get('/setting/db/set', [SettingController::class, 'create'])->name('backup.create');
    Route::post('/setting/db/upload', [SettingController::class, 'upload'])->name('backup.upload');
    Route::get('/setting/db/download/{filename}', [SettingController::class, 'download'])->name('backup.download');
    Route::get('/setting/db/restore/{filename}', [SettingController::class, 'restore'])->name('backup.restore');
    Route::get('/setting/db/delete/{filename}', [SettingController::class, 'delete'])->name('backup.delete');
});
Route::get('login', [UserController::class, 'loginIndex'])->name('loginIndex')->middleware('logged');
Route::post('login', [UserController::class, 'login'])->name('login')->middleware('logged');

