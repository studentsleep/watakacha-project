<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $primaryKey = 'item_id';
    protected $fillable = [
        'item_name',
        'description',
        'price',
        'stock',
        'item_unit_id',
        'item_type_id',
        'status',
    ];

    // ความสัมพันธ์กับ ItemType
    public function type()
    {
        return $this->belongsTo(ItemType::class, 'item_type_id', 'item_type_id');
    }

    // ความสัมพันธ์กับ ItemUnit
    public function unit()
    {
        return $this->belongsTo(ItemUnit::class, 'item_unit_id', 'item_unit_id');
    }

    // ความสัมพันธ์กับหลายรูป
    public function images()
    {
        return $this->hasMany(ItemImage::class, 'item_id', 'item_id');
    }

    // ความสัมพันธ์กับรูปหลัก
    public function mainImage()
    {
        return $this->hasOne(ItemImage::class, 'item_id', 'item_id')->where('is_main', true);
    }
}
