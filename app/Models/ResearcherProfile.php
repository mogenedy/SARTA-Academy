<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class ResearcherProfile extends Model implements HasMedia
{
    use HasFactory , HasTranslations , InteractsWithMedia;

    public $guarded = ['id'];

    public $casts = [
        'education_qualification' => 'array'
    ];
    
    public $translatable = ['title' , 'description' , 'biography' , 'education_qualification.description' , 'education_qualification.points.*.title'];

}
