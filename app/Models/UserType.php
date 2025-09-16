<?php

// app/Models/UserType.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    protected $fillable = ['name', 'description'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function members()
    {
        return $this->hasMany(Member::class);
    }
}

// app/Models/Member.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $primaryKey = 'user_id';
    public $incrementing = false;
    
    protected $fillable = [
        'user_id', 
        'user_type_id', 
        'point'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function userType()
    {
        return $this->belongsTo(UserType::class);
    }

    public function pointTransactions()
    {
        return $this->hasMany(PointTransaction::class, 'user_id', 'user_id');
    }
}
