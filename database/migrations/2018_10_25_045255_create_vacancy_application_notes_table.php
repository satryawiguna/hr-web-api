<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVacancyApplicationNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('vacancy_application_notes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('vacancy_application_id');
            $table->string('note');
            $table->timestamps();

            $table->foreign('vacancy_application_id')->references('id')->on('vacancy_applications')
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
        Schema::dropIfExists('vacancy_application_notes');
    }
}
