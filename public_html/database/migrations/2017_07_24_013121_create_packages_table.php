<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('page_id')->nullable();
            $table->string('title');
            $table->string('details', 1000);
            $table->text('features');
	        $table->float( 'price', 9, 2 );
	        $table->float( 'discount_price', 9, 2 );
	        $table->boolean( 'best_value');
            $table->string('active', 1000);
            $table->string('display_order', 1000);
            //$table->foreign('page_id')->on('pages')->references('id')->onDelete('cascade');
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
        Schema::dropIfExists('packages');
    }
}
