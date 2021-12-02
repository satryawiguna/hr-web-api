<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVacanciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('vacancies', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('vacancy_location_id');
            $table->unsignedBigInteger('vacancy_category_id');

            $table->string('title', 100);
            $table->string('slug', 100)->unique();
            $table->dateTime('publish_date');
            $table->dateTime('expired_date');
            $table->string('reference_code', 100);

            $table->mediumText('intro');
            $table->text('description');
            $table->text('requirement');
            $table->tinyInteger('needs');

            $table->enum('work_status', ['FULL_TIME', 'PART_TIME']);
            $table->enum('work_type', ['PERMANENT', 'CONTRACT']);
            $table->enum('status', ['PUBLISH', 'DRAFT', 'PENDING']);
            $table->string('created_by', 25)->default('system');
            $table->string('modified_by', 25)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('company_id')->references('id')->on('companies')
                ->onDelete('cascade');
            $table->foreign('vacancy_location_id')->references('id')->on('vacancy_locations');
            $table->foreign('vacancy_category_id')->references('id')->on('vacancy_categories');
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
        Schema::dropIfExists('vacancies');
    }
}
