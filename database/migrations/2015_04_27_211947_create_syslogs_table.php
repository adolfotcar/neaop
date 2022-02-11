<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSyslogsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('syslogs', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('url');
			$table->string('method');
			$table->string('message');
			$table->string('ip_address', 45);
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
		Schema::drop('syslogs');
	}

}
