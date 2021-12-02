<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('role_permissions', function (Blueprint $table) {
            $table->unsignedInteger('role_id');
            $table->unsignedBigInteger('permission_id');
            $table->enum('type', ['READ','WRITE']);
            $table->enum('value', ['ALLOW','DENY']);

            $table->unique(['role_id', 'permission_id'], 'role_permissions_unique');

            $table->foreign('role_id')->references('id')->on('roles')
                ->onDelete('restrict');
            $table->foreign('permission_id')->references('id')->on('permissions')
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
        Schema::dropIfExists('role_permissions');
    }
}
