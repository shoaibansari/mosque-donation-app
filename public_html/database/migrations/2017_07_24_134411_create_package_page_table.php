<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackagePageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create( 'package_page', function ( Blueprint $table ) {
		    $table->increments( 'id' );
		    $table->integer('page_id')->unsigned();
		    $table->integer('package_id')->unsigned();
		    $table->boolean('active' );
		    $table->integer('display_order' )->unsigned();
		    $table->foreign('page_id')->on('pages')->references('id')->onDelete('cascade');
		    $table->foreign('package_id')->on('packages')->references('id')->onDelete( 'cascade' );
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
	    Schema::drop( 'package_page' );
    }
}
