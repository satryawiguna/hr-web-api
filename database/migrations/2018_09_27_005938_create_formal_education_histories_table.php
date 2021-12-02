<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormalEducationHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('formal_education_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('degree_id');
            $table->unsignedInteger('major_id');
            $table->string('name');
            $table->dateTime('start_date');
            $table->dateTime('end_date')->nullable();
            $table->string('created_by', 25)->default('system');
            $table->string('modified_by', 25)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('employee_id')->references('id')->on('employees')
                ->onDelete('cascade');
            $table->foreign('degree_id')->references('id')->on('degrees');
            $table->foreign('major_id')->references('id')->on('majors');
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
        Schema::dropIfExists('formal_education_histories');
    }
}
