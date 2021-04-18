<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('account_key')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('platform_id')->nullable();
            $table->string('platform_username');
            $table->text('profile_image')->nullable();
            $table->string('platform');
            $table->boolean('isVerified')->default(false);

            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
