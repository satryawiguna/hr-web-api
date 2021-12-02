<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormulaElementElementValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('formula_element_element_values', function (Blueprint $table) {
            $table->unsignedBigInteger('formula_id');
            $table->unsignedBigInteger('element_id');
            $table->unsignedBigInteger('element_value_id');

            $table->unique(['formula_id', 'element_id', 'element_value_id'], 'formula_element_element_values_unique');

            $table->foreign('formula_id')->references('id')->on('formulas')
                ->onDelete('cascade');
            $table->foreign('element_id')->references('id')->on('elements')
                ->onDelete('cascade');
            $table->foreign('element_value_id')->references('id')->on('element_values')
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
        Schema::dropIfExists('formula_element_element_values');
    }
}
