<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    public function nationality()
    {
        return $this->belongsTo(Country::class,'nationality_id','id');
    }
    public function classroom()
    {
        return $this->belongsToMany(Classroom::class);
    }
    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
    public function courses()
    {
        return $this->hasManyThrough(
            Course::class,
            Classroom::class,
            'id', // Foreign key on the classrooms table...
            'id', // Foreign key on the courses table...
            'id', // Local key on the students table...
            'course_id' // Local key on the classrooms table...
        )->distinct();
    }
}
