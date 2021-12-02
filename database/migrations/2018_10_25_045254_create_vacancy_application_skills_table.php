<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVacancyApplicationSkillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('vacancy_application_skills', function (Blueprint $table) {
            $table->unsignedBigInteger('vacancy_application_id');
            $table->unsignedBigInteger('skill_id');
            $table->timestamps();

            $table->foreign('vacancy_application_id')->references('id')->on('vacancy_applications')
                ->onDelete('cascade');
            $table->foreign('skill_id')->references('id')->on('skills')
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
        Schema::dropIfExists('vacancy_application_skills');
    }
}
