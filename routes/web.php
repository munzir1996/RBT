<?php

use App\Http\Controllers\ArtistController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SimController;
use App\Models\Song;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'songs' => Song::query()->where('is_active', true)->get(),
    ]);
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    // Route::inertia('dashboard', 'Dashboard')->name('dashboard');
    Route::resource('dashboard', DashboardController::class);
    // Route::get('dashboard/create', [DashboardController::class, 'create'])->name('dashboard.create');
    Route::resource('artists', ArtistController::class);
    Route::resource('sims', SimController::class);
});

require __DIR__.'/settings.php';
