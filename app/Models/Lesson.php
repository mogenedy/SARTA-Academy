<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Lesson extends Model
{
    use HasFactory , HasTranslations;

    public $translatable = ['title' , 'description'];
    protected $fillable = ['title','description','link','course_id']; 

    public function course(){
        return $this->belongsTo(Course::class);
    }
}
