<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Friendship extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'status',
    ];

    /**
     * Get the user who sent the friend request (Belongs-to).
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Get the user who received the friend request (Belongs-to).
     */
    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    /**
     * Check if the friendship is pending.
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if the friendship is accepted.
     */
    public function isAccepted(): bool
    {
        return $this->status === 'accepted';
    }

    /**
     * Check if the friendship was rejected.
     */
    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    /**
     * Accept the friend request.
     */
    public function accept(): bool
    {
        return $this->update(['status' => 'accepted']);
    }

    /**
     * Reject the friend request.
     */
    public function reject(): bool
    {
        return $this->update(['status' => 'rejected']);
    }

    /**
     * Scope for pending friend requests.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for accepted friendships.
     */
    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
    }
}
