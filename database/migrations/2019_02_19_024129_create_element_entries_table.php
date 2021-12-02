<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateElementEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('element_entries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('element_id');
            $table->unsignedBigInteger('employee_id');
            $table->dateTime('effective_start_date');
            $table->dateTime('effective_end_date');
            $table->string('created_by', 30)->default('system');
            $table->string('modified_by', 30)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('element_id')->references('id')->on('elements');
            $table->foreign('employee_id')->references('id')->on('employees')
                ->onDelete('cascade');
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
        Schema::dropIfExists('element_entries');
    }
}
