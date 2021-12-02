<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaLibraryablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('media_libraryables', function (Blueprint $table) {
            $table->uuid('media_library_id');
            $table->bigInteger('media_libraryable_id');
            $table->string('media_libraryable_type', 255);
            $table->string('attribute', 255)->nullable(); //ex: avatar, photo, document, ect...
            $table->string('title', 255)->nullable();
            $table->string('caption', 255)->nullable();

            $table->foreign('media_library_id')->references('id')->on('media_libraries');
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
        Schema::dropIfExists('media_libraryables');
    }
}
