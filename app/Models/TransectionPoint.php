<?php

// app/Models/PointTransaction.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PointTransaction extends Model
{
    protected $primaryKey = 'transaction_id';

    protected $fillable = [
        'user_id',
        'change_type',
        'point_change',
        'description',
        'transaction_date'
    ];

    protected $casts = [
        'transaction_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'user_id', 'user_id');
    }
}