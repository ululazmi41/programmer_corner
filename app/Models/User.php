<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\NotificationType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'image_url',
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

    public function posts(): hasMany
    {
        return $this->hasMany(Post::class);
    }

    public function corners(): BelongsToMany
    {
        return $this->belongsToMany(Corner::class)->withPivot('role');
    }

    public function createdCorners(): HasMany
    {
        return $this->hasMany(Corner::class, 'owner_id');
    }

    public function bookmarks(): MorphMany
    {
        return $this->morphMany(Bookmark::class, 'bookmarkable');
    }

    public function following(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id');
    }

    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id');
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    public function follow(User $following)
    {
        $isFollow = $this->following->contains('id', $following->id);
        if ($isFollow) {
            return;
        }
        Notification::sendNotification($following->id, $this->id, NotificationType::FOLLOW, User::class, $this->id);
        $this->following()->attach($following);
    }

    public function unfollow(User $following)
    {
        $isFollow = $this->following->contains('id', $following->id);
        if (!$isFollow) {
            return;
        }
        Notification::removeNotification($following->id, $this->id, NotificationType::FOLLOW, User::class, $this->id);
        $this->following()->detach($following);
    }
}
