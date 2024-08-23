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
    Route::post('/login', [AdminController::class, 'auth'])
        ->name('admin.auth');
    Route::delete('/logout', [AdminController::class, 'logout'])
        ->name('admin.logout');
});
Route::get('/instructor/dashboard', [InstructorController::class, 'instructorDashboard'])->name('instructor.dashboard');


require __DIR__.'/auth.php';
