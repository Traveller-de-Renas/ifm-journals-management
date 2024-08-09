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
        Schema::create('social_media', function (Blueprint $table) {
            $table->id();
            
            $table->string('name')->nullable();
            $table->string('link')->nullable();
            
            $table->text('icon')->nullable();
            $table->string('type')->nullable();
            $table->text('description')->nullable();
            
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
        Schema::dropIfExists('social_media');
    }
};
