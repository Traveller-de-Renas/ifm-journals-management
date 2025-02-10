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
        Schema::table('articles', function (Blueprint $table) {
            $table->integer('guidelines')->default(0);
            $table->integer('plagiarism')->default(0);

            $table->integer('scope')->default(0);
            $table->integer('methodology')->default(0);
            $table->integer('tech_complete')->default(0);
            $table->integer('noverity')->default(0);
            $table->integer('prior_publication')->default(0);

            $table->integer('formatting')->default(0);
            $table->integer('copyediting')->default(0);
            $table->integer('typesetting')->default(0);
            $table->integer('proofreading')->default(0);

            $table->date('deadline')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn(['scope']);
            $table->dropColumn(['methodology']);

            $table->dropColumn(['scope']);
            $table->dropColumn(['methodology']);
            $table->dropColumn(['tech_complete']);
            $table->dropColumn(['noverity']);
            $table->dropColumn(['prior_publication']);

            $table->dropColumn(['formatting']);
            $table->dropColumn(['copyediting']);
            $table->dropColumn(['typesetting']);
            $table->dropColumn(['proofreading']);

            $table->dropColumn(['deadline']);
        });
    }
};
