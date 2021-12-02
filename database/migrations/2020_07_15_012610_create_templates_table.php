<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('templates', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('company_id');
            $table->enum('type', ['MAIL', 'SMS']);
            $table->string('title');
            $table->string('subject');
            $table->text('html_content')->nullable();
            $table->text('text_content')->nullable();
            $table->string('created_by');
            $table->string('modified_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

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
        Schema::dropIfExists('templates');
    }
}
