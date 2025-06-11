<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Institute extends Model implements HasMedia
{
    use HasFactory , InteractsWithMedia , HasTranslations;

    public $fillable = ['name', 'vision', 'mission', 'user_id' , 'short_name'];

    public $translatable = ['name', 'vision', 'mission'];

    
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function courses(){
        return $this->hasMany(Course::class);
    }

    public function instructors(){
        return $this->hasMany(Instructor::class);
    }

    public function calenders(){
        return $this->hasMany(Calender::class);
    }

    public function lives(){
        return $this->hasMany(Live::class);
    }

    public function posts(){
        return $this->hasMany(Post::class);
    }
    
    public function editors(){
        return $this->belongsToMany(User::class , 'editors_institutes' , 'institute_id' , 'user_id');
    }

    public function aboutInstitute()
    {
        return $this->hasOne(AboutInstitute::class , 'institute_id');
    }

    public function departments()
    {
        return $this->hasMany(Department::class , 'institute_id');
    }
}
