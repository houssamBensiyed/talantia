<?php

namespace App\Livewire;

use App\Models\JobOffer;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;

class JobOfferList extends Component
{
    #[Url]
    public string $search = '';

    #[Url]
    public string $specialty = '';

    #[Url]
    public string $contractType = '';

    #[Url]
    public string $location = '';

    public int $perPage = 9;

    public function onScroll()
    {
        // Check if we're near the bottom of the page
        if ($this->hasMorePages) {
            $this->loadMore();
        }
    }

    public function loadMore()
    {
        if ($this->hasMorePages) {
            $this->perPage += 9;
        }
    }

    public function updatingSearch()
    {
        $this->perPage = 9;
    }

    public function updatingSpecialty()
    {
        $this->perPage = 9;
    }

    public function updatingContractType()
    {
        $this->perPage = 9;
    }

    public function updatingLocation()
    {
        $this->perPage = 9;
    }

    public function clearFilters()
    {
        $this->reset(['search', 'specialty', 'contractType', 'location']);
        $this->perPage = 9;
    }

    #[Computed]
    public function jobs()
    {
        $query = JobOffer::with('recruiter')->open();

        if ($this->search) {
            $search = $this->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('company', 'like', "%{$search}%");
            });
        }

        if ($this->specialty) {
            $query->where('specialty', $this->specialty);
        }

        if ($this->contractType) {
            $query->where('contract_type', $this->contractType);
        }

        if ($this->location) {
            $query->where('location', 'like', "%{$this->location}%");
        }

        return $query->latest()->take($this->perPage)->get();
    }

    #[Computed]
    public function totalJobs()
    {
        $query = JobOffer::open();

        if ($this->search) {
            $search = $this->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('company', 'like', "%{$search}%");
            });
        }

        if ($this->specialty) {
            $query->where('specialty', $this->specialty);
        }

        if ($this->contractType) {
            $query->where('contract_type', $this->contractType);
        }

        if ($this->location) {
            $query->where('location', 'like', "%{$this->location}%");
        }

        return $query->count();
    }

    #[Computed]
    public function hasMorePages()
    {
        return $this->perPage < $this->totalJobs;
    }

    #[Computed]
    public function specialties()
    {
        return JobOffer::open()
            ->whereNotNull('specialty')
            ->distinct()
            ->pluck('specialty')
            ->filter()
            ->sort();
    }

    #[Computed]
    public function locations()
    {
        return JobOffer::open()
            ->whereNotNull('location')
            ->distinct()
            ->pluck('location')
            ->filter()
            ->sort();
    }

    public function render()
    {
        return view('livewire.job-offer-list');
    }
}
