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
        Schema::create('challenges', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('type')->comment('1: free, 2: compete')->default(0);
            $table->boolean('commit')->default(false);
            $table->integer('commit_points')->nullable();
            $table->integer('member_limit')->comment('0: newbie, 1: beginner, 2: middle, 3: high, 4: master')->nullable();
            $table->boolean('limit_demension')->comment('false: up, true: down')->nullable();
            $table->integer('status')->comment('0: init, 1: comming, 2: running, 3: pending, 4:finish')->default(0);
            $table->string('description')->nullable();
            $table->dateTime('comming_at')->nullable();
            $table->dateTime('running_at')->nullable();
            $table->dateTime('pending_at')->nullable();
            $table->dateTime('finish_at')->nullable();
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
        Schema::dropIfExists('challenges');
    }
};
