<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'google_id',
        'password',
        'pen_name',
        'bio',
        'avatar_color',
        'avatar_path',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Shayaris penned by this user.
     */
    public function shayaris(): HasMany
    {
        return $this->hasMany(Shayari::class);
    }

    /**
     * Comments posted by this user.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Likes by this user.
     */
    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    /**
     * Bookmarks saved by this user.
     */
    public function bookmarks(): HasMany
    {
        return $this->hasMany(Bookmark::class);
    }

    /**
     * Shayaris bookmarked by this user.
     */
    public function bookmarkedShayaris(): BelongsToMany
    {
        return $this->belongsToMany(Shayari::class, 'bookmarks')->withTimestamps();
    }

    /**
     * Check if user is platform administrator.
     */
    public function isAdmin(): bool
    {
        return ($this->role ?? '') === 'admin';
    }

    /**
     * Get public avatar URL if image exists.
     */
    public function getAvatarUrlAttribute(): ?string
    {
        if (!empty($this->avatar_path)) {
            if (str_starts_with($this->avatar_path, 'http://') || str_starts_with($this->avatar_path, 'https://')) {
                return $this->avatar_path;
            }
            if (file_exists(public_path($this->avatar_path))) {
                return asset($this->avatar_path);
            }
        }
        return null;
    }

    /**
     * Get computed user initials.
     */
    public function getInitialsAttribute(): string
    {
        $name = trim($this->pen_name ?: $this->name);
        if (empty($name)) {
            return 'A';
        }
        $parts = preg_split('/\s+/', $name);
        return count($parts) >= 2
            ? strtoupper(mb_substr($parts[0], 0, 1) . mb_substr($parts[1], 0, 1))
            : strtoupper(mb_substr($name, 0, 2));
    }

    /**
     * Send the password reset notification.
     */
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new \App\Notifications\ResetPasswordNotification($token));
    }
}
