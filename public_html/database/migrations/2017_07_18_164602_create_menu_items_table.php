<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_items', function (Blueprint $table) {

            $table->increments('id')->unsigned();
            $table->string('title');
            $table->integer('parent_id')->unsigned()->nullable();
            $table->integer('menu_id')->unsigned()->nullable();
            $table->enum('type', [ 'page', 'category', 'url', 'slug'] );
	        $table->string( 'value' );
            $table->boolean('active')->default(1);
            $table->boolean('visibility')->default(1);
            $table->timestamps();

            $table->foreign('parent_id')->on('menus')->references('id')->onDelete('cascade');
            $table->foreign('menu_id')->on('menus')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::dropIfExists( 'menu_items' );
    }
}
