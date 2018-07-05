<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoginAttemptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('login_attempts', function (Blueprint $table) {
		    $table->increments('id')->unsigned();
		    $table->string('ip');
		    $table->string('country', 2)->nullable();
		    $table->string('email', 80);
		    $table->string('password', 40);
		    $table->softDeletes();
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
        Schema::drop('login_attempts');
    }
}
