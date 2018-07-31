<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicioelementoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('comerc_servicio_elemento', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('id_servicio')->unsigned();
          $table->foreign('id_servicio')
              ->references('id')->on('comerc_servicio')->onDetele('set null');
          $table->integer('elemento_policial')->nullable();
          $table->string('tipo');
          $table->string('tipo_turno');
          $table->string('horario');
          $table->boolean('estatus');
          $table->text('observacion');
          $table->date('fecha_asignacion')->nullable();
          $table->date('fecha_cambio')->nullable();
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
        Schema::dropIfExists('comerc_servicio_elemento');
    }
}
