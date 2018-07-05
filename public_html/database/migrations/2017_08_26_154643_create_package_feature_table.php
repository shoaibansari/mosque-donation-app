<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePackageFeatureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_feature', function (Blueprint $table) {
	        $table->increments( 'id' );
	        $table->integer( 'package_id' )->unsigned()->nullable();
	        $table->integer( 'service_feature_id' )->unsigned()->nullable();
	        $table->string( 'value' )->default('');
	        $table->enum( 'value_type',['boolean', 'string'] )->default('boolean');
	        $table->boolean( 'active' )->default( 1 );
	        $table->foreign( 'package_id' )->on( 'packages' )->references( 'id' )->onDelete( 'SET NULL' );
	        $table->foreign( 'service_feature_id' )->on( 'service_features' )->references( 'id' )->onDelete( 'SET NULL' );
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
	    Schema::dropIfExists( 'package_feature' );
    }
}
