<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // ตารางหลัก user_types
        Schema::create('user_types', function (Blueprint $table) {
            $table->id(); 
            $table->string('name', 50); // admin, member, staff
            $table->string('description', 255)->nullable(); // รายละเอียดเพิ่มเติม
            $table->timestamps();
        });

        // ตาราง users (แก้ไขของ Laravel เดิม)
        /*Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('user_type_id')->nullable()->after('id');

            // FK เชื่อม users.user_type_id -> user_types.id
            $table->foreign('user_type_id')
                  ->references('id')
                  ->on('user_types')
                  ->cascadeOnUpdate()
                  ->nullOnDelete();
        });*/
    }

    public function down(): void
    {
        /*Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['user_type_id']);
            $table->dropColumn('user_type_id');
        });*/

        Schema::dropIfExists('user_types');
    }
};
