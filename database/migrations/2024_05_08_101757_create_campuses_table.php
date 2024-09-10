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
        Schema::create('campuses', function (Blueprint $table) {
            $table->id();
            
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->string('image')->nullable();
            
            $table->text('welcome')->nullable();
            $table->text('about')->nullable();
            $table->text('contacts')->nullable();

            $table->integer('is_main')->default('0');
            $table->enum('status', ['1','0'])->default('1');

            $table->uuid('uuid')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('campuses');
    }
};
