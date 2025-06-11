<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class TicketType extends Model
{
    use HasFactory , HasTranslations;

    protected $fillable = ['title'];

    public $translatable = ['title'];

    public function tickets()
    {
        return $this->belongsToMany(Ticket::class, 'ticket_type_id');
    }
}
