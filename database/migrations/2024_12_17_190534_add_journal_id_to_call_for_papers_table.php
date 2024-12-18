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
        Schema::table('call_for_papers', function (Blueprint $table) {
            $table->foreignId('journal_id')->nullable()->constrained(table: 'journals');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('call_for_papers', function (Blueprint $table) {
            $table->dropColumn(['journal_id']);
        });
    }
};
