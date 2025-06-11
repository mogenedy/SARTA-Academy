<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class PublicationData extends Model
{
    use HasFactory , HasTranslations;

    // protected $table = 'publication_data';
    public $translatable = ['graph.title'];
    protected $fillable = ['scopus_link', 'research_gate_link', 'graph' , 'web_of_science_link'];

    public $casts = [
        'graph' => 'array',
    ];
}
