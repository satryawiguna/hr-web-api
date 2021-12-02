<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVacancyApplicationAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('vacancy_application_answers', function (Blueprint $table) {
            $table->unsignedBigInteger('vacancy_application_id');
            $table->unsignedBigInteger('additional_question_id');
            $table->text('answer');
            $table->timestamps();

            $table->foreign('vacancy_application_id')->references('id')->on('vacancy_applications')
                ->onDelete('cascade');
            $table->foreign('additional_question_id')->references('id')->on('additional_questions')
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
        Schema::dropIfExists('vacancy_application_answers');
    }
}
