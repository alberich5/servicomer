<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RhPeriodoVacacional extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up()
     {
       Schema::create('rh_periodo_vacacional', function (Blueprint $table) {
           $table->increments('id');
           $table->boolean('activo')->default(true);
           $table->timestamp('fecha_inicial');
           $table->timestamp('fecha_final');
           $table->timestamp('fecha_reincorporacion');
           $table->smallInteger('num_dias');
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
       Schema::dropIfExists('rh_periodo_vacacional');
   }
 }
