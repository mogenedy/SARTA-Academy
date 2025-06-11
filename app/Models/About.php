<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class About extends Model implements HasMedia
{
    use HasFactory , InteractsWithMedia , HasTranslations;

    protected $guarded = ['id'];

    public $translatable = ['title', 'description' , 'vision.*', 'mission.*', 'objectives.*'];
    protected $casts = [
        'vision' => 'array',
        'mission' => 'array',
        'objectives' => 'array',
    ];

}
