<?php

namespace App\Models;

use App\Enums\LevelEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Course extends Model implements HasMedia
{
    use HasFactory , InteractsWithMedia , HasTranslations;

    public $translatable = ['title', 'description' , 'what_will_you_learn.*' , 'curriculam.*'  , 'certification'];
    protected $fillable = ['title','description','price','online','institute_id' , 'start_date' , 'end_date' ,'live' , 'duration' , 'certification'  , 'category_id', 'what_will_you_learn' , 'level' , 'certification' , 'curriculam'];

    protected $casts = [
        'what_will_you_learn' => 'array',
        'curriculam' => 'array',
    ];
    protected function startDate(): Attribute
    {
        return Attribute::make(
            // get: fn (string $value) => Carbon::parse($value)->format('Y-m-d H:i:s A'),
            set: fn ($value) => isset($value) ? Carbon::parse($value)->format('Y-m-d H:i:s') : null,
        );
    }

    protected function endDate(): Attribute
    {
        return Attribute::make(
            // get: fn (string $value) => Carbon::parse($value)->format('Y-m-d H:i:s A'),
            set: fn ($value) => isset($value) ? Carbon::parse($value)->format('Y-m-d H:i:s') : null,
        );
    }

    protected function level(): Attribute
        {
            return Attribute::make(
                get: function ($value) {
                    if (is_numeric($value)){
                        return LevelEnum::fromValue(intval($value))->key;
                    }else{
                        return LevelEnum::fromValue($value)->key;
                    }
                },
                set: fn ($value) => LevelEnum::fromKey($value),
            );
        }

    public function groups(){
        return $this->hasMany(Group::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }
    
    public function institute(){
        return $this->belongsTo(Institute::class);
    }

    public function subscriptions(){
        return $this->hasMany(Subscription::class , 'course_id');
    }

    public function lessons(){
        return $this->hasMany(Lesson::class);
    }
    
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function scopeIsLive($query , bool $live)
    {
        return $query->where('live', $live);
    }
}
