<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AttendanceController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'permission:add_new_user'])->group(function () {
    Route::get('users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('users', [UserController::class, 'store'])->name('users.store');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/attendance/create', [AttendanceController::class, 'showAttendanceForm'])
        ->name('attendance.create');

    Route::post('/attendance/store', [AttendanceController::class, 'store'])
        ->name('attendance.store');
        // ->middleware('permission:mark_attendance');

    Route::get('/attendance/history', [AttendanceController::class, 'history'])
        ->name('attendance.history')
        ->middleware('permission:view own attendance');

    Route::get('/attendance/employees', [AttendanceController::class, 'viewEmployees'])
        ->name('attendance.employees')
        ->middleware('permission:view employee attendance');
});

require __DIR__.'/auth.php';
