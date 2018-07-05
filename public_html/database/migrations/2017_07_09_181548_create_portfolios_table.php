<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePortfoliosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portfolios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->integer('service_id')->unsigned();
            $table->string('title');
            $table->text('description');
            $table->string('short_description');
            $table->string('banner');
            $table->string('banner_large');
            $table->boolean('active');
            $table->integer('display_order')->unsigned();
            $table->timestamps();
            $table->foreign('category_id')->on('categories')->references('id')->onDelete('cascade');
            $table->foreign('service_id')->on('services')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('portfolios');
    }
}
