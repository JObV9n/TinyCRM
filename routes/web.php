<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
use App\RoleEnum;
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function (): void {
    // User Controller route
    Route::resource('users', UserController::class)->middleware( ['role:'.RoleEnum::ADMIN->value]);    
    
    //routes for clients
    Route::resource('clients', ClientController::class);

    //routes for Projects
    Route::resource('projects', ProjectController::class);

    //routes for Tasks
    Route::resource('tasks', TaskController::class);

    // Profile Controller route
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
