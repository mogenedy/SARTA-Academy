<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Prize extends Model
{
    use HasFactory , HasTranslations;

    public $translatable = ['title' , 'researcher_name'];

    protected $guarded = [];
    
    public function researcher(){
        return $this->belongsTo(User::class , 'researcher_id');
    }

}
