<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_templates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('short_code');
            $table->string('sender_name');
            $table->string('sender_email');
            $table->string('subject');
            $table->text('contents');
	        $table->string('tags', 1000);
            $table->boolean('active');
            $table->string('cc');
            $table->string('bcc');
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
        Schema::drop('email_templates');
    }
}
