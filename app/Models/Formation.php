<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Formation extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidate_profile_id',
        'diploma',
        'school',
        'graduation_year',
    ];

    protected $casts = [
        'graduation_year' => 'integer',
    ];

    /**
     * Get the candidate profile that owns the formation (Belongs-to).
     */
    public function candidateProfile(): BelongsTo
    {
        return $this->belongsTo(CandidateProfile::class);
    }
}
