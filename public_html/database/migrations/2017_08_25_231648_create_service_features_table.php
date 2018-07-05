<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_features', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('service_id')->unsigned()->nullable();
            $table->string('title');
            $table->boolean('active')->default(1);
            $table->enum('type', ['default','common', 'free', 'featured', 'addon'])->default('default');
            $table->decimal('price')->default(0.0);
            $table->boolean('is_new')->default(0);
            $table->integer('display_order')->default(0);
            $table->foreign('service_id')->on('services')->references('id')->onDelete('SET NULL');
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
        Schema::dropIfExists('service_features');
    }
}
