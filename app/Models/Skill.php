<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    /**
     * Get the candidate profiles that have this skill (Many-to-Many).
     */
    public function candidateProfiles(): BelongsToMany
    {
        return $this->belongsToMany(CandidateProfile::class);
    }
}
