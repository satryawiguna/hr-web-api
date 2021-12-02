<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateElementValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('element_values', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('element_id');
            $table->string('code');
            $table->string('name');
            $table->string('slug');
            $table->decimal('value',10, 2);
            $table->string('seq_no');
            $table->string('created_by', 30)->default('system');
            $table->string('modified_by', 30)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['slug', 'code']);

            $table->foreign('element_id')->references('id')->on('elements');
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
        Schema::dropIfExists('element_values');
    }
}
