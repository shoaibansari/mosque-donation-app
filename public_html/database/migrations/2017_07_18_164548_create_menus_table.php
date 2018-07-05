<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::create('menus', function (Blueprint $table) {
		    $table->increments( 'id' )->unsigned();
		    $table->string( 'name' );
		    $table->boolean( 'active' )->default( 1 );
		    $table->boolean( 'visibility' )->default( 1 );
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
	    Schema::dropIfExists( 'menus' );
    }
}
