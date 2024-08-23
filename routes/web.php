<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InstructorController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})
    ->middleware(['auth', 'verified', 'role:user'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('/admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'adminDashboard'])
        ->name('admin.dashboard');
    Route::get('/login', [AdminController::class, 'login'])
        ->name('admin.login');
    Route::get('/profile', [AdminController::class, 'profile'])
        ->name('admin.profile');
    Route::get('/profile/change_password', [AdminController::class, 'changePassword'])
        ->name('admin.profile.change_password');
    Route::put('/profile/change_password', [AdminController::class, 'updatePassword'])
        ->name('admin.profile.update_password');
    Route::post('/profile', [AdminController::class, 'profileStore'])
        ->name('admin.profile.store');
    Route::post('/login', [AdminController::class, 'auth'])
        ->name('admin.auth');
    Route::delete('/logout', [AdminController::class, 'logout'])
        ->name('admin.logout');
});


Route::prefix('/instructor')->group(function () {
    Route::get('/dashboard', [InstructorController::class, 'instructorDashboard'])
        ->name('instructor.dashboard');
    Route::get('/login', [InstructorController::class, 'login'])
        ->name('instructor.login');
    Route::post('/login', [InstructorController::class, 'auth'])
        ->name('instructor.auth');
    Route::delete('/logout', [InstructorController::class, 'logout'])
        ->name('instructor.logout');
    Route::get('/profile', [InstructorController::class, 'profile'])
        ->name('instructor.profile');
    Route::get('/profile/change_password', [InstructorController::class, 'changePassword'])
        ->name('instructor.profile.change_password');
    Route::put('/profile/change_password', [InstructorController::class, 'updatePassword'])
        ->name('instructor.profile.update_password');
    Route::post('/profile', [InstructorController::class, 'profileStore'])
        ->name('instructor.profile.store');
});


require __DIR__.'/auth.php';
