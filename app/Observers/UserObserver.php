<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        // ถ้า user ที่สร้างใหม่เป็น member (type_id = 2)
        if ($user->user_type_id == 2) {
            // สร้างข้อมูลในตาราง members ทันที
            $user->member()->create(['point' => 0]);
        }
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        // ตรวจสอบว่ามีการเปลี่ยนแปลง user_type_id หรือไม่
        if ($user->wasChanged('user_type_id')) {
            $originalType = $user->getOriginal('user_type_id');
            $newType = $user->user_type_id;

            // กรณี: เปลี่ยนจากอย่างอื่นมาเป็น member
            if ($newType == 2) {
                // สร้างข้อมูล member (เผื่อยังไม่มี)
                $user->member()->firstOrCreate(['point' => 0]);
            }
            // กรณี: เปลี่ยนจาก member ไปเป็นอย่างอื่น
            elseif ($originalType == 2 && $newType != 2) {
                // ลบข้อมูล member ทิ้ง
                $user->member()->delete();
            }
        }
    }

    /**
     * Handle the User "deleted" event.
     * (ส่วนนี้จะลบ member record ไปพร้อมกับ user โดยอัตโนมัติอยู่แล้ว
     * เพราะเราตั้งค่า Foreign Key เป็น cascadeOnDelete)
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}