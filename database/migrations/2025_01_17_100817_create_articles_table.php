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

            $table->string('paper_id')->nullable();
            $table->string('title')->nullable();
            $table->text('abstract')->nullable();
            $table->text('keywords')->nullable();
            $table->text('areas')->nullable();

            $table->foreignId('journal_id')->constrained(table: 'journals');
            $table->foreignId('article_type_id')->nullable()->constrained(table: 'article_types');
            $table->foreignId('volume_id')->nullable()->constrained(table: 'volumes');
            $table->foreignId('issue_id')->nullable()->constrained(table: 'issues');
            $table->foreignId('article_status_id')->constrained(table: 'article_statuses');

            $table->foreignId('country_id')->constrained(table: 'countries');
            $table->foreignId('user_id')->constrained(table: 'users');

            $table->integer('pages')->default(0)->nullable();
            $table->integer('words')->default(0)->nullable();
            $table->integer('tables')->default(0)->nullable();
            $table->integer('figures')->default(0)->nullable();


            $table->integer('editorial')->default(0);
            $table->integer('type_setting')->default(0);
            $table->string('manuscript_file')->nullable();
            $table->integer('start_page')->default(0);
            $table->integer('end_page')->default(0);

            $table->date('submission_date')->nullable();
            $table->date('publication_date')->nullable();
            $table->integer('downloads')->default(0);

            
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
