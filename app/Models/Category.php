<?php

namespace App\Models;

use App\Jobs\DeleteProductImages;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Category extends Model implements HasMedia
{
    use HasFactory , InteractsWithMedia , HasTranslations;
    
    public $fillable = ['name'];

    public $translatable = ['name'];

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
