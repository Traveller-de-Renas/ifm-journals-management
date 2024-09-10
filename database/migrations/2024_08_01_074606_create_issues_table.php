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
        Schema::create('issues', function (Blueprint $table) {
            $table->id();

            $table->integer('number')->nullable();
            $table->string('description')->nullable();
            $table->foreignId('journal_id')->constrained(table: 'journals');
            $table->foreignId('volume_id')->constrained(table: 'volumes');
            
            $table->date('publication_date')->nullable();
            $table->enum('status', ['Published','Unpublished','Pending'])->default('pending');

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
        Schema::dropIfExists('issues');
    }
};
