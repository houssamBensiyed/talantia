<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $recruiters = User::where('user_type', 'recruiter')
        ->whereNotNull('bio')
        ->latest()
        ->take(6)
        ->get();
    
    return view('welcome', compact('recruiters'));
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Search routes
    Route::get('/search', [SearchController::class, 'index'])->name('search.index');
    Route::get('/users/{user}', [SearchController::class, 'show'])->name('users.show');
});

require __DIR__.'/auth.php';
