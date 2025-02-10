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

            $table->text('editorial')->nullable();
            $table->string('editorial_file')->nullable();
            $table->integer('editorial_downloads')->default(0);
            
            $table->enum('publication', ['Published','Pending'])->default('Pending');
            $table->date('publication_date')->nullable();
            $table->enum('status', ['Open','Closed'])->default('Open');

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
