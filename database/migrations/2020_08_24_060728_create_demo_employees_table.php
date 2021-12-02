<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDemoEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demo_employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nip', 100);
            $table->string('full_name');
            $table->string('nick_name', 100);
            $table->dateTime('birth_date');
            $table->text('address');
            $table->string('phone', 25)->nullable();
            $table->string('mobile', 25)->nullable();
            $table->string('email')->nullable();
            $table->string('created_by', 25)->default('system');
            $table->string('modified_by', 25)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('demo_employees');
    }
}
