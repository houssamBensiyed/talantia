<?php

namespace App\Http\Controllers;

use App\Models\JobOffer;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class JobOfferController extends Controller
{
    /**
     * Display a listing of open job offers.
     */
    public function index(Request $request): View
    {
        $query = JobOffer::with('recruiter')->open();

        // Filter by specialty
        if ($request->filled('specialty')) {
            $query->where('specialty', 'like', '%' . $request->specialty . '%');
        }

        // Filter by contract type
        if ($request->filled('contract_type')) {
            $query->where('contract_type', $request->contract_type);
        }

        // Filter by location
        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        // Search by title or description
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('company', 'like', "%{$search}%");
            });
        }

        $jobs = $query->latest()->paginate(12)->withQueryString();

        return view('jobs.index', compact('jobs'));
    }

    /**
     * Display the specified job offer.
     */
    public function show(JobOffer $job): View
    {
        $job->load('recruiter', 'applications.applicant');
        
        $hasApplied = false;
        if (auth()->check() && auth()->user()->isJobSeeker()) {
            $hasApplied = $job->hasApplicant(auth()->user());
        }

        return view('jobs.show', compact('job', 'hasApplied'));
    }

    /**
     * Show the form for creating a new job offer.
     */
    public function create(): View
    {
        return view('jobs.create');
    }

    /**
     * Store a newly created job offer.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'company' => 'required|string|max:255',
            'contract_type' => 'required|in:CDI,CDD,Full-time,Stage,Freelance',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'specialty' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:255',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('job-images', 'public');
        }

        $request->user()->jobOffers()->create($validated);

        return redirect()->route('jobs.my')
            ->with('status', 'Offre d\'emploi créée avec succès!');
    }

    /**
     * Show the form for editing the job offer.
     */
    public function edit(JobOffer $job): View
    {
        // Authorization check
        if ($job->user_id !== auth()->id()) {
            abort(403);
        }

        return view('jobs.edit', compact('job'));
    }

    /**
     * Update the specified job offer.
     */
    public function update(Request $request, JobOffer $job): RedirectResponse
    {
        // Authorization check
        if ($job->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'company' => 'required|string|max:255',
            'contract_type' => 'required|in:CDI,CDD,Full-time,Stage,Freelance',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'specialty' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:255',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if it's a local file
            if ($job->image && !str_starts_with($job->image, 'http')) {
                Storage::disk('public')->delete($job->image);
            }
            $validated['image'] = $request->file('image')->store('job-images', 'public');
        }

        $job->update($validated);

        return redirect()->route('jobs.my')
            ->with('status', 'Offre d\'emploi mise à jour!');
    }

    /**
     * Close the job offer.
     */
    public function close(JobOffer $job): RedirectResponse
    {
        // Authorization check
        if ($job->user_id !== auth()->id()) {
            abort(403);
        }

        $job->close();

        return back()->with('status', 'Offre d\'emploi clôturée.');
    }

    /**
     * Reopen the job offer.
     */
    public function reopen(JobOffer $job): RedirectResponse
    {
        // Authorization check
        if ($job->user_id !== auth()->id()) {
            abort(403);
        }

        $job->reopen();

        return back()->with('status', 'Offre d\'emploi réouverte.');
    }

    /**
     * Display the recruiter's job offers.
     */
    public function myJobs(Request $request): View
    {
        $jobs = $request->user()->jobOffers()
            ->withCount('applications')
            ->latest()
            ->paginate(10);

        return view('jobs.my', compact('jobs'));
    }

    /**
     * Delete a job offer.
     */
    public function destroy(JobOffer $job): RedirectResponse
    {
        // Authorization check
        if ($job->user_id !== auth()->id()) {
            abort(403);
        }

        // Delete image if local
        if ($job->image && !str_starts_with($job->image, 'http')) {
            Storage::disk('public')->delete($job->image);
        }

        $job->delete();

        return redirect()->route('jobs.my')
            ->with('status', 'Offre d\'emploi supprimée.');
    }
}
