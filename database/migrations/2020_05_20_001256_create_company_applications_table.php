<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('company_applications', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id');
            $table->unsignedSmallInteger('application_id');

            $table->unique(['company_id', 'application_id'], 'company_applications_unique');

            $table->foreign('company_id')->references('id')->on('companies')
                ->onDelete('restrict');
            $table->foreign('application_id')->references('id')->on('applications')
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
        Schema::dropIfExists('company_applications');
    }
}
