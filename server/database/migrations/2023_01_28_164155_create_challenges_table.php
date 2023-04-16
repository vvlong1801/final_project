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
            $table->string('name')->unique();
            $table->string('description')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users');
            $table->integer('type')->default(1)->comment('1: fixed');
            $table->integer('max_count')->default(-1)->comment('-1: non-limited');
            $table->integer('commit_point')->nullable();
            $table->integer('min_rank')->default(0)->comment('0: newbie, 1: beginner, 2: middle, 3: advanced, 4: pro');
            $table->integer('max_rank')->default(4)->comment('0: newbie, 1: beginner, 2: middle, 3: advanced, 4: pro');
            $table->integer('who_can_join')->default(1)->comment('1: all, 2: group, 3: assign');
            $table->boolean('approve_required')->default(false);
            $table->integer('who_can_approve')->nullable();
            $table->integer('status')->default(0)->comment('0: init, 1: waiting, 2: active, 3: finish, 4:pending');
            $table->dateTime('released_at')->nullable();
            $table->dateTime('finished_at')->nullable();
            $table->dateTime('stopped_at')->nullable();
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
