<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\CharacterController;
use App\Http\Controllers\LearningController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\AudioController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\TwoFactorController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;


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

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');
    
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    
    // 2FA маршруты
    Route::get('two-factor/verify', [TwoFactorController::class, 'showVerifyForm'])
        ->name('two-factor.verify');
    
    Route::post('two-factor/verify', [TwoFactorController::class, 'verify'])
        ->name('two-factor.verify');
    
    Route::post('two-factor/resend', [TwoFactorController::class, 'resend'])
        ->name('two-factor.resend');
});

// Главный дашборд
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
});

// Админка 
Route::middleware(['auth', 'verified'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'adminIndex'])->name('admin.dashboard');
    Route::resource('/characters', CharacterController::class)->names('admin.characters');
});



// Обучение иероглифам
Route::middleware(['auth'])->prefix('learn')->group(function () {
    // Генерация и сохранение аудио иероглифа
Route::post('/audio/character/{characterId}', [AudioController::class, 'generateCharacterAudio']);

// Генерация и сохранение аудио для примера
Route::post('/audio/example/{characterId}', [AudioController::class, 'generateExampleAudio']);

// Получение Base64 для иероглифа (без сохранения)
Route::get('/audio/character/{characterId}/base64', [AudioController::class, 'getCharacterBase64']);

// Получение Base64 для примера (без сохранения)
Route::get('/audio/example/{characterId}/base64', [AudioController::class, 'getExampleBase64']);
    Route::get('/', [LearningController::class, 'selectLevel'])->name('learning.select-level');
    Route::get('/review/due', [LearningController::class, 'dueReview'])->name('learning.review.due');
    Route::get('/collection/{collection}/level', [LearningController::class, 'showCollectionLevel'])->name('learning.collection.level');
    Route::get('/collection/{collection}/character/{character}', [LearningController::class, 'showInCollection'])->name('learning.collection.show');
    Route::get('/level/{level}', [LearningController::class, 'showLevel'])->name('learning.level');
    Route::get('/character/{character}', [LearningController::class, 'show'])->name('learning.show');
    Route::get('/character/{character}/panel', [LearningController::class, 'characterPanel'])->name('learning.panel');
    Route::get('/character/{character}/options', [LearningController::class, 'getMultipleChoiceOptions'])->name('learning.options');
    Route::post('/character/{character}/practice', [LearningController::class, 'submitPractice'])->name('learning.practice');
});

// Повторение (SRS)
Route::middleware(['auth'])->prefix('review')->name('review.')->group(function () {
    Route::get('/', [ReviewController::class, 'selectLevel'])->name('select-level');
    Route::get('review/show', [ReviewController::class, 'show'])->name('show');
    Route::post('/submit/{userCharacter}', [ReviewController::class, 'submitResult'])->name('submit');
    Route::post('/check/{userCharacter}', [ReviewController::class, 'checkAnswer'])->name('check');
    Route::get('/hsk/{level}', [ReviewController::class, 'showReview'])->name('hsk');
});

Route::middleware(['auth'])->prefix('collections')->name('collections.')->group(function () {
    Route::get('/', [CollectionController::class, 'index'])->name('index');
    Route::get('/create', [CollectionController::class, 'create'])->name('create');
    Route::post('/', [CollectionController::class, 'store'])->name('store');
    Route::get('/{collection}/characters/search', [CollectionController::class, 'searchCharacters'])->name('characters.search');
    Route::get('/{collection}', [CollectionController::class, 'show'])->name('show');
    Route::get('/{collection}/edit', [CollectionController::class, 'edit'])->name('edit');
    Route::put('/{collection}', [CollectionController::class, 'update'])->name('update');
    Route::delete('/{collection}', [CollectionController::class, 'destroy'])->name('destroy');
    
    // Работа с иероглифами в коллекции
    Route::post('/{collection}/characters', [CollectionController::class, 'addCharacter'])->name('add-character');
    Route::post('/{collection}/characters/multiple', [CollectionController::class, 'addMultipleCharacters'])->name('add-multiple-characters');
    Route::delete('/{collection}/characters/{character}', [CollectionController::class, 'removeCharacter'])->name('remove-character');
    
    // Повторение коллекции
    Route::get('/{collection}/review', [CollectionController::class, 'review'])->name('review');
});

// Профиль
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Устаревшие маршруты для обратной совместимости
Route::middleware(['auth'])->group(function () {
    Route::get('/learn-old', [LearningController::class, 'selectLevel'])->name('learn.old');
    
    // Старые маршруты коллекций из DashboardController
    Route::post('/collection/create', [DashboardController::class, 'createCollection'])->name('collection.create');
    Route::delete('/collection/{id}', [DashboardController::class, 'deleteCollection'])->name('collection.delete');
});

require __DIR__.'/auth.php';
