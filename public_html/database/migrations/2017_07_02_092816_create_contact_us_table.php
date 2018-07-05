<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactUsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_us', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name', 75);
            $table->string('phone', 75);
            $table->string('email', 75);
            $table->text('message')->nullable();
            $table->string('form_type', 40)->nullable();
	        $table->string( 'ip', 40 )->nullable();
	        $table->string( 'country', 3 )->nullable();
	        $table->boolean( 'read' );
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
        Schema::dropIfExists('contact_us');
    }
}
