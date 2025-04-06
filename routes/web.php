<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\UserManagementController;


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

    Route::post('/attendance/sign-in', [AttendanceController::class, 'storeSignIn'])
        ->name('attendance.sign-in');

    Route::post('/attendance/sign-out', [AttendanceController::class, 'storeSignOut'])
        ->name('attendance.sign-out');

    Route::get('/attendance/receipt/{sign_in}/{sign_out?}', [AttendanceController::class, 'showReceipt'])
        ->name('attendance.receipt');

    Route::get('/attendance/history', [AttendanceController::class, 'history'])
        ->name('attendance.history')
        ->middleware('permission:view own attendance');

    Route::get('/attendance/employees', [AttendanceController::class, 'viewEmployees'])
        ->name('attendance.employees')
        ->middleware('permission:view employee attendance');

    Route::get('/attendance/view', [AttendanceController::class, 'view'])->name('attendance.view');

});

Route::middleware(['auth', 'can:manage_users'])->group(function () {
    Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserManagementController::class, 'create'])->name('users.create');
    Route::post('/users', [UserManagementController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserManagementController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserManagementController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');
});

require __DIR__.'/auth.php';
