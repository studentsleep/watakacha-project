<?php
// database/migrations/xxxx_xx_xx_fix_point_transactions_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('point_transactions')) {
            // ตรวจสอบว่ามี column member_id หรือไม่
            if (Schema::hasColumn('point_transactions', 'member_id')) {
                Schema::table('point_transactions', function (Blueprint $table) {
                    // ตรวจสอบและลบ foreign key ถ้ามี
                    try {
                        $table->dropForeign(['member_id']);
                    } catch (Exception $e) {
                        // ถ้าไม่มี foreign key ก็ไม่ต้องทำอะไร
                    }
                    
                    // ลบ column member_id
                    $table->dropColumn('member_id');
                });
            }
            
            // เพิ่ม user_id column ถ้ายังไม่มี
            if (!Schema::hasColumn('point_transactions', 'user_id')) {
                Schema::table('point_transactions', function (Blueprint $table) {
                    $table->foreignId('user_id')->after('transaction_id')->constrained('users')->cascadeOnUpdate()->cascadeOnDelete();
                });
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('point_transactions')) {
            if (Schema::hasColumn('point_transactions', 'user_id')) {
                Schema::table('point_transactions', function (Blueprint $table) {
                    $table->dropForeign(['user_id']);
                    $table->dropColumn('user_id');
                });
            }
            
            if (!Schema::hasColumn('point_transactions', 'member_id')) {
                Schema::table('point_transactions', function (Blueprint $table) {
                    $table->foreignId('member_id')->constrained('members')->cascadeOnUpdate()->cascadeOnDelete();
                });
            }
        }
    }
};