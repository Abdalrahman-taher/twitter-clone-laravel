<?php

namespace App\Traits;

use App\Models\Media;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasMedias
{
    public function medias(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable');
    }
}

