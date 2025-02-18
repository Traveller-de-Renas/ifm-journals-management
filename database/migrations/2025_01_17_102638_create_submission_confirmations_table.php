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
        Schema::create('submission_confirmations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('journal_id')->constrained(table: 'journals');
            $table->text('description')->nullable();
            $table->string('code')->nullable();
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
        Schema::dropIfExists('submission_confirmations');
    }
};
