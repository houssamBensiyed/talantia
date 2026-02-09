<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    /**
     * Display the search page with results.
     */
    public function index(Request $request): View
    {
        $query = User::query();

        // Search by name
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        // Search by specialty
        if ($request->filled('specialty')) {
            $query->where('specialty', 'like', '%' . $request->specialty . '%');
        }

        // Filter by user type
        if ($request->filled('user_type') && in_array($request->user_type, ['recruiter', 'job_seeker'])) {
            $query->where('user_type', $request->user_type);
        }

        // Exclude current user from results
        $query->where('id', '!=', auth()->id());

        // Order by name
        $query->orderBy('name');

        $users = $query->paginate(12)->withQueryString();

        return view('search.index', compact('users'));
    }

    /**
     * Display a user's public profile.
     */
    public function show(User $user): View
    {
        // Eager load relationships for profile display
        $user->load(['candidateProfile.skills', 'candidateProfile.experiences', 'jobOffers']);
        
        return view('search.show', compact('user'));
    }
}
