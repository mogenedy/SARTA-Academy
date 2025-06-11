<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class DirectorMessage extends Model implements HasMedia
{
    use HasFactory , InteractsWithMedia , HasTranslations;
    
    protected $guarded = ['id'];

    public $translatable = ['title', 'description'];

}
