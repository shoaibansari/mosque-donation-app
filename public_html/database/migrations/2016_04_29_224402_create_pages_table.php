<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create( 'pages', function ( Blueprint $table ) {
		    $table->increments( 'id' );
		    $table->integer('category_id');
		    $table->integer('service_id');
		    $table->string( 'slug', 190 )->unique();
		    $table->boolean('slug_editable')->default(1);
		    $table->string( 'banner' );
		    $table->string( 'heading' );
		    $table->text( 'short_contents' );
		    $table->text( 'header_contents' );
		    $table->text( 'footer_contents' );
		    $table->string( 'meta_title' );
		    $table->string( 'meta_keywords', 1000 );
		    $table->string( 'meta_description', 1000 );
		    $table->boolean('top_menu')->default(1);
		    $table->boolean('footer_menu')->default(0);
		    $table->boolean('sidebar_menu')->default(0);
		    $table->boolean( 'published' );
		    $table->dateTime( 'published_at' );
		    $table->boolean( 'status' );
		    $table->timestamps();
		    $table->softDeletes();
		    $table->foreign('category_id')->on('categories')->references('id')->onDelete('cascade');
		    $table->foreign('service_id')->on('services')->references('id')->onDelete( 'cascade' );
	    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::drop( 'pages' );
    }
}
