<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVacancyDegreesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('vacancy_degrees', function (Blueprint $table) {
            $table->unsignedBigInteger('vacancy_id');
            $table->unsignedBigInteger('degree_id');

            $table->unique(['vacancy_id', 'degree_id'], 'vacancy_degrees_unique');

            $table->foreign('vacancy_id')->references('id')->on('vacancies')
                ->onDelete('restrict');
            $table->foreign('degree_id')->references('id')->on('degrees')
                ->onDelete('restrict');
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
        Schema::dropIfExists('vacancy_degrees');
    }
}
