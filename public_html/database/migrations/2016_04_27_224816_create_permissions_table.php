<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
	        $table->integer('permission_group_id')->unsigned();
	        $table->string('title');
	        $table->boolean('active');
            $table->timestamps();
        });

	    Schema::table('permissions', function (Blueprint $table) {
		    $table->foreign( 'permission_group_id' )->references( 'id' )->on( 'permission_groups' )->onDelete('cascade');
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('permissions');
    }
}
