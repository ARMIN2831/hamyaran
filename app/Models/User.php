<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function owner()
    {
        return $this->hasOne(User::class,'id','owner_id');
    }
    public function convene()
    {
        return $this->hasOne(Convene::class);
    }
    public function students()
    {
        return $this->hasMany(Student::class);
    }
    public function conveneB()
    {
        return $this->belongsTo(Convene::class,'convene_id','id');
    }
    public function classrooms()
    {
        return $this->hasMany(Classroom::class);
    }
}
