<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class BlogCategory extends Model
{
    use HasFactory , HasTranslations;

    protected $guarded = ['id'];

    public $translatable = ['title'];

    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }
    

}
