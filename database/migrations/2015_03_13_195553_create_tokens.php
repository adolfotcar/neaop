<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTokens extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tokens', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('device');
			$table->string('device_name');
			$table->integer('user_id')->unsigned()->index();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
			$table->integer('app_id')->unsigned()->index();
			$table->foreign('app_id')->references('id')->on('apps')->onDelete('cascade');
			$table->string('token', 40);
			$table->string('ip_address', 45);
			$table->boolean('remember');
			$table->timestamp('expire_date');
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
		Schema::drop('tokens');
	}

}
