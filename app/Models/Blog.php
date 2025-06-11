<?php

namespace App\Models;

use App\Traits\Calenderable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasTranslatableSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Translatable\HasTranslations;

class Blog extends Model implements HasMedia
{
    use HasFactory  , HasTranslations , InteractsWithMedia , HasTranslatableSlug , Calenderable ;

    protected $guarded = ['id'];

    public $translatable = ['title', 'description' , 'slug'];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function resolveRouteBinding($value, $field = null)
    {
        $lang = request()->header("Accept-Language") ?? 'en';
        
        return $this->where('slug->'. $lang, $value)->firstOrFail();
    }

    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

    public function blog_category()
    {
        return $this->belongsTo(BlogCategory::class);
    }

    public function tags()
    {
        return $this->belongsToMany(BlogTag::class , 'tags_blogs' , 'blog_id' , 'tag_id');
    }

    public function events()
    {
        return $this->belongsToMany(Event::class , 'blogs_events' , 'blog_id' , 'event_id');
    }

}
