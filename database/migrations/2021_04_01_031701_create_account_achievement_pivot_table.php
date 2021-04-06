<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountAchievementPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_achievement', function (Blueprint $table) {
            $table->id();
            $table->string('account_id')->constrained();
            $table->string('achievement_id')->constrained();
            $table->boolean('is_earned')->default(false);
            $table->timestamp('date_earned')->nullable();

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
        Schema::table('account_achievement', function (Blueprint $table) {
            //
        });
    }
}
