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
        Schema::create('plan_item_exercise', function (Blueprint $table) {
            $table->id();
            $table->integer('plan_item_id');
            $table->integer('exercise_id');
            $table->integer('rep');
            $table->integer('set');
            $table->integer('min_time');
            $table->integer('max_time');
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
        Schema::dropIfExists('plan_item_exercises');
    }
};
