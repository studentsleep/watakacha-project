<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Member extends Model
{
    use HasFactory;

    protected $primaryKey = 'user_id';
    public $incrementing = false;
    
    // [CHECK] ตรวจสอบให้แน่ใจว่าไม่มี user_type_id ในนี้
    protected $fillable = [
        'user_id',
        'point'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pointTransactions()
    {
        return $this->hasMany(PointTransaction::class, 'member_id', 'user_id');
    }
}


