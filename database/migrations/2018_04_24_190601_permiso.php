<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Permiso extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('rh_permiso', function (Blueprint $table) {
          $table->increments('id');
          $table->boolean('activo')->default(true);
          $table->timestamp('fecha_final');
          $table->timestamp('fecha_inicial');
          $table->timestamp('fecha_registro');
          $table->timestamp('fecha_reincorporacion');

          $table->bigInteger('usuario_actualiza_id')->nullable();
          $table->bigInteger('usuario_registro_id');
          $table->timestamp('fecha_solicitud');
          $table->string('oficio');
          $table->string('tipo');
          $table->smallInteger('num_dias');
          $table->smallInteger('num_meses')->default(0);
          $table->smallInteger('num_anios')->default(0);
          $table->bigInteger('elemento_policial_id');
          $table->string('archivo_baja')->nullable();
          $table->timestamp('fecha_cancelacion')->nullable();
          $table->string('oficio_baja')->nullable();
          $table->bigInteger('usuario_cancela_id')->nullable();
          $table->text('servicio')->nullable();
          $table->text('lugar_vacaciones')->nullable();
          $table->text('ccp')->nullable();
          $table->text('elemento_temporal')->nullable();
          $table->text('presentarse')->nullable();
           
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
      Schema::dropIfExists('rh_permiso');
  }
}
