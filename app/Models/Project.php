<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Project extends Model implements HasMedia
{
    use HasFactory  ,  HasTranslations , InteractsWithMedia;

    protected $fillable = ['title', 'finance' , 'duration' , 'description' , 'objectives' , 'deliverables' , 'beneficaries' , 'department_id' , 'starts_at' , 'ends_at'];

    public $translatable = ['title', 'finance' , 'duration' , 'description' , 'objectives' , 'deliverables' , 'beneficaries'];
    public function researchers(){
        return $this->belongsToMany(User::class, 'projects_users', 'project_id', 'user_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    protected function startsAt(): Attribute
    {
        return Attribute::make(
            // get: fn (string $value) => Carbon::parse($value)->format('Y-m-d H:i:s A'),
            set: fn (string $value) => Carbon::parse($value)->format('Y-m-d H:i:s'),
        );
    }

    protected function endsAt(): Attribute
    {
        return Attribute::make(
            // get: fn (string $value) => Carbon::parse($value)->format('Y-m-d H:i:s A'),
            set: fn (string $value) => Carbon::parse($value)->format('Y-m-d H:i:s'),
        );
    }
}
