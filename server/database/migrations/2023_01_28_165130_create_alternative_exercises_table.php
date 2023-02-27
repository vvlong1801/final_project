<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alternative_exercises', function (Blueprint $table) {
            $table->id();
            $table->integer('plan_item_exercise_id');
            $table->integer('alternative_exercise_id');
            $table->integer('rep');
            $table->integer('set');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alternative_exercises');
    }
};
