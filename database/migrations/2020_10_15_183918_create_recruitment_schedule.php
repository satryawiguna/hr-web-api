<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecruitmentSchedule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('recruitment_schedule', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('vacancy_application_id');
            $table->datetime('schedule_date');
            $table->softDeletes();
            $table->timestamps();

            $table->unique(['vacancy_application_id'], 'recruitment_schedule_unique');

            $table->foreign('vacancy_application_id')
                ->references('id')
                ->on('vacancy_applications')
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
        Schema::dropIfExists('recruitment_schedule');
    }
}
