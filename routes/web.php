<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\CharacterController;
use App\Http\Controllers\User\LearningController;
use Illuminate\Support\Facades\Route;


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

Route::get('/', function () {
    return view('welcome');
});

// admin
Route::middleware(['auth', 'admin'])->group(function() {
    Route::get('/admin', function() {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::resource('/admin/characters', CharacterController::class)->names('admin.characters');
    });


// user
Route::get('dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])
->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/learn', [LearningController::class, 'index'])->name('learn');
    Route::get('/learn/{character}', [LearningController::class, 'show'])->name('learn.show');
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
