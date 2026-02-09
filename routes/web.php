<?php

use App\Http\Controllers\CandidateProfileController;
use App\Http\Controllers\FriendshipController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\JobOfferController;
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

// ==========================================
// AUTHENTICATED ROUTES
// ==========================================

Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Search routes
    Route::get('/search', [SearchController::class, 'index'])->name('search.index');
    Route::get('/users/{user}', [SearchController::class, 'show'])->name('users.show');

    // ==========================================
    // JOB OFFERS (All authenticated users can view)
    // ==========================================
    Route::get('/jobs', [JobOfferController::class, 'index'])->name('jobs.index');
    Route::get('/jobs/{job}', [JobOfferController::class, 'show'])->name('jobs.show');

    // ==========================================
    // RECRUITER ONLY ROUTES (check user_type)
    // ==========================================
    Route::middleware(['recruiter'])->group(function () {
        Route::get('/recruiter/jobs/create', [JobOfferController::class, 'create'])->name('jobs.create');
        Route::post('/recruiter/jobs', [JobOfferController::class, 'store'])->name('jobs.store');
        Route::get('/recruiter/jobs/{job}/edit', [JobOfferController::class, 'edit'])->name('jobs.edit');
        Route::put('/recruiter/jobs/{job}', [JobOfferController::class, 'update'])->name('jobs.update');
        Route::delete('/recruiter/jobs/{job}', [JobOfferController::class, 'destroy'])->name('jobs.destroy');
        Route::post('/recruiter/jobs/{job}/close', [JobOfferController::class, 'close'])->name('jobs.close');
        Route::post('/recruiter/jobs/{job}/reopen', [JobOfferController::class, 'reopen'])->name('jobs.reopen');
        Route::get('/recruiter/my-jobs', [JobOfferController::class, 'myJobs'])->name('jobs.my');
        Route::get('/recruiter/jobs/{job}/applications', [JobApplicationController::class, 'index'])->name('jobs.applications');
        Route::patch('/recruiter/applications/{application}/status', [JobApplicationController::class, 'updateStatus'])->name('applications.updateStatus');
    });

    // ==========================================
    // JOB SEEKER ONLY ROUTES (check user_type)
    // ==========================================
    Route::middleware(['job_seeker'])->group(function () {
        // Candidate Profile
        Route::get('/candidate/profile', [CandidateProfileController::class, 'index'])->name('candidate.profile.index');
        Route::get('/candidate/profile/create', [CandidateProfileController::class, 'create'])->name('candidate.profile.create');
        Route::post('/candidate/profile', [CandidateProfileController::class, 'store'])->name('candidate.profile.store');
        Route::get('/candidate/profile/edit', [CandidateProfileController::class, 'edit'])->name('candidate.profile.edit');
        Route::put('/candidate/profile', [CandidateProfileController::class, 'update'])->name('candidate.profile.update');

        // Formations
        Route::post('/candidate/formations', [CandidateProfileController::class, 'storeFormation'])->name('candidate.formations.store');
        Route::delete('/candidate/formations/{formation}', [CandidateProfileController::class, 'destroyFormation'])->name('candidate.formations.destroy');

        // Experiences
        Route::post('/candidate/experiences', [CandidateProfileController::class, 'storeExperience'])->name('candidate.experiences.store');
        Route::delete('/candidate/experiences/{experience}', [CandidateProfileController::class, 'destroyExperience'])->name('candidate.experiences.destroy');

        // Skills
        Route::post('/candidate/skills', [CandidateProfileController::class, 'syncSkills'])->name('candidate.skills.sync');

        // Job Applications
        Route::post('/jobs/{job}/apply', [JobApplicationController::class, 'store'])->name('jobs.apply');
        Route::get('/my-applications', [JobApplicationController::class, 'myApplications'])->name('applications.my');
        Route::delete('/applications/{application}', [JobApplicationController::class, 'destroy'])->name('applications.destroy');
    });

    // Application view (both recruiter and applicant can view)
    Route::get('/applications/{application}', [JobApplicationController::class, 'show'])->name('applications.show');

    // ==========================================
    // FRIENDSHIP ROUTES (All authenticated users)
    // ==========================================
    Route::prefix('friends')->group(function () {
        Route::get('/', [FriendshipController::class, 'index'])->name('friends.index');
        Route::post('/request/{user}', [FriendshipController::class, 'sendRequest'])->name('friends.request');
        Route::post('/accept/{friendship}', [FriendshipController::class, 'acceptRequest'])->name('friends.accept');
        Route::post('/reject/{friendship}', [FriendshipController::class, 'rejectRequest'])->name('friends.reject');
        Route::post('/cancel/{friendship}', [FriendshipController::class, 'cancelRequest'])->name('friends.cancel');
        Route::delete('/{user}', [FriendshipController::class, 'removeFriend'])->name('friends.remove');
    });
});

require __DIR__.'/auth.php';
