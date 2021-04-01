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
        Schema::table('account_achievement', function (Blueprint $table) {
            $table->id();
            $table->string('account_key')->constrained();
            $table->string('achievement_key')->constrained();
            $table->boolean('is_earned')->default(false);
            $table->timestamp('date_earned')->nullable();
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
