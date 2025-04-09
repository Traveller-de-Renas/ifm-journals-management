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
        Schema::table('review_sections', function (Blueprint $table) {
            $table->foreignId('review_sections_group_id')->nullable()->constrained(table: 'review_sections_groups');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('review_sections', function (Blueprint $table) {
            $table->dropColumn(['review_sections_group_id']);
        });
    }
};
