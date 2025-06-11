<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'group_id' , 'course_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function group(){
        return $this->belongsTo(Group::class);
    }

    public function course(){
        return $this->belongsTo(Course::class);
    }

}
