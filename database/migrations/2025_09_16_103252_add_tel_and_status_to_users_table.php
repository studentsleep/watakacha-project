<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // เพิ่มคอลัมน์ tel หลัง email (nullable คือ ไม่บังคับกรอก)
            $table->string('tel', 15)->nullable()->after('email');
            
            // เพิ่มคอลัมน์ status หลัง tel และตั้งค่าเริ่มต้นเป็น 'active'
            $table->string('status', 20)->default('active')->after('tel');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('tel');
            $table->dropColumn('status');
        });
    }
};
