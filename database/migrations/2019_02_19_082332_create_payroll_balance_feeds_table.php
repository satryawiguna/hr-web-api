<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayrollBalanceFeedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('payroll_balance_feeds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('payroll_balance_id');
            $table->unsignedBigInteger('element_id');
            $table->unsignedBigInteger('element_value_id');
            $table->enum('add_or_substract', ['ADD', 'SUBSTRACT']);
            $table->string('created_by', 30)->default('system');
            $table->string('modified_by', 30)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('payroll_balance_id')->references('id')->on('payroll_balances');
            $table->foreign('element_id')->references('id')->on('elements');
            $table->foreign('element_value_id')->references('id')->on('element_values');
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
        Schema::dropIfExists('payroll_balance_feeds');
    }
}
