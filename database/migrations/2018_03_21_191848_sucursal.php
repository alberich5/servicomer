<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Sucursal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('rh_sucursal', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->integer('id_sucursal_depende')->nullable();
            $table->bigInteger('id_elemento_encargado')->nullable();
            $table->integer('numero_nomina')->nullable();
            $table->string('email')->nullable();
            $table->text('nombre_largo_sucursal')->nullable();
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
        Schema::dropIfExists('rh_sucursal');
    }
}
