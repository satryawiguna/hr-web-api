<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('company_category_id');
            $table->unsignedInteger('employee_number_scale_id');
            $table->string('name', 190);
            $table->string('slug', 190)->unique();
            $table->string('email')->nullable();
            $table->string('url')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('is_active')->default(0)->comment('0 = false, 1 = true');

            //attribute: logo

            $table->string('created_by', 25)->default('system');
            $table->string('modified_by', 25)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('company_category_id')->references('id')->on('company_categories')
                ->onDelete('restrict');
            $table->foreign('employee_number_scale_id')->references('id')->on('employee_number_scales')
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
        Schema::dropIfExists('companies');
    }
}
