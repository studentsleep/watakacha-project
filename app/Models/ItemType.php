<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemType extends Model
{
    protected $primaryKey = 'item_type_id';
    protected $fillable = ['item_type_name', 'name'];

    public function items()
    {
        return $this->hasMany(Item::class, 'item_type_id', 'item_type_id');
    }

    // Accessor: ให้ ->name อ่านได้ทั้ง name หรือ item_type_name
    public function getNameAttribute()
    {
        return $this->attributes['name'] ?? $this->attributes['item_type_name'] ?? null;
    }
}
