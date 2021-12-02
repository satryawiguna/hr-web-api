<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('parent_id', false, false)->unsigned()->nullable();
            $table->unsignedBigInteger('company_id');
            $table->string('reference_number', 100);
            $table->unsignedInteger('contract_type_id');
            $table->string('name', 100);
            $table->string('first_party_number', 100);
            $table->string('second_party_number', 100);
            $table->dateTime('issue_date');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('activity');
            $table->text('description');
            $table->decimal('value', 10, 2);
            $table->tinyInteger('is_contract')->default(0)->comment('0 = false, 1 = true');

            //attribute: documents

            $table->string('created_by', 30)->default('system');
            $table->string('modified_by', 30)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['company_id', 'reference_number']);

            $table->foreign('company_id')->references('id')->on('companies')
                ->onDelete('cascade');
            $table->foreign('contract_type_id')->references('id')->on('contract_types');
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
        Schema::dropIfExists('projects');
    }
}
