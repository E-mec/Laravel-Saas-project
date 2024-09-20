<?php

use App\Http\Controllers\BackgroundController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CreditController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Feature1Controller;
use App\Http\Controllers\Feature2Controller;
use App\Http\Controllers\DashboardController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::post('/buy-credits/webhook', [CreditController::class, 'webhook'])->name('credit.webhook');

Route::get('/dashboard', [DashboardController::class,  'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    
    

    Route::get('/feature1', [Feature1Controller::class, 'index'])->name('feature1.index');
    Route::post('/feature1', [Feature1Controller::class, 'calculate'])->name('feature1.calculate');

    Route::get('/feature2', [Feature2Controller::class, 'index'])->name('feature2.index');
    Route::post('/feature2', [Feature2Controller::class, 'calculate'])->name('feature2.calculate');

    Route::get('/feature3', [BackgroundController::class, 'index'])->name('feature3.index');
    Route::post('/remove-background', [BackgroundController::class, 'removeBackground'])->name('feature2.removeBackground');

    Route::get('/buy-credits', [CreditController::class, 'index'])->name('credit.index');
    Route::get('/buy-credits/success', [CreditController::class, 'success'])->name('credit.success');
    Route::get('/buy-credits/cancel', [CreditController::class, 'cancel'])->name('credit.canc');

    Route::post('/buy-credits/{package}', [CreditController::class, 'buyCredits'])->name('credit.buy');

});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
