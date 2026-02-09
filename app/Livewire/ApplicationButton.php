<?php

namespace App\Livewire;

use App\Models\JobApplication;
use App\Models\JobOffer;
use Livewire\Component;

class ApplicationButton extends Component
{
    public JobOffer $job;
    public bool $hasApplied = false;
    public string $coverLetter = '';
    public bool $showModal = false;

    public function mount(JobOffer $job)
    {
        $this->job = $job;
        $this->refreshStatus();
    }

    public function refreshStatus()
    {
        $user = auth()->user();
        
        if ($user && $user->isJobSeeker()) {
            $this->hasApplied = $this->job->hasApplicant($user);
        }
    }

    public function openModal()
    {
        if (!auth()->check() || !auth()->user()->isJobSeeker()) {
            return redirect()->route('login');
        }

        if ($this->job->is_closed) {
            session()->flash('error', 'Cette offre est clôturée.');
            return;
        }

        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->coverLetter = '';
    }

    public function apply()
    {
        $user = auth()->user();

        if (!$user || !$user->isJobSeeker()) {
            return;
        }

        if ($this->job->is_closed) {
            session()->flash('error', 'Cette offre est clôturée.');
            $this->closeModal();
            return;
        }

        if ($this->hasApplied) {
            session()->flash('error', 'Vous avez déjà postulé.');
            $this->closeModal();
            return;
        }

        $this->validate([
            'coverLetter' => 'nullable|string|max:5000',
        ]);

        JobApplication::create([
            'user_id' => $user->id,
            'job_offer_id' => $this->job->id,
            'cover_letter' => $this->coverLetter ?: null,
            'status' => 'pending',
        ]);

        $this->hasApplied = true;
        $this->closeModal();
        
        $this->dispatch('application-submitted');
        session()->flash('status', 'Candidature envoyée avec succès!');
    }

    public function withdrawApplication()
    {
        $user = auth()->user();

        if (!$user) {
            return;
        }

        $application = JobApplication::where('user_id', $user->id)
            ->where('job_offer_id', $this->job->id)
            ->first();

        if ($application) {
            $application->delete();
            $this->hasApplied = false;
            session()->flash('status', 'Candidature retirée.');
        }
    }

    public function render()
    {
        return view('livewire.application-button');
    }
}
