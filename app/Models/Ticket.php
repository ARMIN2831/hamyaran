<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function userOne1()
    {
        return $this->hasOne(User::class,'id','userOne');
    }
    public function userTwo2()
    {
        return $this->hasOne(User::class,'id','userTwo');
    }
    public function chats()
    {
        return $this->hasMany(Chat::class,'ticket_id','id')->with('user');
    }
}
