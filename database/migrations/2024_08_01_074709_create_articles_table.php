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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();

            $table->string('title')->nullable();
            $table->text('abstract')->nullable();
            $table->text('keywords')->nullable();

            $table->foreignId('journal_id')->constrained(table: 'journals');
            $table->foreignId('volume_id')->constrained(table: 'volumes');
            $table->foreignId('issue_id')->constrained(table: 'issues');
            $table->foreignId('country_id')->constrained(table: 'countries');
            $table->foreignId('user_id')->constrained(table: 'users');

            $table->integer('pages')->default(0)->nullable();
            $table->integer('words')->default(0)->nullable();
            $table->integer('tables')->default(0)->nullable();
            $table->integer('figures')->default(0)->nullable();

            $table->enum('status', ['Submitted','Under Review','Accepted','Published','Rejected','Pending'])->default('Submitted');
            $table->enum('editor_status', ['Pending','Done','Rejected'])->default('Pending');
            $table->enum('reviewer_status', ['Pending','Done','Rejected'])->default('Pending');
            
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
        Schema::dropIfExists('articles');
    }
};
