<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    public function student()
    {
        return $this->belongsToMany(Student::class)->withPivot('ts','score');
    }
    public function convenes()
    {
        return $this->hasMany(Convene::class);
    }
}
