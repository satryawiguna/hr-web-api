<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('full_name', 100);
            $table->string('nick_name', 100)->nullable();
            $table->char('country', 2)->nullable();
            $table->string('state_or_province', 100)->nullable();
            $table->string('city', 100)->nullable();
            $table->text('address')->nullable();
            $table->string('postcode', 10)->nullable();
            $table->string('phone',25)->nullable();
            $table->string('mobile', 25)->nullable();
            $table->string('email', 255);

            //attribute: photo

            $table->string('created_by', 30)->default('system');
            $table->string('modified_by', 30)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['user_id', 'email'], 'profiles_unique');

            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('restrict');
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
        Schema::dropIfExists('profiles');
    }
}
