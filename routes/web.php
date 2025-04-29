<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\TaskController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\OrganizationController;

Route::get('/', [PageController::class, 'landing'])->name('pages.landing');
Route::get('/org/{organization:username}', [PageController::class, 'organization'])->name('pages.landing');
Route::get('/{organization:username}/leaderboard', [OrganizationController::class, 'leaderboard'])->name('organizations.leaderboard');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::get('tasks/{task}/submit', [SubmissionController::class, 'create'])->name('submissions.create');
    Route::post('/submissions', [SubmissionController::class, 'store'])->name('submissions.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('tasks', TaskController::class);
});

Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->group(function () {
    Route::get('/submissions', [SubmissionController::class, 'index'])->name('admin.submissions.index');
    Route::post('/submissions/{submission}/approve', [SubmissionController::class, 'approve'])->name('admin.submissions.approve');
    Route::post('/submissions/bulk-approve', [SubmissionController::class, 'bulkApprove'])->name('admin.submissions.bulkApprove');
    Route::resource('organizations', OrganizationController::class)->except(['show']);
});


require __DIR__ . '/auth.php';
