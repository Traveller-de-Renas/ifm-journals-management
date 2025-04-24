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
        Schema::table('review_section_options', function (Blueprint $table) {
            //
            // Add the new column to the table
            $table->string('option_value')->nullable()->after('title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('review_section_options', function (Blueprint $table) {
            //
            // Drop the column if it exists
            $table->dropColumn('option_value');
        });
    }
};
