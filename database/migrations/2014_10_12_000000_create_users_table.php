<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('twitter_id')->unique();
            $table->string('user_name');
            $table->string('screen_name')->unique();
            $table->string('profile_image_url');
            $table->string('oauth_token')->unique();
            $table->string('oauth_token_secret')->unique();
            $table->boolean('day_update_flg')->default(false);
            $table->boolean('delete_flg')->default(false);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
