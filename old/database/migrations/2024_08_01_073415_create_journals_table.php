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
        Schema::create('journals', function (Blueprint $table) {
            $table->id();
            
            $table->string('title')->nullable();
            $table->string('code')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->text('scope')->nullable();
            $table->string('issn')->nullable();
            $table->string('publisher')->nullable();
            $table->year('year')->nullable();
            $table->text('guidlines')->nullable();
		    $table->foreignId('category_id')->constrained(table: 'categories');
            
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
        Schema::dropIfExists('journals');
    }
};
