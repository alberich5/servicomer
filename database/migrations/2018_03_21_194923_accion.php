<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Accion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_accion', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('id_departamento');
            $table->string('nombre');
            $table->string('recurso');
            $table->string('operacion');
            $table->string('controlador');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_accion');
    }
}
