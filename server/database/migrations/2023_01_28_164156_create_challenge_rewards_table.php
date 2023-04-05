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
        Schema::create('challenge_rewards', function (Blueprint $table) {
            $table->id();
            $table->integer('challenge_id');
            $table->integer('number_of_first')->nullable();
            $table->integer('number_of_second')->nullable();
            $table->integer('number_of_third')->nullable();
            $table->integer('number_of_completion')->nullable();
            $table->integer('points_of_first')->nullable();
            $table->integer('points_of_second')->nullable();
            $table->integer('points_of_third')->nullable();
            $table->integer('points_of_completion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('challenge_rewards');
    }
};
