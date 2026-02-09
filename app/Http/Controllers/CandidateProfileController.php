<?php

namespace App\Http\Controllers;

use App\Models\CandidateProfile;
use App\Models\Experience;
use App\Models\Formation;
use App\Models\Skill;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CandidateProfileController extends Controller
{
    /**
     * Display the candidate's CV profile.
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        $profile = $user->candidateProfile()->with(['formations', 'experiences', 'skills'])->first();
        
        return view('candidate.profile.index', compact('profile', 'user'));
    }

    /**
     * Show the form for creating a new candidate profile.
     */
    public function create(): View
    {
        return view('candidate.profile.create');
    }

    /**
     * Store a newly created candidate profile.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $request->user()->candidateProfile()->create($validated);

        return redirect()->route('candidate.profile.index')
            ->with('status', 'Profil créé avec succès!');
    }

    /**
     * Show the form for editing the candidate profile.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        $profile = $user->candidateProfile()->with(['formations', 'experiences', 'skills'])->first();
        $allSkills = Skill::orderBy('name')->get();
        
        return view('candidate.profile.edit', compact('profile', 'user', 'allSkills'));
    }

    /**
     * Update the candidate profile.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $profile = $request->user()->candidateProfile;
        
        if (!$profile) {
            $request->user()->candidateProfile()->create($validated);
        } else {
            $profile->update($validated);
        }

        return redirect()->route('candidate.profile.index')
            ->with('status', 'Profil mis à jour avec succès!');
    }

    // ==========================================
    // FORMATION MANAGEMENT
    // ==========================================

    /**
     * Store a new formation.
     */
    public function storeFormation(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'diploma' => 'required|string|max:255',
            'school' => 'required|string|max:255',
            'graduation_year' => 'required|integer|min:1950|max:' . (date('Y') + 5),
        ]);

        $profile = $request->user()->candidateProfile;
        
        if (!$profile) {
            return back()->with('error', 'Veuillez d\'abord créer votre profil.');
        }

        $profile->formations()->create($validated);

        return back()->with('status', 'Formation ajoutée avec succès!');
    }

    /**
     * Delete a formation.
     */
    public function destroyFormation(Formation $formation): RedirectResponse
    {
        // Check ownership
        if ($formation->candidateProfile->user_id !== auth()->id()) {
            abort(403);
        }

        $formation->delete();

        return back()->with('status', 'Formation supprimée.');
    }

    // ==========================================
    // EXPERIENCE MANAGEMENT
    // ==========================================

    /**
     * Store a new experience.
     */
    public function storeExperience(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'position' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'description' => 'nullable|string',
        ]);

        $profile = $request->user()->candidateProfile;
        
        if (!$profile) {
            return back()->with('error', 'Veuillez d\'abord créer votre profil.');
        }

        $profile->experiences()->create($validated);

        return back()->with('status', 'Expérience ajoutée avec succès!');
    }

    /**
     * Delete an experience.
     */
    public function destroyExperience(Experience $experience): RedirectResponse
    {
        // Check ownership
        if ($experience->candidateProfile->user_id !== auth()->id()) {
            abort(403);
        }

        $experience->delete();

        return back()->with('status', 'Expérience supprimée.');
    }

    // ==========================================
    // SKILL MANAGEMENT
    // ==========================================

    /**
     * Sync skills for the candidate profile.
     */
    public function syncSkills(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'skills' => 'array',
            'skills.*' => 'exists:skills,id',
            'new_skill' => 'nullable|string|max:100',
        ]);

        $profile = $request->user()->candidateProfile;
        
        if (!$profile) {
            return back()->with('error', 'Veuillez d\'abord créer votre profil.');
        }

        // Handle new skill creation
        if (!empty($validated['new_skill'])) {
            $newSkill = Skill::firstOrCreate(['name' => trim($validated['new_skill'])]);
            $validated['skills'][] = $newSkill->id;
        }

        $profile->skills()->sync($validated['skills'] ?? []);

        return back()->with('status', 'Compétences mises à jour!');
    }
}
