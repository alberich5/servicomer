<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('comerc_servicio', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('id_cliente')->unsigned();
          $table->foreign('id_cliente')
              ->references('id')->on('comerc_cliente')->onDetele('set null');
          $table->integer('id_contrato');
          $table->foreign('id_contrato')
              ->references('id')->on('comerc_contrato')->onDetele('set null');
          $table->integer('id_analisis_riesgos')->nullable();
          $table->string('nombre_comercial');
          $table->string('domicilio');
          $table->string('municipio');
          $table->string('giro');
          $table->string('tipo');
          $table->boolean('estatus');
          $table->text('observacion');
          $table->integer('id_representante')->unsigned();
          $table->foreign('id_representante')
              ->references('id')->on('representante_legal')->onDetele('set null');
          $table->string('latitud');
          $table->string('longitud');
          $table->date('fecha')->nullable();
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
          Schema::dropIfExists('comerc_servicio');
    }
}
