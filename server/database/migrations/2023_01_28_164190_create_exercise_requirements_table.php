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
        Schema::create('exercise_requirements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('item_session_id');
            $table->foreign('item_session_id')->references('id')->on('exercise_workout_session')->cascadeOnDelete();
            $table->integer('param');
            $table->integer('param_type');
            $table->double('value');
            $table->integer('unit');
            $table->integer('order');
            // $table->unsignedBigInteger('constrained');
            // $table->foreign('constrained')->references('id')->on('exercise_requirements');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercise_requirements');
    }
};
