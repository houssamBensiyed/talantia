<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Experience extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidate_profile_id',
        'position',
        'company',
        'start_date',
        'end_date',
        'description',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Get the candidate profile that owns the experience (Belongs-to).
     */
    public function candidateProfile(): BelongsTo
    {
        return $this->belongsTo(CandidateProfile::class);
    }

    /**
     * Check if this is a current position.
     */
    public function isCurrent(): bool
    {
        return $this->end_date === null;
    }

    /**
     * Get the duration of the experience.
     */
    public function getDurationAttribute(): string
    {
        $end = $this->end_date ?? now();
        $diff = $this->start_date->diff($end);
        
        $parts = [];
        if ($diff->y > 0) {
            $parts[] = $diff->y . ' ' . ($diff->y === 1 ? 'an' : 'ans');
        }
        if ($diff->m > 0) {
            $parts[] = $diff->m . ' mois';
        }
        
        return implode(' ', $parts) ?: 'Moins d\'un mois';
    }
}
