<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthenticationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminController;

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

Route::prefix('admin')->group(function () {
    Route::get('/login', [AuthenticationController::class, 'showLoginForm']);
    Route::post('login', [AuthenticationController::class, 'login'])->name('login.submit');

    Route::middleware(['auth'])->group(function () {
        Route::get('dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
        Route::get('course', [AdminController::class, 'showCourse']);
        Route::post('add-course', [AdminController::class, 'addCourse']);
    });
});

Route::get('student/dashboard', [AuthenticationController::class, 'studentDashboard'])->name('student.dashboard');

