<?php

use Illuminate\Support\Facades\Schema;
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
            $table->string('firstname',1000);
            $table->string('lastname',1000);
            $table->string('email',500)->unique();
            $table->string('username',500)->unique();
            $table->string('password');
            $table->integer('userid')->nullable();
            $table->integer('usergroupid')->nullable();
            $table->enum('role',['superadmin', 'admin', 'user']);
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
