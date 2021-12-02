<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkAgreementLettersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('work_agreement_letters', function (Blueprint $table) {
            $table->BigIncrements('id');
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('letter_type_id');
            $table->string('reference_number', 100);
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->text('description')->nullable();

            //attribute: document

            $table->string('created_by', 25)->default('system');
            $table->string('modified_by', 25)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['employee_id', 'reference_number']);

            $table->foreign('employee_id')->references('id')->on('employees')
                ->onDelete('cascade');
            $table->foreign('letter_type_id')->references('id')->on('letter_types');
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
        Schema::dropIfExists('work_agreement_letters');
    }
}
