<?php

namespace App\Models;

use App\Traits\Calenderable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Event extends Model implements HasMedia
{
    use HasFactory ,  HasTranslations , InteractsWithMedia , Calenderable;

    protected $casts = [
        'what_will_you_learn' => 'array',
        'description' => 'array',
    ];
    public $translatable = ['title', 'description.*.title.*' , 'description.*.description.*' , 'what_will_you_learn.*'];
    protected $guarded = ['id'];

    protected function date(): Attribute
    {
        return Attribute::make(
            // get: fn (string $value) => Carbon::parse($value)->format('Y-m-d H:i:s A'),
            set: fn (string $value) => Carbon::parse($value)->format('Y-m-d H:i:s'),
        );
    }

    public function blogs()
    {
        return $this->belongsToMany(Blog::class , 'blogs_events' , 'event_id' , 'blog_id');
    }

}
