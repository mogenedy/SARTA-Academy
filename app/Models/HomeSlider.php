<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class HomeSlider extends Model implements HasMedia
{
    use HasFactory , InteractsWithMedia , HasTranslations;

    public $translatable = ['title' , 'description' , 'button.*' ];

    protected $casts = [
        'button' => 'array'
    ];
    
    protected $guarded = ['id'];

}
