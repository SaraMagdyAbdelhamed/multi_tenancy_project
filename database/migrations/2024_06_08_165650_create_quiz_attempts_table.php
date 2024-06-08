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
        Schema::create('quiz_attempts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quiz_id');
            $table->unsignedBigInteger('member_id');
            $table->unsignedInteger('attempt_number');
            $table->float('score')->nullable();
            $table->boolean('passed')->default(false);
            $table->string('link')->nullable();
            $table->time('time_taken')->nullable();
            $table->datetime('start_time')->nullable();
            $table->timestamps();
            
            // Add foreign key constraints if necessary
            // $table->foreign('quiz_id')->references('id')->on('quizzes');
            // $table->foreign('member_id')->references('id')->on('members');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_attempts');
    }
};
