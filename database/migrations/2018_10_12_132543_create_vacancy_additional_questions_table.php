<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVacancyAdditionalQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('vacancy_additional_questions', function (Blueprint $table) {
            $table->unsignedBigInteger('vacancy_id');
            $table->unsignedBigInteger('additional_question_id');
            $table->timestamps();

            $table->unique(['vacancy_id', 'additional_question_id'], 'vacancy_additional_questions_unique');

            $table->foreign('vacancy_id')->references('id')->on('vacancies')
                ->onDelete('restrict');
            $table->foreign('additional_question_id')->references('id')->on('additional_questions')
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
        Schema::dropIfExists('vacancy_additional_questions');
    }
}
