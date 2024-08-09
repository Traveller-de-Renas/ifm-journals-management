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
        Schema::create('sliding_images', function (Blueprint $table) {
            $table->id();

            $table->string('image')->nullable();
            $table->string('caption')->nullable();
            $table->string('url')->nullable();
            $table->integer('order')->default(0);

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
        Schema::dropIfExists('sliding_images');
    }
};
