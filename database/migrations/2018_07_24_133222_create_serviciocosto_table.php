<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiciocostoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('comerc_servicio_costo', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('id_servicio')->unsigned();
          $table->foreign('id_servicio')
              ->references('id')->on('comerc_servicio')->onDetele('set null');
          $table->string('mes');
          $table->string('anio');
          $table->double('total', 15, 8);
          $table->double('umma');
          $table->integer('elemento_arma')->nullable();
          $table->integer('id_elemento')->unsigned();
          $table->foreign('id_elemento')
              ->references('id')->on('comerc_servicio_elemento')->onDetele('set null');
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
        Schema::dropIfExists('comerc_servicio_costo');
    }
}
