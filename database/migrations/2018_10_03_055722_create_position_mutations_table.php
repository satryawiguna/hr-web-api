<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePositionMutationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('position_mutations', function (Blueprint $table) {
            $table->BigIncrements('id');
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('position_id');
            $table->unsignedBigInteger('grade_id');
            $table->dateTime('mutation_date');
            $table->text('note')->nullable();
            $table->string('created_by', 30)->default('system');
            $table->string('modified_by', 30)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('employee_id')->references('id')->on('employees')
                ->onDelete('cascade');
            $table->foreign('position_id')->references('id')->on('positions');
            $table->foreign('grade_id')->references('id')->on('grades');
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
        Schema::dropIfExists('position_mutations');
    }
}
