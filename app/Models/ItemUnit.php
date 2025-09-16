<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemUnit extends Model
{
    protected $primaryKey = 'item_unit_id'; // ระบุ PK จริง
    protected $fillable = ['name', 'item_unit_name'];

    public function items()
    {
        return $this->hasMany(Item::class, 'item_unit_id', 'item_unit_id');
    }

    // Accessor: ให้ ->name อ่านได้ไม่ว่าจะเก็บเป็น 'name' หรือ 'item_unit_name'
    public function getNameAttribute()
    {
        return $this->attributes['name'] ?? $this->attributes['item_unit_name'] ?? null;
    }
}