<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Config;

class CreateSettingsTable extends Migration
{
	public function __construct()
	{
		if (version_compare(Application::VERSION, '5.0', '>=')) {
			$this->tablename = Config::get('settings.table');
			$this->keyColumn = Config::get('settings.keyColumn');
			$this->valueColumn = Config::get('settings.valueColumn');
		} else {
			$this->tablename = Config::get('anlutro/l4-settings::table');
			$this->keyColumn = Config::get('anlutro/l4-settings::keyColumn');
			$this->valueColumn = Config::get('anlutro/l4-settings::valueColumn');
		}
	}

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::defaultStringLength(190);
        Schema::disableForeignKeyConstraints();

		Schema::create($this->tablename, function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->unsignedBigInteger('company_id');
			$table->string($this->keyColumn, 190)->index();
			$table->text($this->valueColumn)->nullable();
		});

        Schema::enableForeignKeyConstraints();
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop($this->tablename);
	}
}
