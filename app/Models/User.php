<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;

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
        'username',
        'email',
        'password',
        'avatar', // disarankan tambahkan username jika belum ada
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
     * Relationship: Users that this user follows
     */
    public function followings(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,        // Related model
            'follows',           // Pivot table name
            'follower_id',       // Foreign key on the pivot table for the current model
            'following_id'       // Foreign key on the pivot table for the related model
        )->withTimestamps();     // Include timestamps in pivot table
    }

    /**
     * Relationship: Users that follow this user
     */
    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,        // Related model
            'follows',         // Pivot table name
            'following_id',    // Foreign key on the pivot table for the current model
            'follower_id'       // Foreign key on the pivot table for the related model
        )->withTimestamps();   // Include timestamps in pivot table
    }

    /**
     * Follow a user
     *
     * @param User $user The user to follow
     * @return array Result of the operation
     */
    // Tambahkan accessor untuk avatar URL
    // Tambahkan relasi tweets di model User
    public function tweets()
    {
        return $this->hasMany(Tweet::class);
    }

    // Update method getAvatarUrlAttribute
    public function getAvatarUrlAttribute()
    {
        // Jika ada avatar, tampilkan avatar user
        if ($this->avatar && Storage::disk('public')->exists($this->avatar)) {
            return asset('storage/'.$this->avatar);
        }
        
        // Pastikan path default benar
        return asset('images/default-avatar.png');
    }

// Tambahkan mutator untuk username
    public function setUsernameAttribute($value)
    {
        $this->attributes['username'] = strtolower($value);
    }
    public function follow(User $user): array
    {
        if ($this->id === $user->id) {
            return ['status' => 'error', 'message' => 'You cannot follow yourself'];
        }

        if (!$this->isFollowing($user)) {
            $this->followings()->attach($user->id);
            return ['status' => 'success', 'message' => 'Successfully followed user'];
        }

        return ['status' => 'info', 'message' => 'Already following this user'];
    }

    /**
     * Unfollow a user
     *
     * @param User $user The user to unfollow
     * @return array Result of the operation
     */
    public function unfollow(User $user): array
    {
        if ($this->id === $user->id) {
            return ['status' => 'error', 'message' => 'You cannot unfollow yourself'];
        }

        if ($this->isFollowing($user)) {
            $this->followings()->detach($user->id);
            return ['status' => 'success', 'message' => 'Successfully unfollowed user'];
        }

        return ['status' => 'info', 'message' => 'Not following this user'];
    }

    /**
     * Check if the user is following another user
     *
     * @param User $user The user to check
     * @return bool
     */
    public function isFollowing(User $user): bool
    {
        return $this->followings()->where('following_id', $user->id)->exists();
    }

    /**
     * Get the count of users this user follows
     *
     * @return int
     */
    public function followingCount(): int
    {
        return $this->followings()->count();
    }

    /**
     * Get the count of followers
     *
     * @return int
     */
    public function followersCount(): int
    {
        return $this->followers()->count();
    }
}