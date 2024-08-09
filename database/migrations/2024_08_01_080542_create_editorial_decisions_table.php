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
        Schema::create('editorial_decisions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('article_id')->constrained(table: 'articles');
            $table->foreignId('user_id')->constrained(table: 'users');
            $table->enum('decision', ['Accept','Reject','Request Revision'])->default('Accept');
            $table->text('comments')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('editorial_decisions');
    }
};
