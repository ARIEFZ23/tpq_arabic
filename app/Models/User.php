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
        'role',
        'class_id',
        'level',
        'experience_points',
        'total_score',
        'total_games_completed',
        'current_badge',
        'profile_photo',
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
     * Relationship: User has many scores
     */
    public function scores()
    {
        return $this->hasMany(Score::class);
    }

    /**
     * Relationship: User has many games created
     */
    public function gamesCreated()
    {
        return $this->hasMany(Game::class, 'created_by');
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is ustadz
     */
    public function isUstadz(): bool
    {
        return $this->role === 'ustadz';
    }

    /**
     * Check if user is ustadzah
     */
    public function isUstadzah(): bool
    {
        return $this->role === 'ustadzah';
    }

    /**
     * Check if user is santri (putra or putri)
     */
    public function isSantri(): bool
    {
        return in_array($this->role, ['santri_putra', 'santri_putri']);
    }

    /**
     * Check if user is teacher (ustadz or ustadzah)
     */
    public function isTeacher(): bool
    {
        return in_array($this->role, ['ustadz', 'ustadzah']);
    }

    /**
     * Get profile photo URL
     */
    public function getProfilePhotoUrlAttribute()
    {
        if ($this->profile_photo) {
            return asset('storage/' . $this->profile_photo);
        }
        
        return null;
    }

    /**
     * Get avatar (photo or emoji)
     */
    public function getAvatarAttribute()
    {
        if ($this->profile_photo) {
            return '<img src="' . asset('storage/' . $this->profile_photo) . '" class="w-10 h-10 rounded-full object-cover">';
        }
        
        return $this->role == 'santri_putra' ? '👦' : '👧';
    }
}