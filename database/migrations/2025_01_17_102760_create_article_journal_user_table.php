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
        Schema::create('article_journal_user', function (Blueprint $table) {
            $table->id();

            $table->foreignId('article_id')->constrained(table: 'articles');
            $table->foreignId('journal_user_id')->constrained(table: 'users');
            $table->integer('number')->default(0);

            $table->date('review_start_date')->default(now());
            $table->date('review_end_date')->nullable();

            $table->string('review_status')->default('pending');

            $table->timestamps(); 
            $table->softDeletes(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_journal_user');
    }
};
