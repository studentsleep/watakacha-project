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
        // 1. สร้างตาราง user_types ก่อน เพราะ users จะต้องอ้างอิงถึง
        Schema::create('user_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50); // admin, member, staff
            $table->string('description', 255)->nullable();
            $table->timestamps();
        });

        // 2. สร้างตาราง users ที่รวมทุกอย่างแล้ว
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username', 50)->unique();
            $table->string('first_name', 50)->nullable();
            $table->string('last_name', 50)->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('tel', 15)->nullable();
            $table->string('status', 20)->default('active');
            $table->foreignId('user_type_id')->default(1)->constrained('user_types');
            $table->rememberToken();
            $table->timestamps();
        });

        // 3. สร้างตารางอื่นๆ ที่เกี่ยวข้อง
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
        Schema::dropIfExists('user_types');
    }
};