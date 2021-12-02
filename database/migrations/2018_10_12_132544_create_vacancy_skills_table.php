<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVacancySkillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('vacancy_skills', function (Blueprint $table) {
            $table->unsignedBigInteger('vacancy_id');
            $table->unsignedBigInteger('skill_id');
            $table->timestamps();

            $table->unique(['vacancy_id', 'skill_id'], 'vacancy_skills_unique');

            $table->foreign('vacancy_id')->references('id')->on('vacancies')
                ->onDelete('restrict');
            $table->foreign('skill_id')->references('id')->on('skills')
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
        Schema::dropIfExists('vacancy_skills');
    }
}
