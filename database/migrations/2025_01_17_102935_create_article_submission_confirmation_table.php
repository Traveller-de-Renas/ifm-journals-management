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
        Schema::create('article_submission_confirmation', function (Blueprint $table) {
            $table->id();

            $table->foreignId('article_id')->constrained(table: 'articles');
            $table->foreignId('submission_confirmation_id')->constrained(table: 'submission_confirmations');
            $table->boolean('value')->default(0);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_submission_confirmation');
    }
};
