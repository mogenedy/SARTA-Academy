<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Publication extends Model
{
    use HasFactory , HasTranslations;

    protected $fillable = ['title' , 'journal' , 'year'];
    public $translatable = ['title' , 'journal.title.*'];

    public $casts = [
        'journal' => 'array',
    ];
    
    public function researchers(){
        return $this->belongsToMany(User::class, 'publications_users', 'publication_id', 'user_id');
    }
}
