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
        Schema::create('journal_user', function (Blueprint $table) {
            $table->id();

            $table->foreignId('journal_id')->constrained(table: 'journals');
            $table->foreignId('user_id')->constrained(table: 'users');
            $table->enum('role', ['chief editor','editor','reviewer', 'author'])->nullable();
            $table->string('category')->nullable();
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
        Schema::dropIfExists('journal_user');
    }
};
