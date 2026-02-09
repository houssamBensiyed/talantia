<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobOffer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'company',
        'contract_type',
        'image',
        'specialty',
        'location',
        'is_closed',
    ];

    protected $casts = [
        'is_closed' => 'boolean',
    ];

    /**
     * Get the recruiter that owns the job offer (Belongs-to).
     */
    public function recruiter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Alias for recruiter relationship.
     */
    public function user(): BelongsTo
    {
        return $this->recruiter();
    }

    /**
     * Get the applications for this job offer (One-to-Many).
     */
    public function applications(): HasMany
    {
        return $this->hasMany(JobApplication::class);
    }

    /**
     * Get the image URL.
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->image) {
            if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
                return $this->image;
            }
            return asset('storage/' . $this->image);
        }
        return 'https://via.placeholder.com/800x400?text=Job+Offer';
    }

    /**
     * Scope for open job offers.
     */
    public function scopeOpen($query)
    {
        return $query->where('is_closed', false);
    }

    /**
     * Scope for closed job offers.
     */
    public function scopeClosed($query)
    {
        return $query->where('is_closed', true);
    }

    /**
     * Scope for filtering by specialty.
     */
    public function scopeBySpecialty($query, string $specialty)
    {
        return $query->where('specialty', 'like', "%{$specialty}%");
    }

    /**
     * Check if a user has applied to this job.
     */
    public function hasApplicant(User $user): bool
    {
        return $this->applications()->where('user_id', $user->id)->exists();
    }

    /**
     * Close the job offer.
     */
    public function close(): bool
    {
        return $this->update(['is_closed' => true]);
    }

    /**
     * Reopen the job offer.
     */
    public function reopen(): bool
    {
        return $this->update(['is_closed' => false]);
    }
}
