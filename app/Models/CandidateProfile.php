<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CandidateProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
    ];

    /**
     * Get the user that owns the candidate profile (One-to-One).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the formations for the candidate profile (One-to-Many).
     */
    public function formations(): HasMany
    {
        return $this->hasMany(Formation::class);
    }

    /**
     * Get the experiences for the candidate profile (One-to-Many).
     */
    public function experiences(): HasMany
    {
        return $this->hasMany(Experience::class);
    }

    /**
     * Get the skills for the candidate profile (Many-to-Many).
     */
    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class);
    }
}
