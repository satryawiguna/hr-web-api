<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RecruitmentStagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('recruitment_stages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_id');
            $table->string('name', 100); // Applied, Phone Screen, Interview, Psycho Test, etc...
            $table->string('slug', 100);
            $table->string('color', 10); // #FF0000

            //attribute: icon

            $table->tinyInteger('sort_order'); // 1,2,3...
            $table->boolean('is_scheduled')->default(0);
            $table->boolean('is_init')->default(0);
            $table->boolean('is_hired')->default(0);
            $table->boolean('is_reject')->default(0);
            $table->softDeletes();
            $table->timestamps();

            $table->unique(['company_id', 'slug'], 'recruitment_stages_unique');

            $table->foreign('company_id')->references('id')->on('companies')
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
        Schema::dropIfExists('recruitment_stages');
    }
}
