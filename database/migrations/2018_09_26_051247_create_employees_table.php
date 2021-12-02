<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_id');
            $table->string('nip', 100); //Perubahan field
            $table->string('full_name');
            $table->string('nick_name', 100);
            $table->unsignedInteger('gender_id');
            $table->unsignedInteger('religion_id');
            $table->string('birth_place', 100);
            $table->dateTime('birth_date');
            $table->text('address');
            $table->string('phone', 25)->nullable();
            $table->string('mobile', 25)->nullable();
            $table->string('email')->nullable();
            $table->string('identity_number', 100);
            $table->dateTime('identity_expired_date'); //Perubahan field
            $table->text('identity_address');
            $table->tinyInteger('has_drive_license_a');
            $table->string('drive_license_a_number', 50)->nullable();
            $table->dateTime('drive_license_a_date')->nullable();
            $table->tinyInteger('has_drive_license_b');
            $table->string('drive_license_b_number', 50)->nullable();
            $table->dateTime('drive_license_b_date')->nullable();
            $table->tinyInteger('has_drive_license_c');
            $table->string('drive_license_c_number', 50)->nullable();
            $table->dateTime('drive_license_c_date')->nullable();
            $table->unsignedInteger('marital_status_id');
            $table->enum('mate_as', ['HUSBAND', 'WIFE'])->nullable();
            $table->string('mate_full_name')->nullable();
            $table->string('mate_nick_name', 100)->nullable();
            $table->string('mate_birth_place', 100)->nullable();
            $table->dateTime('mate_birth_date')->nullable();
            $table->string('mate_occupation')->nullable();
            $table->unsignedBigInteger('office_id');
            $table->unsignedBigInteger('work_area_id');
            $table->tinyInteger('has_npwp');
            $table->string('npwp_number', 100)->nullable();
            $table->dateTime('npwp_date')->nullable();
            $table->enum('npwp_status',['TK/0', 'TK/1', 'TK/2', 'TK/3', 'K/0', 'K/1', 'K/2', 'K/3', 'KI/0', 'KI/1', 'KI/2', 'KI/3'])->nullable();
            $table->tinyInteger('has_bpjs_tenaga_kerja');
            $table->string('bpjs_tenaga_kerja_number', 100)->nullable();
            $table->dateTime('bpjs_tenaga_kerja_date')->nullable();
            $table->enum('bpjs_tenaga_kerja_class', ['I', 'II', 'III'])->nullable();
            $table->tinyInteger('has_bpjs_kesehatan');
            $table->string('bpjs_kesehatan_number', 100)->nullable();
            $table->dateTime('bpjs_kesehatan_date')->nullable();
            $table->enum('bpjs_kesehatan_class', ['I', 'II', 'III'])->nullable();
            $table->tinyInteger('has_mate_bpjs_kesehatan');
            $table->string('mate_bpjs_kesehatan_number', 100)->nullable();
            $table->dateTime('mate_bpjs_kesehatan_date')->nullable();
            $table->enum('mate_bpjs_kesehatan_class', ['I', 'II', 'III'])->nullable();
            $table->string('dplk_number', 100)->nullable();
            $table->string('collective_number', 100)->nullable();
            $table->text('english_ability')->nullable();
            $table->text('computer_ability')->nullable();
            $table->text('other_ability')->nullable();
            $table->unsignedInteger('bank_id')->nullable();
            $table->string('account_number', 100)->nullable();
            $table->dateTime('join_date');
            $table->enum('work_status', ['FULL_TIME', 'PART_TIME']); //Perubahan field
            $table->enum('work_type', ['PERMANENT', 'CONTRACT']); //Perubahan field

            //attribute: photo

            $table->string('created_by', 25)->default('system');
            $table->string('modified_by', 25)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['company_id', 'nip']);

            $table->foreign('company_id')->references('id')->on('companies')
                ->onDelete('restrict');
            $table->foreign('gender_id')->references('id')->on('genders')
                ->onDelete('restrict');
            $table->foreign('religion_id')->references('id')->on('religions')
                ->onDelete('restrict');
            $table->foreign('marital_status_id')->references('id')->on('marital_status')
                ->onDelete('restrict');
            $table->foreign('office_id')->references('id')->on('offices')
                ->onDelete('restrict');
            $table->foreign('work_area_id')->references('id')->on('work_areas')
                ->onDelete('restrict');
            $table->foreign('bank_id')->references('id')->on('banks')
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
        Schema::dropIfExists('employees');
    }
}
