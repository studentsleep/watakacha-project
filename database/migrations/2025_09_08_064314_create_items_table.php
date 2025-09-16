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
        Schema::create('items', function (Blueprint $table) {
            $table->id('item_id'); // PK
            $table->string('item_name', 50);
            $table->integer('stock');
            $table->decimal('price', 8, 2);
            $table->string('image', 50)->nullable();
            $table->string('status')->default('active');
            $table->text('description')->nullable();

            // FK
            $table->unsignedBigInteger('item_type_id');
            $table->unsignedBigInteger('item_unit_id');

            // สร้าง Foreign key
            $table->foreign('item_type_id')->references('item_type_id')->on('item_types')->onDelete('cascade');
            $table->foreign('item_unit_id')->references('item_unit_id')->on('item_units')->onDelete('cascade');
            
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
