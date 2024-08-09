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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();

            $table->string('title')->nullable();
            $table->string('image')->nullable();
            
            $table->text('description')->nullable();
            $table->text('phone')->nullable();
            $table->text('email')->nullable();
            $table->text('box')->nullable();
            $table->text('map')->nullable();
            $table->text('location')->nullable();

            $table->integer('category')->nullable();

            $table->string('contactable_type')->nullable();
            $table->integer('contactable_id')->nullable();
            
            $table->enum('status', ['1','0'])->default('1');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
