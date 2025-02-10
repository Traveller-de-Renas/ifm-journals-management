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
        Schema::create('article_reviews', function (Blueprint $table) {
            $table->id();

            $table->foreignId('article_id')->constrained(table: 'articles');
            $table->foreignId('review_section_query_id')->nullable()->constrained(table: 'review_section_queries');
            $table->foreignId('review_section_option_id')->nullable()->constrained(table: 'review_section_options');

            $table->text('comment')->nullable();
            $table->foreignId('user_id')->constrained(table: 'users');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_reviews');
    }
};
