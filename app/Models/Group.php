<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Spatie\Translatable\HasTranslations;

class Group extends Model
{
    use HasFactory , HasTranslations;

    protected $fillable = ['uuid' , 'name', 'is_main', 'institute_id' , 'live' , 'max_users' , 'expires_at' , 'course_id'];

    public $translatable = ['name'];

    public static function boot() {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    protected function expiresAt(): Attribute
    {
        return Attribute::make(
            // get: fn (string $value) => Carbon::parse($value)->format('Y-m-d H:i:s A'),
            set: fn (string $value) => Carbon::parse($value)->format('Y-m-d H:i:s'),
        );
    }

    public function subscriptions(){
        return $this->hasMany(Subscription::class , 'group_id');
    }

    public function course(){
        return $this->belongsTo(Course::class , 'course_id');
    }

    public function institute(){
        return $this->belongsTo(Institute::class , 'institute_id');
    }

}
