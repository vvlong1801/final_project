<?php

use App\Enums\Level;
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
        Schema::create('exercises', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('level')->default(Level::easy->value);
            $table->double('kcal');
            $table->integer('type')->comment('0: counter, 1: timer, 2: runner')->default(0);
            $table->integer('equipment_id')->nullable();
            $table->integer('mode_time');
            $table->integer('star')->default(0);
            $table->string('description')->nullable();
            $table->string('gif_url')->nullable();
            $table->string('video_url')->nullable();
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
        Schema::dropIfExists('exercises');
    }
};
