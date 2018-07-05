<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoginHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('login_history', function (Blueprint $table) {
		    $table->increments('id')->unsigned();
		    $table->integer('user_id')->unsigned();
		    $table->string('ip', 25);
		    $table->string('country', 2)->nullable();
		    $table->string('login_via', 20);
		    $table->softDeletes();
		    $table->timestamps();
	    });

	    Schema::table('login_history', function (Blueprint $table) {
		    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
