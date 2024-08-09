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
        Schema::create('journal_indices', function (Blueprint $table) {
            $table->id();

            $table->foreignId('journal_id')->constrained(table: 'journals');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->text('link')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journal_indices');
    }
};
