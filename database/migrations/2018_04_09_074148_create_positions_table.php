<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('positions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('parent_id', false, false)->unsigned()->nullable();
            $table->unsignedBigInteger('company_id');
            $table->char('code', 5);
            $table->string('name', 100);
            $table->string('slug', 100);
            $table->text('description')->nullable();
            $table->tinyInteger('is_active')->default(0)->comment('0 = false, 1 = true');
            $table->string('created_by', 30)->default('system');
            $table->string('modified_by', 30)->nullable();
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
        Schema::dropIfExists('positions');
    }
}
