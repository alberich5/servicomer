<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiciocontratoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('comerc_servicio_contrato', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('id_servicio')->unsigned();
          $table->foreign('id_servicio')
              ->references('id')->on('comerc_servicio')->onDetele('set null');
          $table->string('nombre');
          $table->string('tipo');
          $table->string('dato');
          $table->integer('id_area')->unsigned();
          $table->foreign('id_area')
              ->references('id')->on('area')->onDetele('set null');
          $table->timestamp('created_at')->nullable();
          $table->timestamp('updated_at')->nullable();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comerc_servicio_contrato');
    }
}
