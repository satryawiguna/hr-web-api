<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('applicants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('profile_id');
            $table->unsignedInteger('gender_id');
            $table->unsignedInteger('religion_id');
            $table->unsignedInteger('marital_status_id');
            $table->string('identity_number', 100);
            $table->dateTime('identity_expired_date');
            $table->text('identity_address');
            $table->string('passport_number',100)->nullable();
            $table->dateTime('passport_expired_date')->nullable();
            $table->string('visa_number',100)->nullable();
            $table->dateTime('visa_expired_date')->nullable();
            $table->dateTime('birth_date');
            $table->string('birth_place');
            $table->string('age', 5);
            $table->string('weight', 5)->nullable();
            $table->string('height', 5)->nullable();
            $table->string('linkedin')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('skype')->nullable();
            $table->string('website')->nullable();

            //attribute: photo
            //attribute: resume
            //attribute: certificate

            $table->string('created_by', 30)->default('system');
            $table->string('modified_by', 30)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['profile_id', 'identity_number'], 'applicants_unique');

            $table->foreign('profile_id')->references('id')->on('profiles');
            $table->foreign('gender_id')->references('id')->on('genders');
            $table->foreign('religion_id')->references('id')->on('religions');
            $table->foreign('marital_status_id')->references('id')->on('marital_status');
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
        Schema::dropIfExists('applicants');
    }
}
