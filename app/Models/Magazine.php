<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Magazine extends Model implements HasMedia
{
    use HasFactory , HasTranslations , InteractsWithMedia;

    protected $fillable = ['title'];

    public $translatable = ['title'];
}
