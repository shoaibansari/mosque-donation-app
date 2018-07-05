<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePageShowcasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_showcases', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('page_id');
            $table->enum('item_type', ['page', 'category', 'service', 'url']);
            $table->integer('item_id')->unsigned();
	        $table->string('icon',500);
	        $table->string('title',500);
            $table->string('slug', 1000);
            $table->integer('display_order')->unsigned();
            $table->boolean('active');
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
        Schema::dropIfExists('page_showcases');
    }
}
