<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnquiryFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enquiry_forms', function (Blueprint $table) {
	        $table->increments( 'id' )->unsigned();
	        $table->string( 'name', 75 );
	        $table->string( 'phone', 75 );
	        $table->string( 'email', 75 );
	        $table->text( 'message' )->nullable();
	        $table->string( 'enquiry_type')->nullable();
	        $table->string( 'package_title')->nullable();
	        $table->text( 'package_details')->nullable();
	        $table->string( 'ip', 40)->nullable();
	        $table->string( 'country', 3)->nullable();
	        $table->boolean( 'read')->nullable()->default(0);
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
        Schema::dropIfExists('enquiry_forms');
    }
}
