<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('work_units', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('parent_id', false, false)->unsigned()->nullable();
            $table->unsignedBigInteger('company_id');
            $table->char('code', 5);
            $table->string('title');
            $table->string('slug');
            $table->char('country', 2)->nullable();
            $table->string('state_or_province', 100)->nullable();
            $table->string('city', 100)->nullable();
            $table->text('address')->nullable();
            $table->string('postcode', 10)->nullable();
            $table->string('phone', 25)->nullable();
            $table->string('fax', 25)->nullable();
            $table->string('email')->nullable();
            $table->string('url')->nullable();
            $table->tinyInteger('is_active')->default(0)->comment('0 = false, 1 = true');
            $table->string('created_by', 25)->default('system');
            $table->string('modified_by', 25)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['company_id', 'code', 'slug']);

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
        Schema::dropIfExists('work_units');
    }
}
