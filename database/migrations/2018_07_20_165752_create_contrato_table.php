<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContratoTable extends Migration
{
    /**
     *   id serial NOT NULL,
     *
     * @return void
     */
    public function up()
    {
      Schema::create('comerc_contrato', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('num_contrato')->nullable();
          $table->string('tipo');
          $table->date('fecha_contratacion')->nullable();
          $table->date('fecha_termino')->nullable();
          $table->text('observacion');
          $table->boolean('estatus');
          $table->boolean('activo');
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
        Schema::dropIfExists('comerc_contrato');
    }
}
