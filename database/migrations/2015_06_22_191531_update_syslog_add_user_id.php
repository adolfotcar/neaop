<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSyslogAddUserId extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('syslogs', function(Blueprint $table)
		{
			$table->integer('user_id')->unsigned()->nullable()->after('id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('syslogs', function(Blueprint $table)
		{
			$table->dropColumn('user_id');
		});
	}

}
