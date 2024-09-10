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
        Schema::create('staff_lists', function (Blueprint $table) {
            $table->id();

            $table->foreignId('salutation_id')->nullable()->constrained(table: 'salutations');

            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('full_name')->nullable();
            $table->string('pf_number')->nullable();
            $table->string('password')->nullable();

            $table->string('picture')->nullable();
            $table->string('gender')->nullable();
            $table->string('nationality')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('box')->nullable();
            
            $table->text('bio')->nullable();
            $table->text('office')->nullable();
            $table->text('social_media')->nullable();
            $table->text('academics')->nullable();
            $table->text('designations')->nullable();
            
            $table->foreignId('faculty_id')->nullable()->constrained(table: 'faculties');
            $table->foreignId('campus_id')->nullable()->constrained(table: 'campuses');
            
            $table->integer('ems_id')->nullable();

            $table->enum('status', ['1','0'])->default('1');

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
        Schema::dropIfExists('staff_lists');
    }
};
