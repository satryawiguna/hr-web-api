<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChildsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('childs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_id');
            $table->string('full_name');
            $table->string('nick_name');
            $table->unsignedInteger('gender_id');
            $table->tinyInteger('order');
            $table->string('birth_place', 100);
            $table->dateTime('birth_date');
            $table->tinyInteger('has_bpjs_kesehatan');
            $table->string('bpjs_kesehatan_number', 100)->nullable();
            $table->dateTime('bpjs_kesehatan_date')->nullable();
            $table->enum('bpjs_kesehatan_class', ['I', 'II', 'III'])->nullable();
            $table->string('created_by', 30)->default('system');
            $table->string('modified_by', 30)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('employee_id')->references('id')->on('employees')
                ->onDelete('cascade');
            $table->foreign('gender_id')->references('id')->on('genders');
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
        Schema::dropIfExists('childs');
    }
}
