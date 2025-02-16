<?php

namespace App\Models\Chat;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Conversation extends Model
{
    protected $fillable = [
        'type',
    ];

    public function lastMessage(): HasOne
    {
        return $this->hasOne(Message::class)->latest();
    }
}
