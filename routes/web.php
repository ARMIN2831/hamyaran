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
use App\Http\Controllers\TicketController;
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
    Route::resource('tickets', TicketController::class)->except('show');
    Route::resource('classStudents', classStudentController::class)->only('index','edit','store');

    Route::get('tickets/manage', [TicketController::class,'manage'])->name('tickets.manage');

    Route::delete('classStudents/{classroom}/{student}', [ClassStudentController::class, 'destroy'])->name('classStudents.destroy');
    Route::get('/students/search', [ActivityController::class, 'search'])->name('students.search');
    Route::get('/classStudents/searchStudent', [classStudentController::class, 'searchStudent'])->name('classStudents.searchStudent');
    Route::get('/classStudents/searchClass', [classStudentController::class, 'searchClass'])->name('classStudents.searchClass');


    Route::get('logout', [UserController::class, 'logout'])->name('logout')->middleware('checkLogin');


    Route::prefix('profile')->group(function () {
        Route::get('edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::post('update', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('password', [ProfileController::class, 'password'])->name('profile.password');
        Route::post('changePassword', [ProfileController::class, 'changePassword'])->name('profile.changePassword');
    });


    Route::prefix('setting')->group(function () {
        Route::get('setdata', [SettingController::class, 'setdata'])->name('setting.setdata');
        Route::post('setdata/update', [SettingController::class, 'update'])->name('setting.update');
        Route::middleware('settingDB')->group(function (){
            Route::get('db', [SettingController::class, 'index'])->name('backup.index');
            Route::get('db/set', [SettingController::class, 'create'])->name('backup.create');
            Route::post('db/upload', [SettingController::class, 'upload'])->name('backup.upload');
            Route::get('db/download/{filename}', [SettingController::class, 'download'])->name('backup.download');
            Route::get('db/restore/{filename}', [SettingController::class, 'restore'])->name('backup.restore');
            Route::get('db/delete/{filename}', [SettingController::class, 'delete'])->name('backup.delete');
        });
    });
});


Route::get('login', [UserController::class, 'loginIndex'])->name('loginIndex')->middleware('logged');
Route::post('login', [UserController::class, 'login'])->name('login')->middleware('logged');

