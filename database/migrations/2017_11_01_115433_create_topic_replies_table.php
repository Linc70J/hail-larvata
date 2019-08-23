<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopicRepliesTable extends Migration
{
	public function up()
	{
		Schema::create('topic_replies', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('topic_id')->unsigned()->default(0)->index();
            $table->bigInteger('user_id')->unsigned()->default(0)->index();
            $table->text('content');
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('topic_replies');
	}
}
