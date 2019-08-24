<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopicsTable extends Migration
{
	public function up()
	{
		Schema::create('topics', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('bu_id')->unsigned()->default(0)->index();
            $table->string('title')->index();
            $table->text('body');
            $table->bigInteger('user_id')->unsigned()->index();
            $table->integer('topic_category_id')->unsigned()->index();
            $table->integer('reply_count')->unsigned()->default(0);
            $table->integer('view_count')->unsigned()->default(0);
            $table->integer('last_reply_user_id')->unsigned()->default(0);
            $table->integer('order')->unsigned()->default(0);
            $table->text('excerpt');
            $table->string('slug')->nullable();
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('topics');
	}
}
