<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectAddendumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('project_addendums', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('project_id');
            $table->string('reference_number', 100);
            $table->string('name');
            $table->dateTime('issue_date');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->text('description');
            $table->decimal('value', 10, 2);
            $table->tinyInteger('is_contract')->default(0)->comment('0 = false, 1 = true');

            //attribute: document

            $table->string('created_by', 30)->default('system');
            $table->string('modified_by', 30)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['project_id', 'reference_number']);

            $table->foreign('project_id')->references('id')->on('projects')
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
        Schema::dropIfExists('project_addendums');
    }
}
