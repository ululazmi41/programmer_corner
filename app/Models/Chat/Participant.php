<?php

namespace App\Models\Chat;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    protected $fillable = [
        'user_id',
        'conversation_id',
        'status',
        'role',
    ];
}
