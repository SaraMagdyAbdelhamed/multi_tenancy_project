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
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('tenant_id');
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('description')->nullable()->default(null);
            $table->timestamp('start_time')->nullable();
             $table->timestamp('end_time')->nullable();
             $table->integer('mark')->default(0);
             $table->enum('type', [1, 2])->nullable()->comment('1: in-time quiz, 2: out-time quiz');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};
