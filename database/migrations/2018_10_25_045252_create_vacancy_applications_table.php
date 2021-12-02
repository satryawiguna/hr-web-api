<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVacancyApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('vacancy_applications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('applicant_id');
            $table->unsignedBigInteger('vacancy_id');
            $table->unsignedBigInteger('recruitment_stage_id');
            $table->text('cover_letter');
            $table->enum('rating', [1,2,3,4,5]);
            $table->timestamps();

            $table->foreign('applicant_id')->references('id')->on('applicants')
                ->onDelete('cascade');
            $table->foreign('vacancy_id')->references('id')->on('vacancies')
                ->onDelete('cascade');
            $table->foreign('recruitment_stage_id')->references('id')->on('recruitment_stages')
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
        Schema::dropIfExists('vacancy_applications');
    }
}
