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
        Schema::create('article_user', function (Blueprint $table) {
            $table->id();

            $table->foreignId('article_id')->constrained(table: 'articles');
            $table->foreignId('user_id')->constrained(table: 'users');
            $table->string('affiliation')->nullable();
            $table->text('biography')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_user');
    }
};
