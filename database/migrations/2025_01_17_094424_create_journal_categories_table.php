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
        Schema::create('journal_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->foreignId('journal_subject_id')->constrained(table: 'journal_subjects');
            $table->integer('status')->default(1);
            
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
        Schema::dropIfExists('journal_categories');
    }
};
