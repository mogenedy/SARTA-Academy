<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Spatie\Translatable\HasTranslations;

class Calender extends Model
{
    use HasFactory , HasTranslations;
    public $translatable = ['title'];
    protected $fillable = ['title' , 'starts_at' , 'ends_at' , 'institude_id' , 'calenderable_id' , 'calenderable_type'];
    public function calenderable()
    {
        return $this->morphTo();
    }

    protected function startsAt(): Attribute
    {
        return Attribute::make(
            // get: fn (string $value) => Carbon::parse($value)->format('Y-m-d H:i:s A'),
            set: fn (string $value) => Carbon::parse($value)->format('Y-m-d H:i:s'),
        );
    }

    protected function endsAt(): Attribute
    {
        return Attribute::make(
            // get: fn (string $value) => Carbon::parse($value)->format('Y-m-d H:i:s A'),
            set: fn (string $value) => Carbon::parse($value)->format('Y-m-d H:i:s'),
        );
    }
}
