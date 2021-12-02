<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('user_applications', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedSmallInteger('application_id');

            $table->unique(['user_id', 'application_id'], 'user_applications_unique');

            $table->foreign('user_id')->references('id')->on('users')
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
        Schema::dropIfExists('user_applications');
    }
}
