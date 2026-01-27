<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

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
}
