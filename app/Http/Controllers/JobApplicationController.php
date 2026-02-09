<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\JobOffer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JobApplicationController extends Controller
{
    /**
     * Apply to a job offer.
     */
    public function store(Request $request, JobOffer $job): RedirectResponse
    {
        $user = $request->user();

        // Check if job is open
        if ($job->is_closed) {
            return back()->with('error', 'Cette offre d\'emploi est clôturée.');
        }

        // Check if already applied
        if ($job->hasApplicant($user)) {
            return back()->with('error', 'Vous avez déjà postulé à cette offre.');
        }

        $validated = $request->validate([
            'cover_letter' => 'nullable|string|max:5000',
        ]);

        JobApplication::create([
            'user_id' => $user->id,
            'job_offer_id' => $job->id,
            'cover_letter' => $validated['cover_letter'] ?? null,
            'status' => 'pending',
        ]);

        return back()->with('status', 'Votre candidature a été envoyée!');
    }

    /**
     * Display the job seeker's applications.
     */
    public function myApplications(Request $request): View
    {
        $applications = $request->user()->applications()
            ->with('jobOffer.recruiter')
            ->latest()
            ->paginate(10);

        return view('applications.my', compact('applications'));
    }

    /**
     * Display applications for a specific job offer (for recruiters).
     */
    public function index(JobOffer $job): View
    {
        // Authorization check
        if ($job->user_id !== auth()->id()) {
            abort(403);
        }

        $applications = $job->applications()
            ->with('applicant.candidateProfile')
            ->latest()
            ->paginate(20);

        return view('applications.index', compact('job', 'applications'));
    }

    /**
     * Update application status (for recruiters).
     */
    public function updateStatus(Request $request, JobApplication $application): RedirectResponse
    {
        // Authorization check - only job owner can update
        if ($application->jobOffer->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,reviewed,accepted,rejected',
        ]);

        $application->update($validated);

        return back()->with('status', 'Statut de la candidature mis à jour.');
    }

    /**
     * View a specific application (for recruiters).
     */
    public function show(JobApplication $application): View
    {
        // Authorization check - job owner or applicant
        $user = auth()->user();
        if ($application->user_id !== $user->id && $application->jobOffer->user_id !== $user->id) {
            abort(403);
        }

        $application->load(['applicant.candidateProfile.formations', 'applicant.candidateProfile.experiences', 'applicant.candidateProfile.skills', 'jobOffer']);

        return view('applications.show', compact('application'));
    }

    /**
     * Withdraw an application (for job seekers).
     */
    public function destroy(JobApplication $application): RedirectResponse
    {
        // Authorization check
        if ($application->user_id !== auth()->id()) {
            abort(403);
        }

        $application->delete();

        return back()->with('status', 'Candidature retirée.');
    }
}
