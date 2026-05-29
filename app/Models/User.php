<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
        'company',
        'specialty',
        'bio',
        'photo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (User $user): void {
            if (! $user->slug) {
                $user->slug = static::generateUniqueSlug($user->name);
            }
        });
    }

    protected static function generateUniqueSlug(string $name): string
    {
        $baseSlug = Str::slug($name) ?: 'user';
        $slug = $baseSlug;
        $suffix = 2;

        while (static::where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$suffix}";
            $suffix++;
        }

        return $slug;
    }

    /**
     * Check if the user is a recruiter.
     */
    public function isRecruiter(): bool
    {
        return $this->user_type === 'recruiter';
    }

    /**
     * Check if the user is a job seeker.
     */
    public function isJobSeeker(): bool
    {
        return $this->user_type === 'job_seeker';
    }

    /**
     * Get the user's photo URL.
     */
    public function getPhotoUrlAttribute(): string
    {
        if ($this->photo) {
            // Check if it's already a full URL (external)
            if (str_starts_with($this->photo, 'http://') || str_starts_with($this->photo, 'https://')) {
                return $this->photo;
            }
            return asset('storage/' . $this->photo);
        }
        
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=111111&color=CCFF00&size=400&bold=true';
    }

    // ==========================================
    // RELATIONSHIPS
    // ==========================================

    /**
     * Get the candidate profile for the user (One-to-One).
     * Only for job seekers.
     */
    public function candidateProfile(): HasOne
    {
        return $this->hasOne(CandidateProfile::class);
    }

    /**
     * Get the job offers created by the recruiter (One-to-Many).
     * Only for recruiters.
     */
    public function jobOffers(): HasMany
    {
        return $this->hasMany(JobOffer::class);
    }

    /**
     * Get the job applications made by the job seeker (One-to-Many).
     * Only for job seekers.
     */
    public function applications(): HasMany
    {
        return $this->hasMany(JobApplication::class);
    }

    /**
     * Get the friend requests sent by this user.
     */
    public function sentFriendRequests(): HasMany
    {
        return $this->hasMany(Friendship::class, 'sender_id');
    }

    /**
     * Get the friend requests received by this user.
     */
    public function receivedFriendRequests(): HasMany
    {
        return $this->hasMany(Friendship::class, 'receiver_id');
    }

    /**
     * Get all accepted friends (from both sent and received requests).
     */
    public function friends()
    {
        $sentFriendIds = $this->sentFriendRequests()
            ->where('status', 'accepted')
            ->pluck('receiver_id');

        $receivedFriendIds = $this->receivedFriendRequests()
            ->where('status', 'accepted')
            ->pluck('sender_id');

        return User::whereIn('id', $sentFriendIds->merge($receivedFriendIds));
    }

    /**
     * Get pending friend requests received by this user.
     */
    public function pendingFriendRequests(): HasMany
    {
        return $this->receivedFriendRequests()->where('status', 'pending');
    }

    /**
     * Check if this user is friends with another user.
     */
    public function isFriendWith(User $user): bool
    {
        return $this->sentFriendRequests()
            ->where('receiver_id', $user->id)
            ->where('status', 'accepted')
            ->exists()
            ||
            $this->receivedFriendRequests()
            ->where('sender_id', $user->id)
            ->where('status', 'accepted')
            ->exists();
    }

    /**
     * Check if there's a pending friend request to the given user.
     */
    public function hasPendingRequestTo(User $user): bool
    {
        return $this->sentFriendRequests()
            ->where('receiver_id', $user->id)
            ->where('status', 'pending')
            ->exists();
    }

    /**
     * Check if there's a pending friend request from the given user.
     */
    public function hasPendingRequestFrom(User $user): bool
    {
        return $this->receivedFriendRequests()
            ->where('sender_id', $user->id)
            ->where('status', 'pending')
            ->exists();
    }

    /**
     * Get the friendship record between this user and another.
     */
    public function getFriendship(User $user): ?Friendship
    {
        return Friendship::where(function ($query) use ($user) {
            $query->where('sender_id', $this->id)
                  ->where('receiver_id', $user->id);
        })->orWhere(function ($query) use ($user) {
            $query->where('sender_id', $user->id)
                  ->where('receiver_id', $this->id);
        })->first();
    }
}
