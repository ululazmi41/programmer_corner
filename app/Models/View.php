<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class View extends Model
{
    public function viewable(): MorphTo
    {
        return $this->morphTo();
    }
}
