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
        Schema::create('files', function (Blueprint $table) {
            $table->id();

            $table->foreignId('article_id')->constrained(table: 'articles');
            $table->foreignId('file_category_id')->constrained(table: 'file_categories');
            
            $table->string('file_description')->nullable();
            $table->string('file_path')->nullable();
            $table->string('file_type')->nullable();

            $table->foreignId('downloads')->default(0);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
