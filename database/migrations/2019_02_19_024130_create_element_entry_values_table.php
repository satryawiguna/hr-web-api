<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateElementEntryValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('element_entry_values', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('element_entry_id');
            $table->unsignedBigInteger('element_value_id');
            $table->dateTime('effective_start_date');
            $table->dateTime('effective_end_date');
            $table->decimal('value', 10, 2);
            $table->string('created_by', 30)->default('system');
            $table->string('modified_by', 30)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('element_entry_id')->references('id')->on('element_entries');
            $table->foreign('element_value_id')->references('id')->on('element_values');
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
        Schema::dropIfExists('element_entry_values');
    }
}
