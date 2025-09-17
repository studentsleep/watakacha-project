<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'username',
        'first_name',
        'last_name',
        'email',
        'password',
        'tel',
        'status',
        'user_type_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            // '#email_verified_at' => 'datetime', // ปิดไว้ก่อนหากยังไม่ได้ใช้
            'password' => 'hashed',
        ];
    }

    // --- ความสัมพันธ์กับตารางอื่น ---
    public function member()
    {
        return $this->hasOne(Member::class, 'user_id');
    }

    public function userType()
    {
        return $this->belongsTo(UserType::class);
    }

    // --- เมธอดสำหรับดึงชื่อย่อ ---
    public function initials(): string
    {
        $firstNameInitial = $this->first_name ? mb_substr($this->first_name, 0, 1) : '';
        $lastNameInitial = $this->last_name ? mb_substr($this->last_name, 0, 1) : '';

        if (! empty($firstNameInitial) && ! empty($lastNameInitial)) {
            return strtoupper($firstNameInitial . $lastNameInitial);
        }

        // ถ้าไม่มีชื่อจริง/นามสกุล ให้ใช้อักษร 2 ตัวแรกของ username แทน
        return strtoupper(mb_substr($this->username, 0, 2));
    }
}