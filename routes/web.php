<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VotingController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CandidateController;

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Voting Routes
    Route::get('/voting', [VotingController::class, 'index'])->name('voting.index');
    Route::post('/voting', [VotingController::class, 'store'])->name('voting.store');

    // Admin Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/results', [AdminController::class, 'results'])->name('results');
        Route::get('/reports', [ReportController::class, 'index'])->name('reports');
        Route::get('/users/{user}/login-as', [UserController::class, 'loginAs'])->name('users.login-as');
        Route::get('/users/download-template', [UserController::class, 'downloadTemplate'])->name('users.download-template');
        Route::post('/users/import', [UserController::class, 'import'])->name('users.import');
        Route::resource('users', UserController::class);
        Route::resource('candidates', CandidateController::class);
    });
});

require __DIR__ . '/auth.php';
