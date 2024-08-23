<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function convenes()
    {
        return $this->belongsToMany(Convene::class);
    }
    public function classrooms()
    {
        return $this->hasMany(Classroom::class);
    }
}
