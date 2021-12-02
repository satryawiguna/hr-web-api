<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfficesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('offices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_id');
            $table->string('name', 190);
            $table->string('slug', 190);
            $table->enum('type', ['HEAD', 'BRANCH'])->default('HEAD');
            $table->char('country', 2);
            $table->string('state_or_province', 100);
            $table->string('city', 100);
            $table->text('address');
            $table->string('postcode', 10)->nullable();
            $table->string('phone',25)->nullable();
            $table->string('fax',25)->nullable();
            $table->string('email')->nullable();
            $table->string('latitude', 25)->nullable();
            $table->string('longitude', 25)->nullable();
            $table->tinyInteger('is_active')->default(0)->comment('0 = false, 1 = true');
            $table->string('created_by', 25)->default('system');
            $table->string('modified_by', 25)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['company_id', 'slug']);

            $table->foreign('company_id')->references('id')->on('companies')
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
        Schema::dropIfExists('offices');
    }
}
