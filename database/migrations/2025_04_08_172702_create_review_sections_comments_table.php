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
        Schema::create('review_sections_comments', function (Blueprint $table) {
            $table->id();

            $table->text('comment')->nullable();
            $table->foreignId('article_id')->nullable()->constrained(table: 'articles');
            $table->foreignId('review_section_id')->nullable()->constrained(table: 'review_sections');
            $table->foreignId('user_id')->nullable()->constrained(table: 'users');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_sections_comments');
    }
};
