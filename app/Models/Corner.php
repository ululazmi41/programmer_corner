<?php

namespace App\Models;

use App\Models\Chat\Conversation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Corner extends Model
{
    protected $fillable = [
        'name',
        'handle',
        'description',
        'icon_url',
        'banner_url',
        'conversation_id',
    ];

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withPivot('role');
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function conversation(): hasOne
    {
        if (Conversation::find($this->conversation_id)->exists() == false) {
            $conversation = Conversation::create([
                'type' => 'group',
            ]);
            $this->conversation_id = $conversation->id;
            $this->save();
        }

        return $this->hasOne(Conversation::class, 'id', 'conversation_id');
    }
}
