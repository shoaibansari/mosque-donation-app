<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
	    Schema::create('countries', function (Blueprint $table) {
		    $table->increments('id');
		    $table->string('title', 80);
		    $table->string('code', 4);
		    $table->string('currency_name', 40);
		    $table->string('currency_code', 40);
		    $table->string('currency_symbol', 4);
		    $table->boolean('active');
		    $table->timestamps();
		    $table->softDeletes();
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::drop('countries');
    }
}
