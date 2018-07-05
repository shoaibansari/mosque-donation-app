<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('author_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->enum('type', ['page', 'blog']);
            $table->string('title');
            $table->text('contents');
            $table->string('slug');
            $table->string('thumbnail');
            $table->string('banner');
            $table->boolean('allow_comments')->default( 1 );
            $table->boolean('published')->default( false );
            $table->dateTime('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('author_id')->on('users')->references('id')->onDelete('cadcade');
            $table->foreign('category_id')->on('categories')->references('id')->onDelete('cadcade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_posts');
    }
}
