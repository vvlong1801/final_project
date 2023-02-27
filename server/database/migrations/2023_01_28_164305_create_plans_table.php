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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->integer('challenge_id');
            $table->integer('member_id');
            $table->integer('level')->default(1);
            $table->integer('total_day')->default(30);
            $table->integer('status')->default(1)->comment('1: on_going, 2: done, 3: pending, 4: not_started');
            $table->date('started_at');
            $table->dateTime('paused_at')->nullable();
            // $table->primary(['challenge_id', 'member_id']);
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
        Schema::dropIfExists('plans');
    }
};
