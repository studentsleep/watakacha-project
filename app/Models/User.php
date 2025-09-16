<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute; // ✅ เพิ่มบรรทัดนี้
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
        'user_type_id',
        'tel',
        'status',
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
            #'email_verified_at' => 'datetime',
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
    protected function initials(): Attribute
    {
        return Attribute::make(
            get: function () {
                $firstNameInitial = mb_substr($this->first_name ?? '', 0, 1);
                $lastNameInitial = mb_substr($this->last_name ?? '', 0, 1);

                if (!empty($firstNameInitial) && !empty($lastNameInitial)) {
                    return strtoupper($firstNameInitial . $lastNameInitial);
                }

                // ถ้าไม่มีชื่อจริง/นามสกุล ให้ใช้อักษร 2 ตัวแรกของ username แทน
                return strtoupper(mb_substr($this->username, 0, 2));
            },
        );
    }
}
