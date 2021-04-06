<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatesAccountGamePivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_game', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id');
            $table->foreignId('game_id');
            $table->integer('hours_played')->nullable();

            $table->index('account_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_game');
    }
}
