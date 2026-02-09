<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'job_offer_id',
        'status',
        'cover_letter',
    ];

    /**
     * Get the job seeker who made the application (Belongs-to).
     */
    public function applicant(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Alias for applicant relationship.
     */
    public function user(): BelongsTo
    {
        return $this->applicant();
    }

    /**
     * Get the job offer for this application (Belongs-to).
     */
    public function jobOffer(): BelongsTo
    {
        return $this->belongsTo(JobOffer::class);
    }

    /**
     * Check if the application is pending.
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if the application has been reviewed.
     */
    public function isReviewed(): bool
    {
        return $this->status === 'reviewed';
    }

    /**
     * Check if the application was accepted.
     */
    public function isAccepted(): bool
    {
        return $this->status === 'accepted';
    }

    /**
     * Check if the application was rejected.
     */
    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    /**
     * Scope for pending applications.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for reviewed applications.
     */
    public function scopeReviewed($query)
    {
        return $query->where('status', 'reviewed');
    }
}
