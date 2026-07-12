<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Media extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'collection',
        'path',
        'mime_type',
        'size',
    ];

    // Every media file belongs to one model (User, Tweet, etc.)
    public function mediable(): MorphTo
    {
        return $this->morphTo();
    }
}
