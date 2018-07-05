<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTempFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_files', function (Blueprint $table) {
            $table->increments('id');
	        $table->string('filename');
	        $table->string('saved_as');
	        $table->string('md5', 50);
	        $table->integer('size');
	        $table->string('mime', 80);
	        $table->string('ext', 20);
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
        Schema::drop('temp_files');
    }
}
