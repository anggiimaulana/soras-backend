<?php

use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\HistoryController;
use App\Http\Controllers\Web\ProfileController;
use App\Http\Controllers\Web\RecommendationController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ExerciseController;
use App\Http\Controllers\Admin\ComplaintController;
use App\Http\Controllers\Admin\GoalController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use Illuminate\Support\Facades\Route;

// ─── Public ───────────────────────────────────────────────────
Route::get('/', function () {
    return view('pages.landing');
})->name('landing');

// ─── Auth ─────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('login',     [AuthController::class, 'showLogin'])->name('login');
    Route::post('login',    [AuthController::class, 'login']);
    Route::get('register',  [AuthController::class, 'showRegister'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
});

Route::post('logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ─── User (perlu login) ───────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('profile',  [ProfileController::class, 'index'])->name('profile.index');
    Route::post('profile', [ProfileController::class, 'store'])->name('profile.store');
    Route::put('profile',  [ProfileController::class, 'update'])->name('profile.update');

    // Recommendation
    Route::get('recommendation',         [RecommendationController::class, 'create'])->name('recommendation.create');
    Route::post('recommendation',        [RecommendationController::class, 'generate'])->name('recommendation.generate');
    Route::get('recommendation/{id}',    [RecommendationController::class, 'result'])->name('recommendation.result');

    // History
    Route::get('history', [HistoryController::class, 'index'])->name('history.index');
});

// ─── Admin ────────────────────────────────────────────────────
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Exercises
        Route::get('exercises',             [ExerciseController::class, 'index'])->name('exercises.index');
        Route::get('exercises/{id}/edit',   [ExerciseController::class, 'edit'])->name('exercises.edit');
        Route::put('exercises/{id}',        [ExerciseController::class, 'update'])->name('exercises.update');

        // Complaints matrix
        Route::get('complaints',            [ComplaintController::class, 'index'])->name('complaints.index');
        Route::put('complaints/{id}/score', [ComplaintController::class, 'updateScore'])->name('complaints.updateScore');

        // Goals matrix
        Route::get('goals',                 [GoalController::class, 'index'])->name('goals.index');
        Route::put('goals/{id}/score',      [GoalController::class, 'updateScore'])->name('goals.updateScore');

        // Users (read-only)
        Route::get('users',      [AdminUserController::class, 'index'])->name('users.index');
        Route::get('users/{id}', [AdminUserController::class, 'show'])->name('users.show');
    });
