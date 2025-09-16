<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username', 50)->unique()->after('id');
            $table->string('first_name', 50)->nullable()->after('username');
            $table->string('last_name', 50)->nullable()->after('first_name');
            $table->string('tel', 11)->nullable()->after('email');
            $table->string('status', 50)->default('active')->after('tel');
            $table->foreignId('user_type_id')->default(1)->constrained('user_types')->after('status');
        });
    }

    public function down(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['user_type_id']);
            $table->dropColumn(['username', 'first_name', 'last_name', 'tel', 'status', 'user_type_id']);
        });
    }
};
