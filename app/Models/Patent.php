<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Spatie\Translatable\HasTranslations;

class Patent extends Model
{
    use HasFactory , HasTranslations;

    public $translatable = ['description' , 'title'];
    protected $fillable = ['patent_number', 'patent_date', 'description' , 'title'];

    protected function patentDate(): Attribute
    {
        return Attribute::make(
            // get: fn (string $value) => Carbon::parse($value)->format('Y-m-d H:i:s A'),
            set: fn (string $value) => Carbon::parse($value)->format('Y-m-d H:i:s'),
        );
    }

    public function researchers(){
        return $this->belongsToMany(User::class, 'patents_users', 'patent_id', 'user_id');
    }
}
