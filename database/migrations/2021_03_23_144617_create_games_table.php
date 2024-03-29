<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('game_key')->unique();
            $table->string('platform');
            $table->string('game_id');
            $table->string('name')->nullable();
            $table->text('cover_image')->nullable();
            $table->string('developer')->nullable();
            $table->string('publisher')->nullable();
            $table->string('release_date')->nullable();
            $table->boolean('has_achievements')->default(true);

            $table->index('platform');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games');
    }
}
