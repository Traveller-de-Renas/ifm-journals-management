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
        Schema::create('editor_checklists', function (Blueprint $table) {
            $table->id();

            $table->text('description')->nullable();
            $table->string('code')->nullable();
            $table->foreignId('editorial_process_id')->nullable()->constrained(table: 'editorial_processes');
            $table->integer('status')->default(1);
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('editor_checklists');
    }
};
