<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable implements HasMedia , Sortable
{
    use HasApiTokens, HasFactory, Notifiable , HasRoles , InteractsWithMedia , HasTranslations , SortableTrait;

    public $translatable = ['name'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'ban',
        'custom_order',
        'phone'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope('ancient', function (Builder $builder) {
            $builder->ordered();
        });
    }
    
    public function subscriptions(){
        return $this->hasMany(Subscription::class , 'user_id');
    }
    
    public function scopeActive($query){
        return $query->where('ban' , '<' , now())->orWhereNull('ban');
    }

    public function scopeBanned($query){
        return $query->where('ban' , '>' , now());
    }

    public function editable_institutes(){
        return $this->belongsToMany(Institute::class , 'editors_institutes' , 'user_id' , 'institute_id');
    }

    public function courses(){
        return $this->belongsToMany(Course::class);
    }

    public function researcher_profile(){
        return $this->hasOne(ResearcherProfile::class , 'user_id');
    }

    public function departments(){
        return $this->belongsToMany(Department::class , 'users_departments' , 'user_id' , 'department_id');
    }

    public function patents(){
        return $this->belongsToMany(Patent::class , 'patents_users' , 'user_id' , 'patent_id');
    }

    public function publications(){
        return $this->belongsToMany(Publication::class , 'publications_users' , 'user_id' , 'publication_id');
    }

    public function projects(){
        return $this->belongsToMany(Project::class , 'projects_users' , 'user_id' , 'project_id');
    }
}
