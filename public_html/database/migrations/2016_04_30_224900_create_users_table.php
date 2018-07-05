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

	        // account info
	        $table->string( 'name', 120 );
	        $table->string( 'email', 120 )->unique();
	        $table->string( 'password', 80 );
	        $table->boolean( 'active' );
	        $table->integer('user_type_id')->unsigned()->nullable();

	        // profile
	        $table->string( 'phone1', 128 );
	        $table->string( 'phone2', 128 );
	        $table->string( 'address1', 128 );
	        $table->string( 'address2', 128 );
	        $table->string( 'city', 128 );
	        $table->string( 'state', 128 );
	        $table->string( 'country', 80 );
	        $table->string( 'avatar' )->nullable();
	        $table->date( 'birth_date' )->nullable();
	        $table->string( 'timezone', 5 )->nullable();

	        // others
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
	        $table->index(['email', 'password']);
        });

	    Schema::table('users', function (Blueprint $table) {
		    $table->foreign( 'user_type_id' )->references( 'id' )->on( 'user_types' )->onDelete('cascade');
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
