<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaLibrariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('media_libraries', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('user_id');
            $table->enum('collection', ['STORAGE', 'COMPANY',
                'PROFILE', 'EMPLOYEE', 'WORK_AGREEMENT_LETTER', 'REGISTRATION_LETTER',
                'PROJECT', 'PROJECT_ADDENDUM', 'APPLICANT']);
            $table->string('original_file', 255);
            $table->string('generate_file', 255);
            $table->string('extension', 255);
            $table->string('type', 255)->nullable();
            $table->string('mime_type', 255);
            $table->string('disk', 100);
            $table->string('path', 255);
            $table->string('width',50)->nullable();
            $table->string('height',50)->nullable();
            $table->string('size', 255);
            $table->string('created_by', 25)->default('system');
            $table->string('modified_by', 25)->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')
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
        Schema::dropIfExists('media_libraries');
    }
}
