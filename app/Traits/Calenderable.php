<?php

namespace App\Traits;

use App\Models\Calender;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Calenderable {

    public function calenders(): MorphMany
    {
        return $this->morphMany(Calender::class, 'calenderable');
    }


}