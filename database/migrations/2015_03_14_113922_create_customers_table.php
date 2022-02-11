<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('customers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('contact_name');
			$table->string('phone1', 30);
			$table->string('phone2', 30)->nullable();
			$table->string('nature', 1)->default('F');
			$table->string('cnae')->nullable();
			$table->string('cnpj')->nullable();
			$table->string('insc_estadual')->nullable();
			$table->smallInteger('status_sintegra')->default(0);
			$table->string('email');
			$table->text('observations')->nullable();
			$table->string('address1')->nullable();
			$table->string('address2')->nullable();
			$table->string('address3')->nullable();
			$table->string('address4')->nullable();
			$table->string('city')->nullable();
			$table->string('state')->nullable();
			$table->string('zip_code', 30)->nullable();
			$table->integer('country_code')->nullable()->unsigned();
			$table->string('country')->nullable();
			$table->string('address_deliver')->nullable();
			$table->string('address_billing')->nullable();
			$table->integer('price_table_id')->nullable()->unsigned();
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
		Schema::drop('customers');
	}

}
