<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->tinyInteger('group_id')->unsigned()->default(0);
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password', 60)->nullable();
            $table->rememberToken();
            $table->timestamp('last_login');
            $table->string('last_login_ip', 45);
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
        Schema::drop('users');
    }
}
